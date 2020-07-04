<?php 
    require_once("includes/tpl/header.php");
    require_once("includes/classes/likedVideosProvider.php");

    if (!user::isLoggedIn()) {
        header("Location:signin.php");
    }
    $likedVideosProvider     = new likedVideosProvider($dbcon, $userLoggedInobj);
    $videos                  = $likedVideosProvider->getVideos();
    $videoGrid               = new videoGrid($dbcon, $userLoggedInobj);
?>
    <div class='largeVideoGridContainer'>

        <?php 
            if (sizeof($videos) > 0) {
                echo $videoGrid->createLarge($videos, "Liked Videos", FALSE ); 
            } else {
                echo "There Is not Any Subscriptions Videos";
            }
        ?>

    </div>
<?php 
    require_once("includes/tpl/footer.php");
?>