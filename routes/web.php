<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\PetugasDashboardController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\LokasiCrudController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PetugasItemController;
use App\Http\Controllers\PetugasLokasiCrudController;
use App\Http\Controllers\PenolakanController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TemporaryItemController;


/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// 🔹 Arahkan root ke login
Route::get('/', fn() => redirect()->route('login'));

/* =====================================================
   🔐 AUTH (Login, Register, Logout)
===================================================== */
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* =====================================================
   🧭 ADMIN
===================================================== */
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
      Route::get('/admin/pengaduan/{id}/cetak', [PengaduanController::class, 'cetak'])
        ->name('admin.pengaduan.cetak');
        
    // Aksi approve / tolak oleh admin
    Route::post('/admin/pengaduan/{id}/approve', [DashboardController::class, 'approve'])
        ->name('admin.pengaduan.approve');

    Route::get('/admin/pengaduan/{id}/tolak-form', [DashboardController::class, 'formTolak'])
        ->name('admin.pengaduan.tolak.form');

    Route::post('/admin/pengaduan/{id}/tolak', [DashboardController::class, 'tolak'])
        ->name('admin.pengaduan.tolak');
        

    // 📁 Kelola Petugas
    Route::prefix('admin/petugas')->name('admin.petugas.')->group(function () {
        Route::get('/', [PetugasController::class, 'index'])->name('index');
        Route::get('/create', [PetugasController::class, 'create'])->name('create');
        Route::post('/', [PetugasController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PetugasController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PetugasController::class, 'update'])->name('update');
        Route::delete('/{id}', [PetugasController::class, 'destroy'])->name('destroy');
    });

    // 👥 Kelola User
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserController::class, 'adminCreate'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'adminStore'])->name('admin.users.store');
    Route::get('/admin/users/{id}/edit', [UserController::class, 'adminEdit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [UserController::class, 'adminUpdate'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [UserController::class, 'adminDestroy'])->name('admin.users.destroy');

    // ⚙ Daftar Admin
    Route::get('/admin/daftar-admin', [PetugasController::class, 'daftarAdmin'])->name('admin.daftarAdmin');

    // 📜 History Perubahan Barang (Temporary Item)
    Route::prefix('admin/temporary-item')->name('admin.temporary-item.')->group(function () {
        Route::get('/', [TemporaryItemController::class, 'index'])->name('index');
        Route::get('/create', [TemporaryItemController::class, 'create'])->name('create');
        Route::post('/', [TemporaryItemController::class, 'store'])->name('store');
        Route::get('/{id_temporary}', [TemporaryItemController::class, 'show'])->name('show');
        Route::get('/{id_temporary}/edit', [TemporaryItemController::class, 'edit'])->name('edit');
        Route::put('/{id_temporary}', [TemporaryItemController::class, 'update'])->name('update');
        Route::delete('/{id_temporary}', [TemporaryItemController::class, 'destroy'])->name('destroy');
    });

    // �📦 Kelola Barang (Item)
    Route::prefix('admin/barang')->group(function () {
        Route::get('/', [LokasiController::class, 'index'])->name('lokasi.index');
        Route::get('/{id_lokasi}', [ItemController::class, 'showByLokasi'])->name('item.byLokasi');
        Route::get('/{id_lokasi}/tambah', [ItemController::class, 'create'])->name('item.create');
        Route::post('/{id_lokasi}/store', [ItemController::class, 'store'])->name('item.store');
        Route::get('/{id_item}/edit', [ItemController::class, 'edit'])->name('item.edit');
        Route::post('/{id_item}/update', [ItemController::class, 'update'])->name('item.update');
        Route::delete('/{id_item}/delete', [ItemController::class, 'destroy'])->name('item.delete');
    });

    // 🧱 CRUD Lokasi untuk Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::prefix('lokasi-crud')->name('lokasi.crud.')->group(function () {
            Route::get('/', [LokasiCrudController::class, 'index'])->name('index');          // admin.lokasi.crud.index
            Route::get('/create', [LokasiCrudController::class, 'create'])->name('create');  // admin.lokasi.crud.create
            Route::post('/', [LokasiCrudController::class, 'store'])->name('store');         // admin.lokasi.crud.store
            Route::get('/{id}/edit', [LokasiCrudController::class, 'edit'])->name('edit');   // admin.lokasi.crud.edit
            Route::put('/{id}', [LokasiCrudController::class, 'update'])->name('update');    // admin.lokasi.crud.update
            Route::delete('/{id}', [LokasiCrudController::class, 'destroy'])->name('destroy'); // admin.lokasi.crud.destroy
        });
    });
    

});

