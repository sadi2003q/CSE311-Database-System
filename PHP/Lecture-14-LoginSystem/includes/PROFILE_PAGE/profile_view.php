<?php


declare(strict_types=1);


use JetBrains\PhpStorm\NoReturn;

#[NoReturn] function show_user_information_profile_view(): void {

    if(isset($_SESSION['user_id']) and isset($_SESSION['username']) and isset($_SESSION['email']) and isset($_SESSION['gender'])) {

        $username = $_SESSION['username'];
        $email = $_SESSION['email'];
        $gender = $_SESSION['gender'];

        echo '<h1>Welcome, ' . $username . '</h1> <br>';

        echo '<p>Email : '. $email . '|'. 'Gender: ' .$gender .'</p> <br>';

    } else {
        header("location: ../../HTML/login.php?server=failed?function=profile_contr/show_user_information");
        die('Something went wrong');
    }

}


function error_found_while_updating_profile(): void {
    if (!isset($_SESSION['error_UpdateProfile']) || empty($_SESSION['error_UpdateProfile'])) {
        return; // No error to display
    }

    $errors = $_SESSION['error_UpdateProfile'];

    echo '<div style="width: 90%; padding: 5px; margin: 10px; background-color: pink; border-radius: 5px">';
    echo '<h3 style="color: orangered; font-family: \'Times New Roman\', Times, serif">Error Occurred</h3>';
    echo '<div style="margin-top: 10px;">';

    foreach ($errors as $error) {
        echo '<p>' . htmlspecialchars($error) . '</p>';
    }

    echo '</div>';
    echo '</div>';

    // Optionally clear the errors after displaying
    $_SESSION['error_UpdateProfile'] = null;
}

function show_all_post_from_user(object $pdo): void {
    if(!isset($_SESSION['user_id'])) {
        header("Location: ../../HTML/login.php");

    }


    $user_id = $_SESSION['user_id'];

    require_once 'profile_model.php';
    $posts = fetch_all_post_from_user($pdo);


    if (empty($posts)) {
        echo '<p>No Post Found</p>';
        header("Location: ../../HTML/login.php?server=failed?function=newsfeed_model/fetch_all_post_from_user");;
    }

    echo '<P>Posts is not empty</P>';


    foreach ($posts as $post) {
        $username = $_SESSION['username'];
        $created_at = $post['created_at'];
        $post_text_content = $post['text_content'];
        $post_image_url = $post['image_url'];

        if (!empty($post_image_url)) {
            // Post with image
            echo '<div class="post">
                <h4>@'.$username.'</h4>
                <p>'.$post_text_content.'</p>
                <p> ' . $post_image_url . '</p>
                <img src="../uploads/'.$post_image_url.'" alt="Post image" style="display: block; max-width: 80%; max-height: 400px; background-image:cover;  border-radius: 6px; margin: 1rem auto 10px; box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);">
                <div class="meta">Posted on '.$created_at.'</div>
              </div>';
        } else {
            // Post without image
            echo '<div class="post">
                <h4>@'.$username.'</h4>
                <p style="margin-top: 15px; margin-bottom: 20px; font-size: 25px; font-weight: 550;">'.$post_text_content.'</p>
                <div class="meta">Posted on '.$created_at.'</div>
              </div>';
        }


    }
}






