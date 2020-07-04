<?php 
    require_once("config.php");
    require_once("includes/classes/user.php");
    require_once("includes/classes/video.php");
    require_once("includes/classes/videoGrid.php");
    require_once("includes/classes/videoGridItem.php");
    require_once("includes/classes/subscribtionsProvider.php");
    require_once("includes/classes/navMenuProvider.php");
    $usernameLoggedIn = (isset($_SESSION['userLoggedIn'])) ? $_SESSION['userLoggedIn'] : "";
    $userLoggedInobj= new user($dbcon, $usernameLoggedIn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Videotube - my Personal Youtube</title>
    <!-- CSS -->
    <link rel='stylesheet' href='assets/css/style.css' type='text/css' />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src='assets/js/userActions.js'></script>
    <script src='assets/js/editVideoActions.js'></script>
    <script src='assets/js/commentActions.js'></script>
</head>
<body>
    <div id="pageContainer">
        <div id="mastHeadContainer">
            <button class='navShowHide'>
                <img src="assets/images/icons/menu.png" alt="MenuIcon"/>
            </button>

            <a class='logoContainer' href="index.php">
                <img src="assets/images/icons/VideoTubeLogo.png" alt="PageLogoHere" title="VideoTube">
            </a>

            <div class="searchBarContainer">
                <form action="search.php" method="GET">
                    <input type="text" name="q" class="searchBar" placeholder="Search...">
                    <button class='searchButton' style='border-radius:none;'>
                        <img src="assets/images/icons/search.png" alt="searchIcon" title='Search'>
                    </button>
                </form>
            </div>
            <div class="rightIconsContainer">
                <a href="upload.php">
                    <img src="assets/images/icons/upload.png" class="upload" style="text-decoration: none;">
                </a>
                    <!-- <img src="assets/images/profilepictures/default-male.png" class="defaultPic"> -->
                    <?php 
                        echo btnProvider::createUserProfileNavigationBtn($dbcon, $userLoggedInobj->getUsername());
                    ?>
            </div>
        </div>
        <div id="sideNavContainer" style='display:none;'>
            <?php 
                $navMenuProvider    = new navMenuProvider($dbcon, $userLoggedInobj);
                echo $navMenuProvider->create();
            ?>
        </div>
        <div id="mainSectionContainer" class=''>
            <div id="mainContentContainer">
