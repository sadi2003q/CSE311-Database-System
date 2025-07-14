<?php


declare(strict_types=1);



function is_all_post_fields_are_empty($post_text, $post_image): bool {
    return empty($post_text) && empty($post_image);
}

function post_now(object $pdo, string $post_text, string $post_image, int $user_id): void {

    upload_post_to_database($pdo, $post_text, $post_image, $user_id);


}


session_start();
require_once '../config/db.php';
require_once '../includes/post_model.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'], $_POST['reaction_type'])) {
    $user_id = $_SESSION['user_id'];
    $post_id = (int) $_POST['post_id'];
    $reaction_type = $_POST['reaction_type'];

    $valid_reactions = ['Like', 'Love', 'Haha', 'Sad', 'Angry'];
    if (!in_array($reaction_type, $valid_reactions, true)) {
        echo json_encode(['status' => 'invalid_reaction']);
        exit;
    }

    try {
        set_reaction($pdo, $user_id, $post_id, $reaction_type);
        $counts = get_reaction_counts($pdo, $post_id);
        $user_reaction = get_user_reaction($pdo, $user_id, $post_id);

        echo json_encode([
            'status' => 'success',
            'reaction_counts' => $counts,
            'user_reaction' => $user_reaction
        ]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

//This function adds or updates a user's reaction (like, love, haha, etc.) on a post.
function set_reaction(PDO $pdo, int $user_id, int $post_id, string $reaction_type): void {
    // Check if user already reacted
    $stmt = $pdo->prepare("SELECT * FROM reactions WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$user_id, $post_id]);
    $existing = $stmt->fetch();

    if ($existing) {
        // Update the reaction
        $stmt = $pdo->prepare("UPDATE reactions SET reaction_type = ? WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$reaction_type, $user_id, $post_id]);
    } else {
        // Insert new reaction
        $stmt = $pdo->prepare("INSERT INTO reactions (user_id, post_id, reaction_type) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $post_id, $reaction_type]);
    }
}

//Fetch how many users gave each type of reaction for a specific post.
function get_reaction_counts(PDO $pdo, int $post_id): array {
    $stmt = $pdo->prepare("SELECT reaction_type, COUNT(*) as count FROM reactions WHERE post_id = ? GROUP BY reaction_type");
    $stmt->execute([$post_id]);
    $results = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    // Initialize all reactions to 0
    $types = ['Like', 'Love', 'Haha', 'Sad', 'Angry'];
    $counts = [];
    foreach ($types as $type) {
        $counts[$type] = $results[$type] ?? 0;
    }

    return $counts;
}

//Find out what reaction a specific user has given to a specific post.
function get_user_reaction(PDO $pdo, int $user_id, int $post_id): ?string {
    $stmt = $pdo->prepare("SELECT reaction_type FROM reactions WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$user_id, $post_id]);
    return $stmt->fetchColumn() ?: null;
}
