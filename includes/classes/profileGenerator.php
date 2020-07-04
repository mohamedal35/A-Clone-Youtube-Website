<?php 
require_once("profileData.php");
require_once("buttonProvider.php");

class profileGenerator {
    private $dbcon, $userLoggedInObj, $profData;

    public function __construct($dbcon, $userLoggedInObj, $profUsername) {
        $this->dbcon            = $dbcon;
        $this->userLoggedInObj  = $userLoggedInObj;
        $this->profData         = new profileData($this->dbcon, $profUsername);

    }
    public function create() {
        $profileUsername        = $this->profData->getProfileUsername();
        if (!$this->profData->userExists()) {
            return "User Doesn't Exists";
        }
        $coverPhotoSection      = $this->createCoverPhotoSection();
        $headerSection          = $this->createHeaderSection();
        $tabsSection            = $this->createTabsSection();
        $contentSection         = $this->createContentSection();

        return "<div class='profileContainer'>
                    $coverPhotoSection
                    $headerSection
                    $tabsSection   
                    $contentSection
                </div>";
    }
    public function createCoverPhotoSection() {
        $profileCoverPic    = $this->profData->getCoverPhoto();
        $fullName           = $this->profData->getProfileFullName();
        return "<div class='coverPhotoContainer'>
                    <img src='$profileCoverPic' class='coverPhoto'/>
                    <span class='channelName'>$fullName</span>
                </div>";
    }
    public function createHeaderSection() {
        $profileImage       = $this->profData->getProfileImage();
        $fullName           = $this->profData->getProfileFullName();
        $subCount           = $this->profData->getSubCount();
        $subscribeBtn       = $this->createHeaderBtn();
        return "<div class='profileHeader'>
                    <div class='userInfoContainer'>
                        <img src='$profileImage' class='userProfileImg'/>
                        <div class='userInfo'>
                            <span class='title'>$fullName</span>
                            <span class='subCount'>$subCount Subscribers</span>
                        </div>
                    </div>

                    <div class='btnContainer'>
                        <div class='btnItem'>
                            $subscribeBtn
                        </div>
                    </div>
                </div>";

    }
    public function createTabsSection() {
        return "<ul class='nav nav-tabs' id='myTab' role='tablist'>
                    <li class='nav-item'>
                        <a class='nav-link active' id='videos-tab' data-toggle='tab' href='#videos' role='tab' aria-controls='home' aria-selected='true'>VIDEOS</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' id='about-tab' data-toggle='tab' href='#about' role='tab' aria-controls='profile' aria-selected='false'>ABOUT</a>
                    </li>
                </ul>";
    }
    public function createContentSection() {
        $videos = $this->profData->getUserVideos();
        if (count($videos) > 0) {
            $videoGrid      = new videoGrid($this->dbcon, $this->userLoggedInObj);
            $videoGridHTML  = $videoGrid->create($videos, NULL, False);
        } else {
            $videoGridHTML  = "<span>This User Has No Videos</span>";
        }
        $aboutSection       = $this->createAboutSection();
        return "<div class='tab-content channelContent border-top-0' id='myTabContent'>
                    <div class='tab-pane fade show active' id='videos' role='tabpanel' aria-labelledby='videos-tab'>
                        $videoGridHTML
                    </div>
                    <div class='tab-pane fade' id='about' role='tabpanel' aria-labelledby='about-tab'>
                        $aboutSection
                    </div>
                </div>";
    }
    private function createHeaderBtn() {
        if ($this->userLoggedInObj->getUsername() == $this->profData->getProfileUsername()) {
            return "";
        } else {
            return btnProvider::createSubscriberBtn($this->dbcon, $this->profData->getProfileUserObj(), $this->userLoggedInObj);
        }
    }
    private function createAboutSection() {
        $html   = "<div class='section'>
                        <div class='title'>
                            <span>DETIALS</span>
                        </div>
                        <div class='values'>";
        $detials= $this->profData->getAllUserDetails();

        foreach ($detials as $key => $value) {
            $html   .= "<span>$key: $value</span>";
        }
        // Add Content

        $html   .= "</div></div>";
        return $html;

    }
}

?>