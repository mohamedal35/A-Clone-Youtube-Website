<?php 
class profileData {
    private $dbcon, $profUserObj;

    public function __construct($dbcon, $profUsername) {
        $this->dbcon            = $dbcon;
        $this->profUserObj      = new user($this->dbcon, $profUsername);

    }
    public function getProfileUsername() {
        return $this->profUserObj->getUsername();
    }
    public function getProfileUserObj() {
        return $this->profUserObj;
    }
    public function userExists() {
        $profUsername   = $this->profUserObj->getUsername();
        $stmt   = $this->dbcon->prepare("SELECT * FROM `users` WHERE username = :un");
        $stmt->bindParam(":un", $profUsername);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    public function getCoverPhoto() {
        return "assets/images/coverPhotos/default-cover-photo.jpg";
    }
    public function getProfileFullName() {
        return $this->profUserObj->getName();
    }
    public function getProfileImage() {
        return $this->profUserObj->getProfilePic();
    }
    public function getSubCount() {
        return $this->profUserObj->getSubscriberCount();
    }
    public function getUserVideos() {
        $username   = $this->profUserObj->getUsername();
        $stmt       = $this->dbcon->prepare("SELECT * FROM `videos` WHERE `uploaded_by` = :ub");
        $stmt->bindParam(":ub", $username);
        $stmt->execute();
        $videos     = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $video  = new video($this->dbcon, $row, $username);
            array_push($videos, $video);
        }
        return $videos;
    }
    public function getAllUserDetails() {
        return array(
            "Name" => $this->getProfileFullName(),
            "Username" => $this->getProfileUsername(),
            "Subscribers" => $this->getSubCount(),
            "Total Views"   => $this->getTotalViews(),
            "SignUp Date"   => $this->getSignUpDate()
        );
    }
    private function getTotalViews() {
        $stmt   = $this->dbcon->prepare("SELECT SUM(views) FROM `videos` WHERE `uploaded_by` = :ub;");
        $stmt->bindParam(":ub", $this->getProfileUsername());
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    private function getSignUpDate() {
        $signUpDate = $this->profUserObj->getSignUpDate();
        return date("F j, Y", strtotime($signUpDate));
    }

}
?>