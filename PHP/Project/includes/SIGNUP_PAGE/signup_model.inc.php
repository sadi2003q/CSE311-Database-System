<?php

declare(strict_types=1);

// This function will check if the given username for signing up already exist or not
function get_username(object $pdo, string $username) {
    $query = "SELECT USERNAME FROM USERS WHERE username = :username";
    $statement = $pdo->prepare($query);
    $statement->execute([':username' => $username]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

// This function will check if the given email for signing up already exist or not
function get_email(object $pdo, string $email) {
    $query = "SELECT EMAIL FROM USERS WHERE email = :email";
    $statement = $pdo->prepare($query);
    $statement->execute([':email' => $email]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}



// This will set the user into the database
function set_user(object $pdo, string $username, string $password, string $email, string $gender, string $dob): void {

    $query = "INSERT INTO USERS (USERNAME, EMAIL, PASSWORD, DOB, GENDER) 
              VALUES (:username, :email, :password, :dob, :gender)";
    $statement = $pdo->prepare($query);

    $option = [
        'cost' => 12,
    ];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT, $option);

    $statement->bindParam(':email', $email);
    $statement->bindParam(':username', $username);
    $statement->bindParam(':password', $hashed_password);
    $statement->bindParam(':gender', $gender);
    $statement->bindParam(':dob', $dob); // Assumes format 'YYYY-MM-DD'

    $statement->execute();
}





























