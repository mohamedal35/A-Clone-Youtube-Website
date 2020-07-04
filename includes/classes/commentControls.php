<?php 
require_once("buttonProvider.php"); 
class commentControls {
        private $dbcon, $comment, $userLoggedInObj;
        public function __construct($dbcon, $comment, $userLoggedInObj) {
            $this->dbcon    = $dbcon;
            $this->comment  = $comment;
            $this->userLoggedInObj  = $userLoggedInObj;
        }
        public function create() {
            $replyBtn   = $this->createReplyBtn();
            $likeCount  = $this->createLikesCount();
            $likeBtn    = $this->createLikeBtn();
            $dislikeBtn = $this->createDislikeBtn();
            $replySection= $this->createReplySection();
            return "<div class='controls'>
                        $replyBtn
                        $likeCount
                        $likeBtn
                        $dislikeBtn
                    </div>
                    $replySection";
        }
        private function createLikeBtn() {
            $videoId    = $this->comment->getVideoId();
            $commentId  = $this->comment->getId();
            $action     = "likeComment($commentId, this, $videoId)";
            $class      = "likeCommentBtn";
            $imageSrc   = "assets/images/icons/thumb-up.png";
            if ($this->comment->wasLikedBy()) {
                $imageSrc   = "assets/images/icons/thumb-up-active.png";
            }
            return btnProvider::createButton("", $imageSrc, $action, $class);
        }
        private function createDislikeBtn() {
            $videoId    = $this->comment->getVideoId();
            $commentId  = $this->comment->getId();
            $action     = "dislikeComment($commentId, this, $videoId)";
            $class      = "dislikeCommentBtn";
            $imageSrc   = "assets/images/icons/thumb-down.png";
            if ($this->comment->wasdislikedBy()) {
                $imageSrc   = "assets/images/icons/thumb-down-active.png";
            }
            return btnProvider::createButton("", $imageSrc, $action, $class);
        }
        private function createReplyBtn() {
            $text  = "REPLY";
            $action= "toggleReply(this)";

            return btnProvider::createButton($text, null, $action, null);
        }

        private function createLikesCount() {
            $text  = ($this->comment->getLikes() == 0) ? "" : $this->comment->getLikes();
            return "<span class='likesCount'>".$text."</span>";
        }
        private function createReplySection() {
            $postedBy       = $this->userLoggedInObj->getUsername();
            $videoId        = $this->comment->getVideoId();
            $commentId      = $this->comment->getId();
            $profileBtn     = btnProvider::createUserProfileBtn($this->dbcon, $postedBy);
            $cancelAction   = "toggleReplyForm(this)";
            $cancelBtn      = btnProvider::createButton("CANCEL", null, $cancelAction, "cancelComment");
    
            $postAction     = "postComment(this, \"$postedBy\", $videoId, \"$commentId\", \"repliesSection\")";
            $postBtn        = btnProvider::createButton("Reply", null, $postAction, "postReply");
            // Get Comments HTML
            return "<div class='commentForm hide'>
                        $profileBtn
                        <textarea class='commentBodyClass' placeholder='Add A Public Comment'></textarea>
                        $cancelBtn
                        $postBtn
                    </div>";
        }
    }
?>