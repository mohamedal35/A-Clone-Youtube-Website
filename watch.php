<?php 
    require_once("includes/tpl/header.php");
    require_once("includes/classes/videoPlayer.php");
    require_once("includes/classes/videoInfoSection.php");
    require_once("includes/classes/commentSection.php");

    if (isset($_GET['id'])) {
        $videoId    = $_GET['id'];
    }else {
        echo "Couldn't Load Video";
        exit;
    }
$video  = new video($dbcon, $videoId, $userLoggedInobj);
$video->incrementViews();
// session_unset();
// session_destroy();
?>
    <div class="watchLeftColumn">
        <?php 
            $videoPlayer        = new videoPlayer($video);
            echo $videoPlayer->create(0);
            $videoInfoSection   = new videoInfoSection($dbcon, $userLoggedInobj, $video);
            echo $videoInfoSection->create();
            $commentSection     = new commentSection($dbcon, $userLoggedInobj, $video);
            echo $commentSection->create();

        ?>
    </div>
    <div class="suggestions">
        <?php 
            $commentSection     = new videoGrid($dbcon, $userLoggedInobj);
            echo $commentSection->create(NULL, NULL, FALSE);
        ?>
    </div>
    <script src='assets/js/videoPlayerActions.js'></script>
<?php 
    require_once("includes/tpl/footer.php");
?>