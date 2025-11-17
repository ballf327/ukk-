<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Pengaduan;
use App\Models\Penolakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Hitung total data untuk statistik
        $totalUser = User::where('role', 'pengguna')->count();
        $totalPetugas = User::where('role', 'petugas')->count();
        $totalItem = Item::count();
        $totalPengaduan = Pengaduan::count();

        // Statistik jumlah pengaduan berdasarkan status
        $pengaduanByStatus = Pengaduan::selectRaw('status, COUNT(*) as jumlah')
            ->groupBy('status')
            ->pluck('jumlah', 'status');

        // ====== QUERY DASAR ======
        $query = Pengaduan::with(['user', 'petugas', 'item'])
            ->orderBy('tgl_pengajuan', 'desc');

        // ====== FILTER STATUS ======
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ====== FILTER RENTANG TANGGAL ======
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tgl_pengajuan', [$request->from, $request->to]);
        } elseif ($request->filled('from')) {
            $query->whereDate('tgl_pengajuan', '>=', $request->from);
        } elseif ($request->filled('to')) {
            $query->whereDate('tgl_pengajuan', '<=', $request->to);
        }

        // Ambil hasil akhir pengaduan
        $pengaduan = $query->get();

        // Kirim semua variabel ke view
        return view('admin.dashboard', compact(
            'totalUser',
            'totalPetugas',
            'totalItem',
            'totalPengaduan',
            'pengaduanByStatus',
            'pengaduan'
        ));
    }

    /**
     * Tampilkan form penolakan khusus untuk admin
     */
    public function formTolak($id)
    {
        $pengaduan = Pengaduan::with('user')->findOrFail($id);
        return view('admin.form_penolakan', compact('pengaduan'));
    }

    /**
     * Proses penolakan oleh admin (simpan ke tabel penolakan)
     */
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|min:10|max:500'
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        DB::transaction(function () use ($pengaduan, $request) {
            $pengaduan->update([
                'status' => 'Ditolak',
                'saran_petugas' => $request->alasan,
            ]);

            Penolakan::create([
                'id_pengaduan' => $pengaduan->id_pengaduan,
                'id_petugas' => null,
                'alasan' => $request->alasan,
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Pengaduan telah ditolak dan dicatat.');
    }

    /**
     * Approve pengaduan dari admin. Setelah disetujui, arahkan ke dashboard petugas.
     */
    public function approve($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update(['status' => 'Disetujui']);

        // Jangan redirect admin ke route yang memerlukan role:petugas (menyebabkan 403)
        return redirect()->route('dashboard')->with('success', 'Pengaduan disetujui dan dikirimkan ke petugas.');
    }
}
