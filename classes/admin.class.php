<?php 

class Admin extends Dbh {

    public function get($username) {
        $sql = "SELECT * FROM admin WHERE username = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$username]);
        $result = $stmt->fetch();
        return $result;
    }

    public function getAll(){
        $sql = "SELECT * FROM admin WHERE role != 'admin'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function addRole($username, $password, $role) {
        $sql = "INSERT INTO `admin`(`username`, `password`, `role`) VALUES (?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$username, $password, $role]);
    }

}