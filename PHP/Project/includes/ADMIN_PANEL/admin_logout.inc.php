<?php

session_start();
session_unset();
session_destroy();

header("Location: ../../HTML/admin_login.php");
exit();