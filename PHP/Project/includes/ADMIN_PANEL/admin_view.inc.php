<?php

declare(strict_types=1);

function display_recent_users(): void {
    require_once "../dbh.inc.php";
    
    $query = "SELECT user_id, username, email, created_at FROM USERS ORDER BY created_at DESC LIMIT 10";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($user['user_id']) . "</td>";
        echo "<td>" . htmlspecialchars($user['username']) . "</td>";
        echo "<td>" . htmlspecialchars($user['email']) . "</td>";
        echo "<td>" . date('M j, Y', strtotime($user['created_at'])) . "</td>";
        echo "<td>
                <button class='action-btn view-btn'>View</button>
                <button class='action-btn delete-btn'>Delete</button>
              </td>";
        echo "</tr>";
    }
}

function display_recent_posts(): void {
    require_once "../dbh.inc.php";
    
    $query = "SELECT p.post_id, p.content, u.username, p.created_at, p.likes 
              FROM POSTS p 
              JOIN USERS u ON p.user_id = u.user_id 
              ORDER BY p.created_at DESC LIMIT 10";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($posts as $post) {
        $content = strlen($post['content']) > 50 ? substr($post['content'], 0, 50) . "..." : $post['content'];
        echo "<tr>";
        echo "<td>" . htmlspecialchars($post['post_id']) . "</td>";
        echo "<td>" . htmlspecialchars($content) . "</td>";
        echo "<td>" . htmlspecialchars($post['username']) . "</td>";
        echo "<td>" . date('M j, Y', strtotime($post['created_at'])) . "</td>";
        echo "<td>" . htmlspecialchars($post['likes']) . "</td>";
        echo "<td>
                <button class='action-btn view-btn'>View</button>
                <button class='action-btn delete-btn'>Delete</button>
              </td>";
        echo "</tr>";
    }
}

function display_flagged_content(): void {
    require_once "../dbh.inc.php";
    
    $query = "SELECT p.post_id, p.content, u.username, COUNT(r.report_id) as flags, p.created_at 
              FROM POSTS p 
              JOIN USERS u ON p.user_id = u.user_id 
              LEFT JOIN REPORTS r ON p.post_id = r.post_id 
              GROUP BY p.post_id 
              HAVING flags > 0 
              ORDER BY flags DESC LIMIT 10";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($posts as $post) {
        $content = strlen($post['content']) > 50 ? substr($post['content'], 0, 50) . "..." : $post['content'];
        echo "<tr>";
        echo "<td>" . htmlspecialchars($post['post_id']) . "</td>";
        echo "<td>" . htmlspecialchars($content) . "</td>";
        echo "<td>" . htmlspecialchars($post['username']) . "</td>";
        echo "<td>" . htmlspecialchars($post['flags']) . "</td>";
        echo "<td>" . date('M j, Y', strtotime($post['created_at'])) . "</td>";
        echo "<td>
                <button class='action-btn view-btn'>View</button>
                <button class='action-btn delete-btn'>Delete</button>
              </td>";
        echo "</tr>";
    }
}

function get_total_users_count() {
    $pdo = require_once "../includes/dbh.inc.php"; // database connection

    // Get total users
    $query = "SELECT COUNT(*) as count FROM USERS";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result_usernumber = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Get total posts
    $query = "SELECT COUNT(*) as count FROM POSTS";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result_postnumber = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Return both counts as an associative array
    return [
        'user_count' => $result_usernumber,
        'post_count' => $result_postnumber
    ];
}


