<?php

declare(strict_types=1);

// This function will fetch the user
function get_user(object $pdo, string $username) {
    $query = "SELECT * FROM USERS WHERE username = :username";
    $statement = $pdo->prepare($query);
    $statement->execute([':username' => $username]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}



