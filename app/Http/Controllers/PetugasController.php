<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Petugas;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    /**
     * 🔹 Menampilkan daftar petugas
     */
    public function index()
    {
        // Ambil hanya data petugas yang memiliki user dengan role 'petugas'
        $petugas = Petugas::with('user')->whereHas('user', function ($query) {$query->where('role', 'petugas');
})
        ->get();
        return view('admin.petugas.index', compact('petugas'));
    }

    /**
     * 🔹 Tampilkan form tambah petugas
     */
    public function create()
    {
        return view('admin.petugas.create');
    }

    /**
     * 🔹 Simpan data petugas baru ke tabel users dan petugas
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'gender'   => 'required|string',
            'telp'     => 'required|string|max:20',
        ]);

        // 1️⃣ Simpan ke tabel users
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'petugas',
        ]);

        // 2️⃣ Simpan ke tabel petugas (hubungkan dengan user_id)
        Petugas::create([
            'user_id' => $user->id,
            'nama'    => $request->name,
            'gender'  => $request->gender === 'Laki-laki' ? 'L' : 'P',
            'telp'    => $request->telp,
        ]);

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil ditambahkan ke dua tabel!');
    }

    /**
     * 🔹 Tampilkan form edit petugas
     */
       // Menampilkan form edit role
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.petugas.edit', compact('user'));
    }

    // Menyimpan perubahan role
   public function update(Request $request, $id)
{
    $request->validate([
        'role' => 'required|in:admin,petugas',
    ]);

    $user = User::findOrFail($id);

    // Jika diubah menjadi admin → hapus data dari tabel petugas
    if ($request->role === 'admin') {
        $petugas = Petugas::where('user_id', $user->id)->first();
        if ($petugas) {
            $petugas->delete();
        }
    } 
    // Jika diubah dari admin menjadi petugas → tambahkan ke tabel petugas
    elseif ($request->role === 'petugas') {
        // Cegah duplikat
        if (!Petugas::where('user_id', $user->id)->exists()) {
            Petugas::create([
                'user_id' => $user->id,
                'nama'    => $user->name,
                'gender'  => 'L', // default aja, bisa diedit nanti
                'telp'    => '-',
            ]);
        }
    }

    // Update role user
    $user->update(['role' => $request->role]);

    return redirect()->route('admin.petugas.index')
        ->with('success', 'Role berhasil diperbarui dan data petugas diperbarui otomatis!');
}

    /**
     * 🔹 Hapus petugas dari dua tabel
     */
    public function destroy($id)
{
    // Cari user berdasarkan ID
    $user = User::find($id);

    if (!$user) {
        return redirect()->route('admin.petugas.index')
            ->with('error', 'Data user tidak ditemukan.');
    }

    // Cari petugas berdasarkan user_id
    $petugas = Petugas::where('user_id', $user->id)->first();

    // Hapus data petugas jika ada
    if ($petugas) {
        $petugas->delete();
    }

    // Hapus juga data user
    $user->delete();

    return redirect()->route('admin.petugas.index')
        ->with('success', 'Petugas dan akun user berhasil dihapus!');
}

    public function daftarAdmin()
{
    $admins = User::where('role', 'admin')->get();
    return view('admin.petugas.admin', compact('admins'));
}
  // ✅ Tampilkan form saran
    public function formSaran($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Pastikan hanya pengaduan yang sudah selesai
        if ($pengaduan->status !== 'Selesai') {
            return redirect()->route('petugas.dashboard')
                ->with('error', 'Hanya pengaduan yang sudah selesai yang dapat diberi saran.');
        }

        return view('petugas.form_saran', compact('pengaduan'));
    }

    // ✅ Proses kirim saran
    public function kirimSaran(Request $request, $id)
    {
        $request->validate([
            'saran_petugas' => 'required|string|min:5|max:1000',
            'saran_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        $data = [
            'saran_petugas' => $request->saran_petugas,
        ];

        if ($request->hasFile('saran_foto')) {
            $path = $request->file('saran_foto')->store('saran', 'public');
            $data['saran_foto'] = $path;
        }

        $pengaduan->update($data);

        // Saran sudah tersimpan di database sebagai `saran_petugas`.
        // Kembali ke dashboard petugas agar alur kerja petugas tidak terputus.
        // Pengguna akan melihat saran ini pada `user.dashboard` ketika mereka login.
        return redirect()->route('petugas.dashboard')->with('success', 'Saran berhasil disimpan dan akan terlihat oleh pengguna.');
    }

}

