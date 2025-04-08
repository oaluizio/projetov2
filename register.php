<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([
        $_POST['username'],
        $_POST['email'],
        password_hash($_POST['password'], PASSWORD_BCRYPT)
    ]);
    header("Location: login.php");
    exit;
}
?>
<form method="post">
    <input name="username" required placeholder="Usuário">
    <input name="email" required type="email" placeholder="Email">
    <input name="password" required type="password" placeholder="Senha">
    <button>Cadastrar</button>
</form>