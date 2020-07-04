<?php 
    require_once "../config.php";
    if (isset($_POST['userTo']) && isset($_POST['userFrom'])) {
        $userTo     = $_POST['userTo'];
        $userFrom   = $_POST['userFrom'];
        # Check If Subbed
        $stmt       = $dbcon->prepare("SELECT * FROM `subscribers` WHERE `userFrom` = :userFrom AND `userTo` = :userTo");
        $stmt->bindParam(":userFrom", $userFrom);
        $stmt->bindParam(":userTo", $userTo);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            // Insert
            $stmt       = $dbcon->prepare("INSERT INTO `subscribers`(`userFrom`, `userTo`) VALUES (:userFrom,:userTo);");
            $stmt->bindParam(":userFrom", $userFrom);
            $stmt->bindParam(":userTo", $userTo);
            $stmt->execute();
        } else {
            // Delete
            $stmt       = $dbcon->prepare("DELETE FROM `subscribers` WHERE `userFrom` = :userFrom AND `userTo` = :userTo");
            $stmt->bindParam(":userFrom", $userFrom);
            $stmt->bindParam(":userTo", $userTo);
            $stmt->execute();
        }
        $stmt       = $dbcon->prepare("SELECT * FROM `subscribers` WHERE `userTo` = :userTo");
        $stmt->bindParam(":userTo", $userTo);
        $stmt->execute();
        $numOfSubscribers = $stmt->rowCount();
        echo $numOfSubscribers;
    } else {
        echo "Parametars Doesn't Pass";
        exit;
    }
?>