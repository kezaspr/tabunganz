<?php
session_start();
require __DIR__ . '/../../config/database.php';

$nasabah_id = $_POST['nasabah_id'];
$jumlah     = $_POST['jumlah'];
$petugas_id = $_SESSION['user_id'];

$limit = 500000; // limit tarik

// ambil saldo
$stmt = $pdo->prepare("SELECT saldo FROM nasabah WHERE id=?");
$stmt->execute([$nasabah_id]);
$nasabah = $stmt->fetch();

if (!$nasabah || $nasabah['saldo'] < $jumlah) {
    die("Saldo tidak cukup");
}

if ($jumlah > $limit) {
    die("Melebihi limit penarikan");
}

$pdo->beginTransaction();

// log transaksi
$stmt = $pdo->prepare(
    "INSERT INTO transaksi (nasabah_id, petugas_id, tipe, jumlah)
     VALUES (?,?, 'tarik', ?)"
);
$stmt->execute([$nasabah_id, $petugas_id, $jumlah]);

// update saldo
$stmt = $pdo->prepare(
    "UPDATE nasabah SET saldo = saldo - ? WHERE id=?"
);
$stmt->execute([$jumlah, $nasabah_id]);

$pdo->commit();

header("Location: /admin/dashboard.php");