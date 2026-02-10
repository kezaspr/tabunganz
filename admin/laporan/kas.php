<?php
require __DIR__ . '/../../config/database.php';

$setor = $pdo->query(
    "SELECT SUM(jumlah) FROM transaksi WHERE tipe='setor'"
)->fetchColumn();

$tarik = $pdo->query(
    "SELECT SUM(jumlah) FROM transaksi WHERE tipe='tarik'"
)->fetchColumn();
?>

<h2>Laporan Kas</h2>

<ul>
    <li>Total Setoran : Rp <?= number_format($setor) ?></li>
    <li>Total Penarikan : Rp <?= number_format($tarik) ?></li>
    <li>Saldo Kas : Rp <?= number_format($setor - $tarik) ?></li>
</ul>