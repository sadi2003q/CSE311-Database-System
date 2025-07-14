<?php

declare(strict_types=1);

// Upload new post
function upload_post_to_database(PDO $pdo, string $post_text, string $post_image, int $user_id): void {
    $query = "INSERT INTO POSTS (user_id, text_content, image_url) 
              VALUES (:user_id, :post_text, :post_image)";
    
    $statement = $pdo->prepare($query);
    $statement->execute([
        ':user_id' => $user_id,
        ':post_text' => $post_text,
        ':post_image' => $post_image
    ]);
}

// Suggest random profiles (for friend suggestions)
function fetch_new_profile_for_suggession(PDO $pdo): array {
    if (!isset($_SESSION['user_id'])) {
        return []; 
    }

    $user_id = $_SESSION['user_id'];

    // Suggest other users excluding self
    $query = "SELECT * FROM USERS WHERE user_id != :user_id ORDER BY user_id DESC LIMIT 20";
    
    $statement = $pdo->prepare($query);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch feed from users the logged-in user follows
function fetch_all_new_feed(PDO $pdo): array {
    if (!isset($_SESSION['user_id'])) {
        return []; 
    }

    try {
        $user_id = $_SESSION['user_id'];

        $query = "SELECT *
                  FROM follow f
                  JOIN posts p ON f.FOLLOWING_ID = p.user_id
                  WHERE f.FOLLOWER_ID = :user_id
                  ORDER BY p.created_at DESC";

        $statement = $pdo->prepare($query);
        $statement->execute([':user_id' => $user_id]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo '<p>Error Found: ' . $e->getMessage() . '</p>';
        return [];
    }
}

// Get info of post creator
function fetch_post_maker_info(PDO $pdo, int $id): ?array {
    try {
        $query = "SELECT * FROM users WHERE user_id = :uid";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':uid', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo 'Exception Found: ' . $e->getMessage();
        return null;
    }
}



// Reaction-related functions

// Add or update user reaction to a post
function set_reaction(PDO $pdo, int $user_id, int $post_id, string $reaction_type): void {
    $stmt = $pdo->prepare("SELECT * FROM reactions WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$user_id, $post_id]);
    $existing = $stmt->fetch();

    if ($existing) {
        $stmt = $pdo->prepare("UPDATE reactions SET reaction_type = ? WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$reaction_type, $user_id, $post_id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO reactions (user_id, post_id, reaction_type) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $post_id, $reaction_type]);
    }
}

// Count total reactions for each type for a post
function get_reaction_counts(PDO $pdo, int $post_id): array {
    $stmt = $pdo->prepare("SELECT reaction_type, COUNT(*) as count FROM reactions WHERE post_id = ? GROUP BY reaction_type");
    $stmt->execute([$post_id]);
    $results = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    $types = ['Like', 'Love', 'Haha', 'Sad', 'Angry'];
    $counts = [];
    foreach ($types as $type) {
        $counts[$type] = $results[$type] ?? 0;
    }

    return $counts;
}

// Get current user's reaction to a post
function get_user_reaction(PDO $pdo, int $user_id, int $post_id): ?string {
    $stmt = $pdo->prepare("SELECT reaction_type FROM reactions WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$user_id, $post_id]);
    return $stmt->fetchColumn() ?: null;
}
