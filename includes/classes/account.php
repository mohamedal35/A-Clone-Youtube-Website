<?php 
require_once "sendActiveCode.php";
class account {
    private $dbcon;
    public $errorArr = array();
    public function __construct($dbcon) {
        $this->dbcon = $dbcon;
    }
    public function register($fn, $ln, $username, $email, $email2, $pass, $pass2, $activationCode) {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateUsername($username);
        $this->validateEmail($email, $email2);
        $this->validatePass($pass, $pass2);

        if (empty($this->errorArr)) {
            return $this->insertUserDetails($fn, $ln, $username, $email, $pass, $activationCode);
        } else {
            return false;
        }
    }
    public function insertUserDetails($fn, $ln, $un, $em, $pw, $ac) {
        $pw         = hash("sha512", $pw);
        $profilePic = "assets/images/profilepictures/default.png";
        $stmt       = $this->dbcon->prepare("INSERT INTO 
                                                `users`(`firstName`, `lastName`, `username`, `email`, `password`, `wasActived`, `activeCode`, `profilePic`) 
                                            VALUES 
                                                (:fn, :ln, :un, :em, :pw, \"FALSE\", :ac,:pp)");
        $stmt->bindParam(":fn", $fn);
        $stmt->bindParam(":ln", $ln);
        $stmt->bindParam(":un", $un);
        $stmt->bindParam(":em", $em);
        $stmt->bindParam(":ac", $ac);
        $stmt->bindParam(":pw", $pw);
        $stmt->bindParam(":pp", $profilePic);
        
        $sendActiveCode     = new sendActiveCode();
        $sendActiveCode->send($fn, $ln, $ac, $em, $un);

        return $stmt->execute();
    }
    private function validateFirstName($fn) {
        if(strlen($fn) > 25 || strlen($fn) < 2) {
            array_push($this->errorArr, constants::$firstNameCharacters);
        }
    }
    private function validateLastName($fn) {
        if(strlen($fn) > 25 || strlen($fn) < 2) {
            array_push($this->errorArr, constants::$lastNameCharacters);
        }
    }
    private function validateUsername($username) {
        if(strlen($username) > 25 || strlen($username) < 5) {
            array_push($this->errorArr, constants::$lastNameCharacters);
            return;
        }

        $stmt   = $this->dbcon->prepare("SELECT username FROM `users` WHERE `username` = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        if ($stmt->rowCount() != 0) {

            array_push($this->errorArr, constants::$usernameDBug);

        }

    }
    private function validateEmail($em, $em2) {
        if($em != $em2) {
            array_push($this->errorArr, constants::$emailMatch);
            return;
        }
        if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArr, constants::$emailValidation);
            return;
        }
        $stmt   = $this->dbcon->prepare("SELECT email FROM `users` WHERE `email` = :em");
        $stmt->bindParam(":em", $em);
        $stmt->execute();

        if ($stmt->rowCount() != 0) {

            array_push($this->errorArr, constants::$emailTaken);

        }

    }
    private function validateNewEmail($em, $un) {
        if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArr, constants::$emailValidation);
            return;
        }
        $stmt   = $this->dbcon->prepare("SELECT email FROM `users` WHERE `email` = :em AND `username` != :un");
        $stmt->bindParam(":em", $em);
        $stmt->bindParam(":un", $un);
        $stmt->execute();

        if ($stmt->rowCount() != 0) {

            array_push($this->errorArr, constants::$emailTaken);

        }
    }
    private function validatePass($pw, $pw2) {
        if($pw != $pw2) {
            array_push($this->errorArr, constants::$passMatch);
            return;
        }
        if (preg_match("/[^A-Za-z0-9]/",$pw)) {
            array_push($this->errorArr, constants::$passPower);
            return;
        }
        if (empty($pw)) {
            array_push($this->errorArr, constants::$passEmpty);
            return;
        }
    }
    public function login($un, $pw) {
        $pw     = hash("sha512", $pw);
        $stmt   = $this->dbcon->prepare("SELECT * FROM `users` WHERE `username` = :us AND `password` = :pw;");
        $stmt->bindParam(":us", $un);
        $stmt->bindParam(":pw", $pw);
        $stmt->execute();
        $data   = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() == 1 && $data['wasActived'] == "TRUE") {
            return true;
        } else {
            if ($data['wasActived'] == "FALSE") {
                array_push($this->errorArr, constants::$verficationErr);
            } else {
                array_push($this->errorArr, constants::$loginErr);
            }
            return false;
        }
    }
    public function getError($err) {
        if (in_array($err, $this->errorArr)) {
            return "<span class='errmsg alert alert-danger'>$err</span>";
        }
    }
    public function updateDetails($fn, $ln, $em, $un) {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateNewEmail($em, $un);
        if (empty($this->errorArr)) {
            $stmt   = $this->dbcon->prepare("UPDATE 
                                                `users` 
                                            SET 
                                                `firstName` = :fn 
                                            , 
                                                `lastName` = :ln 
                                            , 
                                                `email` = :em 
                                            WHERE `username` = :un");
            $stmt->bindParam(":fn", $fn);
            $stmt->bindParam(":ln", $ln);
            $stmt->bindParam(":em", $em);
            $stmt->bindParam(":un", $un);
            $stmt->execute();
            return true;
        } else {
            return false;
        }
    }
    public function getFirstErr() {
        if (!empty($this->errorArr)) {
            return $this->errorArr[0];
        } else {
            return "";
        }
    }
    private function valideteOldPassword($op, $un) {
        $pw     = hash("sha512", $op);
        $stmt   = $this->dbcon->prepare("SELECT * FROM `users` WHERE `username` = :us AND `password` = :pw");
        $stmt->bindParam(":us", $un);
        $stmt->bindParam(":pw", $pw);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            array_push($this->errorArr, constants::$wrongOP);
        } else {
            return true;
        }
    }
    public function updatePassword($op, $np, $cp, $un) {
        $this->validatePass($np, $cp);
        $this->valideteOldPassword($op, $un);
        if (empty($this->errorArr)) {
            $pw     = hash("sha512", $np);
            $stmt   = $this->dbcon->prepare("UPDATE 
                                                `users` 
                                            SET 
                                                `password` = :pw 
                                            WHERE `username` = :un");
            $stmt->bindParam(":pw", $pw);
            $stmt->bindParam(":un", $un);
            
            return $stmt->execute();
        } else {
            return false;
        }
    }
    public function verifyAccount($vc) {
        $stmt   = $this->dbcon->prepare("SELECT * FROM `users` WHERE `activeCode` = :ac;");
        $stmt->bindParam(":ac", $vc);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $stmt   = $this->dbcon->prepare("UPDATE `users` SET `wasActived` = 'TRUE' WHERE `activeCode` = :ac;");
            $stmt->bindParam(":ac", $vc);
            $stmt->execute();
            return true;
        } else {
            return false;
        }
    }
}
?>