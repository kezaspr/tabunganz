<?php
require __DIR__ . '/../../config/database.php';

$pin_hash = password_hash($_POST['pin'], PASSWORD_DEFAULT);

$stmt = $pdo->prepare(
    "INSERT INTO nasabah (nis,nama,kelas,pin)
     VALUES (?,?,?,?)"
);

$stmt->execute([
    $_POST['nis'],
    $_POST['nama'],
    $_POST['kelas'],
    $pin_hash
]);

header("Location: index.php");