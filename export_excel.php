<?php
require_once 'config.php';

// Set header untuk download file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=tabungan_" . date("Ymd") . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Keterangan</th>
        <th>Jumlah (Rp)</th>
      </tr>";

$no = 1;
$data = $koneksi->query("SELECT * FROM tabungan ORDER BY tanggal ASC");
while ($row = $data->fetch_assoc()) {
    echo "<tr>
            <td>{$no}</td>
            <td>{$row['tanggal']}</td>
            <td>{$row['keterangan']}</td>
            <td>{$row['jumlah']}</td>
          </tr>";
    $no++;
}
echo "</table>";
?>
