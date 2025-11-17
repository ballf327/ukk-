<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryItem extends Model
{
    use HasFactory;

    protected $table = 'temporary_item';
    protected $primaryKey = 'id_temporary';

    protected $fillable = [
        'id_item',
        'nama_barang_baru',
        'lokasi_barang_baru',
        'status',
        'deskripsi_masalah',
        'foto_masalah',
        'keterangan',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id_item');
    }

    // 🔹 Relasi ke pengaduan yang terhubung dengan temporary item ini
    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class, 'id_temporary', 'id_temporary');
    }
}
