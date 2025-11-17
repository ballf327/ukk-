<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>ADMINISTRATOR | Data Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #dce7e7; /* warna dasar seperti dashboard */
            font-family: 'Segoe UI', sans-serif;
        }

        .container-custom {
            max-width: 1000px;
            margin: 40px auto;
            background: #f8fafc;
            padding: 25px 35px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .header-title {
            font-weight: 700;
            color: #0f172a;
        }

        .btn-back {
            background: #0ea5e9;
            color: white;
            border-radius: 10px;
            font-weight: 600;
            padding: 8px 18px;
            text-decoration: none;
            transition: 0.2s;
        }
        .btn-back:hover {
            background: #0284c7;
            color: white;
        }

        .table thead {
            background: #e2e8f0;
        }

        .table th {
            color: #334155;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .table td {
            font-size: 14px;
        }

        .btn-outline-primary {
            border-color: #0ea5e9;
            color: #0ea5e9;
            border-radius: 8px;
            font-size: 13px;
        }
        .btn-outline-primary:hover {
            background: #0ea5e9;
            color: white;
        }

        .btn-outline-danger {
            border-color: #ef4444;
            color: #ef4444;
            border-radius: 8px;
            font-size: 13px;
        }
        .btn-outline-danger:hover {
            background: #ef4444;
            color: white;
        }

        .btn-success {
            background: #10b981;
            border: none;
        }
        .btn-success:hover {
            background: #059669;
        }

        .badge {
            font-size: 12px;
            border-radius: 6px;
            padding: 6px 10px;
        }

        /* Warna badge diseragamkan */
        .badge.bg-info {
            background: #7dd3fc !important;
            color: #0c4a6e !important;
        }

        /* Alert */
        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: none;
        }
    </style>
</head>
<body>

    <div class="container-custom">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="header-title mb-0">👥 Kelola Data Petugas</h4>
            <a href="/dashboard" class="btn-back">⬅️ Kembali ke Dashboard</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <h6 class="fw-semibold text-secondary">Daftar Petugas</h6>
            <a href="{{ route('admin.petugas.create') }}" class="btn btn-success btn-sm px-3">+ Tambah Petugas</a>
        </div>

        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Petugas</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($petugas as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $p->user->name ?? '-' }}</td>
                        <td>{{ $p->user->email ?? '-' }}</td>
                        <td><span class="badge bg-info text-dark">{{ ucfirst($p->user->role ?? '-') }}</span></td>
                        <td>
                            @if ($p->user)
                                <a href="{{ route('admin.petugas.edit', $p->user->id) }}" class="btn btn-sm btn-outline-primary">Edit Role</a>
                                <form action="{{ route('admin.petugas.destroy', $p->user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Yakin ingin menghapus petugas ini?')">Hapus</button>
                                </form>
                            @else
                                <span class="text-muted">Data user tidak ditemukan</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada data petugas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>
