<?php
// Backend Logic Hander Page, Database connection and Session variable management page connection
require_once '../includes/config_session.inc.php';
$pdo = require_once '../includes/dbh.inc.php';
require_once '../includes/FOLLOW_PAGE/Follow.inc.php';


?>


<!-- 
  This page is about showing the followers of a profle
  -> comming from visiting profile file
  -> will show the follower list
  -> another section will show the following list
-->



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Followers & Following</title>
  <style>
    /* Basic reset and font */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      background: #F3F4F6;
    }

    /* Layout container */
    .container {
      max-width: 1200px;
      margin: 1.5rem auto;
      padding: 0 1rem;
    }

    /* Header section */
    .header {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .header h1 {
      color: #1E3A8A;
      margin-bottom: 1rem;
    }

    /* Tab buttons */
    .button-group {
      display: flex;
      justify-content: center;
      border-bottom: 2px solid #e5e7eb;
    }

    .button-group button {
      background: none;
      border: none;
      color: #1E3A8A;
      padding: 0.75rem 2rem;
      cursor: pointer;
      font-weight: 500;
      font-size: 1rem;
      transition: color 0.3s;
      position: relative;
    }

    .button-group button.active {
      color: #3B82F6;
      font-weight: bold;
    }

    .button-group button.active::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 100%;
      height: 2px;
      background: #3B82F6;
    }

    /* Content box with scrollable area */
    .content {
      background: #fff;
      padding: 1rem;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      height: 400px; /* Adjust height as needed */
      overflow-y: auto;
      position: relative;
    }

    /* Tab content list style */
    .list {
      display: none;
      width: 100%;
      animation: fadeIn 0.3s ease-in-out;
    }

    .list.active {
      display: block;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Individual user entry */
    .list-item {
      display: flex;
      align-items: center;
      gap: 1rem;
      padding: 1rem;
      border-bottom: 1px solid #e5e7eb;
    }

    .list-item img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }

    .list-item p {
      color: #1E3A8A;
      font-weight: 500;
    }

    /* Responsive layout for small screens */
    @media (max-width: 768px) {
      .container {
        padding: 0 0.5rem;
      }

      .button-group button {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
      }

      .content {
        padding: 1rem;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="header">
      <h1>Followers & Following</h1>

      <!-- Tab Buttons -->
      <!-- Follower and following list button -->
      <div class="button-group">
        <button class="active" onclick="showList('following')">Following</button>
        <button onclick="showList('followers')">Followers</button>
      </div>
    </div>

    <!-- Content Section with Scroll -->
     <!-- this section is the body which show the scorlling profile -->
    <div class="content" style="height: 80vh;">
      
    
    
    
    <!-- Following List (Default Visible) -->
    <div class="list active" id="following-list">
      <?php show_all_following($pdo); ?>
    </div>

    
    
    
    
    <!-- Followers List (Hidden by default) -->
    <div class="list" id="followers-list">
      <?php show_all_follower($pdo) ?>
    </div>



    </div>
  </div>

  
  
  <!-- This section the button for showing follower and following -->
  <script>
    /**
     * Handles tab switching for 'following' and 'followers'
     * @param {string} type - The type of list to show
     */
    function showList(type) {
      // Remove active class from all buttons
      document.querySelectorAll('.button-group button').forEach(btn =>
        btn.classList.remove('active')
      );

      // Activate clicked button
      document.querySelector(`button[onclick="showList('${type}')"]`).classList.add('active');

      // Hide all lists
      document.querySelectorAll('.list').forEach(list =>
        list.classList.remove('active')
      );

      // Show selected list
      document.getElementById(`${type}-list`).classList.add('active');
    }
  </script>

</body>
</html>