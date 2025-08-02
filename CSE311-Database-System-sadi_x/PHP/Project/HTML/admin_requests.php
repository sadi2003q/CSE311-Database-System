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
    <title>Deletion Requests - Admin Panel</title>
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
        .admin-main {
            padding: 2rem;
        }
        .filter-container {
            margin-bottom: 1.5rem;
            display: flex;
            gap: 1rem;
        }
        .filter-select {
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: white;
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
        }
        th {
            background-color: #2d2d2d;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .action-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 0.5rem;
            font-weight: 500;
        }
        .approve-btn {
            background-color: #4CAF50;
            color: white;
        }
        .approve-btn:hover {
            background-color: #3e8e41;
        }
        .reject-btn {
            background-color: #ff6b6b;
            color: white;
        }
        .reject-btn:hover {
            background-color: #ff5252;
        }
        .view-btn {
            background-color: #4ECDC4;
            color: white;
        }
        .view-btn:hover {
            background-color: #3da8a1;
        }
        .status-pending {
            color: #FFD93D;
            font-weight: bold;
        }
        .status-approved {
            color: #4CAF50;
            font-weight: bold;
        }
        .status-rejected {
            color: #ff6b6b;
            font-weight: bold;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
            gap: 0.5rem;
        }
        .page-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            background-color: white;
            cursor: pointer;
            border-radius: 4px;
        }
        .page-btn.active {
            background-color: #4ECDC4;
            color: white;
            border-color: #4ECDC4;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <h2>Deletion Requests</h2>
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
        <div class="filter-container">
            <select class="filter-select" id="status-filter">
                <option value="all">All Requests</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
            <select class="filter-select" id="date-filter">
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
            </select>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Request Date</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php display_deletion_requests(); ?>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn">4</button>
            <button class="page-btn">5</button>
        </div>
    </main>

    <script>
        // Add functionality for filters and pagination here
        document.querySelectorAll('.filter-select').forEach(select => {
            select.addEventListener('change', function() {
                const statusFilter = document.getElementById('status-filter').value;
                const dateFilter = document.getElementById('date-filter').value;
                alert('Would filter by status: ' + statusFilter + ' and date: ' + dateFilter);
            });
        });

        // Pagination buttons
        document.querySelectorAll('.page-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.page-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                alert('Pagination would load page ' + this.textContent);
            });
        });

        function approveRequest(requestId) {
            if (confirm('Approve this deletion request?')) {
                alert('Would approve request with ID: ' + requestId);
            }
        }

        function rejectRequest(requestId) {
            if (confirm('Reject this deletion request?')) {
                alert('Would reject request with ID: ' + requestId);
            }
        }

        function viewUser(userId) {
            alert('Would view user with ID: ' + userId);
        }
    </script>
</body>
</html>