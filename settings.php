<?php 
    require_once("includes/tpl/header.php");
    require_once("includes/classes/constants.php");
    require_once("includes/classes/account.php");
    require_once("includes/classes/formSanitizer.php");
    require_once("includes/classes/settingsFormProvider.php");
    if (!user::isLoggedIn()) {
        header("Location:signin.php");
    }
    $detailsMsg     = "";
    $passwordMsg    = "";

    if (isset($_POST['saveDetailsBtn'])) {
        $account        = new account($dbcon);

        $firstName      = formSanitizer::sanitizeFormString($_POST['firstName']);
        $lastName       = formSanitizer::sanitizeFormString($_POST['lastName']);
        $email          = formSanitizer::sanitizeFormEmail($_POST['email']);

        if ($account->updateDetails($firstName, $lastName, $email, $userLoggedInobj->getUsername())) {
            $detailsMsg = "<div class='alert alert-success'><strong>SUCCESS!</strong> Details Updated Successfully</div>";
        } else {
            $errmsg     = $account->getFirstErr();
            $errmsg     = ($errmsg === "") ? "SomeThing Went Wring" : $errmsg;
            $detailsMsg = "<div class='alert alert-danger'><strong>ERROR!</strong> $errmsg</div>";
        }
    }
    if ( isset($_POST['savePasswordBtn'])) {
        $account        = new account($dbcon);

        $oldPassword      = formSanitizer::sanitizeFormPassword($_POST['oldPassword']);
        $newPassword      = formSanitizer::sanitizeFormPassword($_POST['newPassword']);
        $conPassword      = formSanitizer::sanitizeFormPassword($_POST['confirmPassword']);

        if ($account->updatePassword($oldPassword, $newPassword, $conPassword, $userLoggedInobj->getUsername())) {
            $passwordMsg = "<div class='alert alert-success'><strong>SUCCESS!</strong> Password Updated Successfully</div>";
        } else {
            $errmsg     = $account->getFirstErr();
            $errmsg     = ($errmsg === "") ? "SomeThing Went Wring" : $errmsg;
            $passwordMsg = "<div class='alert alert-danger'><strong>ERROR!</strong> $errmsg</div>";
        }
    }
?>
    <div class='settingsContainer column'>
        <div class='formSection'>
            <div class="message">
                <?php 
                    echo $detailsMsg;
                ?>
            </div>
            <?php 
                
                $settings   = new settingsFormProvider();
                echo $settings->createUserDetailsForm(
                                                        isset($_POST['firstName']) ? $_POST['firstName'] : $userLoggedInobj->getFirstName(), 
                                                        isset($_POST['lastName']) ? $_POST['lastName'] : $userLoggedInobj->getLastName(), 
                                                        isset($_POST['email']) ? $_POST['email'] : $userLoggedInobj->getEmail());
            ?>
        </div>
        <div class='formSection'>
            <div class="message">
                <?php 
                    echo $passwordMsg;
                ?>
            </div>
            <?php 
                 echo $settings->createPasswordForm();
            ?>
        </div>
    </div>
<?php 
    require_once("includes/tpl/footer.php");
?>