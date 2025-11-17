<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pengaduan;
use App\Models\Lokasi;
use App\Models\Item;
use App\Models\TemporaryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Ambil hanya user dengan role 'pengguna'
        $users = User::where('role', 'pengguna')
                ->orderBy('created_at', 'desc')
                ->get();

        // Arahkan ke tampilan resources/views/admin/user/index.blade.php
        return view('admin.user.index', compact('users'));
    }

    // ----- Admin: show form create user -----
    public function adminCreate()
    {
        return view('admin.user.create');
    }

    // ----- Admin: store new user -----
    public function adminStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:pengguna,petugas,admin',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    // ----- Admin: edit user -----
    public function adminEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    // ----- Admin: update user -----
    public function adminUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:pengguna,petugas,admin',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    // ----- Admin: delete user -----
    public function adminDestroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Formulir pengaduan
     */
    public function create()
    {
        $lokasiList = Lokasi::all();
        $itemList = Item::all(); // untuk default jika ingin menampilkan semua
        $temporaryItems = TemporaryItem::latest()->get(); // Ambil semua temporary items
        return view('user.create', compact('lokasiList', 'itemList', 'temporaryItems'));
    }

    /**
     * Ambil barang berdasarkan lokasi (AJAX)
     */
    public function getBarangByLokasi($id_lokasi)
    {
        $items = Item::where('lokasi', function ($query) use ($id_lokasi) {
            $query->select('nama_lokasi')->from('lokasi')->where('id_lokasi', $id_lokasi)->limit(1);
        })->get(['id_item', 'nama_item']);

        return response()->json($items);
    }

    /**
     * Simpan pengaduan
     */
    public function store(Request $request)
    {
        // Validasi: user harus memilih id_item ATAU id_temporary, tidak harus keduanya
        $request->validate([
            'nama_pengaduan' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
            'id_lokasi' => 'required|exists:lokasi,id_lokasi',
            'id_item' => 'nullable|exists:items,id_item',
            'id_temporary' => 'nullable|exists:temporary_item,id_temporary',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Pastikan minimal salah satu dipilih
        if (!$request->id_item && !$request->id_temporary) {
            return back()->withErrors(['error' => 'Pilih barang dari daftar resmi ATAU barang temporary!'])->withInput();
        }

        $filePath = null;
        if ($request->hasFile('foto')) {
            $filePath = $request->file('foto')->store('pengaduan', 'public');
        }

        // Ambil nama lokasi
        $lokasi = Lokasi::find($request->id_lokasi);

        Pengaduan::create([
            'id_user' => Auth::id(),
            'nama_pengaduan' => $request->nama_pengaduan,
            'deskripsi' => $request->isi_laporan,
            'lokasi' => $lokasi->nama_lokasi ?? '',
            'id_item' => $request->id_item,
            'id_temporary' => $request->id_temporary,
            'foto' => $filePath,
            'status' => 'Diajukan',
            'tgl_pengajuan' => now(),
            'id_petugas' => null,
            'saran_petugas' => null,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Pengaduan berhasil dikirim!');
    }
}
