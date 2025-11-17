<?php

namespace App\Http\Controllers;

use App\Models\TemporaryItem;
use App\Models\Item;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemporaryItemController extends Controller
{
    /**
     * Display a listing of temporary items
     */
    public function index()
    {
        $temporaryItems = TemporaryItem::with('item')->latest()->paginate(15);
        
        return view('admin.temporary_item.index', [
            'temporaryItems' => $temporaryItems
        ]);
    }

    /**
     * Show the form for creating a new temporary item
     */
    public function create()
    {
        $lokasis = Lokasi::all();
        return view('admin.temporary_item.create', compact('lokasis'));
    }

    /**
     * Store a newly created temporary item in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang_baru' => 'required|string|max:100',
            'lokasi_barang_baru' => 'required|string|max:100',
            'status' => 'required|in:baik,rusak,cacat',
            'deskripsi_masalah' => 'nullable|string',
            'foto_masalah' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string|max:200',
        ]);

        try {
            // Create a temporary item without id_item (since it's not officially in items yet)
            // Using NULL instead of 0 for proper foreign key handling
            $temporaryItem = new TemporaryItem();
            $temporaryItem->id_item = null; // NULL for barang yang belum resmi
            $temporaryItem->nama_barang_baru = $request->nama_barang_baru;
            $temporaryItem->lokasi_barang_baru = $request->lokasi_barang_baru;
            $temporaryItem->status = $request->status;
            $temporaryItem->deskripsi_masalah = $request->deskripsi_masalah;
            $temporaryItem->keterangan = $request->keterangan;

            if ($request->hasFile('foto_masalah')) {
                $path = $request->file('foto_masalah')->store('foto_temporary', 'public');
                $temporaryItem->foto_masalah = $path;
            }

            $temporaryItem->save();

            return redirect()->route('admin.temporary-item.index')
                ->with('success', 'Barang temporary berhasil ditambahkan');
        } catch (\Throwable $e) {
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified temporary item with related pengaduans
     */
    public function show($id_temporary)
    {
        $temporaryItem = TemporaryItem::with(['pengaduans' => function($query) {
            $query->with(['user', 'petugas'])->latest();
        }])->findOrFail($id_temporary);

        return view('admin.temporary_item.show', compact('temporaryItem'));
    }

    /**
     * Show the form for editing the specified temporary item
     */
    public function edit($id_temporary)
    {
        $temporaryItem = TemporaryItem::findOrFail($id_temporary);
        $lokasis = Lokasi::all();
        return view('admin.temporary_item.edit', compact('temporaryItem', 'lokasis'));
    }

    /**
     * Update the specified temporary item in storage
     */
    public function update(Request $request, $id_temporary)
    {
        $request->validate([
            'nama_barang_baru' => 'required|string|max:100',
            'lokasi_barang_baru' => 'required|string|max:100',
            'status' => 'required|in:baik,rusak,cacat',
            'deskripsi_masalah' => 'nullable|string',
            'foto_masalah' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string|max:200',
        ]);

        try {
            $temporaryItem = TemporaryItem::findOrFail($id_temporary);
            
            $temporaryItem->nama_barang_baru = $request->nama_barang_baru;
            $temporaryItem->lokasi_barang_baru = $request->lokasi_barang_baru;
            $temporaryItem->status = $request->status;
            $temporaryItem->deskripsi_masalah = $request->deskripsi_masalah;
            $temporaryItem->keterangan = $request->keterangan;

            if ($request->hasFile('foto_masalah')) {
                // Delete old photo
                if ($temporaryItem->foto_masalah && Storage::disk('public')->exists($temporaryItem->foto_masalah)) {
                    Storage::disk('public')->delete($temporaryItem->foto_masalah);
                }
                $path = $request->file('foto_masalah')->store('foto_temporary', 'public');
                $temporaryItem->foto_masalah = $path;
            }

            $temporaryItem->save();

            return redirect()->route('admin.temporary-item.index')
                ->with('success', 'Data berhasil diperbarui');
        } catch (\Throwable $e) {
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified temporary item from storage
     */
    public function destroy($id_temporary)
    {
        $temporaryItem = TemporaryItem::find($id_temporary);
        
        if (!$temporaryItem) {
            return redirect()->route('admin.temporary-item.index')
                ->with('error', 'Data tidak ditemukan');
        }

        // Delete foto if exists
        if ($temporaryItem->foto_masalah && Storage::disk('public')->exists($temporaryItem->foto_masalah)) {
            Storage::disk('public')->delete($temporaryItem->foto_masalah);
        }

        $temporaryItem->delete();
        
        return redirect()->route('admin.temporary-item.index')
            ->with('success', 'Data berhasil dihapus');
    }
}

