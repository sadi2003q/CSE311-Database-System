<?php

require_once '../config_session.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {

    
        $pdo = require_once '../dbh.inc.php';
        require_once 'suggested_profile.model.inc.php';

        $recepent_id = $_SESSION['current_profile_visiting'] ?? -1;
        $user_id = $_SESSION['user_id'] ?? -1;


        sent_friend_request($pdo, $recepent_id, $user_id);
        
        header("Location: ../../HTML/newsfeed.php?request_sent=success");
        
        

        $pdo = null; // Close the database connection
        die();

    } catch (Exception $e) {
        error_log("Error in suggested_profile.inc.php: " . $e->getMessage());
        header("Location: ../../HTML/error.php?error=server_error");
        exit();
    }
}
