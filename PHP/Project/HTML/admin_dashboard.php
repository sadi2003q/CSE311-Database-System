<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/ADMIN_PANEL/admin_view.inc.php";

// Check if admin is logged in
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
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f5f5f5;
        }
        .admin-header {
            background-color: #2d2d2d;
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
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
            transition: background-color 0.3s;
        }
        .admin-nav a:hover {
            background-color: #4ECDC4;
        }
        .admin-main {
            padding: 2rem;
        }
        /*.dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }*/
            .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }
        /*
        .dashboard-card {
            background-color: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
            */
        .dashboard-card {
        background-color: white;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        min-height: 290px; 
        }

        .dashboard-card h3 {
            margin-bottom: 1rem;
            color: #2d2d2d;
            border-bottom: 2px solid #4ECDC4;
            padding-bottom: 1rem;
        }
        .stats {
            font-size: 2rem;
            font-weight: bold;
            color: #4ECDC4;
            margin-bottom: 0.5rem;
        }
        .logout-btn {
            background-color: #ff6b6b;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }
        .logout-btn:hover {
            background-color: #ff5252;
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
<?php
$counts = get_total_users_count();
?>

<!--
<div class="dashboard-grid">
    <div class="dashboard-card">
        <h3>Total Users</h3>
        <div class="stats"><?php echo $counts['user_count']; ?></div>
        <p>Registered users in the system</p>
    </div>
    <div class="dashboard-card">
        <h3>Total Posts</h3>
        <div class="stats"><?php echo $counts['post_count']; ?></div>
        <p>Posts created in the system</p>
    </div>
</div>
    -->
<div class="dashboard-grid">
    <div class="dashboard-card">
        <h3>Total Users</h3>
        <div class="stats"><?php echo $counts['user_count']; ?></div>
        <p>Registered users in the system</p>
    </div>
    <div class="dashboard-card">
        <h3>Total Posts</h3>
        <div class="stats"><?php echo $counts['post_count']; ?></div>
        <p>Posts created in the system</p>
    </div>
        <div class="dashboard-card">
        <h3>Total Interaction</h3>
        <div class="stats"><?php echo $counts['like_count']; ?></div>
        <p>Total likes and comments in this system</p>
    </div>
        <div class="dashboard-card">
        <h3>Total deletion request</h3>
        <div class="stats"><?php echo $counts['req_count']; ?></div>
        <p>Pending Deletion requests in the system</p>
    </div>
</div>
    </main>
</body>
</html>