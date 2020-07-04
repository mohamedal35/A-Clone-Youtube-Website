<?php 
    require_once("includes/tpl/header.php");
    require_once("includes/classes/profileGenerator.php");
    if (isset($_GET['username'])) {
        $profUsername   = $_GET['username'];
    } else {
        echo "Channel Not Found";
        exit;
    }
    $profileGenerator   = new profileGenerator($dbcon, $userLoggedInobj, $profUsername);
    echo $profileGenerator->create();
?>

<?php 
    require_once("includes/tpl/footer.php");
?>