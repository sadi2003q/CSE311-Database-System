<?php
require_once "../includes/config_session.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Search</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --primary-color: #1877F2;
      --primary-hover: #166FE5;
      --background-color: #F0F2F5;
      --card-background: #FFFFFF;
      --text-color: #050505;
      --secondary-text-color: #65676B;
      --border-color: #dddfe2;
      --shadow-1: 0 1px 2px rgba(0, 0, 0, 0.1);
      --shadow-2: 0 2px 8px rgba(0, 0, 0, 0.15);
      --border-radius: 8px;
      --font-family: 'Poppins', sans-serif;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      background-color: var(--background-color);
      font-family: var(--font-family);
      color: var(--text-color);
    }

    .navbar {
      background: var(--card-background);
      padding: 0 2rem;
      height: 60px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: var(--shadow-1);
    }

    .navbar-brand {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary-color);
      text-decoration: none;
    }

    .navbar-links {
      display: flex;
      gap: 2rem;
    }

    .navbar-links a {
      color: var(--secondary-text-color);
      text-decoration: none;
      font-weight: 500;
      font-size: 1rem;
    }

    .search-container {
      width: 100%;
      background: var(--card-background);
      padding: 1rem;
      display: flex;
      justify-content: center;
      box-shadow: var(--shadow-1);
      position: sticky;
      top: 60px;
      z-index: 999;
    }

    .search-wrapper {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      width: 100%;
      max-width: 500px;
    }

    .search-input {
      padding: 0.5rem 1rem;
      border: 1px solid var(--border-color);
      border-radius: 20px;
      width: 100%;
      outline: none;
      font-size: 1rem;
    }

    .search-icon {
      background: none;
      border: none;
      cursor: pointer;
      font-size: 1rem;
    }

    .main-container {
      max-width: 800px;
      margin: 2rem auto;
      padding: 1rem;
    }

    .user-list {
      list-style: none;
      padding: 0;
      margin-top: 1rem;
    }

    .user-list li {
      background: var(--card-background);
      padding: 0.75rem 1rem;
      margin-bottom: 0.5rem;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow-1);
    }
  </style>
</head>

<body class="search-page">

  <nav class="navbar">
    <a href="newsfeed.php" class="navbar-brand">Social</a>
    <div class="navbar-links">
      <a href="newsfeed.php">Home</a>
      <a href="profile.php">Profile</a>
      <a href="#">Notifications</a>
      <a href="logout.php">Logout</a>
    </div>
  </nav>

  <div class="search-container">
    <div class="search-wrapper">
      <input type="text" id="searchInput" placeholder="Search..." class="search-input" />
      <button class="search-icon">🔍</button>
    </div>
  </div>

  <main class="main-container">
    <h2>Search Page</h2>
    <ul class="user-list" id="userList">
      <li>Start typing to search users...</li>
    </ul>
  </main>

  <script>
    const searchInput = document.getElementById("searchInput");
    const userList = document.getElementById("userList");

    searchInput.addEventListener("input", () => {
      const query = searchInput.value;

      fetch(`search_users.php?query=${encodeURIComponent(query)}`)
        .then(response => response.text())
        .then(data => {
          userList.innerHTML = data;
        })
        .catch(error => {
          userList.innerHTML = "<li>Error loading results.</li>";
        });
    });
  </script>
</body>
</html>