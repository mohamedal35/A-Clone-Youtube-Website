<?php 
class getThumbnails {
    private $dbcon, $video;
    public function __construct($dbcon, $video) {
        $this->dbcon    = $dbcon;
        $this->video    = $video;
    }
    public function create() {
        $thumbnailData  = $this->getThumbnailsData();

        $html   = "";
        foreach($thumbnailData as $thumbnail) {
            $html   .= $this->createThumbnailItem($thumbnail);
        }
        return "<div class='thumbnailItemContainer'>
                    $html
                </div>";
    }
    private function createThumbnailItem($data) {
        $id     = $data['id'];
        $url    = $data['filePath'];
        $videoId= $data['videoId'];
        $selected= ($data['selected'] == 1) ? "selected" : "";
        
        return "<div class='thumbnailItem $selected' onclick='setThumbnail($id, $videoId, this)'>
                    <img src='$url'>
                </div>";
    }
    public function getThumbnailsData() {
        $data   = array();
        $videoId= $this->video->getId();
        $stmt   = $this->dbcon->prepare("SELECT * FROM `thumbnails` WHERE `videoId` = :vi");
        $stmt->bindParam(":vi", $videoId);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
}

?>