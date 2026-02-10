<?php
session_start();
require __DIR__ . '/../../config/database.php';

$nasabah = $pdo->query("SELECT * FROM nasabah WHERE status='aktif'")->fetchAll();
?>

<h2>Transfer Antar Nasabah</h2>

<form action="transfer_proses.php" method="post">
    Dari <br>
    <select name="from_id">
        <?php foreach ($nasabah as $n): ?>
            <option value="<?= $n['id'] ?>">
                <?= $n['nama'] ?> (<?= $n['saldo'] ?>)
            </option>
        <?php endforeach ?>
    </select><br><br>

    Ke <br>
    <select name="to_id">
        <?php foreach ($nasabah as $n): ?>
            <option value="<?= $n['id'] ?>">
                <?= $n['nama'] ?>
            </option>
        <?php endforeach ?>
    </select><br><br>

    Jumlah <br>
    <input type="number" name="jumlah" min="1000" required><br><br>

    <button>Transfer</button>
</form>