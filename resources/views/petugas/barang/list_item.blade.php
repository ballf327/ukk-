<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Barang di {{ $lokasi->nama_lokasi }}</title>
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
<body class="p-4">
<div class="container">
    <h2>Barang di Ruang: {{ $lokasi->nama_lokasi }}</h2>
    <a href="/petugas/dashboard" class="btn btn-secondary">← Kembali ke Dashboard</a>
    <a href="{{ route('petugas.item.create', $lokasi->id_lokasi) }}" class="btn btn-success my-3">+ Tambah Item</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Foto</th>
                <th>Nama Barang</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $list)
                @if($list->item)
                    <tr>
                        <td>
                            @if($list->item->foto)
                                {{-- 🔹 Gunakan Storage::url agar path selalu benar --}}
                                <img src="{{ Storage::url($list->item->foto) }}" 
                                     alt="Foto {{ $list->item->nama_item }}" 
                                     width="100" 
                                     class="rounded border">
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td>{{ $list->item->nama_item }}</td>
                        <td>{{ $list->item->deskripsi }}</td>
                        <td>
                            <a href="{{ route('petugas.item.edit', $list->item->id_item) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('petugas.item.delete', $list->item->id_item) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin ingin menghapus item ini?')" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
