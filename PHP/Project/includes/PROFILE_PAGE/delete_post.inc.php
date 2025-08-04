<?php
require_once '../config_session.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_post'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../../HTML/login.php");
        exit;
    }

    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];
    
    $pdo = require_once '../dbh.inc.php';
    require_once 'profile_model.php';
    
    delete_the_post($pdo, $post_id);
    
    header("Location: ../../HTML/profile.php?delete=success");
    exit;
} else {
    header("Location: ../../HTML/profile.php");
    exit;
}