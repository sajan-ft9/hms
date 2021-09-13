<?php 
    include_once "layout/header.php";
    require_once "../includes/init.php";

    $rooms = new Rooms();
    if($rooms->find($_GET['id']) == 0) {
        echo "<script>alert('No such room'); window.location = 'rooms.php';</script>";
        die;
    }
   
    $room = $rooms->find($_GET['id']);

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        if(isset($_POST['editRoom'])) {
            
            $err = "";
            $id = $_GET['id'];
            $room_name = clean($_POST['room_name']);
            $room_type = clean($_POST['room_type']);
            $room_price = clean($_POST['room_price']);
            $total_rooms = clean($_POST['total_rooms']);
            $filename = $_FILES["room_photo"] ["name"];
            $tempname = $_FILES["room_photo"] ["tmp_name"];
            $img_del = $_POST['del_img'];


            if(empty($room_name)) {
                $err .= "Room name required<br>";
            } else{
                if( $room['room_name'] != $room_name ){
                    if($rooms->find_room($room_name) > 0 ){
                    $err .= "Room name already exists.<br>";
                    }
                }    
              if(!preg_match("/^[a-zA-Z0-9- ]{3,50}$/", $room_name)) {
                $err .= "Room name must be alphanumeric - 3-50 chars<br>";
              }
            }  

            if(empty($room_type)) {
                $err .= "Room type cannot be empty";
            }else{
                if(!preg_match("/^[a-zA-Z0-9- ]{3,50}$/", $room_type)) {
                    $err .= "Room type must be alphanumeric - 3-50 chars<br>";
                }
            }

            if(empty($room_price)) {
              $err .= "Price required.<br>";
          }else{
              if($room_price < 0){
                $err .= "Price cannot be negative.<br>";
              }
              elseif($room_price > 100000000) {
                $err .= "Expensive. Try lowering price<br>";
              }
          }

            if(empty($total_rooms)) {
                $err .= "Total rooms required<br>";
            }
            else{
              if($total_rooms<0){
                $err.="Total rooms cannot be negative";
              }elseif($total_rooms > 20) {
                $err .= "Total rooms cannot be more than 20.<br>";
              }
            }

            if(empty($filename)) {
              $err .= "Image required<br>";
            }else {
              $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION)); //gives extension
              if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $err .= "Sorry, only JPG, JPEG, PNG files are allowed.<br>";
              }
            }

            if(empty($err)) {
                $newFileName = uniqid('', true) . "." . $imageFileType;
                $fileDestination = "uploads/".$newFileName;
            
                $rooms->updateRoom($room_name, $room_type, $room_price, $total_rooms, $newFileName, $id);
                
                move_uploaded_file($tempname, $fileDestination);
          
                unlink("uploads/$img_del");

                echo "<script>window.location.replace('rooms.php')</script>";
                die;
            }
            else{
                echo "
              <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Error:</strong> $err
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>
                ";
            }

        }
    }    


?>

<h2><u>Update Room</u></h2>

<form action="editRooms.php?id=<?=$room['id']?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <input type="hidden" name="del_img" value="<?=$room['room_photo']?>">
                <label for="">Room Name</label>
                <input type="text" name="room_name" class="form-control" value="<?=$room['room_name']?>" required>
                <label for="">Room Type</label>
                <input type="text" name="room_type" class="form-control" value="<?=$room['room_type']?>" required>            
                <label for="">Price</label>
                <input type="number" step=".01" name="room_price" class="form-control" value="<?=$room['room_price']?>" required>
                <label for="">Total Rooms</label>
                <input type="number" name="total_rooms" class="form-control" value="<?=$room['total_rooms']?>" required>
                <label for="">Photo of room</label><br>
                <input type="file" class="form-control" name="room_photo" required>
                <div class="modal-footer">
                    <a href="rooms.php" type="button" class="btn btn-secondary">Close</a>
                    <button type="submit" name="editRoom" class="btn btn-success">Save changes</button>
                </div>      
            </div>
</form>                


<?php include_once "layout/footer.php"; ?>