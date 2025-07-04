<?php 

declare(strict_types=1);
require_once '../config_session.inc.php';

if($_SERVER['REQUEST_METHOD']=='GET') {
    try {
        $pdo = require_once '../dbh.inc.php';
        $username = $_GET['username'] ?? '';
        $email = $_GET['email'] ?? '';
        $current_password = $_GET['current_password'] ?? '';
        $new_password = $_GET['new_password'] ?? '';



        $error = [];
        
        if (check_if_all_fields_are_empty($username, $email, $current_password, $new_password)) {
            $error["all_empty"] = "All the fields are empty.";
        }

        if (!empty($email) && !check_if_it_is_a_valid_email($email)) {
            $error["invalid_email"] = "The email is not a valid email.";
        }

        if (check_if_email_already_exist($pdo, $email)) {
            $error["email_exist"] = "The email already exist.";
        }

        if (check_if_username_already_exist($pdo, $username)) {
            $error["username_exist"] = "The username already exist.";
        }

        if ((!empty($username) || !empty($email) || !empty($new_password)) && !check_current_password_matched($pdo, $current_password)) {
            $error["password_not_matched"] = "The current password is not matched or not provided.";
        }

        if ($error) {
            $_SESSION['setting_error'] = $error;
            header("Location: ../../HTML/setting.php?error");
            
        }
        
        

        
        


    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


// This function will check if allinput box is empty or not
function check_if_all_fields_are_empty(string $username, string $email, string $old_password, string $new_password) : bool {
    return empty($username) && empty($email) && empty($old_password) && empty($new_password);
}


function check_if_it_is_a_valid_email(string $email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}



function check_if_email_already_exist(object $pdo, string $email) : bool {
    $current_email = $_SESSION['email'];

    // Only check if the new email is different from the current one
    if ($current_email != $email && $email != '')  {
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



function check_if_username_already_exist(object $pdo, string $username) : bool {
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

function check_current_password_matched(object $pdo, string $password) : bool {

    
    $user_id = $_SESSION['user_id'];
    $query = "SELECT PASSWORD FROM USERS WHERE USER_ID = userID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':USER_ID', $user_id, PDO::PARAM_STR);
    $stmt->execute();

    $option = [
        'cost' => 12,
    ];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT, $option);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && isset($row['PASSWORD'])) {
        return password_verify($password, $row['PASSWORD']);
    }
    return false;


}


