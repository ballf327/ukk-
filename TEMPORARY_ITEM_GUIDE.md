# 📋 Fitur Temporary Item (History Perubahan Barang)

## 🎯 Tujuan

Fitur **Temporary Item** dirancang sebagai "tempat penampungan" untuk melacak aset/barang yang baru datang dan belum memiliki nomor inventaris resmi. Fitur ini memungkinkan:

- **Pencatatan Barang Baru** sebelum diberikan nomor aset resmi
- **Hubungan dengan Pengaduan** - Guru/user dapat melaporkan masalah barang baru tanpa harus menunggu proses inventaris
- **Riwayat Lengkap** - Kelompokkan semua pengaduan yang terkait dengan barang baru yang sama

## 📌 Skenario Use Case: 10 Komputer Baru, 3 Rusak

**Timeline Kejadian:**

```
HARI 1 - PAGI
├─ Sekolah menerima 10 set komputer baru untuk lab
├─ Barang diterima fisiknya
└─ Belum diberi nomor inventaris resmi (belum masuk database items)

HARI 1 - SIANG  
├─ Admin membuat Temporary Item: "TEMP-KOMP-LAB" (Komputer Lab, Baik)
└─ Barang ditempatkan di laboratorium

HARI 1 - SORE
├─ Guru melaporkan: "Komputer Meja 3 tidak bisa menyala" 
├─ User membuat PENGADUAN
├─ Memilih "id_temporary" (bukan id_item, karena belum punya nomor aset)
└─ Sistem terhubung pengaduan ke Temporary Item

HARI 2 - PAGI
├─ Guru lain melaporkan: "3 unit dari komputer baru ada error software"
├─ User membuat 3 PENGADUAN lagi
└─ Semua terhubung ke Temporary Item yang sama

HARI 2 - SIANG
├─ Admin buka History → Temporary Items
├─ Klik "Lihat Detail" pada TEMP-KOMP-LAB
├─ Melihat tabel: 4 pengaduan total (1 rusak hardware, 3 error software)
└─ Kepala Sekolah & Aset dapat segera tahu ada masalah dengan kiriman ini
```

## 🔧 Struktur Database

### Tabel: temporary_item
```
id_temporary          - Primary Key
id_item              - FK ke items (0 = belum resmi)
nama_barang_baru     - Nama barang/item
lokasi_barang_baru   - Lokasi/ruangan
status               - baik | rusak | cacat
deskripsi_masalah    - Penjelasan masalah/kerusakan
foto_masalah         - Dokumentasi foto
keterangan           - Info tambahan
created_at, updated_at
```

### Tabel: pengaduan (UPDATED)
```
... (existing columns)
id_item              - FK ke items (NULL jika pakai temporary)
id_temporary         - FK ke temporary_item (NEW!) ⭐
... (existing columns)
```

## 🚀 Fitur-Fitur

### 1. **Admin: Kelola Temporary Item**

#### a) Lihat History (GET `/admin/temporary-item`)
- Daftar semua barang temporary
- Status badge (Baik/Rusak/Cacat)
- Pagination (15 item per halaman)
- Tombol: **Lihat Detail**, **Edit**, **Hapus**

#### b) Tambah Barang Temporary (GET/POST `/admin/temporary-item/create`)
- Nama barang baru
- Lokasi/ruangan
- Status (Baik/Rusak/Cacat)
- Deskripsi masalah
- Upload foto kerusakan
- Keterangan tambahan

#### c) Edit Data (GET/PUT `/admin/temporary-item/{id}/edit`)
- Ubah semua informasi
- Ganti foto jika diperlukan

#### d) **⭐ Lihat Detail + Pengaduan Terkait** (GET `/admin/temporary-item/{id}`)
- Informasi lengkap barang temporary
- **Tabel Pengaduan yang terhubung:**
  - Nama pengaduan
  - Status (Diajukan/Diproses/Selesai/Ditolak)
  - Deskripsi
  - Pelapor (nama user)
  - Petugas yang menangani
  - Tanggal pengajuan & penyelesaian
  - Lokasi

#### e) Hapus Data (DELETE `/admin/temporary-item/{id}`)
- Hapus record & foto terkait

### 2. **User: Buat Pengaduan untuk Barang Temporary**

#### Form Pengaduan (UPDATED)
User sekarang punya 2 pilihan saat membuat pengaduan:
1. **Pilih Barang dari Daftar Resmi** (id_item) - Barang sudah punya nomor inventaris
2. **Pilih Barang Temporary** (id_temporary) - Barang baru belum diresmikan

**Aturan:** Minimal pilih SALAH SATU (tidak harus keduanya)

## 📊 Relasi Model

```php
// TemporaryItem Model
public function pengaduans() {
    return $this->hasMany(Pengaduan::class, 'id_temporary', 'id_temporary');
}

// Pengaduan Model
public function temporaryItem() {
    return $this->belongsTo(TemporaryItem::class, 'id_temporary', 'id_temporary');
}
```

## 🎨 User Interface

### Sidebar Menu
```
- Dashboard
- Data Pengaduan
- Data User
- Kelola Petugas
- Daftar Admin
- Daftar Ruang
- Tambah Barang
- History ⭐ (Temporary Item Hub)
```

