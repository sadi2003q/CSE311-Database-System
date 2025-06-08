<?php

require_once '../config_session.inc.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    try {

        $pdo = require_once '../dbh.inc.php';
        require_once 'post_model.inc.php';
        require_once 'post_contr.inc.php';

        $user_id = $_SESSION['user_id'];


        // Grabbing all variables from the form and storing them in variables
        $post_text = $_POST['post_text'];
        $post_image = $_FILES['post_image']['name'] ?? '';
        $tmp = explode('.', $post_image);
        $newFileName = round(microtime(true)) . '.' . end($tmp);
        $upload_dir = '../../uploads/'.$newFileName;


        move_uploaded_file($_FILES['post_image']['tmp_name'], $upload_dir);

        // Checking for any potential error
        $error_post = [];

        if(is_all_post_fields_are_empty($post_text, $post_image)) {
            $error_post['empty_input'] = "Please fill in all the fields";
        }

        if(!empty($error_post)) {
            $_SESSION['error_post'] = $error_post;
            header("Location: ../../HTML/newsfeed.php?post=error");
            die('Error Occurred');
        }

//        $post_image_name = $post_image['name']['name'];
//        $post_image_tempName = $post_image['type']['tmp_name'];
//        $post_image_folder = "../../uploads/".$post_image_name;

        post_now($pdo, $post_text, $upload_dir, $user_id );
        header("Location: ../../HTML/newsfeed.php?post=success?user_id=$user_id");
        $pdo = null;
        die('Post successful');



    } catch (Exception $e) {
        header("Location: ../../HTML/login.php?server=failed");
        die("Error Occurred");
    }



} else {
    header("Location: ../../HTML/newsfeed.php?upload=error");
}

