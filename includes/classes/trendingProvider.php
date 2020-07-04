<?php 
class trendingProvider {
    private $dbcon, $userLoggedInObj;
    public function __construct($dbcon, $userLoggedInObj) {
        $this->dbcon            = $dbcon;
        $this->userLoggedInObj  = $userLoggedInObj;
    }
    public function create() {

    }
    public function getVideos() {
        $videos = array();
        $stmt   = $this->dbcon->prepare("SELECT * FROM 
                                            `videos` 
                                        WHERE 
                                            `uploadDate` >= now() - INTERVAL 7 DAY 
                                        ORDER BY 
                                            `views` 
                                        DESC
                                        LIMIT
                                            15");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $video  = new video($this->dbcon, $row, $this->userLoggedInObj);
            array_push($videos, $video);
        }
        return $videos;
    }
}
?>