<?php

declare(strict_types=1);
require_once 'suggested_profile.model.inc.php';
// function show_suggested_profile(object $pdo) : void {

//     if(!isset($_SESSION['user_id'])) {
//         Header("Location: newsfeed.php?error=Not_Found");
//         die('Error Loading Profile');
//     }

//     $user_id = $_SESSION['user_id'];
//     $profile = fetch_suggested_profile($pdo, $user_id);

//     if(!$profile) {
//         Header("Location: newsfeed.php?error=Not_Found");
//         die('Error Loading Profile');
//     }

//     show_profile_picture();
//     show_prifile_name();
//     show_all_post_of_this_user($pdo, $profile['id']);
// }

function show_profile_picture() : void {

    $_SESSION['current_profile_visiting'] = $_GET['profile_id'] ?? null;

    if(!$_GET['image_url']) {
        Header("Location: newsfeed.php?image_url=Not_Found");
        die('Error Loading Image');
    }

    $image_url = $_GET['image_url'];
    echo '<img src="' . $image_url . '" alt="Profile Picture" />';


}

function show_prifile_name() : void {
    if(!$_GET['username']) {
        Header("Location: newsfeed.php?username=Not_Found");
        die('Error Loading Username');
    }


    $username = $_GET['username'];


    echo '<h2>' . htmlspecialchars($username) . '</h2>';
}

function show_basic_information_of_this_user(object $pdo) : void {

    if(!isset($_GET['profile_id'])) {
        Header("Location: newsfeed.php?profile_id=Not_Found");
        die('Error Loading User Information');
    }
    $user_id = (int)$_GET['profile_id'];

    $result = fetch_email_and_gender_of_this_user($pdo, $user_id);
    if(!$result) {
        Header("Location: newsfeed.php?profile_id=Not_Found");
        die('Error Loading User Information');
    }
    $email = htmlspecialchars($result['email']);
    $gender = htmlspecialchars($result['gender']);

    // <p style="margin: 20px;"> Email | Gender</p>
    echo '<p style="margin: 20px;">' . $email . ' | ' . $gender . '</p>';

}

function show_all_post_of_this_user(object $pdo) : void {

    if(!isset($_GET['profile_id'])) {
        Header("Location: newsfeed.php?profile_id=Not_Found");
        die('Error Loading Posts');
    }
    $user_id = (int)$_GET['profile_id'];

    $posts = fetch_all_post_of_this_user($pdo, $user_id);

    if(empty($posts)) {
        echo '<p>No posts available.</p>';
        return;
    }

    foreach ($posts as $post) {
        echo '<div class="post">';
        echo '<div class="post-header">';
        echo '<img src="' . htmlspecialchars($post['image_url']) . '" alt="Avatar" />';
        echo '<span>' . htmlspecialchars($post['username']) . '</span>';
        echo '</div>';
        echo '<div class="post-content">';
        echo '<p>' . htmlspecialchars($post['content']) . '</p>';
        echo '</div>';
        echo '</div>';
    }
    echo '<div class="post-actions">';
    echo '<button type="button">Like</button>';
    echo '<button type="button">Comment</button>';
    echo '</div>';
    echo '</div>';
}


function show_something() :void {
    echo '<p>Something to show</p>';
}

