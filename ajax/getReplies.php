<?php 
    require_once("../config.php");
    require_once("../includes/classes/user.php");
    require_once("../includes/classes/comment.php");

    $username   = (isset($_SESSION['userLoggedIn'])) ? $_SESSION['userLoggedIn'] : "";
    $commentId  = (isset($_POST['commentId'])) ? $_POST['commentId'] : "";
    $videoId    = (isset($_POST['videoId'])) ? $_POST['videoId'] : "";

    $userLoggedInobj= new user($dbcon, $username);
    $commentObj = new comment($dbcon, $commentId, $userLoggedInobj, $videoId);

    echo $commentObj->getReplies();
?>