/* =====================================================
   🧩 PETUGAS
===================================================== */
Route::middleware(['auth', 'role:petugas'])->group(function () {

    

    // Dashboard Petugas
    Route::get('/petugas/dashboard', [PetugasDashboardController::class, 'index'])
        ->name('petugas.dashboard');


    // 🔹 Tombol aksi status pengaduan
    Route::post('/petugas/pengaduan/{id}/mulai', [PetugasDashboardController::class, 'mulai'])
        ->name('petugas.pengaduan.mulai');

    Route::post('/petugas/pengaduan/{id}/tolak', [PetugasDashboardController::class, 'tolak'])
        ->name('petugas.pengaduan.tolak');

    Route::post('/petugas/pengaduan/{id}/selesai', [PetugasDashboardController::class, 'selesai'])
        ->name('petugas.pengaduan.selesai');
        // Form saran
Route::get('/petugas/pengaduan/{id}/saran', [PetugasController::class, 'formSaran'])->name('petugas.formSaran');

// Kirim saran
Route::post('/petugas/pengaduan/{id}/saran', [PetugasController::class, 'kirimSaran'])->name('petugas.kirimSaran');


    // 📦 Barang & Lokasi (Petugas)
    Route::prefix('petugas')->name('petugas.')->group(function () {

        // Barang per Lokasi
        Route::get('/lokasi', [PetugasItemController::class, 'index'])->name('lokasi.index');
        Route::get('/lokasi/{id_lokasi}/barang', [PetugasItemController::class, 'showByLokasi'])->name('item.byLokasi');
        Route::get('/lokasi/{id_lokasi}/barang/tambah', [PetugasItemController::class, 'create'])->name('item.create');
        Route::post('/lokasi/{id_lokasi}/barang/store', [PetugasItemController::class, 'store'])->name('item.store');
        Route::get('/barang/edit/{id_item}', [PetugasItemController::class, 'edit'])->name('item.edit');
        Route::post('/barang/update/{id_item}', [PetugasItemController::class, 'update'])->name('item.update');
        Route::delete('/barang/delete/{id_item}', [PetugasItemController::class, 'destroy'])->name('item.delete');

        // Lokasi CRUD untuk Petugas
        Route::prefix('lokasi-crud')->name('lokasi.crud.')->group(function () {
            Route::get('/', [PetugasLokasiCrudController::class, 'index'])->name('index');
            Route::get('/create', [PetugasLokasiCrudController::class, 'create'])->name('create');
            Route::post('/', [PetugasLokasiCrudController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PetugasLokasiCrudController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PetugasLokasiCrudController::class, 'update'])->name('update');
            Route::delete('/{id}', [PetugasLokasiCrudController::class, 'destroy'])->name('destroy');
        });
    });
   Route::prefix('petugas')->group(function () {
    Route::get('/penolakan', [PenolakanController::class, 'index'])->name('petugas.penolakan.index');
     Route::get('/petugas/pengaduan/{id}/cetak', [PengaduanController::class, 'cetaklaporan'])
        ->name('petugas.pengaduan.cetak');
});

});

/* =====================================================
   👤 PENGGUNA (USER)
===================================================== */
Route::middleware(['auth', 'role:pengguna'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

    // Form tambah pengaduan
    Route::get('/user/pengaduan/tambah', [UserController::class, 'create'])->name('user.create_pengaduan');
    Route::post('/user/pengaduan/simpan', [UserController::class, 'store'])->name('user.store_pengaduan');
    Route::get('/user/barang-by-lokasi/{id_lokasi}', [UserController::class, 'getBarangByLokasi'])->name('user.barang_by_lokasi');
});

// GANTI route tolak yang lama dengan ini:
Route::get('/petugas/pengaduan/{id}/tolak-form', [PetugasDashboardController::class, 'formTolak'])
    ->name('petugas.pengaduan.tolak.form');

Route::post('/petugas/pengaduan/{id}/tolak', [PetugasDashboardController::class, 'tolak'])
    ->name('petugas.pengaduan.tolak');

