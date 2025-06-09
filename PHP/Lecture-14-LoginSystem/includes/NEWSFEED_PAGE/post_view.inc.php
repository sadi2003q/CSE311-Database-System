<?php


declare(strict_types=1);


function upload_error_occurred(): void {

    if($_GET['post']==='success') {
        echo '
        <div class="success-message">
                    <h3>Post Uploaded Successfully</h3>
                    <p>Refresh the page for new feeds</p>
        </div>
        ';
        return;
    }

    if (!isset($_SESSION['error_post']) || empty($_SESSION['error_post'])) {
        return;
    }

    $errors = $_SESSION['error_post'];

    echo '<div style="width: 90%; background-color: pink; padding: 10px; border-radius: 10px; margin-top: 10px;">
            <h3 style="font-family: \'Times New Roman\', Times, serif; font-weight: bold; color: orangered">
                Error Occurred While Uploading
            </h3>
            <div style="margin-top: 15px; font-family: \'Times New Roman\', Times, serif">';

    foreach ($errors as $error) {
        echo '<p>' . htmlspecialchars($error) . '</p>';
    }

    echo '   </div>
          </div>';

    // Optional: clear errors after displaying
    unset($_SESSION['error_post']);
}

function show_new_suggession_form_database(object $pdo): void
{
    require_once 'post_model.inc.php';
    $all_profile = fetch_new_profile_for_suggession($pdo);
    if(empty($all_profile)) {
        return;
    }
    echo '<div class="friend-suggestions">';


    echo '<h3 class="friend-suggestions"> Suggested Profiles </h3>';
    foreach($all_profile as $profile) {
        echo '<div class="suggestion">'.
                //'<img src="friend-avatar.jpg" alt="Friend" />'.
                '<div>'.
                    '<p>'.$profile['username'].'</p>'.
                    '<button>Add</button>'.
                '</div>'.
            '</div>';
    }

    echo '</div>';


}