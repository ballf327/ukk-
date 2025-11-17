<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Petugas;
use Illuminate\Support\Facades\Auth;

class PetugasDashboardController extends Controller
{
    public function index()
    {
        // Ambil semua pengaduan beserta relasi user dan petugas
        $pengaduan = Pengaduan::with(['user', 'petugas'])->get();
        $pengaduanTerbaru = Pengaduan::with(['user', 'petugas'])->latest()->take(10)->get();

        // Hitung statistik
        $totalPengaduan   = Pengaduan::count();
        $pengaduanProses  = Pengaduan::where('status', 'Diproses')->count();
        $pengaduanSelesai = Pengaduan::whereIn('status', [ 'Disetujui'])->count();
        $jumlahPenolakan  = Pengaduan::where('status', 'Ditolak')->count();

        return view('petugas.dashboard', compact(
            'pengaduan',
            'pengaduanTerbaru',
            'totalPengaduan',
            'pengaduanProses',
            'pengaduanSelesai',
            'jumlahPenolakan'
        ));
    }

   // Di PetugasDashboardController.php - PERBAIKI SEMUA METHOD
public function mulai($id)
{
    $pengaduan = Pengaduan::findOrFail($id);
    $user = Auth::user();
    
    // Cari petugas berdasarkan nama (sesuai dengan relasi di model)
    $petugas = Petugas::where('nama', $user->name)->first();
    
    if (!$petugas) {
        return redirect()->back()->with('error', 'Data petugas tidak ditemukan. Silakan hubungi administrator.');
    }

    $pengaduan->update([
        'status' => 'Diproses',
        'id_petugas' => $petugas->id_petugas,
    ]);

    return redirect()->back()->with('success', 'Pengaduan mulai diproses!');
}

public function tolak(Request $request, $id)
{
    $request->validate([
        'alasan' => 'required|string|min:10|max:500'
    ]);

    $pengaduan = Pengaduan::findOrFail($id);
    $user = Auth::user();
    
    // Cari petugas berdasarkan nama
    $petugas = Petugas::where('nama', $user->name)->first();
    
    if (!$petugas) {
        return redirect()->back()->with('error', 'Data petugas tidak ditemukan. Silakan hubungi administrator.');
    }

    // Mulai transaction untuk memastikan konsistensi data
    \DB::transaction(function () use ($pengaduan, $petugas, $request) {
        // 1. Update status pengaduan menjadi Ditolak dan simpan alasan ke saran_petugas
        $pengaduan->update([
            'status' => 'Ditolak',
            'id_petugas' => $petugas->id_petugas,
            'saran_petugas' => $request->alasan, // Simpan alasan penolakan ke saran_petugas
        ]);

        // 2. Simpan data ke tabel penolakan
        \App\Models\Penolakan::create([
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'id_petugas' => $petugas->id_petugas,
            'alasan' => $request->alasan,
        ]);
    });

    return redirect()->route('petugas.dashboard')->with('success', 'Pengaduan telah ditolak dan dicatat!');
}

public function formTolak($id)
{
    $pengaduan = Pengaduan::with('user')->findOrFail($id);
    return view('petugas.form_penolakan', compact('pengaduan'));
}

    public function selesai($id)
{
    $pengaduan = Pengaduan::findOrFail($id);

    // Dapatkan user yang sedang login
    $user = Auth::user();

    // Cari petugas berdasarkan nama (sesuai dengan relasi di model)
    $petugas = Petugas::where('nama', $user->name)->first();

    if (!$petugas) {
        return redirect()->back()->with('error', 'Data petugas tidak ditemukan. Silakan hubungi administrator.');
    }

    $pengaduan->update([
        'status' => 'Selesai',
        'id_petugas' => $petugas->id_petugas,
        'tgl_selesai' => now(),
    ]);

    return redirect()->back()->with('success', 'Pengaduan telah diselesaikan!');
}
}
