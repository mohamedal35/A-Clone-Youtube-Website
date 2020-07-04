<?php 
require_once "../config.php";
require_once "../includes/classes/user.php";
require_once "../includes/classes/comment.php";
if (isset($_POST['postedBy']) && isset($_POST['videoId']) && isset($_POST['commentText']) && isset($_SESSION['userLoggedIn'])) {
    $userLoggedInObj        = new user($dbcon, $_SESSION['userLoggedIn']);
    $commentText    = trim(filter_var($_POST['commentText'], FILTER_SANITIZE_STRING));
    $postBy         = $_POST['postedBy'];
    $videoId        = $_POST['videoId'];
    $replyTo        = isset($_POST['replyTo']) ? $_POST['replyTo'] : 0;
    $stmt   = $dbcon->prepare("INSERT INTO 
                                    `comments`(`postedBy`, `videoId`, `responseTo`, `body`) 
                                VALUES
                                    (:postedBy, :videoId, :responseTo, :body);");
    $stmt->bindParam(":postedBy", $postBy);
    $stmt->bindParam(":videoId", $videoId);
    $stmt->bindParam(":responseTo", $replyTo);
    $stmt->bindParam(":body", $commentText);
    $stmt->execute();
    $newComment     = new comment($dbcon, $dbcon->lastInsertId(), $userLoggedInObj, $videoId);
    echo $newComment->create();
} else {
    echo "Parametars Doesn't Pass";
    exit;
}

?>