<?php 
class videoGrid {
    private $dbcon, $userLoggedInObj;
    private $largeMode = false;
    private $gridClass = "videoGrid";
    public function __construct($dbcon, $userLoggedInObj) {
        $this->dbcon            = $dbcon;
        $this->userLoggedInObj  = $userLoggedInObj;
    }
    public function create($videos, $title, $filter) {

        if ($videos == null) {
            $gridItems  = $this->generateItems();
        } else {
            $gridItems  = $this->generateItemsFromVideos($videos);

        }
        $header     = "";
        if ($title != null) {
            $header = $this->createGridHeader($title, $filter);
        }

        return "$header
                <div class='$this->gridClass'>
                    $gridItems
                </div>";
    }
    public function generateItems() {
        $stmt   = $this->dbcon->prepare("SELECT * FROM `videos` ORDER BY RAND() LIMIT 15;");
        $stmt->execute();
        $elementsHTML = "";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $video  = new video($this->dbcon, $row,  $this->userLoggedInObj);
            $item   = new videoGridItem($video,  $this->largeMode);
            $elementsHTML .= $item->create();

        }
        return $elementsHTML;
    }
    public function generateItemsFromVideos($videos) {
        $elementsHTML = "";
        foreach ($videos as $row) {
            $item           = new videoGridItem($row,  $this->largeMode);
            $elementsHTML  .= $item->create();

        }
        return $elementsHTML;
    }
    public function createGridHeader($title, $showFilter) {
        $filter = "";
        if ($showFilter) {
            $link   = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $urlArr = parse_url($link);
            $query  = $urlArr['query'];
            parse_str($query, $params);
            unset($params['orderBy']);
            $newQ   = http_build_query($params);

            $newUrl = basename($_SERVER['PHP_SELF']) . "?" . $newQ;
            $filter = "<div class='right '>
                            <span>OrderBy: &nbsp</span>
                            <a href='$newUrl&orderBy=views'>Views&nbsp</a>||
                            <a href='$newUrl&orderBy=uploadDate'>&nbspDate</a>
                        </div>";
        }
        $header = "<div class='videoGridHeader'>
                        <div class='left'>
                            $title
                        </div>
                        $filter
                    </div>";
        return $header;
    }
    public function createLarge($videos, $title, $showFilter) {
        $this->gridClass    .= " large";
        $this->largeMode    = true;

        return $this->create($videos, $title, $showFilter);
    }
}

?>