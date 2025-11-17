<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
/* Tombol Kembali - Stroke Elegan */
.btn-back {
    background-color: transparent;
    color: var(--cerulean);
    border: 2px solid var(--cerulean);
    padding: 8px 20px;
    border-radius: 8px;
    font-weight: 600;
    transition: 0.3s ease;
}

.btn-back:hover {
    background-color: rgba(0, 108, 132, 0.1);
    color: var(--cerulean);
    transform: translateY(-2px);
}

    </style>
</head>
<body>
    <div class="container">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-semibold text-primary">Daftar Admin</h4>
                <a href="{{ route('dashboard') }}" class="btn btn-back">← Kembali ke Dashboard</a>
            </div>

            @if($admins->isEmpty())
                <div class="alert alert-info text-center">Belum ada admin yang terdaftar.</div>
            @else
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $index => $admin)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</body>
</html>
