<?php 
    include_once "layout/header.php";
    require_once "../includes/init.php";

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
                $rooms->addRoom($room_num, $room_type, $price, $av_room);
            }
            else{
                echo "<p style='color:red;'>Error: $err </p>";
            }

        }
    }    

?>

<h2><u>Dashboard</u></h2>

<!-- Button trigger modal -->
<div class="text-center">
    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#roomsModal">
        Add Rooms
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="roomsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Rooms</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <div class="form-group">
                <label for="">Room No.</label>
                <input type="number" name="room_num" class="form-control" required>
                <label for="">Room Type</label>
                <input type="text" name="room_type" class="form-control" required>            
                <label for="">Price</label>
                <input type="number" step=".01" name="price" class="form-control" required>
                <label for="">Available Rooms</label>
                <input type="number" name="available" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="insert" class="btn btn-success">Save changes</button>
            </div>      
        </form>
      </div>
      
    </div>
  </div>
</div>

<div class="mt-2">
    <h4>All Rooms</h4>
    <table class="table table-striped table-dark">
  <thead>
    <tr>
      <th scope="col">Room No.</th>
      <th scope="col">Room Type</th>
      <th scope="col">Price</th>
      <th scope="col">Available Rooms</th>
      <th colspan="2" scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
      <?php 
        if($rooms->getAll() > 0):
            foreach($rooms->getAll() as $room): ?>
                 <tr>
                    <th scope="row"><?=$room['room_num']?></th>
                    <td><?=$room['room_type']?></td>
                    <td><?=$room['room_price']?></td>
                    <td><?=$room['available_rooms']?></td>
                    <td><a class="btn btn-warning" href="editRoom.php?id=<?=$room['id']?>">Edit</a></td>
                    <td><a class="btn btn-danger" href="delete.process.php?send=del&id=<?=$room['id']?>" onClick="return confirm('Do you want to delete??')">Delete</a></td>
                </tr>
        <?php
            endforeach;
        else:
        ?>
        <div class="alert alert-danger" role="alert">
            No rooms added.
        </div>
        <?php
        endif;
       ?>
  </tbody>
</table>
</div>

<?php include_once "layout/footer.php" ?>
