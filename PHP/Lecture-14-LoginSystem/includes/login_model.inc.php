<?php

declare(strict_types=1);

function get_user(object $pdo, string $username) {
    $query = "SELECT * FROM LOGIN_USER WHERE username = :username";
    $statement = $pdo->prepare($query);
    $statement->execute([':username' => $username]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}



