<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <h1>This Lecture is About Global Variables</h1>

    <?php
    $name = "Adnan";

    // Displaying some $_SERVER superglobal variables
    echo "$_SERVER[DOCUMENT_ROOT]";
    echo "<br> $_SERVER[SERVER_NAME]";
    echo "<br> $_SERVER[SERVER_PORT]";
    echo "<br> $_SERVER[HTTP_HOST]";
    echo "<br> $_SERVER[SERVER_PROTOCOL]";
    echo "<br> $_SERVER[REQUEST_METHOD]";

    // Lecture content on $_GET and $_POST
    echo "<h2>Understanding $_GET and $_POST Superglobals</h2>";
    echo "<p>Superglobal variables like <code>$_GET</code> and <code>$_POST</code> are used to collect data sent via HTML forms. <code>$_GET</code> retrieves data from the URL query string, while <code>$_POST</code> retrieves data sent through the form body securely.</p>";
    
    
    echo "<br> $_GET[name]";
    echo "<br> $_POST[name]";
    echo "<br> $_REQUEST[name]";
    
    $_SESSION['AGE'] = 22;
    echo "<br> $_SESSION[AGE]";
    
    ?>




</body>
</html>