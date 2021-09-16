<?php

class RoomNumber extends Dbh {

    public function getAll() {
        $sql = "SELECT * FROM roomnumber";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        while($result = $stmt->fetchAll()) {
            return $result;
        }
    }

    public function getAllJoined() {
        $sql = "SELECT * FROM `roomnumber` INNER JOIN rooms where roomnumber.roomtype = rooms.room_type";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        while($result = $stmt->fetchAll()) {
            return $result;
        }
    }

    public function find_room($room_num) {
        $sql = "SELECT * FROM `roomnumber` WHERE roomnumber = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$room_num]);
        $result = $stmt->fetch();
        return $result;
    }

    public function addRoomNumber($room_num, $room_type) {
        $sql = "INSERT INTO `roomnumber`(`roomnumber`, `roomtype`, `isempty`) VALUES (?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$room_num, $room_type, "true"]);
    }

    public function updateRoomNumber($roomtype, $isempty, $roomnumber) {
        $sql = "UPDATE `roomnumber` SET roomtype= ?, isempty = ? WHERE roomnumber = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$roomtype, $isempty, $roomnumber]);
    }

    public function toggleBook($book, $roomnumber){
        $sql = "UPDATE `roomnumber` SET isempty = ? WHERE roomnumber = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$book, $roomnumber]);
    }

    public function delete($roomnumber) {
        $sql = "DELETE FROM roomnumber WHERE roomnumber = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$roomnumber]);
    }

    public function Available(){
        
    }


}