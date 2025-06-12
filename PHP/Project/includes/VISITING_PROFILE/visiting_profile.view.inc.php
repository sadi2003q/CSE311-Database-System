<?php 


declare(strict_types=1);

require_once '../config_session.inc.php';




function show_all_information(object $pdo): void {


    require_once 'visiting_profile.model.inc.php';
    $user_id = $_GET['profile_id'];
    $_SESSION['current_profile_being_visited'] = $user_id;
    

    // Fetching from Database
    $result = fetch_all_information_from_database($pdo, (int)$user_id);
    

    // storing into variable
    $username = $result['username'];
    $email = $result['email'];
    $gender = $result['GENDER'];


    $image = '';
    if(!empty($result['image_url'])) {
        $image = '../uploads/'.$result['image_url'];
    } else {
        if($gender=='mele') {
            $image = '../uploads/male_profile_icon_image.png';
        } else if($gender=='female') {
            $image = '../uploads/female_profile_icon_image.jpg';
        }
    }

    // Display All Information of the User
    echo '<img src="'. $image . '" alt="Profile Picture" />';
    echo '<h2>' . $username . '</h2>';
    echo '<p style="margin: 10px;"> ' . $email . '</p>';

    return;
}



