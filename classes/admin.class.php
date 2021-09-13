<?php 

class Admin extends Dbh {

    public function get($username) {
        $sql = "SELECT * FROM admin WHERE username = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$username]);
        $result = $stmt->fetch();
        return $result;
    }

}