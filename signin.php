<?php 
    require_once("config.php");
    require_once("includes/classes/formSanitizer.php");
    require_once("includes/classes/constants.php");
    require_once("includes/classes/account.php");
    $account    = new account($dbcon);
    if (isset($_POST['signinbtn'])) {
        $username   = formSanitizer::sanitizeFormUsername($_POST['username']);
        $password   = formSanitizer::sanitizeFormPassword($_POST['password']);

        $wasSuccessful  = $account->login($username, $password);
        if ($wasSuccessful) {
            $_SESSION['userLoggedIn'] = $username;
            header("Location:index.php");
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
                <h3>signIn</h3>
                <span>to continue to VideoTube</span>
            </div>
            <div class="loginForm">
                <form action="signin.php" method="POST">
                    <input type="text" name="username" placeholder='Username' value="<?php echo     getInputValue("username"); ?>" autocomplete='off' required>
                    <input type="password" name="password" placeholder='Enter Your Password' required>
                    <?php 
                        echo $account->getError(constants::$loginErr);
                        echo $account->getError(constants::$verficationErr); 
                    ?>
                    <input type="submit" name='signinbtn' value="SUBMIT">
                </form>
            </div>
            <a class='signInMessage' href="signup.php">Don't have An account ?! Sign Up Here.</a>
        </div>
    </div>
</body>
</html>