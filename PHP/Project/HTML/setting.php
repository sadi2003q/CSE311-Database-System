<?php
require_once "../includes/config_session.inc.php";
$pdo = require_once "../includes/dbh.inc.php";
require_once "../includes/SETTING_PAGE/setting.view.inc.php";


// $pdo = require_once "../includes/dbh.inc.php";
// require_once "../includes/PROFILE_PAGE/profile_view.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Social Media</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #F9FAFB;
            color: #1F2937;
        }

        .navbar {
            background-color: #0F172A;
            padding: 1rem 2rem;
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            border-bottom: 1px solid #1E293B;
        }

        .navbar a {
            color: #E5E7EB;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .navbar a:hover {
            color: #60A5FA;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
        }

        /* Settings Section - Card Style */
        .settings-section {
            background-color: #FFFFFF;
            flex: 1 1 calc(50% - 2rem);
            min-width: 320px;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.3s ease;
        }

        .settings-section:hover {
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.08);
        }

        .settings-section h2 {
            color: #111827;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #E5E7EB;
            padding-bottom: 0.5rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
        }

        input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #D1D5DB;
            border-radius: 6px;
            font-size: 1rem;
            background-color: #F3F4F6;
            transition: border-color 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            background-color: #FFFFFF;
        }

        button,
        .action-button {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #3B82F6;
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            font-weight: 600;
        }

        button:hover,
        .action-button:hover {
            background-color: #1E40AF;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .logout-button {
            background-color: #EF4444;
        }

        .logout-button:hover {
            background-color: #B91C1C;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .activity-log {
            margin-top: 1rem;
        }

        .activity-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #E5E7EB;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-item p {
            color: #6B7280;
            font-size: 0.95rem;
        }

        .error-message {
            color: #EF4444;
            font-size: 0.95rem;
            margin-top: 0.5rem;
            display: none;
            font-weight: 500;
        }

        /* Stronger delete button hover */
        .settings-section .action-button[href*="delete"] {
            background-color: #991B1B;
        }

        .Error_box {
            background-color: #FEF2F2;
            /* A very light red */
            border: 1px solid #F87171;
            /* A soft red border */
            color: #991B1B;
            /* Dark red text for context */
            padding: 1.25rem;
            border-radius: 8px;
            margin-top: 1rem;
            width: 100%;
        }

        .Error_box h2 {
            color: #7F1D1D;
            /* A darker red for the heading */
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            border-bottom: none;
            padding-bottom: 0;
        }

        .Error_box p {
            color: #B91C1C;
            /* A slightly lighter, but still strong red for the message */
            font-size: 0.95rem;
        }

        .settings-section .action-button[href*="delete"]:hover {
            background-color: #7F1D1D;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(153, 27, 27, 0.3);
        }

        .Error_box_insider {
            width: 100%;
            height: 100%;
            transition: transform 0.3s ease;
            /* Smooth transition */

            &:hover {
                transform: scale(1.01);
                /* Use transform for scaling */
            }
        }

        /* Individual Update Button */
        .small-button {
            padding: 0.4rem 1rem;
            font-size: 0.9rem;
            border-radius: 6px;
            background-color: #3B82F6;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.2s ease;
            white-space: nowrap;
        }

        .small-button:hover {
            background-color: #1E40AF;
            transform: translateY(-1px);
        }

        /* Responsive Grid Layout */
        @media (max-width: 1024px) {
            .settings-section {
                flex: 1 1 100%;
            }
        }

        @media (max-width: 600px) {
            .navbar {
                flex-direction: column;
                align-items: center;
            }

            .navbar a {
                margin: 0.5rem 0;
            }

            .container {
                padding: 0 1rem;
            }

            .settings-section {
                padding: 1.25rem;
            }

            button,
            .action-button {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <a href="newsfeed.html">Home</a>
        <a href="profile.html">Profile</a>
        <a href="notifications.html">Notifications</a>
        <a href="settings.html">Settings</a>
        <a href="logout.html">Logout</a>
    </nav>

    <div class="container">


        <!-- Edit Profile Section -->
        <div class="settings-section" style="overflow: auto;">
            <h2>Edit Profile</h2>

            <!-- Update Username Form -->
            <form action="../includes/SETTING_PAGE/setting.inc.php" method="POST" class="form-row">
                <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
                    <label for="username" style="flex: 0 0 100px;">Username</label>
                    <?php
                    $username = $_SESSION['username'];
                    echo '<input type="text" id="username" name="username" value="' . $username .  '" style="flex: 1;">';
                    ?>
                    <button type="submit" name="update_username" class="small-button">Update</button>
                </div>
            </form>

            <!-- Update Email Form -->
            <form action="../includes/SETTING_PAGE/setting.inc.php" method="POST" class="form-row">
                <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
                    <label for="email" style="flex: 0 0 100px;">Email</label>
                    <?php
                    $email = $_SESSION['email'];
                    echo '<input type="email" id="email" name="email" value="' . $email .  '" style="flex: 1;">';
                    ?>
                    <button type="submit" name="update_email" class="small-button">Update</button>
                </div>
            </form>

            <!-- Update Password Form -->
            <form action="../includes/SETTING_PAGE/setting.inc.php" method="POST">
                <!-- Current Password -->
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" placeholder="Enter current password">
                </div>

                <!-- New Password -->
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" placeholder="Enter new password">
                </div>

                <button type="submit" name="update_password" class="small-button">Update Password</button>
            </form>

            <!-- Error display -->
            <p class="error-message" id="error-message">Please fill in all required fields correctly.</p>
            <br>
            <?php 
                error_found_while_updating_profile(); 
                apply_success_border()
            ?>
        </div>







        <!-- Activity Log Section -->
        <div class="settings-section" style="max-height: 500px; overflow-y: auto; cursor: pointer; scrollbar-width: none; -ms-overflow-style: none;">
            <h2 style="
                position: sticky;
                top: 0;
                background-color: white;
                z-index: 10;
                padding: 1rem 0;
                border-bottom: 2px solid #E5E7EB;
                margin: 0 -2rem 1.5rem -2rem;
                padding-left: 2rem;
                padding-right: 2rem;
            ">
                Activity Log
            </h2>

            <div class="activity-log" id="activity-log">
                <?php show_all_activities_log($pdo) ?>
            </div>
        </div>







        <!-- Logout Section -->
        <!-- Account Actions Section -->
        <div style="display: flex; gap: 2rem; flex-wrap: wrap; width: 100%;">
            <!-- Log Out Card -->
            <div class="settings-section" style="flex: 1 1 320px;">
                <h2>Log Out</h2>
                <p style="color: #6B7280; font-size: 0.95rem;">Sign out of your account securely.</p>
                <a href="logout.php" class="action-button logout-button" style="margin-top: 1rem;">Log Out</a>
            </div>

            <!-- Delete Account Card -->
            <div class="settings-section" style="flex: 1 1 320px;">
                <h2>Delete Account</h2>
                <p style="color: #6B7280; font-size: 0.95rem;">Permanently delete your account and all data.</p>
                <a href="delete_account.html" class="action-button logout-button" style="background-color: #991B1B; margin-top: 1rem;">Delete Account</a>
            </div>
        </div>
    </div>

    <script>
        // Basic form validation
        document.getElementById('edit-profile-form').addEventListener('submit', function(e) {

        });

        // Simulate activity log
        const activities = [{
                action: 'Logged in',
                time: '2025-07-01 09:00 AM'
            },
            {
                action: 'Updated profile',
                time: '2025-06-30 03:15 PM'
            },
            {
                action: 'Posted an update',
                time: '2025-06-29 11:45 AM'
            }
        ];

        const activityLog = document.getElementById('activity-log');
        activities.forEach(activity => {
            const activityItem = document.createElement('div');
            activityItem.className = 'activity-item';
            activityItem.innerHTML = `<p><strong>${activity.action}</strong> - ${activity.time}</p>`;
            activityLog.appendChild(activityItem);
        });
    </script>
</body>

</html>