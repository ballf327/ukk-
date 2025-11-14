<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buat Pengaduan | Aplikasi Sarpras</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    :root {
  --cerulean: #006C84;    /* biru laut elegan */
  --blue-topaz: #6EB5C0;  /* biru muda pastel */
  --icicle: #E2E8E4;      /* abu lembut kebiruan */
  --soft-coral: #FEC8B8;  /* coral lembut aksen */
  --dark: #1A1A1A;        /* teks gelap */
}

body {
  background: linear-gradient(180deg, #f5f9f9 0%, var(--icicle) 40%, #dceceb 100%);
  min-height: 100vh;
  color: var(--dark);
  font-family: 'Segoe UI', sans-serif;
}

h3 {
  color: var(--cerulean);
  font-weight: 700;
}

.container {
  background: #ffffff;
  padding: 25px;
  border-radius: 16px;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
  border: 1px solid #dde6e8;
}

/* Table Styling */
.table {
  background-color: #ffffff;
  border-radius: 10px;
  overflow: hidden;
  color: var(--dark);
}

.table thead {
  background-color: var(--blue-topaz);
  color: #fff;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(110, 181, 192, 0.1);
}

/* Buttons */
.btn-primary {
  background: linear-gradient(90deg, #57bac8, #0c8da0);
  border: none;
  color: #fff;
  box-shadow: 0 2px 6px rgba(0, 108, 132, 0.2);
}

.btn-primary:hover {
  background: linear-gradient(90deg, #0c8da0, #57bac8);
}

.btn-secondary {
  background-color: var(--icicle);
  color: var(--cerulean);
  border: 1px solid #c9dbda;
}

.btn-warning {
  background-color: var(--soft-coral);
  color: var(--dark);
  border: none;
}

.btn-danger {
  background-color: #e14d4d;
  border: none;
}

/* Badges & Alerts */
.badge.bg-info {
  background-color: var(--blue-topaz) !important;
  color: var(--dark);
}

.alert-success {
  background-color: var(--cerulean);
  color: #fff;
  border: none;
}

/* Subtle hover effect */
.table tbody tr:hover {
  background-color: rgba(110, 181, 192, 0.15);
  transition: 0.2s;
}
  </style>
</head>
<body>

<div class="container">
  <div class="card p-4 bg-white">
    <h4 class="mb-4 text-primary">
      <i class="fa fa-file-pen"></i> Formulir Pengaduan
    </h4>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('user.store_pengaduan') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- Judul Pengaduan -->
      <div class="mb-3">
        <label for="nama_pengaduan" class="form-label">Judul Pengaduan</label>
        <input type="text" name="nama_pengaduan" id="nama_pengaduan" class="form-control" required value="{{ old('nama_pengaduan') }}">
      </div>

      <!-- Deskripsi -->
      <div class="mb-3">
        <label for="isi_laporan" class="form-label">Deskripsi</label>
        <textarea name="isi_laporan" id="isi_laporan" class="form-control" rows="4" required>{{ old('isi_laporan') }}</textarea>
      </div>

      <!-- Lokasi -->
      <div class="mb-3">
        <label for="id_lokasi" class="form-label">Pilih Lokasi</label>
        <select name="id_lokasi" id="id_lokasi" class="form-select" required>
          <option value="">-- Pilih Lokasi --</option>
          @foreach($lokasiList as $lokasi)
            <option value="{{ $lokasi->id_lokasi }}">{{ $lokasi->nama_lokasi }}</option>
          @endforeach
        </select>
      </div>

      <!-- Barang -->
      <div class="mb-3">
        <label for="id_item" class="form-label">Pilih Barang (dari daftar resmi)</label>
        <select name="id_item" id="id_item" class="form-select">
          <option value="">-- Pilih Barang --</option>
        </select>
        <small class="text-muted">Kosongkan jika barang belum memiliki nomor inventaris</small>
      </div>

      <!-- Barang Temporary -->
      <div class="mb-3">
        <label for="id_temporary" class="form-label">Atau Pilih Barang Temporary (Barang Baru)</label>
        <select name="id_temporary" id="id_temporary" class="form-select">
          <option value="">-- Pilih Barang Temporary --</option>
          @if(isset($temporaryItems))
            @foreach($temporaryItems as $temp)
              <option value="{{ $temp->id_temporary }}">
                [{{ ucfirst($temp->status) }}] {{ $temp->nama_barang_baru }} - {{ $temp->lokasi_barang_baru }}
              </option>
            @endforeach
          @endif
        </select>
        <small class="text-muted">Barang yang belum memiliki nomor inventaris resmi</small>
      </div>

      <!-- Foto -->
      <div class="mb-3">
        <label for="foto" class="form-label">Foto (opsional)</label>
        <input type="file" name="foto" id="foto" class="form-control">
      </div>

      <!-- Tombol -->
      <button type="submit" class="btn btn-primary w-100 mt-3">Kirim Pengaduan</button>
    </form>

    <div class="text-center mt-3">
      <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">⬅ Kembali ke Dashboard</a>
    </div>
  </div>
</div>

<script>
  // Saat lokasi berubah, ambil barang via AJAX
  $('#id_lokasi').on('change', function () {
    let idLokasi = $(this).val();
    $('#id_item').html('<option value="">Memuat...</option>');

    if (idLokasi) {
      $.get("{{ url('/user/barang-by-lokasi') }}/" + idLokasi, function (data) {
        let options = '<option value="">-- Pilih Barang --</option>';
        data.forEach(function (item) {
          options += `<option value="${item.id_item}">${item.nama_item}</option>`;
        });
        $('#id_item').html(options);
      });
    } else {
      $('#id_item').html('<option value="">-- Pilih Barang --</option>');
    }
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
