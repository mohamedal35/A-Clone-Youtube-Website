<?php 
class commentSection {
    private $video, $dbcon, $userLoggedInObj;
    public function __construct($dbcon, $userLoggedInObj, $video) {
        $this->dbcon            = $dbcon;
        $this->video            = $video;
        $this->userLoggedInObj  = $userLoggedInObj;
    }
    public function create() {
        return $this->createCommentSection();
    }
    private function createCommentSection() {
        $commentsNum    = $this->video->commentsNum();
        $postedBy       = $this->userLoggedInObj->getUsername();
        $videoId        = $this->video->getId();
        $profileBtn     = btnProvider::createUserProfileBtn($this->dbcon, $postedBy);
        $commentAction  = "postComment(this, \"$postedBy\", \"$videoId\", null, \"comments\")";
        $commentBtn     = btnProvider::createButton("COMMENT", null, $commentAction, "postComment");

        // Get Comments HTML
        $comments       = $this->video->getComments();
        $commentItems   = "";
        foreach($comments as $comment) {
            $commentItems .= $comment->create();
        }

        return "<div class='commentSection'>
                    <div class='header'>
                        <span class='commentCount'>$commentsNum Comments</span>
                        <div class='commentForm'>
                            $profileBtn
                            <textarea class='commentBodyClass' placeholder='Add A Public Comment'></textarea>
                            $commentBtn
                        </div>
                    </div>
                    <div class='comments'>
                        $commentItems
                    </div>
                </div>";
    }

}    
?>