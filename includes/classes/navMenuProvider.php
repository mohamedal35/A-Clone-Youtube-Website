<?php 
class navMenuProvider {
    private $dbcon, $userLoggedInObj;
    public function __construct($dbcon, $userLoggedInObj) {
        $this->dbcon            = $dbcon;
        $this->userLoggedInObj  = $userLoggedInObj;
    }
    public function create() {
        $menuHTML   = $this->createNavItem("Home", "assets/images/icons/home.png", "index.php");
        $menuHTML   .= $this->createNavItem("Trend", "assets/images/icons/trending.png", "trend.php");
        $menuHTML   .= $this->createNavItem("Subscriptions", "assets/images/icons/subscriptions.png", "subscriptions.php");
        $menuHTML   .= $this->createNavItem("Liked Videos", "assets/images/icons/thumb-up.png", "likedVideos.php");
        if (user::isLoggedIn()) {
            $menuHTML   .= $this->createNavItem("Settings", "assets/images/icons/settings.png", "settings.php");
            $menuHTML   .= $this->createNavItem("Log Out", "assets/images/icons/logout.png", "logout.php");
            $menuHTML       .= $this->createSubscriptionsSection();
        }
        ## Create Subscribed Channels Section
        return "<div class='navigationItems'>
                    $menuHTML
                </div>";
    }
    private function createNavItem($text, $icon, $link) {
        return "<div class='navigationItem'>
                    <a href='$link'>
                        <img src='$icon' />
                        <span>$text</span>
                    </a>
                </div>";
    }
    private function createSubscriptionsSection() {
        $subscriptions  = $this->userLoggedInObj->getSubsribtions();

        $html           = "<span class='heading'>Subscriptions</span>";
        foreach ($subscriptions as $sub) {
            $SubscribedUserObj  = new user($this->dbcon, $sub);
            $html               .= $this->createNavItem($sub, $SubscribedUserObj->getProfilePic(), "profile.php?username=$sub");
        }
        return $html;
    }
}
?>