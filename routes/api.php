<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PengaduanApiController;
use App\Http\Controllers\Api\LokasiApiController;
use App\Http\Controllers\Api\ItemApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* =====================================================
   🔐 AUTH ROUTES (Public)
===================================================== */
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);

/* =====================================================
   🔒 PROTECTED ROUTES (Require Authentication)
===================================================== */
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/user', [AuthApiController::class, 'user']);
    
    // Pengaduan
    Route::get('/pengaduan', [PengaduanApiController::class, 'index']);
    Route::get('/pengaduan/{id}', [PengaduanApiController::class, 'show']);
    Route::post('/pengaduan', [PengaduanApiController::class, 'store']);
    Route::put('/pengaduan/{id}', [PengaduanApiController::class, 'update']);
    Route::delete('/pengaduan/{id}', [PengaduanApiController::class, 'destroy']);
    
    // Lokasi
    Route::get('/lokasi', [LokasiApiController::class, 'index']);
    Route::get('/lokasi/{id}', [LokasiApiController::class, 'show']);
    
    // Item
    Route::get('/item', [ItemApiController::class, 'index']);
    Route::get('/item/{id}', [ItemApiController::class, 'show']);
});
