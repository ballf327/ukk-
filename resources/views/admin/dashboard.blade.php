<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>

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

    <a href="{{ route('dashboard') }}" class="active"><i class="fa fa-home"></i> Dashboard</a>
    <a href="#data-pengaduan" class="nav-scroll"><i class="fa fa-database"></i> Data Pengaduan</a>
    <a href="{{ route('admin.users.index') }}"><i class="fa fa-users"></i> Data User</a>
    <a href="{{ route('admin.petugas.index') }}"><i class="fa fa-user-tie"></i> Kelola Petugas</a>
    <a href="{{ route('admin.daftarAdmin') }}"><i class="fa fa-user-cog"></i> Daftar Admin</a>
    <a href="{{ route('admin.lokasi.crud.index') }}"><i class="fa fa-list"></i> Daftar Ruang</a>
    <a href="{{ route('lokasi.index') }}"><i class="fa fa-box"></i> Tambah Barang</a>
    <a href="{{ route('admin.temporary-item.index') }}"><i class="fa fa-history"></i> History</a>


    <form method="POST" action="{{ route('logout') }}" class="mt-3 px-3">
      @csrf
      <button class="btn btn-danger w-100"><i class="fa fa-sign-out-alt"></i> Logout</button>
    </form>
  </div>

  <!-- ===== MAIN CONTENT ===== -->
  <div class="main-content">

    <!-- Topbar -->
    <div class="topbar d-flex justify-content-between align-items-center">
      <h4 class="mb-0">Dashboard Admin</h4>
      <span>Selamat datang, <b>{{ Auth::user()->name }}</b></span>
    </div>

    <!-- Statistik Utama -->
    <div class="row g-4">
      <div class="col-md-3">
        <div class="card-stat bg-primary">
          <i class="fa fa-users"></i>
          <h3>{{ $totalUser ?? 0 }}</h3>
          <p>Jumlah Pengguna</p>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card-stat bg-success">
          <i class="fa fa-user-tie"></i>
          <h3>{{ $totalPetugas ?? 0 }}</h3>
          <p>Jumlah Petugas</p>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card-stat bg-warning">
          <i class="fa fa-box"></i>
          <h3>{{ $totalItem ?? 0 }}</h3>
          <p>Jumlah Barang</p>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card-stat bg-danger">
          <i class="fa fa-file-alt"></i>
          <h3>{{ $totalPengaduan ?? 0 }}</h3>
          <p>Total Pengaduan</p>
        </div>
      </div>
    </div>

    <!-- Statistik Pengaduan -->
    <div class="mt-5">
      <h5>Statistik Pengaduan Berdasarkan Status</h5>
      <div class="row g-3">
        @if(!empty($pengaduanByStatus))
          @foreach($pengaduanByStatus as $status => $jumlah)
            <div class="col-md-2">
              <div class="card-stat bg-light text-dark shadow-sm">
                <h4>{{ $jumlah }}</h4>
                <p>{{ ucfirst($status) }}</p>
              </div>
            </div>
          @endforeach
        @else
          <p class="text-muted">Belum ada data pengaduan.</p>
        @endif
      </div>
    </div>

    <!-- Tabel Pengaduan -->
