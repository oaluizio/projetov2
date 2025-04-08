
<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$is_private = isset($_POST['is_private']) ? 1 : 0;

$stmt = $pdo->prepare("UPDATE users SET is_private = ? WHERE id = ?");
$stmt->execute([$is_private, $_SESSION['user_id']]);

header("Location: profile.php?id=" . $_SESSION['user_id']);
exit;
