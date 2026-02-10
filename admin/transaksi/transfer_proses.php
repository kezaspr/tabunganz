<?php
session_start();
require __DIR__ . '/../../config/database.php';

$from   = $_POST['from_id'];
$to     = $_POST['to_id'];
$jumlah = $_POST['jumlah'];
$petugas_id = $_SESSION['user_id'];

if ($from == $to) {
    die("Rekening tidak boleh sama");
}

// cek saldo
$stmt = $pdo->prepare("SELECT saldo FROM nasabah WHERE id=?");
$stmt->execute([$from]);
$saldo = $stmt->fetchColumn();

if ($saldo < $jumlah) {
    die("Saldo pengirim tidak cukup");
}

$pdo->beginTransaction();

// keluar
$pdo->prepare(
    "INSERT INTO transaksi (nasabah_id, petugas_id, tipe, jumlah)
     VALUES (?,?, 'transfer_keluar', ?)"
)->execute([$from, $petugas_id, $jumlah]);

$pdo->prepare(
    "UPDATE nasabah SET saldo = saldo - ? WHERE id=?"
)->execute([$jumlah, $from]);

// masuk
$pdo->prepare(
    "INSERT INTO transaksi (nasabah_id, petugas_id, tipe, jumlah)
     VALUES (?,?, 'transfer_masuk', ?)"
)->execute([$to, $petugas_id, $jumlah]);

$pdo->prepare(
    "UPDATE nasabah SET saldo = saldo + ? WHERE id=?"
)->execute([$jumlah, $to]);

$pdo->commit();

header("Location: /admin/dashboard.php");