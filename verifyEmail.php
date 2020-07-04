<?php 
    require_once("includes/tpl/header.php");
    require_once("includes/classes/account.php");

    $verificationCode = isset($_GET['code']) ? $_GET['code'] : "";

    if ($verificationCode == "") {
        echo "<div class='alert alert-danger'>There Is No Any Verfication Code</div>";
    } else {
        $account        = new account($dbcon);
        $wasSuccessful  = $account->verifyAccount($verificationCode);

        if ($wasSuccessful) {
            header("Location:signin.php");
        } else {
            echo "<div class='alert alert-danger'>There Is No User With This Verfication Code</div>";
        }
    }
?>
<?php 
    require_once("includes/tpl/footer.php");
?>