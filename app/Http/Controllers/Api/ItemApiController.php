<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemApiController extends Controller
{
    /**
     * Get all items
     */
    public function index(Request $request)
    {
        $query = Item::query();

        // Filter by lokasi if provided
        if ($request->has('lokasi')) {
            $query->where('lokasi', $request->lokasi);
        }

        $items = $query->get();

        return response()->json([
            'success' => true,
            'data' => $items,
        ], 200);
    }

    /**
     * Get item by ID
     */
    public function show($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $item,
        ], 200);
    }
}

