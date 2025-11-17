<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Tambah Petugas | Admin</title>
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

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <div class="d-flex justify-content-between mb-4">
    <h3>Tambah Petugas</h3>
    <a href="{{ route('admin.petugas.index') }}" class="btn btn-secondary">← Kembali</a>
  </div>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card p-4 shadow-sm">
    <form action="{{ route('admin.petugas.store') }}" method="POST">
      @csrf

      {{-- NAMA --}}
      <div class="mb-3">
        <label for="name" class="form-label fw-semibold">Nama</label>
        <input id="name" name="name" type="text" 
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name') }}" placeholder="Masukkan nama anda" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- EMAIL --}}
      <div class="mb-3">
        <label for="email" class="form-label fw-semibold">Email</label>
        <input id="email" name="email" type="email" 
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}" placeholder="contoh@email.com" required>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- PASSWORD --}}
      <div class="mb-3">
        <label for="password" class="form-label fw-semibold">Password</label>
        <input id="password" name="password" type="password"
               class="form-control @error('password') is-invalid @enderror" 
               placeholder="Minimal 8 karakter" required>
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- ROLE --}}
      <div class="mb-3">
        <label for="role" class="form-label fw-semibold">Role</label>
        <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
          <option value="petugas" {{ old('role')=='petugas' ? 'selected' : '' }}>Petugas</option>
        </select>
        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- TELEPON --}}
      <div class="mb-3">
        <label for="telp" class="form-label fw-semibold">No. Telepon</label>
        <input id="telp" name="telp" type="text" 
               class="form-control @error('telp') is-invalid @enderror"
               value="{{ old('telp') }}" placeholder="08xxxxxxxxxx" required>
        @error('telp') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- JENIS KELAMIN --}}
      <div class="mb-4">
        <label for="gender" class="form-label fw-semibold">Jenis Kelamin</label>
        <select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror" required>
          <option value="">-- Pilih --</option>
          <option value="L">Laki-laki</option>
          <option value="P">Perempuan</option>
        </select>
        @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <button class="btn btn-success px-4 py-2 fw-semibold">Simpan Petugas</button>
    </form>
  </div>
</div>
</body>
</html>
