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

    if (empty($all_profile)) {
        return;
    }

    echo '<div class="friend-suggestions">';
    echo '<h3 class="friend-suggestions">Suggested Profiles</h3>';

    foreach ($all_profile as $profile) {
        // Determine image source
        $imageSrc = '';
        if($profile['image_url']) {
            $imageSrc = '../uploads/'.$profile['image_url']; // Assuming images are stored in an 'uploads' 
        } else {
            if($profile['GENDER'] == 'male') {
                $imageSrc = '../uploads/male_profile_icon_image.png';
            } else if($profile['GENDER'] == 'female') {
                $imageSrc = '../uploads/female_profile_icon_image.jpg';
            }
        }

        echo '<div class="suggestion" style="display: flex; align-items: center; margin-bottom: 10px;">' .
                '<img src="' . $imageSrc . '" alt="Profile" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 10px;" />' .
                '<div>' .
                    '<p style="margin: 0; font-weight: bold;">' . htmlspecialchars($profile['username']) . '</p>' .
                    '<button>Add</button>' .
                '</div>' .
             '</div>';
    }

    echo '</div>';
}