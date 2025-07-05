<?php

require_once '../config_session.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $pdo = require_once '../dbh.inc.php';
        require_once 'setting.model.inc.php';

        $error = [];

        // === UPDATE USERNAME ===
        if (isset($_POST['update_username'])) {
            $username = trim($_POST['username'] ?? '');

            if (empty($username)) {
                $error['empty_username'] = "Username cannot be empty.";
            } elseif (check_if_username_already_exist($pdo, $username)) {
                $error['username_exist'] = "The username already exists.";
            }

            if (empty($error)) {
                $user_id = $_SESSION['user_id'];
                $query = "UPDATE USERS SET USERNAME = :username WHERE USER_ID = :user_id";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->execute();

                $_SESSION['username'] = $username;
                header("Location: ../../HTML/setting.php?update=username_success");
                exit();
            }
        }

        // === UPDATE EMAIL ===
        elseif (isset($_POST['update_email'])) {
            $email = trim($_POST['email'] ?? '');

            if (empty($email)) {
                $error['empty_email'] = "Email cannot be empty.";
            } elseif (!check_if_it_is_a_valid_email($email)) {
                $error['invalid_email'] = "The email is not valid.";
            } elseif (check_if_email_already_exist($pdo, $email)) {
                $error['email_exist'] = "The email already exists.";
            }

            if (empty($error)) {
                $user_id = $_SESSION['user_id'];
                $query = "UPDATE USERS SET EMAIL = :email WHERE USER_ID = :user_id";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->execute();

                $_SESSION['email'] = $email;
                header("Location: ../../HTML/setting.php?update=email_success");
                exit();
            }
        }

        // === UPDATE PASSWORD ===
        elseif (isset($_POST['update_password'])) {
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';

            if (empty($current_password) || empty($new_password)) {
                $error['password_empty'] = "Both password fields are required.";
            } elseif (!check_current_password_matched($pdo, $current_password)) {
                $error['password_not_matched'] = "The current password is incorrect.";
            }

            if (empty($error)) {
                $user_id = $_SESSION['user_id'];
                $hashed = password_hash($new_password, PASSWORD_BCRYPT);
                $query = "UPDATE USERS SET PASSWORD = :password WHERE USER_ID = :user_id";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':password', $hashed);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->execute();

                header("Location: ../../HTML/setting.php?update=password_success");
                exit();
            }
        }

        // Show errors if any
        if ($error) {
            $_SESSION['update_profile_error'] = $error;
            header("Location: ../../HTML/setting.php?update=error");
            exit();
        }

        header("Location: ../../HTML/setting.php?update=success");


    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}