<?php 
    require_once "comment.php";
    class video {
        private $dbcon, $sqlData, $userLoggedInObj;
        public function __construct($dbcon, $input, $userLoggedInObj) {
            $this->dbcon                = $dbcon;
            $this->userLoggedInObj      = $userLoggedInObj;
            if (is_array($input)) {
                $this->sqlData          = $input;
            } else {
                $stmt           = $this->dbcon->prepare("SELECT * FROM `videos` WHERE `id` = :id");
                $stmt->bindParam(":id", $input);
                $stmt->execute();
    
                $this->sqlData        = $stmt->fetch(PDO::FETCH_ASSOC);
            }

        }
        public function getId() {
            return $this->sqlData['id'];
        }
        public function getUploadedBy() {
            return $this->sqlData['uploaded_by'];
        }
        public function getUploadAgeDate() {
            return $this->time_elapsed_string($this->sqlData['uploadDate']);
        }
        public function getTitle() {
            return $this->sqlData['title'];
        }
        public function getDesc() {
            return $this->sqlData['description'];
        }
        public function getPrivacy() {
            return $this->sqlData['privacy'];
        }
        public function getFilePath() {
            return $this->sqlData['filePath'];
        }
        public function getCategory() {
            return $this->sqlData['category'];
        }
        public function getUploadDate() {
            $date   = $this->sqlData['uploadDate'];
            return date("M j, Y", strtotime($date));
        }
        public function getViews() {
            return $this->sqlData['views'];
        }
        public function getDuration() {
            return $this->sqlData['duration'];
        }
        public function incrementViews() {
            $id         = $this->getId();
            $stmt       = $this->dbcon->prepare("UPDATE `videos` SET `views` = `views` + 1 WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $this->sqlData['views'] = $this->sqlData['views'] + 1;
        }
        public function getLikes() {
            $videoId    = $this->getId();
            $stmt       = $this->dbcon->prepare("SELECT COUNT(*) as `count` FROM `likes` WHERE `videoId`  = :id");
            $stmt->bindParam(":id", $videoId);
            $stmt->execute();
            $data       = $stmt->fetch(PDO::FETCH_ASSOC);
            return  $data['count'];
        }
        public function getDislikes() {
            $videoId    = $this->getId();
            $stmt       = $this->dbcon->prepare("SELECT COUNT(*) as `count` FROM `dislikes` WHERE `videoId`  = :id");
            $stmt->bindParam(":id", $videoId);
            $stmt->execute();
            $data       = $stmt->fetch(PDO::FETCH_ASSOC);
            return  $data['count'];
        }
        public function like() {
            $videoId    = $this->getId();

            if ($this->wasLikedBy()) {
                $stmt   = $this->dbcon->prepare("DELETE FROM `likes` WHERE username = :un AND `videoId` = :vi");
                $stmt->bindParam(":un", $this->userLoggedInObj->getUsername());
                $stmt->bindParam(":vi", $videoId);
                $stmt->execute();
                $result = array(
                    "likes" => -1,
                    "dislikes" => 0,
                    "likeImg"   => "thumb-up.png",
                    "dislikeImg"   => "thumb-down.png"
                );
                return json_encode($result);
            } else {
                $stmt   = $this->dbcon->prepare("DELETE FROM `dislikes` WHERE username = :un AND `videoId` = :vi");
                $stmt->bindParam(":un", $this->userLoggedInObj->getUsername());
                $stmt->bindParam(":vi", $videoId);
                $stmt->execute();
                $count   = $stmt->rowCount();

                $stmt       = $this->dbcon->prepare("INSERT INTO `likes` (`username`, `videoId`) VALUES (:username, :vi)");
                $stmt->bindParam(":username", $this->userLoggedInObj->getUsername());
                $stmt->bindParam(":vi", $videoId);
                $stmt->execute();
                $result = array(
                    "likes" => 1,
                    "dislikes" => (0 - $count),
                    "likeImg"   => "thumb-up-active.png",
                    "dislikeImg"   => "thumb-down.png"
                );
                return json_encode($result);
            }
            
        }
        public function dislike() {
            $videoId    = $this->getId();
            $stmt       = $this->dbcon->prepare("SELECT * FROM `dislikes` WHERE username = :un AND videoId = :vi");
            $stmt->bindParam(":un", $this->userLoggedInObj->getUsername());
            $stmt->bindParam(":vi", $videoId);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt   = $this->dbcon->prepare("DELETE FROM `dislikes` WHERE username = :un AND `videoId` = :vi");
                $stmt->bindParam(":un", $this->userLoggedInObj->getUsername());
                $stmt->bindParam(":vi", $videoId);
                $stmt->execute();
                $result = array(
                    "likes"     => 0,
                    "dislikes"  => -1,
                    "dislikeImg"   => "thumb-down.png",
                    "likeImg"   => "thumb-up.png"

                );
                return json_encode($result);
            } else {
                $stmt   = $this->dbcon->prepare("DELETE FROM `likes` WHERE username = :un AND `videoId` = :vi");
                $stmt->bindParam(":un", $this->userLoggedInObj->getUsername());
                $stmt->bindParam(":vi", $videoId);
                $stmt->execute();
                $count   = $stmt->rowCount();

                $stmt       = $this->dbcon->prepare("INSERT INTO `dislikes` (`username`, `videoId`) VALUES (:username, :vi)");
                $stmt->bindParam(":username", $this->userLoggedInObj->getUsername());
                $stmt->bindParam(":vi", $videoId);
                $stmt->execute();
                $result = array(
                    "likes"     => (0 - $count),
                    "dislikes"  => 1,
                    "dislikeImg"   => "thumb-down-active.png",
                    "likeImg"   => "thumb-up.png"
                );
                return json_encode($result);
            }
    }
        public function wasLikedBy() {
            $videoId    = $this->getId();
            $stmt       = $this->dbcon->prepare("SELECT * FROM `likes` WHERE username = :un AND videoId = :vi");
            $stmt->bindParam(":un", $this->userLoggedInObj->getUsername());
            $stmt->bindParam(":vi", $videoId);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        }
        public function wasDislikedBy() {
            $videoId    = $this->getId();
            $stmt       = $this->dbcon->prepare("SELECT * FROM `dislikes` WHERE username = :un AND videoId = :vi");
            $stmt->bindParam(":un", $this->userLoggedInObj->getUsername());
            $stmt->bindParam(":vi", $videoId);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        }
        public function commentsNum() {
            $stmt   = $this->dbcon->prepare("SELECT * FROM `comments` WHERE `videoId` = :id;");
            $stmt->bindParam(":id", $this->getId());
            $stmt->execute();
            return $stmt->rowCount();
        }
        public function getComments() {
            $id         = $this->sqlData['id'];
            $stmt       = $this->dbcon->prepare("SELECT * FROM `comments` WHERE videoId= :vi AND `responseTo` = 0 ORDER BY `datePosted` DESC");
            $stmt->bindParam(":vi", $id);
            $stmt->execute();
            $comments   = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $comment = new comment($this->dbcon, $row, $this->userLoggedInObj, $id);
                array_push($comments, $comment);
            }
            return $comments;
        }
        public function getThumbnail() {
            $videoId= $this->getId();
            $stmt   = $this->dbcon->prepare("SELECT filePath FROM `thumbnails` WHERE videoId=:vi AND `SELECTED`= 1");
            $stmt->bindParam(":vi", $videoId);
            $stmt->execute();
            $data   = $stmt->fetchColumn();
            return  $data;
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
}
?>