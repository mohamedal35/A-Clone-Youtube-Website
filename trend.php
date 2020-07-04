<?php 
    require_once("includes/tpl/header.php");
    require_once("includes/classes/trendingProvider.php");
    $trendingProvider   = new trendingProvider($dbcon, $userLoggedInobj);
    $videos             = $trendingProvider->getVideos();

    $videoGrid          = new videoGrid($dbcon, $userLoggedInobj);
?>
    <div class='largeVideoGridContainer'>

        <?php 
            if (sizeof($videos > 0)) {
                echo $videoGrid->createLarge($videos, "Trending In Last Week", false); 
            } else {
                echo "No Trending Videos To Show";
            }
        ?>

    </div>
<?php 
    require_once("includes/tpl/footer.php");
?>