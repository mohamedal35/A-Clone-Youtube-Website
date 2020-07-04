<?php 
require_once("includes/tpl/header.php");
require_once("includes/classes/videoPlayer.php");
require_once("includes/classes/videoDetailsFormProvider.php");
require_once("includes/classes/videoLoadData.php");
require_once("includes/classes/getThumbnails.php");

if (!user::isLoggedIn()) {
    header("Location :signin.php");
}
if (!isset($_GET['videoId'])) {
    echo "No Video Selected";
    exit;
}
$video  = new video($dbcon, $_GET['videoId'], $userLoggedInobj);
$detailsMsg = "";
if ($video->getUploadedBy() != $userLoggedInobj->getUsername()) {
    echo "Not Your Video :(";
    exit;
}
if (isset($_POST['saveBtn'])) {
    $videoUpdateData    = new videoLoadData(NULL, $_POST['title'], $_POST['description'], $_POST['privacyInput'], $_POST['categoryInput'], $userLoggedInobj->getUsername());
    if ($videoUpdateData->updateDetails($dbcon, $video->getId())) {
        $detailsMsg = "<div class='alert alert-success'><strong>SUCCESS!</strong> Details Updated Successfully</div>";
        $video  = new video($dbcon, $_GET['videoId'], $userLoggedInobj);
    } else {
        $detailsMsg = "<div class='alert alert-danger'><strong>ERROR!</strong> SomeThing Went Wrong</div>";
    }
}
?>
<div class='editVideoContainer column'>
    <div class="message">
        <?php 
            echo $detailsMsg;
        ?>
    </div>
    <div class='topSection'>
        <?php 
            $videoPlayer        = new videoPlayer($video);
            echo $videoPlayer->create(0);

            $getThumbnails      = new getThumbnails($dbcon, $video);
            echo $getThumbnails->create();   
        
        ?>
    </div>
    <div class='bottomSection'>
        <?php 
            $videoDetailsFormProvider   = new videoDetailsFormProvider($dbcon);
            echo $videoDetailsFormProvider->createEditForm($video);
        ?>
    </div>


</div>




<?php 
require_once("includes/tpl/footer.php");
?>