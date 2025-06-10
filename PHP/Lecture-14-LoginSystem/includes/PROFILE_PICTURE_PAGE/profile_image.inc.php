<?php
require_once '../config_session.inc.php';


if($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        // FIle connection
        $pdo = require_once '../dbh.inc.php';
        require_once 'profile_image.model.inc.php';
        require_once 'profile_image.contr.inc.php';

        $user_id = $_SESSION['user_id'];



        // Grabbing the image
        $image = $_FILES['profile_picture']['name'] ?? '';
        $tmp = explode('.', $image);
        $newFileName = round(microtime(true)) . '.' . end($tmp);
        $upload_dir = '../../uploads/'.$newFileName;

        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_dir);


        upload_image_to_database($pdo, $newFileName);

        $_Session['image_url'] = '../uploads/'.$newFileName;

        header("Location: ../../HTML/profile.php?upload=success");





    } catch (Exception $e) {
        header("Location: ../../HTML/login.php?server=failed");
        die("Error Occurred");
    }











}