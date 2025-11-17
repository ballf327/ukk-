<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Item</title>
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
<body class="p-4 bg-light">
<div class="container">
    <h3 class="mb-4">Edit Item: {{ $item->nama_item }}</h3>

    {{-- 🔹 Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    {{-- 🔹 Notifikasi error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 🔹 Form edit item --}}
    <form action="{{ route('item.update', $item->id_item) }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf
        {{-- penting: gunakan enctype untuk upload file --}}

        <div class="mb-3">
            <label for="nama_item" class="form-label">Nama Item</label>
            <input 
                type="text" 
                name="nama_item" 
                id="nama_item"
                class="form-control" 
                value="{{ old('nama_item', $item->nama_item) }}" 
                required
            >
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea 
                name="deskripsi" 
                id="deskripsi" 
                class="form-control"
                rows="3"
            >{{ old('deskripsi', $item->deskripsi) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label><br>

            {{-- 🔹 Tampilkan foto lama --}}
            @if($item->foto)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $item->foto) }}" 
                         alt="Foto Lama {{ $item->nama_item }}" 
                         width="150" 
                         class="rounded border">
                </div>
            @endif

            {{-- 🔹 Input upload foto baru --}}
            <input 
                type="file" 
                name="foto" 
                id="foto" 
                class="form-control"
                accept="image/*"
            >
            <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">⬅️ Kembali</a>
        </div>
    </form>
</div>
</body>
</html>
