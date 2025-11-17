<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard User - Pengaduan</title>
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

  <!-- Sidebar -->
  <div class="sidebar">
    <h3>PENGGUNA</h3>
    <div class="text-center my-3">
      <i class="fa-solid fa-user-circle fa-4x"></i>
      <p class="mt-2">{{ Auth::user()->name }}</p>
    </div>
    <a href="{{ route('user.dashboard') }}" class="active">
      <i class="fa fa-home"></i> Dashboard
    </a>
    <a href="{{ route('user.create_pengaduan') }}">
      <i class="fa fa-plus"></i> Buat Pengaduan
    </a>
    <a href="{{ route('user.dashboard') }}">
      <i class="fa fa-file-alt"></i> Riwayat Pengaduan
    </a>

    <form method="POST" action="{{ route('logout') }}" class="mt-3 px-3">
      @csrf
      <button class="btn btn-danger w-100">
        <i class="fa fa-sign-out-alt"></i> Logout
      </button>
    </form>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Topbar -->
    <div class="topbar d-flex justify-content-between align-items-center">
      <h4>Dashboard User</h4>
      <span>Halo, <b>{{ Auth::user()->name }}</b></span>
    </div>

    <!-- Card Tabel Pengaduan -->
    <div class="card-table">
      <div class="d-flex justify-content-between mb-3">
        <h5>Riwayat Pengaduan Saya</h5>
        <a href="{{ route('user.create_pengaduan') }}" class="btn btn-sm btn-primary">
          <i class="fa fa-plus"></i> Tambah Pengaduan
        </a>
      </div>

      @if($pengaduan->count() > 0)
        <div class="table-responsive">
          <table class="table table-bordered align-middle">
            <thead class="table-light text-center">
              <tr>
                <th>No</th>
                <th>Nama Pengaduan</th>
                <th>Deskripsi</th>
                <th>Lokasi</th>
                <th>Foto</th>
                <th>Status</th>
                <th>Nama Petugas</th>
                <th>Saran Petugas</th>
                <th>Tgl Pengajuan</th>
                <th>Tgl Selesai</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pengaduan as $i => $p)
                @php
                  $badge = match($p->status) {
                    'Diajukan'  => 'bg-warning text-dark',
                    'Diproses'  => 'bg-primary',
                    'Selesai'   => 'bg-success',
                    'Ditolak'   => 'bg-danger',
                    default     => 'bg-secondary',
                  };
                @endphp
                <tr>
                  <td class="text-center">{{ $i + 1 }}</td>
                  <td>{{ $p->nama_pengaduan }}</td>
                  <td>{{ Str::limit($p->deskripsi, 80, '...') }}</td>
                  <td>{{ $p->lokasi }}</td>
                  <td class="text-center">
                    @if($p->foto)
                      <img src="{{ asset('storage/' . $p->foto) }}" alt="Foto Pengaduan" class="photo-thumbnail">
                    @else
                      <span class="text-muted">Tidak ada</span>
                    @endif
                  </td>
                  <td class="text-center">
                    <span class="badge {{ $badge }}">{{ $p->status }}</span>
                  </td>
               <td>{{ $p->petugas ? $p->petugas->nama : '-' }}</td>


                  <td>
                    @if($p->saran_petugas)
                      <div>{{ $p->saran_petugas }}</div>
                      @if($p->saran_foto)
                        <div class="mt-2 text-center">
                          <img src="{{ asset('storage/' . $p->saran_foto) }}" alt="Foto Saran" class="photo-thumbnail">
                        </div>
                      @endif
                    @else
                      -
                    @endif
                  </td>
                  <td>{{ \Carbon\Carbon::parse($p->tgl_pengajuan)->format('d-m-Y') }}</td>
                  <td>
                    @if($p->tgl_selesai)
                      {{ \Carbon\Carbon::parse($p->tgl_selesai)->format('d-m-Y') }}
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <p class="text-muted">Belum ada pengaduan yang diajukan.</p>
      @endif
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
