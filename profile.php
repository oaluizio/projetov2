<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'sidebar.php';

$my_id = $_SESSION['user_id'];
$view_id = isset($_GET['id']) ? $_GET['id'] : $my_id;
$is_own_profile = $view_id == $my_id;

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$view_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "<p>Usuário não encontrado.</p>";
    exit;
}

if (!$is_own_profile && $user['is_private']) {
    $check = $pdo->prepare("SELECT * FROM follows WHERE follower_id = ? AND followed_id = ?");
    $check->execute([$my_id, $view_id]);
    if ($check->rowCount() == 0) {
        echo "<div style='margin-left: 240px; padding: 20px;'><p>Perfil privado.</p></div>";
        exit;
    }
}

?>
<div style="margin-left: 240px; padding: 20px;">
    <h2>Perfil de <?= htmlspecialchars($user['username']) ?></h2>

    <?php if ($is_own_profile): ?>
        <form method="post">
            <label>
                <input type="checkbox" name="is_private" <?= $user['is_private'] ? 'checked' : '' ?>> Deixar perfil privado
            </label>
            <button type="submit">Salvar</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $private = isset($_POST['is_private']) ? 1 : 0;
            $update = $pdo->prepare("UPDATE users SET is_private = ? WHERE id = ?");
            $update->execute([$private, $my_id]);
            header("Location: profile.php");
            exit;
        }
        ?>
    <?php endif; ?>

    <h3>Posts:</h3>
    <?php
    $posts = $pdo->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
    $posts->execute([$view_id]);
    foreach ($posts->fetchAll() as $post): ?>
        <div style="border:1px solid #ccc; margin:10px; padding:10px;">
            <p><?= htmlspecialchars($post['texto']) ?></p>
            <?php if ($post['imagem']): ?>
                <img src="uploads/<?= $post['imagem'] ?>" width="200">
            <?php endif; ?>
            <?php if ($post['video']): ?>
                <video width="300" controls>
                    <source src="uploads/<?= $post['video'] ?>" type="video/mp4">
                </video>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
