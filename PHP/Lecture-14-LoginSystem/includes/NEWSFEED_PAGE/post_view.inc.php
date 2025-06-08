<?php


declare(strict_types=1);


function upload_error_occurred(): void {
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