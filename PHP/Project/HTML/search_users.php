<?php
$pdo = require_once "../includes/dbh.inc.php";

function fetch_all_user_from_database()
{
  try {
    global $pdo;
    $query = "SELECT * FROM USERS";
    $statement = $pdo->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  } catch (Exception $e) {
    return [];
  }
}

$all_users = fetch_all_user_from_database();
$search_query = isset($_GET['query']) ? strtolower(trim($_GET['query'])) : '';

$filtered_users = array_filter($all_users, function ($user) use ($search_query) {
  return $search_query === '' || strpos(strtolower($user['username']), $search_query) === 0;
});

if (count($filtered_users) === 0) {
  echo '<li>No users found.</li>';
} else {
  foreach ($filtered_users as $user) {
    $profile_link = 'visiting_profile.php?profile_id=' . $user['user_id'];
    // '<a href="' . $profile_link . '">Visit Profile</a>' .
    echo '<li><a href="' . $profile_link . '" style="text-decoration: none; color: inherit; display: block;">' . htmlspecialchars($user['username']) . '</a></li>';
  }
}