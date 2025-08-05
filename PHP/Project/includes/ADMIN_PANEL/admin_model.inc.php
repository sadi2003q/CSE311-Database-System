<?php

declare(strict_types=1);

function get_admin(object $pdo, string $username) {
    $query = "SELECT * FROM admins WHERE username = :username";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":username", $username);
    $statement->execute();
    
    return $statement->fetch(PDO::FETCH_ASSOC);
}