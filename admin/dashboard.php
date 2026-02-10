<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /auth/login.php");
    exit;
}
?>
<h1>Dashboard Admin</h1>
<p>Selamat datang, Admin</p>
<ul>
    <li>Kelola Nasabah</li>
    <li>Transaksi</li>
    <li>Transfer</li>
    <li>Log Aktivitas</li>
</ul>