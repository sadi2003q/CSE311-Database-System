<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";

// Redirect if admin not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle full user deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $user_id = (int)$_POST['delete_user_id'];

    try {
        $pdo->beginTransaction();

        // 1. Delete comments made by user
        $stmt = $pdo->prepare("DELETE FROM comments WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

        // 2. Delete comments on user's posts
        $stmt = $pdo->prepare("DELETE FROM comments WHERE post_id IN (SELECT post_id FROM posts WHERE user_id = :user_id)");
        $stmt->execute(['user_id' => $user_id]);

        // 3. Delete likes
        $stmt = $pdo->prepare("DELETE FROM likes WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

        // 4. Delete notifications
        $stmt = $pdo->prepare("DELETE FROM notifications WHERE sender_id = :user_id OR recipient_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

        // 5. Delete follow records
        $stmt = $pdo->prepare("DELETE FROM follow WHERE follower_id = :user_id OR following_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

        // 6. Delete deletion request
        $stmt = $pdo->prepare("DELETE FROM deletion_requests WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

        // 7. Delete posts
        $stmt = $pdo->prepare("DELETE FROM posts WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

        // 8. Delete user
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

        $pdo->commit();
        header("Location: admin_requests.php?msg=deleted");
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Error deleting user: " . htmlspecialchars($e->getMessage());
    }
}

// Fetch deletion requests with user info
$stmt = $pdo->query("SELECT dr.*, u.username, u.email FROM deletion_requests dr JOIN users u ON dr.user_id = u.user_id ORDER BY dr.requested_at DESC");
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Deletion Requests</title>
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        .admin-header {
            background-color: #2d2d2d;
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-nav {
            display: flex;
            gap: 1rem;
        }
        .admin-nav a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }
        .admin-nav a:hover {
            background-color: #4ECDC4;
        }
        .logout-btn {
            background-color: #ff6b6b;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }
        .logout-btn:hover {
            background-color: #ff5252;
        }
        .admin-main {
            padding: 2rem;
        }
        .search-container {
            margin-bottom: 1.5rem;
            display: flex;
            gap: 1rem;
        }
        .search-input {
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            flex-grow: 1;
        }
        .search-btn {
            padding: 0.75rem 1.5rem;
            background-color: #4ECDC4;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .table-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
      th, td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #ddd;
    white-space: normal;       
    word-wrap: break-word;     
    max-width: 300px;          
}

        th {
            background-color: #2d2d2d;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }

    </style>
</head>
<body>

    <header class="admin-header">
        <h2>Admin REQUEST</h2>
        <nav class="admin-nav">
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="admin_users.php">Manage Users</a>
            <a href="admin_posts.php">Manage Posts</a>
            <a href="admin_requests.php">Deletion Requests</a>
            <form action="../includes/ADMIN_PANEL/admin_logout.inc.php" method="post">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </nav>
    </header>

<main class="admin-main">
    <?php if (isset($error)): ?>
        <div class="status-msg" style="color:red;"><?= $error ?></div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
        <div class="status-msg" style="color:green;">User and all related data deleted successfully.</div>
    <?php endif; ?>

    <?php if (isset($_GET['confirm_user_id'])): ?>
        <?php
        $confirm_id = (int)$_GET['confirm_user_id'];
        $user = null;
        foreach ($requests as $r) {
            if ($r['user_id'] == $confirm_id) {
                $user = $r;
                break;
            }
        }
        ?>
        <?php if ($user): ?>
            <div class="confirm-box">
                <h3>Are you sure you want to delete this user and all related data?</h3>
                <p><strong><?= htmlspecialchars($user['username']) ?> (<?= htmlspecialchars($user['email']) ?>)</strong></p>
                <form method="post">
                    <input type="hidden" name="delete_user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
                    <button type="submit" class="yes">Yes, Delete</button>
                    <a href="admin_requests.php" class="no"><button type="button" class="no">Cancel</button></a>
                </form>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <h3>Account Deletion Requests</h3>
        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Requested At</th>
                    <th>Reason</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($requests)): ?>
                    <tr><td colspan="5">No deletion requests found.</td></tr>
                <?php else: ?>
                    <?php foreach ($requests as $r): ?>
                        <tr>
                            <td><?= htmlspecialchars($r['username']) ?></td>
                            <td><?= htmlspecialchars($r['email']) ?></td>
                            <td><?= date('M j, Y H:i', strtotime($r['requested_at'])) ?></td>
                            <td><?= nl2br(htmlspecialchars($r['reason'])) ?></td>
                            <td>
                                <a href="?confirm_user_id=<?= $r['user_id'] ?>" style="color: red; font-weight: bold;">DELETE 🗑️</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

</body>
</html>
