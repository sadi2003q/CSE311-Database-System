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

        $stmt = $pdo->prepare("DELETE FROM comments WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

        $stmt = $pdo->prepare("DELETE FROM comments WHERE post_id IN (SELECT post_id FROM posts WHERE user_id = :user_id)");
        $stmt->execute(['user_id' => $user_id]);

        $stmt = $pdo->prepare("DELETE FROM likes WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

        $stmt = $pdo->prepare("DELETE FROM notifications WHERE sender_id = :user_id OR recipient_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

        $stmt = $pdo->prepare("DELETE FROM follow WHERE follower_id = :user_id OR following_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

        $stmt = $pdo->prepare("DELETE FROM deletion_requests WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

        $stmt = $pdo->prepare("DELETE FROM posts WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);

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

// Handle cancel deletion request only
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_request_user_id'])) {
    $user_id = (int)$_POST['cancel_request_user_id'];

    $stmt = $pdo->prepare("DELETE FROM deletion_requests WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);

    header("Location: admin_requests.php?msg=canceled");
    exit();
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

        .delete-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: #ff5252;
        }

        .cancel-btn {
            background-color: gray;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .cancel-btn:hover {
            background-color: #bdbdbd;
        }

        .action-form {
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>

<header class="admin-header">
    <h2>Account Delete REQUEST</h2>
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
    <div class="table-container">
        <?php if (isset($error)): ?>
            <div class="status-msg" style="color:red; margin-bottom: 1rem;"><?= $error ?></div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
            <div class="status-msg" style="color:green; margin-bottom: 1rem;">   User and all related data deleted successfully.</div>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'canceled'): ?>
            <div class="status-msg" style="color:blue; margin-bottom: 1rem;"> Deletion request canceled.</div>
        <?php endif; ?>

        <table>
            <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Requested At</th>
                <th>Reason</th>
                <th>Actions</th>
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
                <details>
                    <summary style="color: red; cursor: pointer;">DELETE 🗑️</summary>
                    <div style="margin-top: 0.5rem;">
                        <form method="post">
                            <input type="hidden" name="delete_user_id" value="<?= htmlspecialchars($r['user_id']) ?>">
                            <button type="submit" style="background-color: red; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">Yes, Delete</button>
                            <button type="button" style="background-color: gray; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;" onclick='this.closest("details").removeAttribute("open")'>Cancel</button>
                        </form>
                    </div>
                </details>
                <form method="post" style="margin-top: 0.5rem;">
                    <input type="hidden" name="cancel_request_user_id" value="<?= htmlspecialchars($r['user_id']) ?>">
                    <button type="submit" class="cancel-btn">Cancel Request</button>
                </form>
            </td>

                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>