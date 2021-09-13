<?php 
include_once "layout/header.php";

    $rooms = new Rooms();
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        if(isset($_POST['insert'])) {
            
            $err = "";
            $room_num = clean($_POST['room_num']);
            $room_type = clean($_POST['room_type']);
            $price = clean($_POST['price']);
            $av_room = clean($_POST['available']);

            if(empty($room_num)) {
                $err .= "Room number required<br>";
            }else{
                if($rooms->find_room($room_num) > 0 ){
                    $err .= "Room number already exists.<br>";
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
                    $err .= "Room type must be alphanumeric - 3-50 chars<br>";
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
                // $rooms->addRoom($room_num, $room_type, $price, $av_room);
            }
            else{
                echo "<p style='color:red;'>Error: $err </p>";
            }

        }
    }    

?>

<h2><u>Dashboard</u></h2>
index
<?php include_once "layout/footer.php" ?>
