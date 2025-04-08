<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'sidebar.php';
?>

<div style="margin-left: 240px; padding: 20px;">
    <h2>Criar Novo Post</h2>
    <form method="post" enctype="multipart/form-data">
        <textarea name="texto" placeholder="Escreva algo..." required></textarea><br>
        <input type="file" name="imagem"><br>
        <input type="file" name="video" accept="video/*"><br><br>
        <button type="submit">Publicar</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $texto = $_POST['texto'];
        $user_id = $_SESSION['user_id'];
        $imagem = '';
        $video = '';

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
            $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $nome = uniqid() . "." . $ext;
            move_uploaded_file($_FILES['imagem']['tmp_name'], "uploads/" . $nome);
            $imagem = $nome;
        }

        if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
            $ext = pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION);
            $nome = uniqid() . "." . $ext;
            move_uploaded_file($_FILES['video']['tmp_name'], "uploads/" . $nome);
            $video = $nome;
        }

        $stmt = $pdo->prepare("INSERT INTO posts (user_id, texto, imagem, video) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$user_id, $texto, $imagem, $video])) {
            echo "<p>Post criado com sucesso!</p>";
        } else {
            echo "<p>Erro ao criar post.</p>";
        }
    }
    ?>
</div>
