<?php

declare(strict_types=1);

function check_login_status(): void {
    if (isset($_SESSION['admin_login_errors'])) {
            foreach ($_SESSION['admin_login_errors'] as $error) {
                echo '<p class="error">' . $error . '</p>';
            }
            unset($_SESSION['admin_login_errors']);
        }
}

function get_total_users_count() {
    $pdo = require_once "../includes/dbh.inc.php"; // database connection

    // Get total users
    $query = "SELECT COUNT(*) as count FROM USERS";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result_usernumber = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Get total posts
    $query = "SELECT COUNT(*) as count FROM POSTS";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result_postnumber = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // total likes
    $query = "SELECT COUNT(*) as count FROM LIKES";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result_likenumber = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // total comments
    $query = "SELECT COUNT(*) as count FROM COMMENTS";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result_commentnumber = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    //Total Interaction
    $result_interaction = $result_commentnumber + $result_likenumber;

    // total comments
    $query = "SELECT COUNT(*) as count FROM DELETION_REQUESTS";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result_reqnumber = $stmt->fetch(PDO::FETCH_ASSOC)['count'];



    // Return both counts as an associative array
    return [
        'user_count' => $result_usernumber,
        'post_count' => $result_postnumber,
        'like_count' => $result_interaction,
        'req_count' => $result_reqnumber,

        
    ];
}