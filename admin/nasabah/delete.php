<?php
require __DIR__ . '/../../config/database.php';

$stmt = $pdo->prepare("UPDATE nasabah SET status='nonaktif' WHERE id=?");
$stmt->execute([$_GET['id']]);

header("Location: index.php");