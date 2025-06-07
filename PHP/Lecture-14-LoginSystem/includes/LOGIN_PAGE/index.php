<?php

$pdo = require_once 'database-connection.php';

if (isset($_GET['user_id'])) {
    echo 'id : ' . $_GET['user_id'];
    $id = $_GET['user_id'];

    $query = "SELECT * FROM USERS WHERE USER_ID = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':user_id' => $id]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo $row['username'];
    } else {
        echo 'User not found.';
    }

    $pdo = null;
    $stmt = null;
} else {
    echo 'No id Found';
}