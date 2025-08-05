<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";
// Handle post deletion
if (isset($_GET['delete_post_id'])) {
    $delete_id = (int)$_GET['delete_post_id'];

    try {
        // Start a transaction
        $pdo->beginTransaction();

        // Delete all comments related to the post
        $stmt_comments = $pdo->prepare("DELETE FROM comments WHERE post_id = :post_id");
        $stmt_comments->bindParam(':post_id', $delete_id, PDO::PARAM_INT);
        $stmt_comments->execute();

        // Delete all likes related to the post
        $stmt_likes = $pdo->prepare("DELETE FROM likes WHERE post_id = :post_id");
        $stmt_likes->bindParam(':post_id', $delete_id, PDO::PARAM_INT);
        $stmt_likes->execute();
        //
        $query = "DELETE FROM NOTIFICATIONS WHERE POST_ID = :postID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':postID', $delete_id, PDO::PARAM_INT);
        $stmt->execute();


        // Delete the post itself
        $stmt_post = $pdo->prepare("DELETE FROM posts WHERE post_id = :post_id");
        $stmt_post->bindParam(':post_id', $delete_id, PDO::PARAM_INT);
        $stmt_post->execute();

        // Commit the transaction
        $pdo->commit();

        // Redirect with success message
        header("Location: admin_posts.php?msg=deleted");
        exit();
    } catch (Exception $e) {
        // Rollback transaction on error
        $pdo->rollBack();
        header("Location: admin_posts.php?msg=delete_failed");
        exit();
    }
}



// Redirect if admin not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Posts</title>
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
        <h2>Admin Dashboard</h2>
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
        <h3>Search Posts</h3>
        <div class="search-container">
            <form method="get" style="display: flex; gap: 1rem; width: 100%;">
                <input type="text" name="search" class="search-input" placeholder="Search by username or content..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="search-btn">Search</button>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Image</th>
                        <th>Caption</th>
                        <th>Created At</th>
                         <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';

                   $query = "SELECT p.post_id, p.image_url, p.text_content, p.created_at, u.username 
          FROM posts p 
          JOIN users u ON p.user_id = u.user_id 
          WHERE u.username LIKE :search OR p.text_content LIKE :search 
          ORDER BY p.created_at DESC 
          LIMIT 50";


                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':search', $search);
                    $stmt->execute();

                    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (empty($posts)) {
                        echo "<tr><td colspan='4'>No posts found.</td></tr>";
                    } else {
                        foreach ($posts as $post) {
echo "<tr>";
echo "<td>" . htmlspecialchars($post['username']) . "</td>";
if (!empty($post['image_url'])) {
    echo "<td>
        <details>
            <summary>
                <img src='../uploads/" . htmlspecialchars($post['image_url']) . "' alt='Post Image' style='max-width: 100px; max-height: 100px; cursor: pointer;'>
            </summary>
            <div style='margin-top: 1rem;'>
                <img src='../uploads/" . htmlspecialchars($post['image_url']) . "' alt='Full Image' style='max-width: 100%; max-height: 400px; display: block; margin-bottom: 0.5rem;'>
                <div style='color: gray; font-size: 0.9rem;'>(Click the image above to close)</div>
            </div>
        </details>
    </td>";
} else {
    echo "<td><em>No photo attached in this post</em></td>";
}



echo "<td>" . htmlspecialchars($post['text_content']) . "</td>";
echo "<td>" . date('M j, Y H:i', strtotime($post['created_at'])) . "</td>";
echo "<td>
    <details>
        <summary style='color: red; cursor: pointer;'>DELETE 🗑️</summary>
        <div style='margin-top: 0.5rem;'>
            <form method='get'>
                <input type='hidden' name='delete_post_id' value='" . htmlspecialchars($post['post_id']) . "'>
                <button type='submit' style='background-color: red; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;'>Yes, Delete</button>
                <button type='button' style='background-color: gray; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;' onclick='this.closest(\"details\").removeAttribute(\"open\")'>Cancel</button>
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
</body>
</html>