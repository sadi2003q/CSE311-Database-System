<?php
require_once "../includes/config_session.inc.php";


// Function to fetch all users
function fetch_all_user_from_database()
{
  $pdo = require_once "../includes/dbh.inc.php";
  try {
    $query = "SELECT * FROM USERS";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result ?? [];
  } catch (Exception $e) {
    echo '<p>Error Found: ' . $e->getMessage() . '</p>';
    return [];
  }
}

$all_users = fetch_all_user_from_database();
$search_query = isset($_GET['query']) ? strtolower(trim($_GET['query'])) : '';
$filtered_users = array_filter($all_users, function ($user) use ($search_query) {
  return $search_query === '' || strpos(strtolower($user['name']), $search_query) !== false;
});
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

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

    .navbar-links a:hover,
    .navbar-links a.active {
      color: var(--primary-color);
    }

    .hamburger {
      display: none;
      background: none;
      border: none;
      color: var(--text-color);
      font-size: 1.5rem;
      cursor: pointer;
    }

    .navbar-search {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding-right: 10px;
    }

    .search-input {
      padding: 0.4rem 0.75rem;
      border: 1px solid var(--border-color);
      border-radius: 20px;
      width: 220px;
      outline: none;
      font-family: var(--font-family);
    }

    .search-icon {
      background: none;
      border: none;
      font-size: 1.2rem;
      cursor: pointer;
      color: var(--secondary-text-color);
    }

    .search-icon:hover {
      color: var(--primary-color);
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

    .nav-links-mobile {
      display: none;
    }

    .navbar-right {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    @media (max-width: 768px) {
      body:not(.search-page) .search-input {
        display: none;
      }

      .navbar-links {
        display: none;
      }

      .hamburger {
        display: block;
      }

      .search-page .navbar-brand {
        display: none;
      }

      .search-page .search-input {
        display: inline-block;
      }

      .navbar-right {
        justify-content: space-between;
        width: 100%;
      }

      .sidebar {
        position: fixed;
        top: 0;
        left: -100%;
        height: 100%;
        width: 280px;
        background: var(--card-background);
        z-index: 1001;
        transition: left 0.3s ease-in-out;
        padding: 1.5rem;
        box-shadow: var(--shadow-2);
      }

      .sidebar.active {
        left: 0;
      }

      .nav-links-mobile {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 2rem;
      }

      .nav-links-mobile a {
        color: var(--text-color);
        text-decoration: none;
        font-weight: 500;
        font-size: 1.1rem;
      }
    }
  </style>
</head>

<body class="search-page">

  <nav class="navbar">
    <a href="newsfeed.php" class="navbar-brand">Social</a>

    <div class="navbar-right">
      <form class="navbar-search" method="GET" action="search.php">
        <input type="text" name="query" placeholder="Search..." class="search-input" value="<?php echo htmlspecialchars($_GET['query'] ?? '') ?>" />
        <button type="submit" class="search-icon">🔍</button>
      </form>

      <div class="navbar-links">
        <a href="newsfeed.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="#">Notifications</a>
        <a href="logout.php">Logout</a>
      </div>

      <button class="hamburger" onclick="toggleSidebar()">☰</button>
    </div>
  </nav>

  <aside class="sidebar" id="sidebar">
    <div class="nav-links-mobile">
      <a href="newsfeed.php">Home</a>
      <a href="profile.php">Profile</a>
      <a href="#">Notifications</a>
      <a href="logout.php">Logout</a>
    </div>
  </aside>

  <main class="main-container">
    <h2>Search Page</h2>

    <?php if ($search_query): ?>
      <p class="search-results">Showing results for "<strong><?php echo htmlspecialchars($search_query); ?></strong>":</p>
    <?php else: ?>
      <p class="search-results">Showing all users:</p>
    <?php endif; ?>

    <ul class="user-list">
      <?php if (count($filtered_users) > 0): ?>
        <?php foreach ($filtered_users as $user): ?>
          <li><?php echo htmlspecialchars($user['username']); ?></li>
        <?php endforeach; ?>
      <?php else: ?>
        <li>No users found.</li>
      <?php endif; ?>
    </ul>
  </main>

  <script>
    function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("active");
    }
  </script>
</body>

</html>