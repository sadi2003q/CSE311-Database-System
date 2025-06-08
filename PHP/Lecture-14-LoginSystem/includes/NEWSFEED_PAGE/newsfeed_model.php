<?php



declare(strict_types=1);


function find_user_information(object $pdo) {
    // Check if a user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../../HTML/login.php");
        die("Error Occurred");
    }


    $userId = $_SESSION['user_id'];

    try {
        // Prepare SQL query to fetch user information
        $query = "SELECT * FROM USERS WHERE user_id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);


    } catch (PDOException $e) {
        echo "<p>Error fetching user information: " . htmlspecialchars($e->getMessage()) . "</p>";
    }

}




