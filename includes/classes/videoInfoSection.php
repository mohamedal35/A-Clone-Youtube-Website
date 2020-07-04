<?php 
require_once("includes/classes/videoInfoControls.php"); 
class videoInfoSection {
    private $video, $dbcon, $userLoggedInObj;
    public function __construct($dbcon, $userLoggedInObj, $video) {
        $this->dbcon            = $dbcon;
        $this->video            = $video;
        $this->userLoggedInObj  = $userLoggedInObj;
    }
    public function create() {
        return $this->createPrimaryInfo() . $this->createSecondryInfo();
    }
    private function createPrimaryInfo() {
        $title  = $this->video->getTitle();
        $views  = $this->video->getViews();
        $videoInfoControls  = new videoInfoControls($this->userLoggedInObj, $this->video);
        $controls           = $videoInfoControls->create();
        return "<div class='videoInfo'>
                    <h1>$title</h1>
                    <div class='btnSection'>
                        <span class='viewCount'>$views views</span>
                        $controls
                    </div>
                </div>";
    }
    private function createSecondryInfo() {
        $describtion    = $this->video->getDesc();
        $uploadedBy     = $this->video->getUploadedBy();
        $uploadDate     = $this->video->getUploadDate();
        $profileButton  = btnProvider::createUserProfileBtn($this->dbcon, $uploadedBy);
        if ($uploadedBy == $this->userLoggedInObj->getUsername()) {
            $actionButton= btnProvider::createEditVideoButton($this->video->getId());
        }else {
            $userToObj   = new user($this->dbcon, $uploadedBy);
            $actionButton= btnProvider::createSubscriberBtn($this->dbcon, $userToObj, $this->userLoggedInObj);
        }
        return "<div class='secondaryInfo'>
                    <div class='topRow'>
                        $profileButton
                        <div class='uploadInfo'>
                            <span class='owner'>
                                <a href='profile.php?username=$uploadedBy'>$uploadedBy</a>
                            </span>
                            <span class='date'>
                                Published On $uploadDate
                            </span>
                        </div>
                        $actionButton
                    </div>
                    <div class='describtionContainer'>
                        $describtion
                    </div>
                </div>";
    }

}    
?>