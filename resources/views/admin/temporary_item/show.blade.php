<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Barang Temporary - Admin</title>

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
/* Tombol SIMPAN */
.btn-edit {
  background-color: var(--cerulean);
  color: white;
  padding: 10px 22px;
  border-radius: 8px;
  border: 2px solid var(--cerulean);
  font-weight: 600;
  transition: 0.3s ease;
}

.btn-edit:hover {
  background-color: #00586b;
  border-color: #00586b;
  transform: translateY(-2px);
}

/* Tombol BATAL dengan STROKE */
.btn-back {
  background-color: transparent;
  color: var(--cerulean);
  padding: 10px 22px;
  border-radius: 8px;
  border: 2px solid var(--cerulean);  /* STROKE */
  font-weight: 600;
  margin-left: 10px;
  transition: 0.3s ease;
}

.btn-back:hover {
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
        <i class="fa fa-info-circle"></i> Detail Barang Temporary
      </h4>
      <span>Selamat datang, <b>{{ Auth::user()->name }}</b></span>
    </div>

    <!-- Tombol Navigasi -->
    <div style="margin-bottom: 20px;">
      <a href="{{ route('admin.temporary-item.index') }}" class="btn-back">
        <i class="fa fa-arrow-left"></i> Kembali
      </a>
      <a href="{{ route('admin.temporary-item.edit', $temporaryItem->id_temporary) }}" class="btn-edit">
        <i class="fa fa-edit"></i> Edit
      </a>
    </div>

    <!-- Detail Barang -->
    <div class="card">
      <div class="card-header">
        <i class="fa fa-box"></i> Informasi Barang Temporary
      </div>
      <div class="card-body">
        <div class="info-row">
          <div class="info-item">
            <div class="info-label">ID Temporary</div>
            <div class="info-value">{{ $temporaryItem->id_temporary }}</div>
          </div>
          <div class="info-item">
            <div class="info-label">Nama Barang</div>
            <div class="info-value"><strong>{{ $temporaryItem->nama_barang_baru }}</strong></div>
          </div>
        </div>

        <div class="info-row">
          <div class="info-item">
            <div class="info-label">Lokasi</div>
            <div class="info-value">{{ $temporaryItem->lokasi_barang_baru }}</div>
          </div>
          <div class="info-item">
            <div class="info-label">Status</div>
            <div class="info-value">
              @if ($temporaryItem->status == 'baik')
                <span class="badge bg-success"><i class="fa fa-check-circle"></i> Baik</span>
              @elseif ($temporaryItem->status == 'rusak')
                <span class="badge bg-danger"><i class="fa fa-times-circle"></i> Rusak</span>
              @elseif ($temporaryItem->status == 'cacat')
                <span class="badge bg-warning text-dark"><i class="fa fa-exclamation-circle"></i> Cacat</span>
              @endif
            </div>
          </div>
        </div>

        @if ($temporaryItem->deskripsi_masalah)
          <div class="info-item" style="grid-column: 1 / -1;">
            <div class="info-label">Deskripsi Masalah</div>
            <div class="info-value">{{ $temporaryItem->deskripsi_masalah }}</div>
          </div>
        @endif

        @if ($temporaryItem->keterangan)
          <div class="info-item" style="grid-column: 1 / -1;">
            <div class="info-label">Keterangan</div>
            <div class="info-value">{{ $temporaryItem->keterangan }}</div>
          </div>
        @endif

        <div class="info-row" style="margin-top: 20px;">
          <div class="info-item">
            <div class="info-label">Tanggal Dibuat</div>
            <div class="info-value">{{ $temporaryItem->created_at->format('d M Y H:i') }}</div>
          </div>
          <div class="info-item">
            <div class="info-label">Terakhir Diupdate</div>
            <div class="info-value">{{ $temporaryItem->updated_at->format('d M Y H:i') }}</div>
          </div>
        </div>

        @if ($temporaryItem->foto_masalah)
          <div style="margin-top: 20px; grid-column: 1 / -1;">
            <div class="info-label mb-2">Foto Masalah</div>
            <img src="{{ asset('storage/' . $temporaryItem->foto_masalah) }}" alt="Foto" class="image-preview">
          </div>
        @endif
      </div>
    </div>

    <!-- Pengaduan Terkait -->
    <div class="card">
      <div class="card-header">
        <i class="fa fa-list"></i> Pengaduan Terkait 
        <span class="badge bg-light text-dark ms-2">{{ $temporaryItem->pengaduans->count() }} pengaduan</span>
      </div>
      <div class="card-body">
        @if ($temporaryItem->pengaduans->count() > 0)
          @foreach ($temporaryItem->pengaduans as $pengaduan)
            <div class="pengaduan-item">
              <h6>
                <i class="fa fa-file-alt"></i> {{ $pengaduan->nama_pengaduan }}
                @if ($pengaduan->status == 'selesai')
                  <span class="badge bg-success ms-2">Selesai</span>
                @elseif ($pengaduan->status == 'ditolak')
                  <span class="badge bg-danger ms-2">Ditolak</span>
                @elseif ($pengaduan->status == 'diproses')
                  <span class="badge bg-warning text-dark ms-2">Diproses</span>
                @else
                  <span class="badge bg-info ms-2">{{ $pengaduan->status }}</span>
                @endif
              </h6>
              
              <div style="margin: 10px 0; padding: 10px 0; border-top: 1px solid #ddd;">
                <small>
                  <strong>Deskripsi:</strong> {{ Str::limit($pengaduan->deskripsi, 100) }}<br>
                  <strong>Lokasi:</strong> {{ $pengaduan->lokasi }}<br>
                  <strong>Pelapor:</strong> {{ $pengaduan->user->name ?? 'Unknown' }}<br>
                  <strong>Petugas:</strong> {{ $pengaduan->petugas->nama_petugas ?? '-' }}<br>
                  <strong>Tanggal Pengajuan:</strong> {{ \Carbon\Carbon::parse($pengaduan->tgl_pengajuan)->format('d M Y H:i') }}<br>
                  @if ($pengaduan->tgl_selesai)
                    <strong>Tanggal Selesai:</strong> {{ \Carbon\Carbon::parse($pengaduan->tgl_selesai)->format('d M Y H:i') }}<br>
                  @endif
                </small>
              </div>
            </div>
          @endforeach
        @else
          <div style="text-align: center; padding: 40px 20px; color: #7f8c8d;">
            <i class="fa fa-inbox" style="font-size: 48px; margin-bottom: 10px;"></i>
            <p>Tidak ada pengaduan terkait dengan barang ini</p>
          </div>
        @endif
      </div>
    </div>

  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
