<?php
session_start();
require __DIR__ . '/../../config/database.php';

$nasabah_id = $_POST['nasabah_id'];
$jumlah     = $_POST['jumlah'];
$petugas_id = $_SESSION['user_id'];

$pdo->beginTransaction();

// catat transaksi
$stmt = $pdo->prepare(
    "INSERT INTO transaksi (nasabah_id, petugas_id, tipe, jumlah)
     VALUES (?,?, 'setor', ?)"
);
$stmt->execute([$nasabah_id, $petugas_id, $jumlah]);

// update saldo cepat
$stmt = $pdo->prepare(
    "UPDATE nasabah SET saldo = saldo + ? WHERE id=?"
);
$stmt->execute([$jumlah, $nasabah_id]);

$pdo->commit();

header("Location: /admin/dashboard.php");