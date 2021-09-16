<?php 
include_once "layout/header.php";
require_once "../includes/init.php";
if($_SESSION['role'] === 'admin'){
$rooms = new Rooms();
$roomNumber = new RoomNumber();

if($roomNumber->find_room($_GET['id']) == 0) {
    echo "<script>alert('No such room'); window.location = 'roomnumber.php';</script>";
    die;
}

$old_room = $roomNumber->find_room($_GET['id']);

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['roomTypeChange'])) {
        
        $err = "";
        $roomnumber = $_GET['id'];
        $roomtype = clean($_POST['roomtype']);
        $isempty = clean($_POST['isempty']);

        if(empty($roomtype)) {
            $err .= "Room type cannot be empty";
        }else{
            if(!preg_match("/^[a-zA-Z0-9- ]{3,50}$/", $roomtype)) {
                $err .= "Room type must be alphanumeric - 3-50 chars<br>";
            }
        }

        if(empty($err)) {

            $roomNumber->updateRoomNumber($roomtype, $isempty, $roomnumber);

            echo "<script>window.location.replace('roomnumber.php')</script>";
            die;
        }else{
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
<h2><u>Update Room Type</u></h2>
<h3 class="text-center">Room No. <?=$old_room['roomnumber']?></h3>

<form action="editRoomNumber.php?id=<?=$old_room['roomnumber']?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="">Room Type</label>
                <select class="form-control" name="roomtype" required>
                    <?php 
                      if($rooms->getAll() > 0):
                        foreach($rooms->getAll() as $room):?>
                            <option value="<?=$room['room_type']?>" <?php echo $old_room['roomtype'] == $room['room_type'] ? "selected" : "" ?>><?=$room['room_type']?></option>
                        <?php
                        endforeach;
                      endif;
                    ?>
                </select>    
                <label for="">Status</label>
                <select class="form-control" name="isempty" required>
                    <option value="true" <?=$old_room['isempty']== "true" ? "selected" : ""?>>Available</option>
                    <option value="false" <?=$old_room['isempty']== "false" ? "selected" : ""?>>Booked</option>
                </select>      
            </div>
            <div class="modal-footer">
                <a href="roomnumber.php" type="button" class="btn btn-secondary">Close</a>
                <button type="submit" name="roomTypeChange" class="btn btn-success">Save changes</button>
            </div>      
        </form>

<?php include_once "layout/footer.php"; 
}else{
    header("location:roomnumber.php");
    die;
}?>