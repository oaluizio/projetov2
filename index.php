<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: feed.php");
} else {
    header("Location: login.php");
}
exit;
