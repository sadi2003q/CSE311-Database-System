<?php 


// This function will check if allinput box is empty or not
function check_if_all_fields_are_empty(string $username, string $email, string $old_password, string $new_password): bool
{
    return empty($username) && empty($email) && empty($old_password) && empty($new_password);
}


function check_if_it_is_a_valid_email(string $email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}



function check_if_email_already_exist(object $pdo, string $email): bool
{   
    $current_email = $_SESSION['email'];
    

    // Only check if the new email is different from the current one
    if ($current_email != $email && $email != '') {
        $query = "SELECT EMAIL FROM USERS WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        // If we get a result, it means the email already exists
        if ($stmt->fetch()) {
            return true;
        }
    }

    // Return false if same email or not found
    return false;
}



function check_if_username_already_exist(object $pdo, string $username): bool
{
    $current_username = $_SESSION['username'];

    // Only check if the new username is different from the current one
    if ($current_username != $username && $username != '') {
        $query = "SELECT USERNAME FROM USERS WHERE username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        // If we get a result, it means the username already exists
        if ($stmt->fetch()) {
            return true;
        }
    }

    // Return false if same username or not found
    return false;
}


function check_current_password_matched(object $pdo, string $password): bool
{
    $user_id = $_SESSION['user_id'];
    
    $query = "SELECT PASSWORD FROM USERS WHERE USER_ID = :USER_ID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':USER_ID', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && isset($row['PASSWORD'])) {
        return password_verify($password, $row['PASSWORD']); // ✅ correct comparison
    }

    return false;
}



function update_username(object $pdo, string $username) : void {
    $user_id = $_SESSION['user_id'];
    $query = "UPDATE USERS SET USERNAME = :username WHERE USER_ID = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
}


function update_email(object $pdo, string $email) : void {
    $user_id = $_SESSION['user_id'];
    $query = "UPDATE USERS SET EMAIL = :email WHERE USER_ID = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
}


function update_password(object $pdo, string $new_password) : void {
    $user_id = $_SESSION['user_id'];
    $hashed = password_hash($new_password, PASSWORD_BCRYPT);
    $query = "UPDATE USERS SET PASSWORD = :password WHERE USER_ID = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':password', $hashed);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

}



// Fetch all Interraction
// FOLLOW, likes, posts





