<?php 
    ob_start();
    session_start();
    date_default_timezone_set("Africa/Cairo");
    // Declare Constants
    define('KB', 1024);
    define('MB', 1048576);
    define('GB', 1073741824);
    define('TB', 1099511627776);
    # Start dbCon
    try {
        $dbcon = new PDO("mysql:dbname=youtube;host=localhost;", 'root', "");
        $dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch (PDOException $e) {
        $msgError = "Connection Failed => " . $e.getMessage();
    }
?>