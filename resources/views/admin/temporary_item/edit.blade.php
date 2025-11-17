<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Barang Temporary - Admin</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    /* ========== GLOBAL ========== */
:root {
  --cerulean: #006C84;    /* biru laut elegan */
  --blue-topaz: #6EB5C0;  /* biru muda pastel */
  --icicle: #E2E8E4;      /* abu lembut */
  --soft-coral: #FEC8B8;  /* coral lembut aksen */
  --dark: #1A1A1A;        /* teks gelap */
}

body {
  font-family: "Poppins", sans-serif;
  background-color: var(--icicle);
  color: var(--dark);
  margin: 0;
  display: flex;
  transition: background 0.3s ease;
}

/* ========== SIDEBAR ========== */
.sidebar {
  width: 240px;
  height: 100vh;
  background: linear-gradient(180deg, var(--cerulean) 0%, var(--blue-topaz) 100%);
  color: white;
  position: fixed;
  top: 0;
  left: 0;
  border-right: 1px solid rgba(255, 255, 255, 0.1);
  box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
  padding-top: 25px;
}

.sidebar h3 {
  text-align: center;
  font-size: 18px;
  font-weight: 700;
  letter-spacing: 1px;
  color: #fff;
  margin-bottom: 30px;
}

.sidebar .user-info {
  text-align: center;
  margin-bottom: 25px;
}

.sidebar .user-info i {
  font-size: 48px;
  color: var(--soft-coral);
}

.sidebar a {
  display: block;
  color: rgba(255, 255, 255, 0.9);
  padding: 12px 25px;
  font-size: 15px;
  border-left: 4px solid transparent;
  transition: all 0.3s ease;
}

.sidebar a:hover,
.sidebar a.active {
  background-color: rgba(255, 255, 255, 0.12);
  border-left: 4px solid var(--soft-coral);
  padding-left: 32px;
  color: #fff;
}

/* ========== MAIN CONTENT ========== */
.main-content {
  margin-left: 240px;
  padding: 30px;
  width: 100%;
  min-height: 100vh;
}

