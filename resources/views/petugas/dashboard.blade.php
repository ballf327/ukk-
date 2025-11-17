<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Petugas - Pengaduan Sarpras</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

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

  <!-- Overlay untuk mobile -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>
  
  <!-- Burger Button -->
  <button class="sidebar-toggle" id="toggleSidebar">
    <i class="fa fa-bars"></i> Menu
  </button>

  <!-- Sidebar -->
  <div class="sidebar hidden" id="sidebar">
    <h3>PETUGAS PANEL</h3>
    <div class="text-center mb-3">
      <i class="fa-solid fa-user-circle fa-4x"></i>
      <p class="mt-2">{{ Auth::guard('petugas')->user()->nama ?? 'Petugas' }}</p>
    </div>

    <a href="{{ route('petugas.dashboard') }}" class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
      <i class="fa fa-home"></i> Dashboard
    </a>

    <a href="{{ route('petugas.lokasi.index') }}">
      <i class="fa fa-box"></i> Data Barang
    </a>

    <a href="{{ route('petugas.lokasi.crud.index') }}">
      <i class="fa fa-list"></i> Daftar Ruang
    </a>
    
    <a href="{{ route('petugas.penolakan.index') }}" class="{{ request()->routeIs('petugas.penolakan.index') ? 'active' : '' }}">
      <i class="fa fa-ban"></i> Riwayat Penolakan
    </a>

    <form method="POST" action="{{ route('logout') }}" class="mt-3 px-3">
      @csrf
      <button class="btn btn-danger w-100"><i class="fa fa-sign-out-alt"></i> Logout</button>
    </form>
  </div>

  <!-- Main -->
  <div class="main-content" id="mainContent">
    <h4 class="fw-bold text-primary mb-4"><i class="fa fa-gauge"></i> Dashboard Petugas</h4>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <!-- Statistik -->
    <div class="row g-3 mb-4">
      <div class="col-md-3"><div class="card text-center border-primary"><div class="card-body"><h6>Total Pengaduan</h6><h3 class="text-primary fw-bold">{{ $totalPengaduan }}</h3></div></div></div>
      <div class="col-md-3"><div class="card text-center border-info"><div class="card-body"><h6>Sedang Diproses</h6><h3 class="text-info fw-bold">{{ $pengaduanProses }}</h3></div></div></div>
      <div class="col-md-3"><div class="card text-center border-success"><div class="card-body"><h6>Selesai / Disetujui</h6><h3 class="text-success fw-bold">{{ $pengaduanSelesai }}</h3></div></div></div>
      <div class="col-md-3"><div class="card text-center border-danger"><div class="card-body"><h6>Ditolak</h6><h3 class="text-danger fw-bold">{{ $jumlahPenolakan }}</h3></div></div></div>
    </div>

    <!-- Daftar Pengaduan -->
    <div class="card">
      <div class="card-header bg-primary text-white">
        <i class="fa fa-list"></i> Daftar Pengaduan Terbaru
      </div>
      <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Pelapor</th>
              <th>Judul Pengaduan</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($pengaduanTerbaru as $index => $p)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->user->name ?? '-' }}</td>
                <td>{{ $p->nama_pengaduan ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}</td>
                <td>
                  @if($p->status == 'Diajukan')
    <span class="badge bg-secondary">Diajukan</span>
@elseif($p->status == 'Diproses')
    <span class="badge bg-info">Diproses</span>
@elseif($p->status == 'Disetujui')
    <span class="badge bg-primary">Disetujui</span>
@elseif($p->status == 'Selesai')
    <span class="badge bg-success">Selesai</span>
@elseif($p->status == 'Ditolak')
    <span class="badge bg-danger">Ditolak</span>
@endif

                </td>
                <td>
                  <!-- Tombol Detail -->
                  <button 
                    class="btn btn-sm btn-warning me-1"
                    data-bs-toggle="modal"
                    data-bs-target="#detailModal"
                    data-nama="{{ $p->nama_pengaduan }}"
                    data-deskripsi="{{ $p->deskripsi }}"
                    data-lokasi="{{ $p->lokasi }}"
                    data-foto="{{ asset('storage/' . $p->foto) }}"
                    data-status="{{ $p->status }}"
                    data-user="{{ $p->user->name ?? '-' }}"
                    data-petugas="{{ $p->petugas->nama ?? '-' }}"
                    data-tglpengajuan="{{ \Carbon\Carbon::parse($p->tgl_pengajuan)->format('d M Y') }}"
                    data-tglselesai="{{ $p->tgl_selesai ? \Carbon\Carbon::parse($p->tgl_selesai)->format('d M Y') : '-' }}"
                    data-saran="{{ $p->saran_petugas ?? '-' }}"
                  >
                    <i class="fa fa-eye"></i> Detail
                  </button>
                    <!-- Tombol Cetak -->
  <a href="{{ route('petugas.pengaduan.cetak', $p->id_pengaduan) }}"
     target="_blank"
     class="btn btn-secondary btn-sm me-1">
    <i class="fa fa-print"></i> Cetak
  </a>


                 @if($p->status == 'Disetujui')
    <form method="POST" action="{{ route('petugas.pengaduan.mulai', $p->id_pengaduan) }}" style="display: inline;">
        @csrf
        <button type="submit" class="btn btn-sm btn-primary me-1" onclick="return confirm('Yakin ingin memulai pengaduan ini?')">
            <i class="fa fa-play"></i> Mulai
        </button>
    </form>

    <a href="{{ route('petugas.pengaduan.tolak.form', $p->id_pengaduan) }}" class="btn btn-sm btn-danger">
        <i class="fa fa-times"></i> Tolak
    </a>


                  @elseif($p->status == 'Diproses')
                    <form method="POST" action="{{ route('petugas.pengaduan.selesai', $p->id_pengaduan) }}" style="display: inline;">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Yakin ingin menyelesaikan pengaduan ini?')">
                        <i class="fa fa-check"></i> Selesai
                      </button>
                    </form>
                  @elseif(in_array($p->status, ['Selesai', 'Disetujui']))
    @if(!$p->saran_petugas)
        <a href="{{ route('petugas.formSaran', $p->id_pengaduan) }}" class="btn btn-sm btn-info">
            <i class="fa fa-comment-dots"></i> Saran
        </a>
    @else
        <span class="text-success"><i class="fa fa-check-circle"></i> Saran sudah dikirim</span>
    @endif
@else
    <span class="text-muted">Tidak ada aksi</span>
@endif

                
                </td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center text-muted py-3">Belum ada pengaduan.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal Detail -->
  <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title"><i class="fa fa-info-circle"></i> Detail Pengaduan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <p><strong>Nama Pengaduan:</strong> <span id="detailNama"></span></p>
              <p><strong>Deskripsi:</strong> <span id="detailDeskripsi"></span></p>
              <p><strong>Lokasi:</strong> <span id="detailLokasi"></span></p>
              <p><strong>Status:</strong> <span id="detailStatus"></span></p>
              <p><strong>Nama User:</strong> <span id="detailUser"></span></p>
              <p><strong>Nama Petugas:</strong> <span id="detailPetugas"></span></p>
              <p><strong>Tanggal Pengajuan:</strong> <span id="detailTglPengajuan"></span></p>
              <p><strong>Tanggal Selesai:</strong> <span id="detailTglSelesai"></span></p>
              <p><strong>Saran Petugas:</strong> <span id="detailSaran"></span></p>
            </div>
            <div class="col-md-6 text-center">
              <img id="detailFoto" src="" alt="Foto Pengaduan" class="modal-img mt-2">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // --- Sidebar Toggle (Burger Button) ---
    const toggleSidebar = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const mainContent = document.getElementById('mainContent');

    function toggleSidebarMenu() {
      sidebar.classList.toggle('show');
      sidebarOverlay.classList.toggle('active');
      
      // Ganti ikon burger
      const icon = toggleSidebar.querySelector('i');
      if (sidebar.classList.contains('show')) {
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-times');
        toggleSidebar.innerHTML = '<i class="fa fa-times"></i> Tutup';
      } else {
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
        toggleSidebar.innerHTML = '<i class="fa fa-bars"></i> Menu';
      }
    }
    
    toggleSidebar.addEventListener('click', toggleSidebarMenu);
    sidebarOverlay.addEventListener('click', toggleSidebarMenu);
    
    // Tutup sidebar saat mengklik link di dalam sidebar (untuk mobile)
    document.querySelectorAll('.sidebar a').forEach(link => {
      link.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
          toggleSidebarMenu();
        }
      });
    });

    // --- Modal Detail Pengaduan ---
    const detailModal = document.getElementById('detailModal');
    detailModal.addEventListener('show.bs.modal', event => {
      const button = event.relatedTarget;

      document.getElementById('detailNama').textContent = button.getAttribute('data-nama');
      document.getElementById('detailDeskripsi').textContent = button.getAttribute('data-deskripsi');
      document.getElementById('detailLokasi').textContent = button.getAttribute('data-lokasi');
      document.getElementById('detailStatus').textContent = button.getAttribute('data-status');
      document.getElementById('detailUser').textContent = button.getAttribute('data-user');
      document.getElementById('detailPetugas').textContent = button.getAttribute('data-petugas');
      document.getElementById('detailTglPengajuan').textContent = button.getAttribute('data-tglpengajuan');
      document.getElementById('detailTglSelesai').textContent = button.getAttribute('data-tglselesai');
      document.getElementById('detailSaran').textContent = button.getAttribute('data-saran');
      document.getElementById('detailFoto').src = button.getAttribute('data-foto');
    });

    // Responsif saat resize window
    window.addEventListener('resize', () => {
      if (window.innerWidth > 768) {
        sidebar.classList.remove('show');
        sidebarOverlay.classList.remove('active');
        toggleSidebar.innerHTML = '<i class="fa fa-bars"></i> Menu';
      }
    });
  </script>
</body>
</html>