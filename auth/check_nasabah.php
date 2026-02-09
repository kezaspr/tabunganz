<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'nasabah') {
    header("Location: ../index.php");
    exit;
}