<?php

declare(strict_types=1);

require_once 'newsfeed_model.php';


function show_user_information(object $pdo): void {
    $user = find_user_information($pdo);

    if ($user) {
        echo '<div>
                <p>Name: ' . htmlspecialchars($user['username']) . '</p>
                <p>Email: ' . htmlspecialchars($user['email']) . '</p>
                <p>GENDER: ' . htmlspecialchars($user['GENDER']) . '</p>
              </div>';
        unset($user);
    } else {
        header("Location: ../../HTML/login.php?server=failed?function=newsfeed_model/find_user_information");
        die("Error Occurred");       
    }

}



