<?php 
class videoGridItem {
    private $video, $largMode;
    public function __construct($video, $largMode) {
        $this->video    = $video;
        $this->largeMode= $largMode;
    }
    public function create(){
        $videoId    = $this->video->getId();
        $thumbnail  = $this->createThumbnail();
        $details    = $this->createDetails();
        $url        = "watch.php?id=".$videoId;
        return "<a href='$url' class='vida'>
                    <div class='videoGridItem'>
                        $thumbnail
                        $details
                    </div>
                </a>";
    }
    private function createThumbnail() {
        $thumbnail  = $this->video->getThumbnail();
        $duration   = $this->video->getDuration();
        return "<div class='thumbnail'>
                    <img src='$thumbnail' alt='Thumbnail Video'>
                    <div class='duration'>
                        <span>$duration</span>
                    </div>
                </div>";
    }    
    private function createDetails() {
        $title      = $this->video->getTitle();
        $Describtion= $this->createDesc();
        $uploadedBy = $this->video->getUploadedBy();
        $views      = $this->video->getViews();
        $uploadDate = $this->video->getUploadAgeDate();

        return "<div class='details'>
                    <h3 class='title'>$title</h3>
                    <span class='username'>$uploadedBy</span>
                    <div class='status'>
                        <span class='viewCount'>$views Views - </span>
                        <span class='timeStamp'>$uploadDate</span>
                    </div>
                    $Describtion
                </div>";
        
    }
    private function createDesc() {
        if (!$this->largeMode) {
            return "";
        }
        else {
            $Describtion    = $this->video->getDesc();
            return "<span class='describtion'>" . (($Describtion > 350) ? substr($Describtion, 0, 340) . "..." : $Describtion) . "</span>";

        }

    }
}
?>