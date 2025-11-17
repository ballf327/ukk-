<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>History Perubahan Barang - Admin</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
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
</style>
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
        <i class="fa fa-history"></i> History Perubahan Barang
      </h4>
      <span>Selamat datang, <b>{{ Auth::user()->name }}</b></span>
    </div>

    <!-- Button Tambah -->
    <div style="margin-bottom: 20px;">
      <a href="{{ route('admin.temporary-item.create') }}" class="btn btn-primary">
        <i class="fa fa-plus"></i> Tambah Barang Temporary
      </a>
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

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>Berhasil!</strong> {{ session('success') }}
      </div>
    @endif

    @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>Gagal!</strong> {{ session('error') }}
      </div>
    @endif

    <!-- Table -->
    <div class="table-container">
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th style="width: 50px;">#</th>
              <th>Nama Barang</th>
              <th>Lokasi</th>
              <th>Status</th>
              <th>Deskripsi Masalah</th>
              <th>Tanggal Dibuat</th>
              <th style="width: 120px; text-align: center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($temporaryItems as $index => $item)
              <tr>
                <td>{{ ($temporaryItems->currentPage() - 1) * $temporaryItems->perPage() + $loop->iteration }}</td>
                <td>
                  <strong>{{ $item->nama_barang_baru ?? 'N/A' }}</strong>
                </td>
                <td>{{ $item->lokasi_barang_baru ?? '-' }}</td>
                <td>
                  @if ($item->status == 'baik')
                    <span class="badge bg-success"><i class="fa fa-check-circle"></i> Baik</span>
                  @elseif ($item->status == 'rusak')
                    <span class="badge bg-danger"><i class="fa fa-times-circle"></i> Rusak</span>
                  @elseif ($item->status == 'cacat')
                    <span class="badge bg-warning text-dark"><i class="fa fa-exclamation-circle"></i> Cacat</span>
                  @endif
                </td>
                <td>
                  {{ Str::limit($item->deskripsi_masalah ?? '-', 50) }}
                  @if ($item->foto_masalah)
                    <br><small class="text-muted"><i class="fa fa-image"></i> Ada foto</small>
                  @endif
                </td>
                <td>
                  {{ $item->created_at->format('d M Y H:i') }}
                </td>
                <td style="text-align: center;">
                  <a href="{{ route('admin.temporary-item.show', $item->id_temporary) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                    <i class="fa fa-eye"></i>
                  </a>
                  <a href="{{ route('admin.temporary-item.edit', $item->id_temporary) }}" class="btn btn-warning btn-sm" title="Edit">
                    <i class="fa fa-edit"></i>
                  </a>
                  <form action="{{ route('admin.temporary-item.destroy', $item->id_temporary) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                      <i class="fa fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center py-4 text-muted">
                  <i class="fa fa-inbox"></i> Tidak ada data perubahan barang
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      @if ($temporaryItems->count())
        <div class="d-flex justify-content-center">
          {{ $temporaryItems->links('pagination::bootstrap-4') }}
        </div>
      @endif
    </div>

  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
