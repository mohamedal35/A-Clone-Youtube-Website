<?php 
require_once("buttonProvider.php"); 
require_once("commentControls.php"); 

class comment {
    private $dbcon, $sqlData, $userLoggedInObj, $videoId;
    public function __construct($dbcon, $input, $userLoggedInObj, $videoId)    {
        $this->dbcon    = $dbcon;
        $this->userLoggedInObj  = $userLoggedInObj;
        $this->videoId  = $videoId;
        if (!is_array($input)) {
            $stmt   = $this->dbcon->prepare("SELECT * FROM `comments` WHERE `id` = :id");
            $stmt->bindParam(":id", $input);
            $stmt->execute();
            $input = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        $this->sqlData      = $input;
    }
    public function create() {
        $id         = $this->sqlData['id'];
        $videoId    = $this->getVideoId();
        $body       = $this->sqlData['body'];
        $postedBy   = $this->sqlData['postedBy'];
        $profileBtn = btnProvider::createUserProfileBtn($this->dbcon, $postedBy);
        $timeStamp  = $this->time_elapsed_string($this->sqlData['datePosted']);
        
        $numResponses   = $this->getNumberOfReplies();
        $viewRepliesTxt = ($numResponses > 0) ? "<span class='repliesSection viewReplies' onclick='getReplies($id, this, $videoId)'>View All $numResponses Replies</span>" : "<div class='repliesSection'></div>";


        $commentControlsObj     = new commentControls($this->dbcon, $this, $this->userLoggedInObj);
        $commentControls        = $commentControlsObj->create();
        return "<div class='itemContainer'>
                    <div class='comment'>
                        $profileBtn
                        <div class='mainContainer'>

                            <div class='commentHeader'>
                                <a href='profile.php?username=$postedBy'><span class='username'>$postedBy</span></a>
                                <span class='timestamp'>$timeStamp</span>

                            </div>
                            <div class='body'>
                                $body
                            </div>
                        </div>
                    </div>
                    $commentControls
                    $viewRepliesTxt
                </div>";
    }
    public function getId() {
        return $this->sqlData['id'];
    }
    public function getVideoId() {
        return $this->videoId;
    }
    public function like() {
        $commentId    = $this->getId();
        $username     = $this->userLoggedInObj->getUsername();
        if ($this->wasLikedBy()) {
            $stmt   = $this->dbcon->prepare("DELETE FROM `likes` WHERE username = :un AND `commentId` = :ci");
            $stmt->bindParam(":un", $username);
            $stmt->bindParam(":ci", $commentId);
            $stmt->execute();
            $result = array(
                "likes" => -1,
                "dislikes" => 0,
                "likeImg"   => "assets/images/icons/thumb-up.png",
                "dislikeImg"   => "assets/images/icons/thumb-down.png"
            );
            return json_encode($result);
        } else {
            $stmt   = $this->dbcon->prepare("DELETE FROM `dislikes` WHERE username = :un AND `commentId` = :ci");
            $stmt->bindParam(":un", $username);
            $stmt->bindParam(":ci", $commentId);
            $stmt->execute();
            $count   = $stmt->rowCount();

            $stmt       = $this->dbcon->prepare("INSERT INTO `likes` (`username`, `commentId`) VALUES (:username, :ci)");
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":ci", $commentId);
            $stmt->execute();
            $result = array(
                "likes" => 1,
                "dislikes" => (0 - $count),
                "likeImg"   => "assets/images/icons/thumb-up-active.png",
                "dislikeImg"   => "assets/images/icons/thumb-down.png"
            );
            return json_encode($result);
        }
        
    }
    public function dislike() {
        $commentId    = $this->getId();
        $username     = $this->userLoggedInObj->getUsername();

        if ($this->wasDislikedBy()) {
            $stmt   = $this->dbcon->prepare("DELETE FROM `dislikes` WHERE username = :un AND `commentId` = :ci");
            $stmt->bindParam(":un", $username);
            $stmt->bindParam(":ci", $commentId);
            $stmt->execute();
            $result = array(
                "likes"     => 0,
                "dislikes"  => -1,
                "dislikeImg"   => "assets/images/icons/thumb-down.png",
                "likeImg"   => "assets/images/icons/thumb-up.png"

            );
            return json_encode($result);
        } else {
            $stmt   = $this->dbcon->prepare("DELETE FROM `likes` WHERE username = :un AND `commentId` = :ci");
            $stmt->bindParam(":un", $username);
            $stmt->bindParam(":ci", $commentId);
            $stmt->execute();
            $count   = $stmt->rowCount();

            $stmt       = $this->dbcon->prepare("INSERT INTO `dislikes` (`username`, `commentId`) VALUES (:username, :ci)");
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":ci", $commentId);
            $stmt->execute();
            $result = array(
                "likes"     => (0 - $count),
                "dislikes"  => 1,
                "dislikeImg"   => "assets/images/icons/thumb-down-active.png",
                "likeImg"   => "assets/images/icons/thumb-up.png"
            );
            return json_encode($result);
        }
}
    public function wasLikedBy() {
        $commentId  = $this->getId();
        $username   = $this->userLoggedInObj->getUsername();
        $stmt       = $this->dbcon->prepare("SELECT * FROM `likes` WHERE username = :un AND commentId = :ci");
        $stmt->bindParam(":un", $username);
        $stmt->bindParam(":ci", $commentId);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    public function wasDislikedBy() {
        $commentId  = $this->getId();
        $username   = $this->userLoggedInObj->getUsername();
        $stmt       = $this->dbcon->prepare("SELECT * FROM `dislikes` WHERE username = :un AND commentId = :ci");
        $stmt->bindParam(":un", $username);
        $stmt->bindParam(":ci", $commentId);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    public function getLikes() {
        $stmt   = $this->dbcon->prepare("SELECT COUNT(*) as 'count' FROM `likes` WHERE commentId=:commentid;");
        $commentId  = $this->getId();
        $stmt->bindParam(":commentid", $commentId);
        $stmt->execute();
        $data       = $stmt->fetch(PDO::FETCH_ASSOC);
        $numLikes   = $data['count'];
        return $numLikes;
    }
    private function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
    private function getNumberOfReplies() {
        $id     = $this->sqlData['id'];
        $stmt   = $this->dbcon->prepare("SELECT COUNT(*) AS 'count' FROM `comments` WHERE `responseTo` = :rt");
        $stmt->bindParam(":rt", $id);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function getReplies() {
        $id         = $this->sqlData['id'];
        $stmt       = $this->dbcon->prepare("SELECT * FROM `comments` WHERE  `responseTo` = :rt ORDER BY `datePosted` ASC");
        $stmt->bindParam(":rt", $id);
        $stmt->execute();
        $comments   = "";
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $comment    = new comment($this->dbcon, $row, $this->userLoggedInObj, $this->videoId);
            $comments   .= $comment->create();
        }
        return $comments;
    }
}
?>