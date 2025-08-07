<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";

// Redirect if admin not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Delete user if delete_user_id is set via GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_user_id'])) {
    $user_id = (int)$_GET['delete_user_id'];

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
        header("Location: admin_users.php?msg=deleted");
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Error deleting user: " . htmlspecialchars($e->getMessage());
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
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
    </style>
</head>

<body>
    <header class="admin-header">
        <h2>All USERS</h2>
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
        <h3>Search Users</h3>
        <div class="search-container">
            <form method="get" style="display: flex; gap: 1rem; width: 100%;">
                <input type="text" name="search" class="search-input" placeholder="Search by username or email..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="search-btn">Search</button>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>E-mail</th>
                        <th>Joined</th>
                        <th>Number of Posts</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';

                    $query = "SELECT u.user_id, u.username, u.created_at, u.email, COUNT(p.post_id) AS post_count
                              FROM users u
                              LEFT JOIN posts p ON u.user_id = p.user_id
                              WHERE u.username LIKE :search OR u.email LIKE :search
                              GROUP BY u.user_id
                              ORDER BY u.created_at DESC
                              LIMIT 50";

                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':search', $search);
                    $stmt->execute();

                    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (empty($users)) {
                        echo "<tr><td colspan='5'>No users found.</td></tr>";
                    } else {
                        foreach ($users as $user) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($user['username']) . "</td>";
                            echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                            echo "<td>" . date('M j, Y', strtotime($user['created_at'])) . "</td>";
                            echo "<td>" . htmlspecialchars($user['post_count']) . "</td>";
                            echo "<td>
                                      <details>
                                          <summary style='color: red; cursor: pointer;'>DELETE 🗑️</summary>
                                          <div style='margin-top: 0.5rem;'>
                                              <form method='get'>
                                                  <input type='hidden' name='delete_user_id' value='" . htmlspecialchars($user['user_id']) . "'>
                                                  <button type='submit' class='delete-btn'>Yes, Delete</button>
                                                  <button type='button' class='cancel-btn' onclick='this.closest(\"details\").removeAttribute(\"open\")'>Cancel</button>
                                              </form>
                                          </div>
                                      </details>
                                  </td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body