<?php 
    require_once("includes/tpl/header.php");
    require_once("includes/classes/videoLoadData.php");
    require_once("includes/classes/videoProcessor.php");
?>

<?php 
    if (!isset($_POST['uploadButton'])) {
        echo "No File Sent To Page";
        exit;
    }
    // Video Upload Data
    $videoUploadData = new videoLoadData(
                                $_FILES['fileInput'], 
                                $_POST['title'], 
                                $_POST['description'], 
                                $_POST['privacyInput'], 
                                $_POST['categoryInput'], 
                                $userLoggedInobj->getUsername());
    // Video Processor Class
    $videoProcessor  = new videoProcessor($dbcon);
    $wasSuccessful   = $videoProcessor->upload($videoUploadData);
    // Check If Successful
    if ($wasSuccessful) {
        echo "Upload Successful";
    }
    require_once("includes/tpl/footer.php");
?>