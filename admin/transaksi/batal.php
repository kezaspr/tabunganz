<?php
require __DIR__ . '/../../config/database.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM transaksi WHERE id=?");
$stmt->execute([$id]);
$t = $stmt->fetch();

if ($t['status'] === 'batal') die("Sudah dibatalkan");

$pdo->beginTransaction();

// rollback saldo
if ($t['tipe'] === 'setor' || $t['tipe'] === 'transfer_masuk') {
    $pdo->prepare("UPDATE nasabah SET saldo = saldo - ? WHERE id=?")
        ->execute([$t['jumlah'], $t['nasabah_id']]);
} else {
    $pdo->prepare("UPDATE nasabah SET saldo = saldo + ? WHERE id=?")
        ->execute([$t['jumlah'], $t['nasabah_id']]);
}

// tandai batal
$pdo->prepare("UPDATE transaksi SET status='batal' WHERE id=?")
    ->execute([$id]);

$pdo->commit();

header("Location: mutasi.php?nasabah_id=".$t['nasabah_id']);