<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PengaduanApiController extends Controller
{
    /**
     * Get all pengaduan
     */
    public function index(Request $request)
    {
        $query = Pengaduan::with(['user', 'petugas', 'item', 'temporaryItem']);

        // Filter by user if role is pengguna
        if (Auth::user()->role === 'pengguna') {
            $query->where('id_user', Auth::id());
        }

        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $pengaduan = $query->orderBy('tgl_pengajuan', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $pengaduan,
        ], 200);
    }

    /**
     * Get pengaduan by ID
     */
    public function show($id)
    {
        $pengaduan = Pengaduan::with(['user', 'petugas', 'item', 'temporaryItem'])
            ->find($id);

        if (!$pengaduan) {
            return response()->json([
                'success' => false,
                'message' => 'Pengaduan tidak ditemukan',
            ], 404);
        }

        // Check authorization
        if (Auth::user()->role === 'pengguna' && $pengaduan->id_user !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $pengaduan,
        ], 200);
    }

    /**
     * Create pengaduan
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pengaduan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string',
            'foto' => 'nullable|string', // base64 image
            'id_item' => 'nullable|exists:items,id_item',
            'id_temporary' => 'nullable|exists:temporary_item,id_temporary',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Handle base64 image
        $filePath = null;
        if ($request->has('foto') && $request->foto) {
            try {
                // Decode base64 image
                $imageData = $request->foto;
                if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                    $imageData = substr($imageData, strpos($imageData, ',') + 1);
                    $type = strtolower($type[1]);
                }

                $imageData = base64_decode($imageData);
                $fileName = 'pengaduan_' . time() . '_' . uniqid() . '.' . ($type ?? 'jpg');
                $filePath = 'pengaduan/' . $fileName;

                Storage::disk('public')->put($filePath, $imageData);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error processing image: ' . $e->getMessage(),
                ], 422);
            }
        }

        $pengaduan = Pengaduan::create([
            'id_user' => Auth::id(),
            'nama_pengaduan' => $request->nama_pengaduan,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'foto' => $filePath,
            'status' => 'Diajukan',
            'tgl_pengajuan' => now(),
            'id_item' => $request->id_item,
            'id_temporary' => $request->id_temporary,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan berhasil dibuat',
            'data' => $pengaduan->load(['user', 'item']),
        ], 201);
    }

    /**
     * Update pengaduan
     */
    public function update(Request $request, $id)
    {
        $pengaduan = Pengaduan::find($id);

        if (!$pengaduan) {
            return response()->json([
                'success' => false,
                'message' => 'Pengaduan tidak ditemukan',
            ], 404);
        }

        // Check authorization
        if (Auth::user()->role === 'pengguna' && $pengaduan->id_user !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'nama_pengaduan' => 'sometimes|string|max:255',
            'deskripsi' => 'sometimes|string',
            'lokasi' => 'sometimes|string',
            'status' => 'sometimes|string',
            'saran_petugas' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $pengaduan->fill($request->only([
            'nama_pengaduan',
            'deskripsi',
            'lokasi',
            'status',
            'saran_petugas',
        ]));

        if ($request->has('status') && $request->status === 'Selesai') {
            $pengaduan->tgl_selesai = now();
        }

        $pengaduan->save();

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan berhasil diupdate',
            'data' => $pengaduan->load(['user', 'petugas', 'item']),
        ], 200);
    }

    /**
     * Delete pengaduan
     */
    public function destroy($id)
    {
        $pengaduan = Pengaduan::find($id);

        if (!$pengaduan) {
            return response()->json([
                'success' => false,
                'message' => 'Pengaduan tidak ditemukan',
            ], 404);
        }

        // Check authorization
        if (Auth::user()->role === 'pengguna' && $pengaduan->id_user !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        // Delete foto if exists
        if ($pengaduan->foto && Storage::disk('public')->exists($pengaduan->foto)) {
            Storage::disk('public')->delete($pengaduan->foto);
        }

        $pengaduan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan berhasil dihapus',
        ], 200);
    }
}

