<?php 
require_once '../includes/config_session.inc.php';
$pdo = require_once '../includes/dbh.inc.php';
require_once "../includes/VISITING_PROFILE/visiting_profile.view.inc.php";



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>  
    <h1>HERE this is working</h1>
    
    <form action="../includes/VISITING_PROFILE/visiting_profile.inc.php" methid="POST">
        <label for="Button">
            <Button type="submit"></Button>
        </label>
    </form>



</body>
</html>