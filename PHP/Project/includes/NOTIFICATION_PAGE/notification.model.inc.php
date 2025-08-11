<?php 

declare(strict_types=1);

// Fetches all notifications for a specific user, ordered by creation date.
function fetch_all_notifications(object $pdo, int $userID) {
    $query = "SELECT * FROM NOTIFICATIONS WHERE RECIPIENT_ID = :recipientID ORDER BY CREATED_AT DESC";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':recipientID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetches the information of the user who sent a notification.
function fetch_notification_sender_information(object $pdo, int $userID) {
    $query = "SELECT * FROM USERS WHERE USER_ID = :userID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);

}

// Marks all unread notifications for a user as read.
function mark_all_notification_as_read(object $pdo, int $userID) {
    $query = "UPDATE NOTIFICATIONS SET STATE=1 WHERE RECIPIENT_ID=:recipient_id and STATE = 0";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':recipient_id', $userID, PDO::PARAM_INT);
    $stmt->execute();
}



