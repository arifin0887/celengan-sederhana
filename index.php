<?php
require_once 'config.php';

$data = $koneksi->query("SELECT * FROM tabungan ORDER BY tanggal DESC");
$total = $koneksi->query("SELECT SUM(jumlah) as total FROM tabungan")->fetch_assoc()['total'] ?? 0;

// Proses simpan jika form modal disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tgl = $_POST['tanggal'];
    $ket = $_POST['keterangan'];
    $jml = $_POST['jumlah'];
    $koneksi->query("INSERT INTO tabungan (tanggal, keterangan, jumlah) VALUES ('$tgl', '$ket', '$jml')");
    header("Location: index.php");
    exit;
}

// Edit data
if (isset($_POST['edit'])) {
    $id  = $_POST['id'];
    $tgl = $_POST['tanggal'];
    $ket = $_POST['keterangan'];
    $jml = $_POST['jumlah'];
    $koneksi->query("UPDATE tabungan SET tanggal='$tgl', keterangan='$ket', jumlah='$jml' WHERE id=$id");
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Celenganku</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="findev1.png">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">💰 Celenganku</h1>
    <div class="alert alert-success text-center">
        Total Tabungan: <strong>Rp <?= number_format($total, 0, ',', '.') ?></strong>
    </div>

    <!-- Tombol Modal -->
   <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahModal">+ Tambah Tabungan</button>
        <a href="export_excel.php" class="btn btn-outline-success">📤 Ekspor ke Excel</a>
    </div>

    <!-- Modal Form Tambah -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="POST">
              <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Tabungan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="mb-3">
                      <label for="tanggal" class="form-label">Tanggal</label>
                      <input type="date" name="tanggal" class="form-control" required>
                  </div>
                  <div class="mb-3">
                      <label for="keterangan" class="form-label">Keterangan</label>
                      <input type="text" name="keterangan" class="form-control" required>
                  </div>
                  <div class="mb-3">
                      <label for="jumlah" class="form-label">Jumlah</label>
                      <input type="number" name="jumlah" class="form-control" required>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Tabel Tabungan -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Jumlah (Rp)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php $no = 1; while ($row = $data->fetch_assoc()) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['tanggal'] ?></td>
                    <td><?= $row['keterangan'] ?></td>
                    <td><?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>
                        <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm mt-1" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>

                <!-- Modal Edit (sudah dijelaskan sebelumnya) -->

            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
