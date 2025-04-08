<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'sidebar.php';
?>

<!-- Estilo e modal -->
<style>
.modal {
  display: none;
  position: fixed;
  z-index: 10000;
  left: 0; top: 0;
  width: 100%; height: 100%;
  background-color: rgba(0,0,0,0.8);
}

.modal-content {
  margin: 5% auto;
  display: block;
  max-width: 80%;
  border-radius: 10px;
  box-shadow: 0 0 15px #000;
}

.modal:target {
  display: block;
  text-align: center;
  padding-top: 60px;
}
</style>

<div id="imagemModal" class="modal">
  <span onclick="document.getElementById('imagemModal').style.display='none'" style="position:absolute;top:20px;right:35px;color:#fff;font-size:40px;cursor:pointer">&times;</span>
  <img id="imgExpandida" class="modal-content">
</div>

<script>
function expandirImagem(src) {
    var modal = document.getElementById("imagemModal");
    var img = document.getElementById("imgExpandida");
    img.src = src;
    modal.style.display = "block";
}
</script>

<div style="margin-left: 240px; padding: 20px;">
    <h2>Feed de posts</h2>

    <?php
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE posts.user_id IN (SELECT followed_id FROM follows WHERE follower_id = ?) OR posts.user_id = ? ORDER BY posts.created_at DESC");
    $stmt->execute([$user_id, $user_id]);

    foreach ($stmt->fetchAll() as $post):
    ?>
        <div style="border:1px solid #ccc; margin:10px; padding:10px;">
            <p><strong>@<?= htmlspecialchars($post['username']) ?></strong></p>
            <p><?= htmlspecialchars($post['texto']) ?></p>

            <?php if ($post['imagem']): ?>
                <img src="uploads/<?= $post['imagem'] ?>" width="200" style="cursor:zoom-in;" onclick="expandirImagem('uploads/<?= $post['imagem'] ?>')">
            <?php endif; ?>

            <?php if ($post['video']): ?>
                <video width="300" controls>
                    <source src="uploads/<?= $post['video'] ?>" type="video/mp4">
                    Seu navegador não suporta vídeos.
                </video>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
