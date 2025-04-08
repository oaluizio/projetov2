<?php
?>
<div class="sidebar">
    <h3>Chat Up</h3>
    <ul>
        <li><a href="feed.php">Início</a></li>
        <li><a href="create_post.php">Criar Post</a></li>
        <li><a href="profile.php">Meu Perfil</a></li>
        <li><a href="users.php">Usuários</a></li>
        <li><a href="logout.php">Sair</a></li>
    </ul>
</div>

<style>
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
</style>