function get_active_users_count(): int {
    $pdo = require_once "../includes/dbh.inc.php";
    
    $query = "SELECT COUNT(*) as count FROM USERS";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

function get_total_posts_count(): int {
    $pdo = require_once "../includes/dbh.inc.php";
    $query = "SELECT COUNT(*) as count FROM POSTS";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

function get_pending_requests_count(): int {
    require_once "../dbh.inc.php";
    
    $query = "SELECT COUNT(*) as count FROM DELETION_REQUESTS WHERE status = 'pending'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

function display_all_users(): void {
   $pdo = require_once "../includes/dbh.inc.php";
    
    // Pagination variables
    $limit = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;
    
    // Search functionality
    $search = isset($_GET['search']) ? "%" . $_GET['search'] . "%" : "%";
    
    $query = "SELECT user_id, username, email, created_at, last_login, is_active 
              FROM USERS 
              WHERE username LIKE :search OR email LIKE :search
              ORDER BY created_at DESC 
              LIMIT :limit OFFSET :offset";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':search', $search);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($users)) {
        echo "<tr><td colspan='7'>No users found</td></tr>";
        return;
    }
    
    foreach ($users as $user) {
        $status = $user['is_active'] ? "Active" : "Inactive";
        $lastLogin = $user['last_login'] ? date('M j, Y H:i', strtotime($user['last_login'])) : "Never";
        
        echo "<tr>";
        echo "<td>" . htmlspecialchars($user['user_id']) . "</td>";
        echo "<td>" . htmlspecialchars($user['username']) . "</td>";
        echo "<td>" . htmlspecialchars($user['email']) . "</td>";
        echo "<td>" . date('M j, Y', strtotime($user['created_at'])) . "</td>";
        echo "<td>" . $lastLogin . "</td>";
        echo "<td>" . $status . "</td>";
        echo "<td>
                <button class='action-btn view-btn' onclick='viewUser(" . $user['user_id'] . ")'>View</button>
                <button class='action-btn delete-btn' onclick='confirmDelete(" . $user['user_id'] . ")'>Delete</button>
              </td>";
        echo "</tr>";
    }
}

function display_all_posts(): void {
    $pdo = require_once "../includes/dbh.inc.php";
    
    // Pagination variables
    $limit = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;
    
    // Search functionality
    $search = isset($_GET['search']) ? "%" . $_GET['search'] . "%" : "%";
    
    $query = "SELECT p.post_id, p.content, u.username, p.created_at, p.likes, 
                     COUNT(r.report_id) as flags, p.is_restricted
              FROM POSTS p 
              JOIN USERS u ON p.user_id = u.user_id 
              LEFT JOIN REPORTS r ON p.post_id = r.post_id 
              WHERE p.content LIKE :search
              GROUP BY p.post_id
              ORDER BY p.created_at DESC 
              LIMIT :limit OFFSET :offset";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':search', $search);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($posts)) {
        echo "<tr><td colspan='8'>No posts found</td></tr>";
        return;
    }
    
    foreach ($posts as $post) {
        $content = strlen($post['content']) > 100 ? substr($post['content'], 0, 100) . "..." : $post['content'];
        $status = $post['is_restricted'] ? "Restricted" : "Active";
        
        echo "<tr>";
        echo "<td>" . htmlspecialchars($post['post_id']) . "</td>";
        echo "<td>" . htmlspecialchars($content) . "</td>";
        echo "<td>" . htmlspecialchars($post['username']) . "</td>";
        echo "<td>" . date('M j, Y', strtotime($post['created_at'])) . "</td>";
        echo "<td>" . htmlspecialchars($post['likes']) . "</td>";
        echo "<td>" . htmlspecialchars($post['flags']) . "</td>";
        echo "<td>" . $status . "</td>";
        echo "<td>
                <button class='action-btn view-btn' onclick='viewPost(" . $post['post_id'] . ")'>View</button>
                <button class='action-btn delete-btn' onclick='deletePost(" . $post['post_id'] . ")'>Delete</button>
                <button class='action-btn restrict-btn' onclick='restrictPost(" . $post['post_id'] . ")'>" . 
                ($post['is_restricted'] ? "Unrestrict" : "Restrict") . "</button>
              </td>";
        echo "</tr>";
    }
}





function display_deletion_requests(): void {
    require_once "../includes/dbh.inc.php";

    $query = "SELECT dr.id, u.username, u.email, dr.requested_at, dr.reason 
              FROM deletion_requests dr 
              JOIN users u ON dr.user_id = u.user_id 
              ORDER BY dr.requested_at DESC";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($requests)) {
        echo "<tr><td colspan='5'>No deletion requests found</td></tr>";
        return;
    }

    foreach ($requests as $request) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($request['username']) . "</td>";
        echo "<td>" . htmlspecialchars($request['email']) . "</td>";
        echo "<td>" . date('M j, Y H:i', strtotime($request['requested_at'])) . "</td>";
        echo "<td>" . htmlspecialchars($request['reason'] ?? 'No reason provided') . "</td>";
        echo "<td><button class='delete-btn' onclick='deleteUserByEmail(\"" . $request['email'] . "\")'>Delete Account</button></td>";
        echo "</tr>";
    }
}

