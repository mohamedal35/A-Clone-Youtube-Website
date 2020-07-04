<?php 
    require_once("config.php");
    require_once("includes/classes/formSanitizer.php");
    require_once("includes/classes/constants.php");
    require_once("includes/classes/account.php");
    require_once "includes/classes/phpmailer.php";
    require_once "includes/classes/smtp.php";
    $account    = new account($dbcon);

    if (isset($_POST['submitbtn'])) {

        $firstName      = formSanitizer::sanitizeFormString($_POST['firstName']);
        $lastName       = formSanitizer::sanitizeFormString($_POST['lastName']);
        
        $username       = formSanitizer::sanitizeFormUsername($_POST['username']);

        $email          = formSanitizer::sanitizeFormEmail($_POST['email']);
        $email2         = formSanitizer::sanitizeFormEmail($_POST['email2']);

        $password       = formSanitizer::sanitizeFormPassword($_POST['password']);
        $password2      = formSanitizer::sanitizeFormPassword($_POST['password2']);
        $activationCode = uniqid() . $username . uniqid();
        $wasSuccessful  =   $account->register($firstName, $lastName, $username, $email, $email2, $password, $password2, $activationCode);
        if ($wasSuccessful) {
            // $_SESSION['userLoggedIn'] = $username;
            $successMsg = "<div class='alert alert-success'>You Have Registered Go And Active Your Account</div>";
            unset($_POST);
            // header("Location:index.php");
        } else {

        }
    }
    function getInputValue($name) {
        if (isset($_POST[$name])) {
            echo $_POST[$name];
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Videotube || SignUp</title>
    <!-- CSS -->
    <link rel='stylesheet' href='assets/css/style.css' type='text/css' />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
    <div class="signInContainer">
        <div class="column">
            <div class="header">
                <img src="assets/images/icons/VideoTubeLogo.png" alt="PageLogoHere" style='' title="VideoTube">
                <h3>SignUp</h3>
                <span>to continue to VideoTube</span>
            </div>
            <div class="loginForm">
                <div class='Msg'>
                    <?php 
                        if (isset($successMsg)) {
                            echo $successMsg;
                        }
                    ?>
                </div>
                <form action="signup.php" method="POST">
                    <input type="text" name="firstName" placeholder='First Name' value="<?php getInputValue("firstName") ?>" autocomplete='off' required>
                    <?php echo $account->getError(constants::$firstNameCharacters); ?>
                    <input type="text" name="lastName"  placeholder='Last Name' value="<?php getInputValue("lastName") ?>" autocomplete='off' required>
                    <?php echo $account->getError(constants::$lastNameCharacters); ?>
                    <input type="text" name="username" placeholder='Username' value="<?php getInputValue("username") ?>" autocomplete='off' required>
                    <?php 
                        echo $account->getError(constants::$usernameCharacters); 
                        echo $account->getError(constants::$usernameDBug); 
                    ?>

                    <input type="email" name="email" placeholder='Email' value="<?php getInputValue("email") ?>" autocomplete='off' required>
                    <input type="email" name="email2" placeholder='Confirm Email' value="<?php getInputValue("email2") ?>" autocomplete='off' required>
                    <?php 
                        echo $account->getError(constants::$emailMatch); 
                        echo $account->getError(constants::$emailValidation); 

                    ?>

                    <input type="password" name="password" placeholder='Password' required>
                    <input type="password" name="password2" placeholder='Confirm Password' required>
                    <?php 
                        echo $account->getError(constants::$passMatch); 
                        echo $account->getError(constants::$passPower);
                        echo $account->getError(constants::$passEmpty);
                    ?>

                    <input type="submit" name='submitbtn' value="SUBMIT">
                </form>
            </div>
            <a class='signInMessage' href="signin.php">Already have An account ?! Sign In Here.</a>
        </div>
    </div>
</body>
</html>