<?php 
    include_once "layout/header.php";
    require_once "../includes/init.php";

    $rooms = new Rooms();
    if($rooms->find($_GET['id']) == 0) {
        echo "<script>alert('No such room'); window.location = 'index.php';</script>";
        die;
    }
   
    $room = $rooms->find($_GET['id']);

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        if(isset($_POST['editRoom'])) {
            
            $err = "";
            $room_num = intval(clean($_POST['room_num']));
            $room_type = clean($_POST['room_type']);
            $price = clean($_POST['price']);
            $av_room = clean($_POST['available']);

            if(empty($room_num)) {
                $err .= "Room number required<br>";
            }else{
                if( $room['room_num'] != $room_num ){
                    if($rooms->find_room($room_num) > 0 ){
                        $err .= "Room number already exists.<br>";
                    }
                }
                if($room_num < 0){
                  $err .= "Room number cannot be negative.<br>";
                }
                elseif($room_num > 100000000) {
                  $err .= "No valid room number<br>";
                }
            }    

            if(empty($room_type)) {
                $err .= "Room type cannot be empty";
            }else{
                if(!preg_match("/^[a-zA-Z0-9- ]{3,50}$/", $room_type)) {
                    $err .= "Must be alphanumeric 3-50 chars<br>";
                }
            }

            if(empty($price)) {
                $err .= "Price required.<br>";
            }else{
                if($price < 0){
                  $err .= "Price cannot be negative.<br>";
                }
                elseif($price > 100000000) {
                  $err .= "Expensive. Try lowering price<br>";
                }
            }

            if(empty($av_room)) {
                $err .= "Available rooms required<br>";
            }else{
                if($av_room < 0){
                  $err .= "Available rooms cannot be negative.<br>";
                }elseif($av_room > 10) {
                  $err .= "Available rooms cannot be more than 10.<br>";
                }
            }

            if(empty($err)) {
                $rooms->updateRoom($room_num, $room_type, $price, $av_room);
                echo "<script>window.location = 'index.php'</script>";
                die;
            }
            else{
                echo "<p style='color:red;'>Error: $err </p>";
            }

        }
    }    


?>

<h2><u>Update Room</u></h2>

<form action="editRoom.php?id=<?=$room['id']?>" method="POST">
            <div class="form-group">
                <label for="">Room No.</label>
                <input type="number" name="room_num" class="form-control" value="<?=$room['room_num']?>" required>
                <label for="">Room Type</label>
                <input type="text" name="room_type" class="form-control" value="<?=$room['room_type']?>" required>            
                <label for="">Price</label>
                <input type="number" step=".01" name="price" class="form-control" value="<?=$room['room_price']?>" required>
                <label for="">Available Rooms</label>
                <input type="number" name="available" class="form-control" value="<?=$room['available_rooms']?>" required>
                <button class="form-control btn btn-outline-info mt-2" type="submit" name="editRoom">Update</button>
            </div>
</form>                


<?php include_once "layout/footer.php"; ?>