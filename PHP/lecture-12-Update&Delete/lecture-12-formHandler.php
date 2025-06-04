<?php
//
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//
//    $username = $_POST['_inputUsername'];
//    $password = $_POST['_inputPassword'];
//    $email = $_POST['_inputEmail'];
//    $action = $_POST['action'] ?? '';
//
//    if ($action === 'login') {
//        loginUser($username, $password, $email);
//    } elseif ($action === 'update') {
//        updateUser($username, $password, $email);
//    } else {
//        header("Location: lecture-12-Failed.html");
//        exit;
//    }
//
//
//} else {
//    header("Location: lecture-12-Failed.html");
//    exit;
//}
//
//// Function to handle login (Insert)
//function loginUser($username, $password, $email): void
//{
//     try {
//         $pdo  = require_once("lecture-12.inc.php");
//
//
//         $query = "
//        INSERT INTO LOGIN_USERS(EMAIL, USERNAME, PASS)
//        VALUES (:email, :username, :password)
//        ";
//         $stmt = $pdo->prepare($query);
//         $stmt->bindParam(':username', $username);
//         $stmt->bindParam(':password', $password);
//         $stmt->bindParam(':email', $email);
//         $stmt->execute();
//
//         header("Location: lecture-12-success.html");
//         $stmt = null;
//         exit;
//     } catch (PDOException $e) {
//         header("Location: lecture-12-Failed.html");
//     }
//
//
//}
//
//// Function to handle update
//function updateUser($username, $password, $email): void
//{
//
//
//    try {
//
//        $pdo  = require_once("lecture-12.inc.php");
//
//
//        $query = "
//        UPDATE LOGIN_USERS 
//        SET PASS = :password
//        WHERE EMAIL = :email AND USERNAME = :username
//        ";
//
//
//
//
//        $stmt = $pdo->prepare($query);
//        $stmt->bindParam(':username', $username);
//        $stmt->bindParam(':password', $password);
//        $stmt->bindParam(':email', $email);
//        $stmt->execute();
//
//        if ($stmt->rowCount() > 0) {
//            header("Location: lecture-12-success.html");
//        } else {
//            header("Location: lecture-12-Failed.html");
//        }
//        $stmt = null;
//        header("Location: lecture-12-success.html");
//    } catch (PDOException $e) {
//        header("Location: lecture-12-Failed.html");
//    }
//
//}


// Include database connection
$pdo = require_once 'lecture-12.inc.php';

// Start with input sanitization
$action = $_POST['action'] ?? '';
$username = $_POST['_inputUsername'] ?? '';
$email = $_POST['_inputEmail'] ?? '';
$password = $_POST['_inputPassword'] ?? '';
$user_id = $_POST['user_id'] ?? null;

if ($action === 'login') {
    // LOGIN USER
    $stmt = $pdo->prepare("SELECT * FROM users WHERE Username = :username AND Email = :email AND password = :password");
    $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $password
    ]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "✅ Login successful. Welcome, " . htmlspecialchars($user['Username']);
        // You can set session here if needed
    } else {
        echo "❌ Invalid login credentials.";
    }

} elseif ($action === 'update' && $user_id) {
    // UPDATE USER INFO
    $stmt = $pdo->prepare("UPDATE users SET Username = :username, Email = :email, password = :password WHERE id = :id");
    $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $password,
        ':id' => $user_id
    ]);

    echo "✅ User information updated successfully.";

} elseif (isset($_GET['delete_id'])) {
    // DELETE USER BY ID (through GET parameter like ?delete_id=2)
    $deleteId = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute([':id' => $deleteId]);

    echo "🗑️ User deleted successfully.";
} else {
    echo "⚠️ Invalid action or missing user ID.";
}