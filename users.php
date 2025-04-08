<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'sidebar.php';

$me = $_SESSION['user_id'];
$search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';

$stmt = $pdo->prepare("SELECT * FROM users WHERE id != ? AND username LIKE ?");
$stmt->execute([$me, $search]);
$users = $stmt->fetchAll();

$following = $pdo->prepare("SELECT followed_id FROM follows WHERE follower_id = ?");
$following->execute([$me]);
$followed_ids = array_column($following->fetchAll(), 'followed_id');
?>

<div class="main">
    <h2>Usuários</h2>

    <form method="get" class="search-form">
        <input type="text" name="search" placeholder="Buscar usuário..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button type="submit">Buscar</button>
    </form>

    <?php foreach ($users as $user): ?>
        <div class="user-card">
            <span>@<?= htmlspecialchars($user['username']) ?></span>
            <a href="profile.php?id=<?= $user['id'] ?>">Ver perfil</a>
            <a href="follow.php?id=<?= $user['id'] ?>">
                <?= in_array($user['id'], $followed_ids) ? 'Deixar de seguir' : 'Seguir' ?>
            </a>
        </div>
    <?php endforeach; ?>
</div>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
}

.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 220px;
    height: 100%;
    background: #242526;
    color: #fff;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0,0,0,0.3);
}

.sidebar h3 {
    margin-bottom: 30px;
    color: #fff;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    margin-bottom: 15px;
}

.sidebar ul li a {
    color: #ddd;
    text-decoration: none;
    font-weight: bold;
    display: block;
    padding: 8px 10px;
    border-radius: 6px;
    transition: background 0.3s;
}

.sidebar ul li a:hover {
    background: #3a3b3c;
}

.main {
    margin-left: 240px;
    padding: 20px;
}

.search-form {
    margin-bottom: 20px;
}
.search-form input {
    padding: 8px;
    width: 200px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.search-form button {
    padding: 8px 12px;
    background: #007bff;
    border: none;
    color: white;
    border-radius: 4px;
    cursor: pointer;
}
.search-form button:hover {
    background: #0056b3;
}

.user-card {
    background: #f0f0f0;
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 6px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.user-card a {
    margin-left: 10px;
    text-decoration: none;
    color: #007BFF;
}
.user-card a:hover {
    text-decoration: underline;
}
</style>
