<?php

require_once "dbh.class.php";

class Rooms extends Dbh {

    public function getAll() {
        $sql = "SELECT * FROM rooms";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        while($result = $stmt->fetchAll()) {
            return $result;
        }
    }

    public function find($room_num) {
        $sql = "SELECT * FROM `rooms` WHERE room_num = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$room_num]);
        $result = $stmt->fetch();
        return $result;
    }

    public function addRoom($room_num, $room_type, $price, $av_room) {
        $sql = "INSERT INTO `rooms`(`room_num`, `room_type`, `room_price`, `available_rooms`) VALUES (?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$room_num, $room_type, $price, $av_room]);
    }

    public function updateRoom($room_num, $room_type, $price, $av_room) {
        $sql = "UPDATE `rooms` SET room_type= ?, room_price= ?, available_rooms = ? WHERE room_num = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$room_type, $price, $av_room, $room_num]);
    }

    public function delete($id) {
        $sql = "DELETE FROM rooms WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
    }

}