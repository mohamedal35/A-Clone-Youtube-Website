<?php 
    class user {
        private $dbcon, $sqlData;
        public function __construct($dbcon, $un) {
            $this->dbcon    = $dbcon;
            $stmt           = $this->dbcon->prepare("SELECT * FROM `users` WHERE `username` = :un");
            $stmt->bindParam(":un", $un);
            $stmt->execute();

            $this->sqlData        = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function getUsername() {
            return $this->sqlData['username'];
        }
        public static function isLoggedIn() {
            return isset($_SESSION['userLoggedIn']);
        }
        public function getName() {
            return $this->sqlData['firstName'] . " " . $this->sqlData['lastName'];
        }
        public function getFirstName() {
            return $this->sqlData['firstName'];
        }
        public function getLastName() {
            return $this->sqlData['lastName'];
        }
        public function getEmail() {
            return $this->sqlData['email'];
        }
        public function getSignUpDate() {
            return $this->sqlData['signUpDate'];
        }
        public function getProfilePic() {
            return $this->sqlData['profilePic'];
        }
        public function isSubscribedTo($userTo) {
            $stmt   = $this->dbcon->prepare("SELECT * FROM `subscribers` WHERE `userTo` = :userTo AND `userFrom` = :userFrom");
            $stmt->bindParam(":userTo", $userTo);
            $stmt->bindParam(":userFrom", $this->getUsername());
            $stmt->execute();

            return $stmt->rowCount() > 0;
        }
        public function getSubscriberCount() {
            $stmt   = $this->dbcon->prepare("SELECT * FROM `subscribers` WHERE `userTo` = :userTo");
            $stmt->bindParam(":userTo", $this->getUsername());
            $stmt->execute();
            return $stmt->rowCount();
        }
        public function getSubsribtions() {
            $username   = $this->getUsername();
            $stmt   = $this->dbcon->prepare("SELECT userTo FROM `subscribers` WHERE userFrom = :uf;");
            $stmt->bindParam(":uf", $username);
            $stmt->execute();
            $subs   = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // $user   = new user($this->dbcon, $row['userTo']);
                array_push($subs, $row['userTo']);
            }
            return $subs;
        }
    }
?>