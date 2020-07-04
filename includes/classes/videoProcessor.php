<?php 
    class videoProcessor {
        private $dbcon;
        private $ffmpegRoute;
        private $ffrobeRout;
        private $allowTypes = array("mp4", "flv", "webm", "mkv", "vob", "ogv", "ogg", "avi", "wmv", "mov", "mpeg", "mpg");
        public function __construct($dbcon) {
            $this->dbcon       = $dbcon;
            $this->ffmpegRoute = realpath("ffmpeg/ffmpeg");
            $this->ffrobeRout  = realpath("ffmpeg/ffprobe");
        }
        public function upload($videoUploadData) {

            $targetDir = "uploads/videos/";
            $videoData = $videoUploadData->videoDataArray;
            $tempFilePath   = $targetDir . uniqid() . basename($videoData['name']);
            $tempFilePath   = str_replace(" ", "_", $tempFilePath);
            // Checking Data
            $isValidData    = $this->processData($videoData, $tempFilePath);

            if (!$isValidData) {
                return false;
            }
            if (move_uploaded_file($videoData['tmp_name'], $tempFilePath)) {
                $finalFilePath = $targetDir . uniqid() . ".mp4";
                if (!$this->insertVideoData($videoUploadData, $finalFilePath)) {
                    echo "Insert Query Failed";
                    return false;
                }
                if (!$this->convertVideoToMp4($tempFilePath, $finalFilePath)) {
                    echo "Upload Failed";
                    return false;
                }
                if (!$this->deleteFile($tempFilePath)) {
                    echo "Deleting File Process Failed";
                    return false;
                }
                if (!$this->generateThumbnails($finalFilePath)) {
                    echo "Couldn't Generate Thumbnails";
                    return false;
                }
                return true;
            }
        }
        private function processData($videoData, $filePath) {
            $videoType = pathinfo($filePath, PATHINFO_EXTENSION);
            if (!$this->isValidSize($videoData)) {
                echo "File Too Large Can't Be More Than 1.5GB";
                return false;
            }
            elseif (!$this->isValidType($videoType)) {
                echo "Invalid Video Type";
                return false;
            }
            elseif ($this->hasError($videoData)) {
                echo "Error Code : " . $videoData['error'];
                return false;
            }
            return true;
        }
        private function isValidSize($Data) {
            return $Data['size'] <= (1.5 * GB);
        }
        private function isValidType($type) {
            $lowerCase = strtolower($type);
            return in_array($lowerCase, $this->allowTypes);
        }
        private function hasError($data) {
            return $data['error'] != 0;
        }
        private function insertVideoData($uploadData, $filePath) {
            $stmt = $this->dbcon->prepare("INSERT INTO 
                                                `videos` (`uploaded_by`, `title`, `description`, `privacy`, `filePath`, `category`) 
                                            VALUES 
                                                (:uploadedBy, :title, :description, :privacy, :filePath, :category)");
            $stmt->bindParam(":uploadedBy", $uploadData->uploadedBy);
            $stmt->bindParam(":title", $uploadData->title);
            $stmt->bindParam(":description", $uploadData->description);
            $stmt->bindParam(":privacy", $uploadData->privacy);
            $stmt->bindParam(":filePath", $filePath);
            $stmt->bindParam(":category", $uploadData->category);

            return $stmt->execute();
        }
        public function convertVideoToMp4($tempFilePath, $finalFilePath) {
            $cmd        = "$this->ffmpegRoute -i $tempFilePath $finalFilePath 2>&1";
            $outputLog  = array();
            exec($cmd, $outputLog, $returnCode);
            if ($returnCode != 0) {
                // Command Failed
                foreach ($outputLog as $line) {
                    echo "$line <br />";
                }
                return false;
            }
            return true;
        }
        private function deleteFile($filePath) {
            if (!unlink($filePath)) {
                echo "Couldn't Delete Original File";
                return false;
            }
            return true;
        }
        public function generateThumbnails($filePath){
            $thumbnailSize  = "210x118";
            $numThumbnails  = 3;
            $pathToThumbnail= "uploads/thumbnails";
            $videoId        = $this->dbcon->lastInsertId();
            $duration       = $this->getVideoDuration($filePath);

            $this->updateDuration($duration, $videoId);
            for ($num = 1; $num <= $numThumbnails; $num++){
                $imageName = uniqid() . ".jpg";
                $interval  = ($duration * .8) / $numThumbnails * $num;
                $fullThumbnailPath = "$pathToThumbnail/$videoId-$imageName";
                $selected = ($num == 1) ? 1 : 0;

                $cmd        = "$this->ffmpegRoute -i $filePath -ss $interval -s $thumbnailSize -vframes 1 $fullThumbnailPath 2>&1";
                $outputLog  = array();
                exec($cmd, $outputLog, $returnCode);
                if ($returnCode != 0) {
                    // Command Failed
                    foreach ($outputLog as $line) {
                        echo "$line <br />";
                    }
                }
                $stmt = $this->dbcon->prepare("INSERT INTO `thumbnails`(`videoId`, `filePath`, `selected`) VALUES (:videoId, :filePath, :selected)");
                $stmt->bindParam(":videoId", $videoId);
                $stmt->bindParam(":filePath", $fullThumbnailPath);
                $stmt->bindParam(":selected", $selected);

                $success = $stmt->execute();
                if (!$success) {
                    echo "Error Inserting Thumbnails";
                    return false;
                }
            }
            return true;
        }
        private function getVideoDuration($filePath) {
            return (int)shell_exec("$this->ffrobeRout -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 $filePath");
        }
        private function updateDuration($duration, $videoId) {
            $hours  = floor($duration/ 3600);
            $mins   = floor(($duration - ($hours*3600)) / 60);
            $secs   = floor($duration % 60);

            $hours = ($hours < 1) ? "" : $hours . ":";
            $mins  = ($mins < 10) ? "0" . $mins . ":" : $mins . ":";
            $secs  = ($secs < 10) ? "0" . $secs : $secs;
            
            $duration = $hours.$mins.$secs;

            $stmt = $this->dbcon->prepare("UPDATE `videos` SET duration = :duration WHERE id = :videoId");
            $stmt->bindParam(":duration", $duration);
            $stmt->bindParam(":videoId", $videoId);
            $stmt->execute();
        }
    }
?>