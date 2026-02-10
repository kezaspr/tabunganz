<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: /auth/login.php");
    exit;
}

require __DIR__ . '/../../config/database.php';

$data = $pdo->query("SELECT * FROM nasabah WHERE status='aktif'")->fetchAll();
?>

<h2>Data Nasabah</h2>
<a href="create.php">+ Tambah Nasabah</a>

<table border="1" cellpadding="8">
<tr>
    <th>NIS</th>
    <th>Nama</th>
    <th>Kelas</th>
    <th>Saldo</th>
    <th>Aksi</th>
</tr>

<?php foreach ($data as $n): ?>
<tr>
    <td><?= $n['nis'] ?></td>
    <td><?= $n['nama'] ?></td>
    <td><?= $n['kelas'] ?></td>
    <td>Rp <?= number_format($n['saldo']) ?></td>
    <td>
        <a href="edit.php?id=<?= $n['id'] ?>">Edit</a> |
        <a href="delete.php?id=<?= $n['id'] ?>" onclick="return confirm('Yakin?')">Hapus</a>
    </td>
</tr>
<?php endforeach ?>
</table>