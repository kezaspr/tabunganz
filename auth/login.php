<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    var_dump($user);
    exit;


    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role']    = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: /admin/dashboard.php");
        } elseif ($user['role'] === 'petugas') {
            header("Location: /petugas/dashboard.php");
        } else {
            header("Location: /nasabah/dashboard.php");
        }
        exit;
    } else {
        echo "LOGIN GAGAL";
    }
}