<div id="data-pengaduan" class="mt-5">
  <h5 class="mb-3">Data Pengaduan</h5>

  <!-- ===== FILTER FORM ===== -->
  <form method="GET" action="{{ route('dashboard') }}" class="row g-3 mb-4">
    <div class="col-md-3">
      <label class="form-label">Filter Status</label>
      <select name="status" class="form-select">
        <option value="">-- Semua Status --</option>
        <option value="Diajukan"  {{ request('status') == 'Diajukan' ? 'selected' : '' }}>Diajukan</option>
        <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
        <option value="Diproses"  {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
        <option value="Ditolak"   {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
        <option value="Selesai"   {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label">Dari Tanggal</label>
      <input type="date" name="from" class="form-control" value="{{ request('from') }}">
    </div>

    <div class="col-md-3">
      <label class="form-label">Sampai Tanggal</label>
      <input type="date" name="to" class="form-control" value="{{ request('to') }}">
    </div>

    <div class="col-md-3 d-flex align-items-end gap-2">
      <button type="submit" class="btn btn-primary w-50"><i class="fa fa-filter"></i> Filter</button>
      <a href="{{ route('dashboard') }}" class="btn btn-secondary w-50"><i class="fa fa-undo"></i> Reset</a>
    </div>
  </form>

  <div class="table-responsive">

        <table class="table table-bordered table-striped align-middle">
          <thead class="table-dark">
            <tr>
              <th>No</th>
              <th>Nama Pengaduan</th>
              <th>Lokasi</th>
              <th>Foto</th>
              <th>Status</th>
              <th>Tgl Pengajuan</th>
              <th>Tgl Selesai</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($pengaduan as $i => $item)
              @php
                $badge = match($item->status) {
                  'Diajukan'  => 'bg-primary',
                  'Disetujui' => 'bg-success',
                  'Ditolak'   => 'bg-danger',
                  'Diproses'  => 'bg-warning',
                  default     => 'bg-secondary',
                };
              @endphp
              <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->nama_pengaduan }}</td>
                <td>{{ $item->lokasi }}</td>
                <td>
                  @if($item->foto)
                    <img src="{{ asset('storage/' . $item->foto) }}"
                         class="photo-thumbnail"
                         data-photo="{{ asset('storage/' . $item->foto) }}"
                         alt="Foto">
                  @else
                    <span class="text-muted">Tidak ada</span>
                  @endif
                </td>
                <td><span class="badge {{ $badge }}">{{ $item->status }}</span></td>
                <td>{{ \Carbon\Carbon::parse($item->tgl_pengajuan)->format('d-m-Y') }}</td>
                <td>{!! $item->tgl_selesai ? \Carbon\Carbon::parse($item->tgl_selesai)->format('d-m-Y') : '<span class="text-muted">-</span>' !!}</td>
                 <td>
  <div class="d-flex gap-2">
    <!-- Tombol Detail -->
    <button class="btn btn-info btn-sm btn-detail" data-item='@json($item)'>
      <i class="fas fa-eye"></i>
    </button>

    <!-- Tombol Cetak -->
    <a href="{{ route('admin.pengaduan.cetak', $item->id_pengaduan) }}"
   target="_blank"
   class="btn btn-secondary btn-sm">
   <i class="fa fa-print"></i>
</a>

    @if($item->status == 'Diajukan')
      <!-- Tombol Setujui (admin) -->
      <form method="POST" action="{{ route('admin.pengaduan.approve', $item->id_pengaduan) }}" style="display:inline">
        @csrf
        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Yakin ingin menyetujui pengaduan ini?')">
          <i class="fa fa-check"></i> Setujui
        </button>
      </form>

      <!-- Tombol Tolak (admin) -->
      <a href="{{ route('admin.pengaduan.tolak.form', $item->id_pengaduan) }}" class="btn btn-sm btn-danger">
        <i class="fa fa-times"></i> Tolak
      </a>
    @endif

  </div>
</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- ===== MODAL FOTO ===== -->
  <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Foto Pengaduan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <img src="" class="modal-photo rounded img-fluid" alt="Foto Pengaduan">
        </div>
      </div>
    </div>
  </div>

  <!-- ===== MODAL DETAIL ===== -->
  <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Pengaduan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"></div>
      </div>
    </div>
  </div>

  <!-- ===== SCRIPT ===== -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
document.querySelectorAll('.btn-detail').forEach(btn => {
  btn.addEventListener('click', function() {
    const item = JSON.parse(this.dataset.item);

    // pastikan relasi sudah dikirim dari controller
    const namaUser = item.user ? item.user.name : '-';
    const namaPetugas = item.petugas ? item.petugas.nama : '-';
    const namaItem = item.item ? item.item.nama_item : '-';

    const modalBody = document.querySelector('#detailModal .modal-body');
    modalBody.innerHTML = `
      <div class="row">
        <div class="col-md-6">
          <h6>Informasi Pengaduan</h6>
          <table class="table table-sm">
            <tr><td><strong>Nama Pengaduan</strong></td><td>${item.nama_pengaduan}</td></tr>
            <tr><td><strong>Lokasi</strong></td><td>${item.lokasi}</td></tr>
            <tr><td><strong>Status</strong></td><td><span class="badge ${getBadge(item.status)}">${item.status}</span></td></tr>
            <tr><td><strong>Tgl Pengajuan</strong></td><td>${formatDate(item.tgl_pengajuan)}</td></tr>
            <tr><td><strong>Tgl Selesai</strong></td><td>${item.tgl_selesai ? formatDate(item.tgl_selesai) : '-'}</td></tr>
          </table>
        </div>
        <div class="col-md-6">
          <h6>Data Terkait</h6>
          <table class="table table-sm">
            <tr><td><strong>Nama User</strong></td><td>${namaUser}</td></tr>
            <tr><td><strong>Nama Petugas</strong></td><td>${namaPetugas}</td></tr>
            <tr><td><strong>Nama Item</strong></td><td>${namaItem}</td></tr>
          </table>
        </div>
      </div>

      <div class="mt-3"><h6>Deskripsi</h6><p>${item.deskripsi || '-'}</p></div>
      ${item.foto ? `<div class="mt-3 text-center"><img src="/storage/${item.foto}" class="img-fluid rounded shadow-sm"></div>` : ''}
    `;
    new bootstrap.Modal(document.getElementById('detailModal')).show();
  });
});

const getBadge = status => ({
  'Diajukan': 'bg-primary',
  'Disetujui': 'bg-success',
  'Ditolak': 'bg-danger',
  'Diproses': 'bg-warning'
}[status] || 'bg-secondary');

const formatDate = d => new Date(d).toLocaleDateString('id-ID', {
  day: '2-digit', month: '2-digit', year: 'numeric'
});
</script>

</body>
</html>
