<?php 
    require_once "includes/tpl/header.php";
    require_once "includes/classes/searchResultsProvider.php"; 



    if (!isset($_GET['q']) || empty($_GET['q'])) {
        echo "You Must Enter What You Search For";
        exit;
    }
    $q  = $_GET['q'];
    if (!isset($_GET['orderBy']) || $_GET['orderBy'] == "views") {
        $orderBy    = "views";
    } else {
        $orderBy    = "uploadDate";
    }
?>


<?php 
    $searchResultsProvider  = new searchResultsProvider($dbcon, $userLoggedInobj);
    $videos                 = $searchResultsProvider->getVideos($q, $orderBy);

    $videoGrid              = new videoGrid($dbcon, $userLoggedInobj);

?>
<div class='largeVideoGridContainer'>
    <?php 
        if (sizeof($videos) > 0) {
            echo $videoGrid->createLarge($videos, sizeof($videos) . " Results Found", true);
        } else {
            echo "No Results Found";
        }
    
    ?>
</div>





<?php 
    require_once "includes/tpl/footer.php";

?>