### Halaman Detail Temporary Item
```
┌─ Detail Barang Temporary ─────────────────────────┐
│                                                    │
│ ID:         TEMP-001                              │
│ Nama:       Komputer Dell Inspiron XPS 13        │
│ Lokasi:     Lab Komputer A                        │
│ Status:     🟡 Rusak                              │
│ Deskripsi:  LCD pecah saat pembukaan paket        │
│ Foto:       [Preview Image]                       │
│                                                    │
├─ Pengaduan Terkait (4 pengaduan) ─────────────────┤
│                                                    │
│ 1. Komputer tidak menyala (Selesai) ✅           │
│    └─ Pelapor: Guru Budi                          │
│    └─ Petugas: Teknisi Ahmad                      │
│    └─ 13 Nov 2025 14:30 - 13 Nov 2025 16:45     │
│                                                    │
│ 2. Error Software (Diproses) ⏳                   │
│    └─ Pelapor: Guru Siti                          │
│    └─ Petugas: Teknisi Ahmad                      │
│    └─ 13 Nov 2025 15:00 - -                       │
│                                                    │
└────────────────────────────────────────────────────┘
```

## 💾 Workflow Lengkap

```
ADMIN FLOW:
Admin Dashboard 
  ↓
Klik "History" di sidebar
  ↓
Lihat tabel Temporary Items
  ↓
Klik "Lihat Detail" pada barang
  ↓
Melihat detail barang + 4 pengaduan yang terhubung
  ↓
Admin/Kepala Sekolah bisa ambil keputusan:
  - "Barang ini rusak, contact vendor untuk klaim"
  - "3 unit ada error software, test ulang sebelum resmi"
  - "Barang sesuai, lanjutkan proses inventaris"

USER FLOW:
User melaporkan masalah barang baru
  ↓
Buka form "Buat Pengaduan"
  ↓
Isi: Judul, Deskripsi, Lokasi, Foto
  ↓
Pilih:
  - Barang dari daftar resmi (jika punya nomor aset), ATAU
  - Barang Temporary (jika barang baru belum resmi)
  ↓
Submit pengaduan
  ↓
Sistem otomatis linking pengaduan → Temporary Item
  ↓
Admin lihat History untuk tracking semua pengaduan terkait
```

## 📁 File-File Terkait

```
Controllers:
✅ TemporaryItemController.php     - index, create, store, show, edit, update, destroy
✅ UserController.php               - Updated create() & store()

Models:
✅ TemporaryItem.php                - Added pengaduans() relationship
✅ Pengaduan.php                    - Added id_temporary, temporaryItem() relationship

Views:
✅ admin/temporary_item/index.blade.php       - List temporary items
✅ admin/temporary_item/create.blade.php      - Form tambah barang temporary
✅ admin/temporary_item/edit.blade.php        - Form edit barang temporary
✅ admin/temporary_item/show.blade.php        - Detail + Pengaduan terkait ⭐
✅ user/create.blade.php                      - Form pengaduan (updated)

Migrations:
✅ 2025_11_13_025918_add_columns_to_temporary_item_table.php
✅ 2025_11_13_030709_add_id_temporary_to_pengaduan_table.php

Routes:
✅ web.php - /admin/temporary-item/* routes
```

## 🔐 Akses & Permissions

- **Admin Only** - Lihat, buat, edit, hapus temporary item
- **User/Guru** - Buat pengaduan referensi ke temporary item
- **Petugas** - Lihat & tangani pengaduan dari temporary item

## ✨ Keunggulan Implementasi

✅ **Linking Otomatis** - Pengaduan terhubung ke Temporary Item  
✅ **Tracking Terpusat** - Lihat semua masalah barang baru di satu tempat  
✅ **Dokumentasi Lengkap** - Foto, status, deskripsi masalah  
✅ **Flexible Form** - User bisa pilih barang resmi ATAU barang temporary  
✅ **Report Untuk Manajemen** - Kepala sekolah & Bagian Aset bisa analisa  
✅ **Audit Trail** - Riwayat lengkap dari penerimaan hingga penyelesaian  

## 🎓 Contoh Penggunaan

### Skenario 1: Barang Rusak Saat Diterima
```
1. Admin catat di Temporary Item:
   - Nama: Proyektor Sony 5000 Lumen
   - Lokasi: Ruang Aula
   - Status: Rusak
   - Deskripsi: Lampu tidak menyala saat testing

2. Barang menunggu konfirmasi dari vendor

3. Jika ada pengaduan dari user, langsung link ke temporary ini
   └─ History akan menunjukkan barang ini punya masalah sejak penerimaan
```

### Skenario 2: Barang Rusak Setelah Digunakan Sementara
```
1. Komputer baru diterima - Admin catat dengan status "Baik"

2. Guru melaporkan ada masalah:
   - "Komputer Lab 3 layar mati"
   
3. User buat Pengaduan + link ke Temporary Item

4. Admin lihat Detail:
   - Barang ini status "Baik" saat diterima
   - Tapi sekarang ada pengaduan kerusakan
   └─ Berarti rusak akibat penggunaan, bukan cacat pabrik

5. Bisa request garansi dengan bukti timeline lengkap
```

## 🚀 Next Features (Opsional)

- Export history ke PDF/Excel
- Filter pengaduan berdasarkan status
- Notifikasi ke Kepala Sekolah saat ada pengaduan
- Statistik barang rusak per bulan
- Proses "Konversi Temporary ke Item" (formal naming + nomor aset)

---

**Versi**: 2.0 (Updated dengan integrasi Pengaduan)  
**Tanggal**: 13 November 2025  
**Status**: Active & Production Ready ✅
