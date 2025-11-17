<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Clean up bad data
$updated = \App\Models\TemporaryItem::where('id_item', 0)->update(['id_item' => null]);
echo "Updated {$updated} records with id_item=0 to id_item=null\n";

// Test create new temporary item
try {
    $temp = \App\Models\TemporaryItem::create([
        'id_item' => null,
        'nama_barang_baru' => 'Test Komputer',
        'lokasi_barang_baru' => 'Lab Test',
        'status' => 'baik',
        'deskripsi_masalah' => 'Test deskripsi',
        'keterangan' => 'Test keterangan',
    ]);
    echo "✓ Successfully created temporary item with ID: {$temp->id_temporary}\n";
} catch (\Exception $e) {
    echo "✗ Error: {$e->getMessage()}\n";
}
