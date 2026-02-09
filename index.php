<!DOCTYPE html>
<html>
<head>
    <title>Login Bank Mini</title>
</head>
<body>
<h2>Login Bank Mini Sekolah</h2>

<?php if (!empty($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST" action="/auth/login.php">
    <input type="text" name="username" required>
    <input type="password" name="password" required>
    <button type="submit">Login</button>
</form>
</body>
</html>
