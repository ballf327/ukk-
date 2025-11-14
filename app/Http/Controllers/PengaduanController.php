<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    /**
     * Cetak laporan pengaduan berdasarkan ID
     */
    public function cetak($id)
    {
        $pengaduan = Pengaduan::with(['user', 'petugas', 'item'])->findOrFail($id);
        return view('admin.pengaduan.cetak', compact('pengaduan'));
    }
     public function cetaklaporan($id)
    {
        $pengaduan = Pengaduan::with(['user', 'petugas', 'item'])->findOrFail($id);
        return view('petugas.pengaduan.cetak', compact('pengaduan'));
    }
}
