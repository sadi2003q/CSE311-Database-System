<?php



declare(strict_types=1);


function find_user_information(object $pdo) {
    // Check if a user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../../HTML/login.php");
        die("Error Occurred");
    }


    $userId = $_SESSION['user_id'] ;

    try {
        // Prepare SQL query to fetch user information
        $query = "SELECT * FROM USERS WHERE user_id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Adding important information to the session

        $_SESSION['username'] = $result['username'];
        $_SESSION['email'] = $result['email'];

        $_SESSION['gender'] = $result['GENDER'];

        if($result['image_url'] !== null) {
            $_SESSION['image_url'] = $result['image_url'];
        }



        return $result;



    } catch (PDOException $e) {
        echo "<p>Error fetching user information: " . htmlspecialchars($e->getMessage()) . "</p>";
    }

}

function fetch_notification_sender_information(object $pdo, int $userID) {
    $query = "SELECT * FROM USERS WHERE USER_ID = :userID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);

}


function find_leatest_notification(object $pdo, int $userID) {
    $query = "SELECT * FROM NOTIFICATIONS WHERE RECIPIENT_ID = :userID ORDER BY CREATED_AT DESC LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $notification = $stmt->fetch(PDO::FETCH_ASSOC);

    return $notification;
}