.topbar {
  background-color: #fff;
  border-radius: 10px;
  padding: 18px 25px;
  margin-bottom: 30px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.topbar h4 {
  margin: 0;
  color: var(--cerulean);
  font-weight: 600;
}

/* ========== CARD STAT ========== */
.card-stat {
  border-radius: 14px;
  padding: 22px;
  color: white;
  text-align: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-stat:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.bg-primary { background: var(--cerulean) !important; }
.bg-success { background: var(--blue-topaz) !important; }
.bg-warning { background: var(--soft-coral) !important; color: #333 !important; }
.bg-danger  { background: #1f3b4d !important; }

/* ========== TABLE ========== */
.table thead {
  background: var(--cerulean);
  color: #fff;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: #f8fafb;
}

.table-hover tbody tr:hover {
  background-color: rgba(110, 181, 192, 0.2);
}

.badge {
  padding: 6px 10px;
  border-radius: 8px;
  font-size: 12px;
  font-weight: 500;
}

/* ========== PHOTO ========== */
.photo-thumbnail {
  width: 70px;
  height: 70px;
  object-fit: cover;
  border-radius: 8px;
  border: 2px solid var(--icicle);
  cursor: pointer;
  transition: all 0.3s ease;
}

.photo-thumbnail:hover {
  transform: scale(1.08);
  border-color: var(--blue-topaz);
}

/* ========== MODAL FOTO ========== */
.modal-photo {
  max-height: 80vh;
  border-radius: 10px;
  border: 4px solid var(--blue-topaz);
}

/* ========== RESPONSIVE ========== */
@media (max-width: 992px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: relative;
  }

  .main-content {
    margin-left: 0;
    padding: 20px;
  }

  .sidebar .user-info { display: none; }
}

/* Tombol SIMPAN */
.btn-submit {
  background-color: var(--cerulean);
  color: white;
  padding: 10px 22px;
  border-radius: 8px;
  border: 2px solid var(--cerulean);
  font-weight: 600;
  transition: 0.3s ease;
}

.btn-submit:hover {
  background-color: #00586b;
  border-color: #00586b;
  transform: translateY(-2px);
}

/* Tombol BATAL dengan STROKE */
.btn-cancel {
  background-color: transparent;
  color: var(--cerulean);
  padding: 10px 22px;
  border-radius: 8px;
  border: 2px solid var(--cerulean);  /* STROKE */
  font-weight: 600;
  margin-left: 10px;
  transition: 0.3s ease;
}

.btn-cancel:hover {
  background-color: rgba(0, 108, 132, 0.1);
  color: var(--cerulean);
  transform: translateY(-2px);
}
  </style>
</head>
<body>

  <!-- ===== SIDEBAR ===== -->
  <div class="sidebar">
    <h3>ADMINISTRATOR</h3>

    <div class="user-info">
      <i class="fa-solid fa-user-shield"></i>
      <p class="mt-2 mb-0 fw-bold">{{ Auth::user()->name }}</p>
    </div>

    <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Dashboard</a>
    <a href="#data-pengaduan" class="nav-scroll"><i class="fa fa-database"></i> Data Pengaduan</a>
    <a href="{{ route('admin.users.index') }}"><i class="fa fa-users"></i> Data User</a>
    <a href="{{ route('admin.petugas.index') }}"><i class="fa fa-user-tie"></i> Kelola Petugas</a>
    <a href="{{ route('admin.daftarAdmin') }}"><i class="fa fa-user-cog"></i> Daftar Admin</a>
    <a href="{{ route('admin.lokasi.crud.index') }}"><i class="fa fa-list"></i> Daftar Ruang</a>
    <a href="{{ route('lokasi.index') }}"><i class="fa fa-box"></i> Tambah Barang</a>
    <a href="{{ route('admin.temporary-item.index') }}" class="active"><i class="fa fa-history"></i> History</a>

    <form method="POST" action="{{ route('logout') }}" class="mt-3 px-3">
      @csrf
      <button class="btn btn-danger w-100"><i class="fa fa-sign-out-alt"></i> Logout</button>
    </form>
  </div>

  <!-- ===== MAIN CONTENT ===== -->
  <div class="main-content">

    <!-- Topbar -->
    <div class="topbar">
      <h4 class="mb-0">
        <i class="fa fa-edit"></i> Edit Barang Temporary
      </h4>
      <span>Selamat datang, <b>{{ Auth::user()->name }}</b></span>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>Terjadi Kesalahan!</strong>
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>Gagal!</strong> {{ session('error') }}
      </div>
    @endif

    <!-- Form -->
    <div class="form-container">
      <form action="{{ route('admin.temporary-item.update', $temporaryItem->id_temporary) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label for="nama_barang_baru">
            Nama Barang <span class="required">*</span>
          </label>
          <input type="text" id="nama_barang_baru" name="nama_barang_baru" class="form-control" 
                 placeholder="Contoh: Komputer Dell Inspiron" value="{{ old('nama_barang_baru', $temporaryItem->nama_barang_baru) }}" required>
          @error('nama_barang_baru')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="form-group">
          <label for="lokasi_barang_baru">
            Lokasi/Ruangan <span class="required">*</span>
          </label>
          <input type="text" id="lokasi_barang_baru" name="lokasi_barang_baru" class="form-control" 
                 placeholder="Contoh: Lab Komputer A" value="{{ old('lokasi_barang_baru', $temporaryItem->lokasi_barang_baru) }}" required>
          @error('lokasi_barang_baru')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="form-group">
          <label for="status">
            Status Barang <span class="required">*</span>
          </label>
          <select id="status" name="status" class="form-control" required>
            <option value="">-- Pilih Status --</option>
            <option value="baik" @if(old('status', $temporaryItem->status) == 'baik') selected @endif>
              Baik
            </option>
            <option value="rusak" @if(old('status', $temporaryItem->status) == 'rusak') selected @endif>
              Rusak
            </option>
            <option value="cacat" @if(old('status', $temporaryItem->status) == 'cacat') selected @endif>
              Cacat
            </option>
          </select>
          @error('status')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="form-group">
          <label for="deskripsi_masalah">
            Deskripsi Masalah/Kerusakan
          </label>
          <textarea id="deskripsi_masalah" name="deskripsi_masalah" class="form-control" 
                    placeholder="Jelaskan masalah atau kerusakan yang ditemukan (opsional)">{{ old('deskripsi_masalah', $temporaryItem->deskripsi_masalah) }}</textarea>
          @error('deskripsi_masalah')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="form-group">
          <label for="foto_masalah">
            Foto Kerusakan
          </label>
          
          @if ($temporaryItem->foto_masalah)
            <div>
              <img src="{{ asset('storage/' . $temporaryItem->foto_masalah) }}" alt="Foto" class="image-preview">
              <p class="mt-2 mb-3"><small class="text-muted">Foto saat ini</small></p>
            </div>
          @endif

          <input type="file" id="foto_masalah" name="foto_masalah" class="form-control" 
                 accept="image/jpeg,image/png,image/jpg">
          <small class="text-muted">Format: JPG, JPEG, PNG. Max: 2MB (Kosongkan jika tidak ingin mengubah)</small>
          @error('foto_masalah')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="form-group">
          <label for="keterangan">
            Keterangan Tambahan
          </label>
          <input type="text" id="keterangan" name="keterangan" class="form-control" 
                 placeholder="Informasi tambahan (opsional)" value="{{ old('keterangan', $temporaryItem->keterangan) }}">
          @error('keterangan')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="form-group" style="margin-top: 30px;">
          <button type="submit" class="btn-submit">
            <i class="fa fa-save"></i> Simpan Perubahan
          </button>
          <a href="{{ route('admin.temporary-item.index') }}" class="btn-cancel">
            <i class="fa fa-times"></i> Batal
          </a>
        </div>
      </form>
    </div>

  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
