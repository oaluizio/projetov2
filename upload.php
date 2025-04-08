<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) exit(header("Location: login.php"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $texto = $_POST['texto'];
    $img = null;
    if ($_FILES['imagem']['name']) {
        $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $img = uniqid() . ".$ext";
        move_uploaded_file($_FILES['imagem']['tmp_name'], "uploads/$img");
    }
    $stmt = $pdo->prepare("INSERT INTO posts (user_id, texto, imagem) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $texto, $img]);
    header("Location: index.php");

    include 'sidebar.php'; 
    
}
?>
<form method="POST" enctype="multipart/form-data">
    <textarea name="texto" placeholder="Compartilhe algo..."></textarea>
    <input type="file" name="imagem">
    <button>Postar</button>
</form>