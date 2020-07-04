<?php 
    require_once("includes/tpl/header.php");
?>
    <div class='videoSection'>


        <?php 
            $subscriptionsProvide   = new subscriptionsProvider($dbcon, $userLoggedInobj);
            $subVideos              = $subscriptionsProvide->getVideos();

            $videoSection     = new videoGrid($dbcon, $userLoggedInobj);
            if (user::isLoggedIn() && sizeof($subVideos) > 0) {
                echo $videoSection->create($subVideos, "Subscriptions", FALSE);

            }
            echo $videoSection->create(NULL, "Recommended", FALSE);
        ?>
    
    
    </div>


<?php 
    require_once("includes/tpl/footer.php");
?>