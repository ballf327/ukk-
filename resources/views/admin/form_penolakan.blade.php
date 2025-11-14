<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penolakan Pengaduan (Admin)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

                        <form method="POST" action="{{ route('admin.pengaduan.tolak', $pengaduan->id_pengaduan) }}">
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
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
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