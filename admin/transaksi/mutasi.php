<?php
require __DIR__ . '/../../config/database.php';

$nasabah_id = $_GET['nasabah_id'] ?? null;
$bulan      = $_GET['bulan'] ?? date('Y-m');

$stmt = $pdo->prepare(
    "SELECT * FROM transaksi
     WHERE nasabah_id = ?
     AND DATE_FORMAT(created_at,'%Y-%m') = ?
     ORDER BY created_at DESC"
);
$stmt->execute([$nasabah_id, $bulan]);
$data = $stmt->fetchAll();
?>

<h2>Mutasi Transaksi</h2>

<form method="get">
    ID Nasabah <input name="nasabah_id" required>
    Bulan <input type="month" name="bulan" value="<?= $bulan ?>">
    <button>Filter</button>
</form>

<table border="1" cellpadding="6">
<tr>
    <th>Tanggal</th>
    <th>Tipe</th>
    <th>Jumlah</th>
</tr>

<?php foreach ($data as $t): ?>
<tr>
    <td><?= $t['created_at'] ?></td>
    <td><?= $t['tipe'] ?></td>
    <td><?= number_format($t['jumlah']) ?></td>
</tr>
<?php endforeach ?>
</table>