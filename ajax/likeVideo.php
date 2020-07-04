<?php 
    require_once("../config.php");
    require_once("../includes/classes/video.php");
    require_once("../includes/classes/user.php");

    $username   = $_SESSION['userLoggedIn'];
    $userLoggedInobj= new user($dbcon, $username);

    $videoId    = (isset($_POST['videoId'])) ? $_POST['videoId'] : "";
    $video      = new video($dbcon, $videoId, $userLoggedInobj);
    echo $video->like();
?>