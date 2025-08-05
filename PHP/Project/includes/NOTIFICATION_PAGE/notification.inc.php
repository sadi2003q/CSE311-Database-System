<?php

require_once '../config_session.inc.php';
$pdo = require_once '../dbh.inc.php';
require_once 'notification.model.inc.php';



if($_SERVER['REQUEST_METHOD']=='POST') {
    try {
        
        $userID = $_SESSION['user_id'];
        mark_all_notification_as_read($pdo, (int)$userID);
        // notification.php
        header("Location: ../../HTML/notification.php");

    } catch (Exception $e) {
        header("Location: ../../HTML/ServerFailed.html");
    }
}  else {
    header("Location: ../../HTML/login.php");
}
