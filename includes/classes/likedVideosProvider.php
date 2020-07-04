<?php 
class likedVideosProvider {
    private $dbcon, $userLoggedInObj;
    public function __construct($dbcon, $userLoggedInObj) {
        $this->dbcon            = $dbcon;
        $this->userLoggedInObj  = $userLoggedInObj;
    }
    public function getVideos() {
        $videos     = array();
        $username   = $this->userLoggedInObj->getUsername();
        $stmt   = $this->dbcon->prepare("SELECT `videoId` FROM 
                                            `likes` 
                                        WHERE 
                                            `username` = :un
                                        AND
                                            `commentId` = 0
                                        ORDER BY `id`  DESC");
        $stmt->bindParam(":un", $username);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $videos[]  = new video($this->dbcon, $row['videoId'], $this->userLoggedInObj);
        }
        return $videos;
    }
}
?>