<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$_POST['email']]);
    $user = $stmt->fetch();
    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit;
    }
    echo "Login inválido.";
}
?>
<form method="post">
    <input name="email" required type="email" placeholder="Email">
    <input name="password" required type="password" placeholder="Senha">
    <button>Entrar</button>
</form>

<p>Não tem uma conta? <a href="register.php">Cadastre-se aqui</a></p>
