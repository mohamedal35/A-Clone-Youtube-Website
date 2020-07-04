<?php 
class subscriptionsProvider {
    private $dbcon, $userLoggedInObj;
    public function __construct($dbcon, $userLoggedInObj) {
        $this->dbcon    = $dbcon;
        $this->userLoggedInObj  = $userLoggedInObj;
    }
    public function getVideos() {
        $videos          = array();
        $subscriptions   = $this->userLoggedInObj->getSubsribtions();
        if (sizeof ($subscriptions)> 0) {
            $condition  = "";
            $i          = 0;
            while($i < sizeof($subscriptions)) {
                if ($i == 0) {
                    $condition .= "WHERE `uploaded_by` = ?";

                } else {
                    $condition  .= " OR `uploaded_by` = ?";
                }
                $i++;
            }
            $videosSql  = $this->dbcon->prepare("SELECT * FROM `videos` $condition ORDER BY uploadDate DESC");
            $i          = 1;
            // foreach($subscriptions as $sub) {
            //     $subUsername    = $sub->getUsername();
            //     $videosSql->bindValue($i, $subUsername);
            //     $i++;
            // }
            $videosSql->execute($subscriptions);
            while ($row = $videosSql->fetch(PDO::FETCH_ASSOC)){
                $video  = new video($this->dbcon, $row, $this->userLoggedInObj);
                array_push($videos, $video);
            }
        }

        return $videos;
    }
}

?>