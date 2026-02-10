<?php
require __DIR__ . '/../config/database.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=mutasi.xls");

$data = $pdo->query("SELECT * FROM transaksi ORDER BY created_at DESC")->fetchAll();

echo "Tanggal\tNasabah\tTipe\tJumlah\n";
foreach ($data as $d) {
    echo "{$d['created_at']}\t{$d['nasabah_id']}\t{$d['tipe']}\t{$d['jumlah']}\n";
}