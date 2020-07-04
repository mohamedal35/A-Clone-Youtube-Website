<?php 
    class videoPlayer {
        private $video;
        public function __construct($video) {
            $this->video    = $video;
        }
        public function create($autoplay) {
            if ($autoplay) {
                $autoplay   = "autoplay";
            } else {
                $autoplay   = "";
            }
            $filePath       = $this->video->getFilePath();
            return "<video class='videoPlayer' controls $autoplay>
                        <source src='$filePath'>
                        Your Browser Doesn't Support Video tag
                    </video>";
        }
    }
?>