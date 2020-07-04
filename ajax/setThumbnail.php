<?php 
require_once "../config.php";
if (isset($_POST['thumbnailId']) && isset($_POST['videoId']) && isset($_SESSION['userLoggedIn'])) {
    $videoId    = $_POST['videoId'];
    $thumbnailId= $_POST['thumbnailId'];

    $stmt       = $dbcon->prepare("UPDATE `thumbnails` SET `selected`=0 WHERE `videoId` = :vi");
    $stmt->bindParam(":vi", $videoId);
    $stmt->execute();

    $stmt       = $dbcon->prepare("UPDATE `thumbnails` SET `selected`=1 WHERE  `id` = :id");
    $stmt->bindParam(":id", $thumbnailId);
    $stmt->execute();
    echo "true";
} else {
    echo "Parametars Doesn't Pass";
    exit;
}
?>