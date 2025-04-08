<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$me = $_SESSION['user_id'];
$target = $_GET['id'];

if ($me != $target) {
    $stmt = $pdo->prepare("SELECT * FROM follows WHERE follower_id = ? AND followed_id = ?");
    $stmt->execute([$me, $target]);

    if ($stmt->rowCount() > 0) {
        $pdo->prepare("DELETE FROM follows WHERE follower_id = ? AND followed_id = ?")->execute([$me, $target]);
    } else {
        $pdo->prepare("INSERT INTO follows (follower_id, followed_id) VALUES (?, ?)")->execute([$me, $target]);
    }
}

header("Location: profile.php?id=$target");
exit;
