<?php
require '../../config/database.php';
require '../../auth/check_admin.php';

$nasabah_id = $_GET['id'] ?? null;
if (!$nasabah_id) {
    die('ID nasabah tidak ditemukan');
}

// ambil data mutasi (PDO)
$stmt = $pdo->prepare("
    SELECT * FROM transaksi
    WHERE nasabah_id = ?
    ORDER BY tanggal DESC
");
$stmt->execute([$nasabah_id]);
$transaksi = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mutasi Nasabah</title>
</head>
<body>

<h2>Mutasi Nasabah</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Tanggal</th>
        <th>Jenis</th>
        <th>Jumlah</th>
        <th>Keterangan</th>
    </tr>

<?php if (count($transaksi) > 0): ?>
    <?php foreach ($transaksi as $row): ?>
        <tr>
            <td><?= $row['tanggal'] ?></td>
            <td><?= $row['jenis'] ?></td>
            <td><?= number_format($row['jumlah']) ?></td>
            <td><?= $row['keterangan'] ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="4" align="center">Belum ada transaksi</td>
    </tr>
<?php endif; ?>

</table>

</body>
</html>