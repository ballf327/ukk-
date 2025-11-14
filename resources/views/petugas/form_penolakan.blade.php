<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penolakan Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="fa fa-times"></i> Form Penolakan Pengaduan</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Judul Pengaduan:</strong>
                            <p>{{ $pengaduan->nama_pengaduan }}</p>
                        </div>
                        <div class="mb-3">
                            <strong>Pelapor:</strong>
                            <p>{{ $pengaduan->user->name ?? '-' }}</p>
                        </div>
                        
                        <form method="POST" action="{{ route('petugas.pengaduan.tolak', $pengaduan->id_pengaduan) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="alasan" class="form-label"><strong>Alasan Penolakan *</strong></label>
                                <textarea class="form-control @error('alasan') is-invalid @enderror" 
                                          id="alasan" 
                                          name="alasan" 
                                          rows="4" 
                                          placeholder="Masukkan alasan penolakan..." 
                                          required>{{ old('alasan') }}</textarea>
                                @error('alasan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-times"></i> Tolak Pengaduan
                                </button>
                                <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>