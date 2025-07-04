<?php

declare(strict_types=1);

require_once 'newsfeed_model.php';


function show_user_information(object $pdo): void {
    $user = find_user_information($pdo);

    if ($user) {
        echo '
            <div style="text-align: left; font-family: Poppins, sans-serif;">
                <p style="font-weight: 600; margin-bottom: 10px; font-size: 1.5rem; color: #333;">' . htmlspecialchars($user['username']) . '</p>
                <p style="color: #555; font-size: 0.95rem; margin-bottom: 10px;">📧 ' . htmlspecialchars($user['email']) . '</p>
                <p style="color: #555; font-size: 0.95rem; margin-bottom: 10px;">🚻 ' . htmlspecialchars($user['GENDER']) . '</p>
            </div>';
        unset($user);
    } else {
        header("Location: ../../HTML/login.php?server=failed&function=newsfeed_model/find_user_information");
        die("Error Occurred");       
    }
}



