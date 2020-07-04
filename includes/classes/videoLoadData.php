<?php
class videoLoadData {
    public $videoDataArray, $title, $description, $privacy, $category, $uploadedBy;
    public function __construct($videoDataArray, $title, $description, $privacy, $category, $uploadedBy) {
        $this->videoDataArray   = $videoDataArray;
        $this->title            = $title;
        $this->description      = $description;
        $this->privacy          = $privacy;
        $this->category         = $category;
        $this->uploadedBy       = $uploadedBy;
    }
    public function updateDetails($dbcon, $videoId) {
        $stmt   = $dbcon->prepare("UPDATE 
                                        `videos` 
                                    SET 
                                        `title` = :title,
                                        `description`=:descrip,
                                        `privacy`=:privacy,
                                        `category`= :cg
                                    WHERE
                                        `id`=:vi");
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":descrip", $this->description);
        $stmt->bindParam(":privacy", $this->privacy);
        $stmt->bindParam(":cg", $this->category);
        $stmt->bindParam(":vi", $videoId);
        $stmt->execute();
        return $stmt->execute();
    }
}
?>