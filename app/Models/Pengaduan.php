<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';
    protected $primaryKey = 'id_pengaduan';

    protected $fillable = [
        'nama_pengaduan',
        'deskripsi',
        'lokasi',
        'foto',
        'status',
        'id_user',
        'id_petugas',
        'id_item',
        'id_temporary',
        'tgl_pengajuan',
        'tgl_selesai',
        'saran_petugas',
        'saran_foto',
    ];

    // 🔹 Relasi ke pelapor (users)
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_user', 'id');
    }

    // 🔹 Relasi ke petugas (yang menangani)
    public function petugas()
    {
        return $this->belongsTo(\App\Models\Petugas::class, 'id_petugas', 'id_petugas');
    }

    public function penolakan()
    {
       return $this->hasOne(\App\Models\Penolakan::class, 'id_pengaduan', 'id_pengaduan');
    }
    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item');
    }

    // 🔹 Relasi ke temporary_item (barang yang belum punya nomor aset)
    public function temporaryItem()
    {
        return $this->belongsTo(TemporaryItem::class, 'id_temporary', 'id_temporary');
    }
}
