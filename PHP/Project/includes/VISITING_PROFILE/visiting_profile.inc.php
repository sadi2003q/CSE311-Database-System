<?php

require_once '../config_session.inc.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {

        $pdo = require_once '../dbh.inc.php';
        require_once 'visiting_profile.model.inc.php';
        require_once 'visiting_profile.contr.inc.php';
        
        $visitor_id = $_SESSION['user_id'];
        $visiting_id = $_SESSION['current_profile_being_visited'];
        

        $action = $_POST['action'] ?? '';

        if ($action === 'follow') {
            $result = follow_now($pdo, $visitor_id, $visiting_id);
            if($result) {
                header("Location: ../../HTML/visiting_profile.php?profile_id=" . $visiting_id . "&following=Success");
            } else {
                header("Location: ../../HTML/visiting_profile.php?profile_id=" . $visiting_id . "&following=Failed");
            }
        } else if ($action === 'unfollow') {
            $result = unfollow_now($pdo, $visitor_id, $visiting_id);
            if($result) {
                header("Location: ../../HTML/visiting_profile.php?profile_id=" . $visiting_id . "&unfollowing=Success");
            } else {
                header("Location: ../../HTML/visiting_profile.php?profile_id=" . $visiting_id . "&unfollowing=Failed");
            }
        }


        $pdo = null;
        die();




    } catch (Exception $e) {
        print_r($e->getMessage());
        die();
    }
}


