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
        while($result = $stmt->fetchAll()) {
            return $result;
        }
    }

    public function addRole($username, $password, $role) {
        $sql = "INSERT INTO `admin`(`username`, `password`, `role`) VALUES (?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$username, $password, $role]);
    }

    public function changePass($password, $username){
        $sql = "UPDATE admin SET password = ? WHERE username = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$password, $username]);
    }

    public function editStaffRole($role, $username){
        $sql = "UPDATE admin SET role = ? WHERE username = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$role, $username]);
    }

    public function delete($username){
        $sql = "DELETE FROM admin WHERE username = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$username]);
    }

    public function getReception(){
        $sql = "SELECT * FROM admin WHERE role = 'reception'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        while($result = $stmt->fetchAll()) {
            return $result;
        }
    }

}