<?php

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);


session_set_cookie_params([

    'lifetime' => 1800,
    'domain'=>'localhost',
    'path'=>'/',
    'secure'=>true,
    'httponly'=>true,

]);

session_start();

if(!isset($_SESSION['last_generation'])) {
    Session_Regeneration();

} else {

    if(time() - $_SESSION['last_generation'] > 1800) {
        Session_Regeneration();
    }
}


function Session_Regeneration(): void {
    session_regenerate_id(true);
    $_SESSION['last_generation'] = time();
}






















