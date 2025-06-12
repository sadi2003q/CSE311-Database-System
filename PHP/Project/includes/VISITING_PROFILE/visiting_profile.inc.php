<?php

require_once '../config_session.inc.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {

        $pdo = require_once '../dbh.inc.php';
        require_once 'visiting_profile.model.inc.php';
        require_once 'visiting_profile.contr.inc.php';
        
        $visitor_id = $_SESSION['user_id'];
        $visiting_id = $_SESSION['current_profile_being_visited'];
        

        if(check_follower($pdo, $visitor_id, $visiting_id)) {
            header("Location: ../../HTML/newsfeed.php?following=Yes");
            die();

        } 



        $result = follow_now($pdo, $visitor_id, $visiting_id);

        if(!$result) {
            header("Location: ../../HTML/newsfeed.php?following=Failed");
        }


        header("Location: ../../HTML/newsfeed.php?following=Successful");
        $pdo = null;
        die();




    } catch (Exception $e) {
        print_r($e->getMessage());
        die();
    }
}


