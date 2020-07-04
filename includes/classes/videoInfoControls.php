<?php 
require_once("includes/classes/buttonProvider.php"); 
class videoInfoControls {
        private $video, $userLoggedInObj;
        public function __construct($userLoggedInObj, $video) {
            $this->video            = $video;
            $this->userLoggedInObj  = $userLoggedInObj;
        }
        public function create() {
            $likeBtn    = $this->createLikeBtn();
            $dislikeBtn = $this->createDislikeBtn();
            return "<div class='controls'>
                        $likeBtn
                        $dislikeBtn
                    </div>";
        }
        private function createLikeBtn() {
            $text       = $this->video->getLikes();
            $videoId    = $this->video->getId();
            $action     = "likeVideo(this, $videoId)";
            $class      = "likeBtn";
            $imageSrc   = "assets/images/icons/thumb-up.png";
            if ($this->video->wasLikedBy()) {
                $imageSrc   = "assets/images/icons/thumb-up-active.png";
            }
            return btnProvider::createButton($text, $imageSrc, $action, $class);
        }
        private function createDislikeBtn() {
            $text       = $this->video->getDislikes();
            $videoId    = $this->video->getId();
            $action     = "dislikeVideo(this, $videoId)";
            $class      = "dislikeBtn";
            $imageSrc   = "assets/images/icons/thumb-down.png";
            if ($this->video->wasDislikedBy()) {
                $imageSrc   = "assets/images/icons/thumb-down-active.png";
            }
            return btnProvider::createButton($text, $imageSrc, $action, $class);
        }
    }
?>