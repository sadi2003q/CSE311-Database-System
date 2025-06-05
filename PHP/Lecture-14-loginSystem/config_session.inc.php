<?php


ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1); //  this line is mandatory


session_get_cookie_params([

    'lifetime' => 1800,
    'domain' => 'localhost',
    'path' => '/',
    'secure' => true,
    'httponly' => true
]);

session_start();



if (!isset($_SESSION['last_regeneration'])) {

    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();

} else {
    $interval = 60*30;

    if ($_SESSION['last_regeneration'] + $interval < time()) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}













