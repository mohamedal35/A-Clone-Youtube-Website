<?php
class btnProvider {
    public static function createButton($text, $imageSrc, $action, $class) {
        $image  = ($imageSrc == NULL) ? "" : "<img src='$imageSrc' />";
        
        return    "<button class='$class' onclick='$action'>
                        $image
                        <span class='text'>$text</span>
                    </button>";
    }
    public static function createUserProfileBtn($dbcon , $username) {
        $userObj    = new user($dbcon, $username);
        $profilePic = $userObj->getProfilePic();
        $link       = "profile.php?username=$username";
        return "<a href='$link'>
                    <img src='$profilePic' class='profilePicutre'>
                </a>";
    }
    public static function createHyberLinkButton($text, $imageSrc, $href, $class) {
        $image  = ($imageSrc == NULL) ? "" : "<img src='$imageSrc' />";
        
        return    "<a href='$href'>
                        <button class='$class'>
                            $image
                            <span class='text'>$text</span>
                        </button>
                    </a>";
    }
    public static function createEditVideoButton($video) {
        $href   = "editVideo.php?videoId=$video";
        $button = btnProvider::createHyberLinkButton("EDIT VIDEO", NULL, $href, "edit button");
        return "<div class='editVideoContainer'>
                    $button
                </div>";
    }
    public static function createSubscriberBtn($con, $userToObj, $userLoggedInObj) {
        $userTo         = $userToObj->getUsername();
        $userLoggedIn   = $userLoggedInObj->getUsername();
        $isSubscribedTo = $userLoggedInObj->isSubscribedTo($userTo);
        $buttonText     = $isSubscribedTo ? "SUBSCRIBED" : "SUBSCRIBE";
        $buttonText     .= " " . $userToObj->getSubscriberCount();

        $buttonClass    = $isSubscribedTo ? "unsubscribe button" : "subscribe button";

        $action         = "subscribe(\"$userTo\", \"$userLoggedIn\", this)";

        $button         = btnProvider::createButton($buttonText, NULL, $action, $buttonClass);

        return "<div class='subscribeBtnContainer'>
                    $button
                </div>";
    }
    public static function createUserProfileNavigationBtn($dbcon, $username) {
        if (user::isLoggedIn()) {
            return btnProvider::createUserProfileBtn($dbcon, $username);
        } else {
            return "<a href='signin.php' class='signINA'>
                        <span class='signInLink'>SIGN IN</span>
                    </a>";
        }
    }
}   
?>