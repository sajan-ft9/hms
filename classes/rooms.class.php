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

    public function find_room($room_name) {
        $sql = "SELECT * FROM `rooms` WHERE room_name = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$room_name]);
        $result = $stmt->fetch();
        return $result;
    }

    public function find($id) {
        $sql = "SELECT * FROM `rooms` WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result;
    }

    public function addRoom($room_name, $room_type, $room_price, $total_rooms, $newFileName) {
        $sql = "INSERT INTO `rooms`(`room_name`, `room_type`, `room_price`, `total_rooms`, room_photo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$room_name, $room_type, $room_price, $total_rooms, $newFileName]);
    }

    public function updateRoom($room_name, $room_type, $room_price, $total_rooms, $newFileName, $id) {
        $sql = "UPDATE `rooms` SET room_name= ?, room_type = ?, room_price= ?, total_rooms = ?, room_photo = ? WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$room_name, $room_type, $room_price, $total_rooms, $newFileName, $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM rooms WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
    }

}