<?php 
    require_once("includes/tpl/header.php");

    if (!user::isLoggedIn()) {
        header("Location:signin.php");
    }
    $subscriptionsProvider   = new subscriptionsProvider($dbcon, $userLoggedInobj);
    $videos                  = $subscriptionsProvider->getVideos();

    $videoGrid               = new videoGrid($dbcon, $userLoggedInobj);
?>
    <div class='largeVideoGridContainer'>

        <?php 
            if (sizeof($videos > 0)) {
                echo $videoGrid->createLarge($videos, "Subscriptions Videos", FALSE ); 
            } else {
                echo "There Is not Any Subscriptions Videos";
            }
        ?>

    </div>
<?php 
    require_once("includes/tpl/footer.php");
?>