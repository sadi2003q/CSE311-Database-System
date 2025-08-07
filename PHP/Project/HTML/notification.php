 <!-- /*

✅Signup Notification -> Welcome Message
✅follow Notification
✅like Notification
✅comment notification


*/ -->
 <?php
    require_once "../includes/config_session.inc.php";
    $pdo = require_once "../includes/dbh.inc.php";
    require_once '../includes/NOTIFICATION_PAGE/notification.view.inc.php'
    ?>
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Blank Page - Social Media</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <style>
         :root {
             --primary: #4361ee;
             --primary-dark: #3a0ca3;
             --secondary: #f72585;
             --light: #f8f9fa;
             --dark: #212529;
             --gray: #6c757d;
             --light-gray: #e9ecef;
             --white: #ffffff;
             --border-radius: 12px;
             --shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
             --shadow-hover: 0 10px 15px rgba(0, 0, 0, 0.1);
             --transition: all 0.3s ease;
         }

         * {
             margin: 0;
             padding: 0;
             box-sizing: border-box;
             font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
         }

         body {
             background-color: var(--light);
             color: var(--dark);
             line-height: 1.6;
             min-height: 100vh;
         }

         .navbar {
             background-color: var(--white);
             padding: 1rem 2rem;
             display: flex;
             justify-content: space-between;
             align-items: center;
             box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
             position: sticky;
             top: 0;
             z-index: 100;
             border-bottom: 1px solid var(--light-gray);
         }

         .navbar a {
             color: var(--dark);
             text-decoration: none;
             font-weight: 500;
             font-size: 0.95rem;
             padding: 0.6rem 1.2rem;
             border-radius: 8px;
             transition: var(--transition);
             display: flex;
             align-items: center;
             gap: 0.5rem;
         }

         .navbar a:hover {
             background-color: var(--light-gray);
             transform: scale(1.05);
         }

         .navbar a i {
             font-size: 1.1rem;
         }

         .navbar div {
             display: flex;
             gap: 0.5rem;
         }

         .notification-container {
             max-width: 800px;
             margin: 2rem auto;
             padding: 0 1rem;
         }

         .notification-panel {
             background-color: var(--white);
             border-radius: var(--border-radius);
             box-shadow: var(--shadow);
             overflow: hidden;
         }

         .panel-header {
             padding: 1.5rem;
             border-bottom: 1px solid var(--light-gray);
             display: flex;
             justify-content: space-between;
             align-items: center;
         }

         .panel-title {
             font-size: 1.5rem;
             font-weight: 600;
             color: var(--primary);
         }

         .mark-all-read {
             background-color: var(--primary);
             color: white;
             border: none;
             padding: 0.5rem 1rem;
             border-radius: var(--border-radius);
             cursor: pointer;
             transition: var(--transition);
         }

         .mark-all-read:hover {
             background-color: var(--primary-dark);
         }

         .notifications-list {
             max-height: 70vh;
             overflow-y: auto;
         }

         .notification-item {
             padding: 1.25rem 1.5rem;
             border-bottom: 1px solid var(--light-gray);
             display: flex;
             gap: 1rem;
             transition: var(--transition);
         }

         .notification-item.unread {
             background-color: rgba(67, 97, 238, 0.05);
             border-left: 3px solid var(--primary);
         }

         .notification-item:hover {
             background-color: var(--light-gray);
         }

         .profile-avatar {
             width: 50px;
             height: 50px;
             border-radius: 50%;
             overflow: hidden;
             flex-shrink: 0;
         }

         .profile-avatar img {
             width: 100%;
             height: 100%;
             object-fit: cover;
         }

         .notification-content {
             flex: 1;
         }

         .notification-header {
             display: flex;
             align-items: center;
             flex-wrap: wrap;
             gap: 0.5rem;
             margin-bottom: 0.5rem;
         }

         .user-name {
             font-weight: 600;
             color: var(--dark);
         }

         .reaction-icon {
             font-size: 1.1rem;
         }

         .notification-message {
             color: var(--dark);
         }

         .timestamp {
             color: var(--gray);
             font-size: 0.85rem;
             margin-left: auto;
         }

         .post-preview {
             background-color: var(--light-gray);
             padding: 0.75rem;
             border-radius: var(--border-radius);
             margin-top: 0.5rem;
         }

         .post-preview a {
             color: var(--primary);
             text-decoration: none;
             font-weight: 500;
         }

         .post-preview a:hover {
             text-decoration: underline;
         }

         .empty-state {
             text-align: center;
             padding: 3rem 1rem;
             color: var(--gray);
         }

         .empty-state-icon {
             font-size: 2.5rem;
             margin-bottom: 1rem;
             color: var(--gray);
             opacity: 0.7;
         }

         .empty-state h3 {
             font-size: 1.25rem;
             margin-bottom: 0.5rem;
             color: var(--dark);
         }

         .post-preview {
             display: flex;
             justify-content: space-between;
             align-items: center;
             gap: 1rem;
             background-color: var(--light-gray);
             padding: 0.75rem;
             border-radius: var(--border-radius);
             margin-top: 0.5rem;
         }

         .post-message {
             flex: 1;
             white-space: nowrap;
             overflow: hidden;
             text-overflow: ellipsis;
             color: var(--dark);
         }

         .post-link {
             color: var(--primary);
             text-decoration: none;
             font-weight: 500;
             white-space: nowrap;
         }

         .post-link:hover {
             text-decoration: underline;
         }

         @media (max-width: 768px) {
             .navbar {
                 flex-direction: column;
                 padding: 1rem;
                 gap: 0.5rem;
             }

             .navbar div {
                 width: 100%;
                 justify-content: space-between;
             }

             .navbar a {
                 flex-grow: 1;
                 text-align: center;
                 padding: 0.5rem;
                 font-size: 0.85rem;
             }

             .navbar a:last-child {
                 width: 100%;
                 margin-top: 0.5rem;
             }
         }

         @media (max-width: 480px) {
             .navbar a {
                 font-size: 0.8rem;
             }

             .navbar a i {
                 font-size: 1rem;
             }
         }
     </style>
 </head>

 <body>
     <!-- Navigation Bar -->
     <nav class="navbar">
         <div></div>
         <div>
             <a href="newsfeed.php" class="navbar-brand">Social</a>
             <a href="newsfeed.php" class="active" title="Home" style="font-size: 1.2rem;"><i class="fas fa-house"> Home </i></a>
             <a href="profile.php" title="Profile"><i class="fas fa-user"> Profile </i></a>
             <a href="setting.php" title="Settings"><i class="fas fa-cog"> Setting </i></a>
         </div>
     </nav>

     <!-- Blank content area -->
     <?php show_all_notification($pdo, (int)$_SESSION['user_id']) ?>

 </body>

 </html>