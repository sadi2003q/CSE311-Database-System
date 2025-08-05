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
                update_username($pdo, $username);

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
                update_email($pdo, $email);

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
                update_password($pdo, $new_password);
                header("Location: ../../HTML/setting.php?update=password_success");
                exit();
            }
        }

        // === REQUEST ACCOUNT DELETION ===
       /* elseif (isset($_POST['request_deletion'])) {
            $user_id = $_SESSION['user_id'];
            $email = $_SESSION['email'];
            $reason = $_POST['delete_reason'] ?? null;

            // Log deletion request with reason
            log_deletion_request($pdo, $user_id, $email, $reason);

            // Redirect to the dedicated success page
            header("Location: /PHP/Project/HTML/deletion_success.php");
            exit();
        }*/

        elseif (isset($_POST['request_deletion'])) {
            $user_id = $_SESSION['user_id'];
            $email = $_SESSION['email'];
            $reason = $_POST['delete_reason'] ?? null;
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM deletion_requests WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            $alreadyRequested = $stmt->fetchColumn();

            if ($alreadyRequested > 0) {
                // Already requested - redirect to a message page or back with error
                $_SESSION['error'] = "You have already submitted a deletion request.";
                header("Location: /PHP/Project/HTML/setting.php?confirm_request=1");
                exit();
            } else {
                log_deletion_request($pdo, $user_id, $email, $reason);
                header("Location: /PHP/Project/HTML/deletion_success.php");
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
