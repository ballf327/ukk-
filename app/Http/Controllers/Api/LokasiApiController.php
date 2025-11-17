<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiApiController extends Controller
{
    /**
     * Get all lokasi
     */
    public function index()
    {
        $lokasi = Lokasi::all();

        return response()->json([
            'success' => true,
            'data' => $lokasi,
        ], 200);
    }

    /**
     * Get lokasi by ID
     */
    public function show($id)
    {
        $lokasi = Lokasi::find($id);

        if (!$lokasi) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $lokasi,
        ], 200);
    }
}

