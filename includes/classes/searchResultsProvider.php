<?php 
class searchResultsProvider {
    private $dbcon, $userLoggedInObj;
    public function __construct($dbcon, $userLoggedInObj) {
        $this->dbcon    = $dbcon;
        $this->userLoggedInObj  = $userLoggedInObj;
    }
    public function getVideos($searchQ, $orderBy) {
        $stmt   = $this->dbcon->prepare("SELECT * FROM `videos` 
                                        WHERE 
                                            (`title` LIKE CONCAT('%', :q, '%')) 
                                        OR 
                                            (`description` LIKE CONCAT('%', :q, '%'))
                                        OR
                                            (`uploaded_by` LIKE CONCAT('%', :q, '%'))
                                        ORDER BY $orderBy DESC");
        $stmt->bindParam(":q", $searchQ);
        $stmt->execute();
        $videos = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
            $video  = new video($this->dbcon, $row, $this->userLoggedInObj);
            array_push($videos, $video);
        }
        return $videos;
    }
}

?>