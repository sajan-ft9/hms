<?php 
    include_once "layout/header.php";
    require_once "../includes/init.php";

    $rooms = new Rooms();
    if($_SESSION['role'] === "admin"){
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        if(isset($_POST['insert'])) {
            
            $err = "";
            $room_name = clean($_POST['room_name']);
            $room_type = clean($_POST['room_type']);
            $room_price = clean($_POST['room_price']);
            $total_rooms = clean($_POST['total_rooms']);
            $filename = $_FILES["room_photo"] ["name"];
            $tempname = $_FILES["room_photo"] ["tmp_name"];

            if(empty($room_name)) {
                $err .= "Room name required<br>";
            } else{
              if($rooms->find_room($room_name) > 0 ){
                  $err .= "Room name already exists.<br>";
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
              $rooms->addRoom($room_name, $room_type, $room_price, $total_rooms, $newFileName);
              move_uploaded_file($tempname, $fileDestination);
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
  } 

?>

<h2><u>Dashboard</u></h2>

<!-- Button trigger modal -->
<?php if($_SESSION['role'] === "admin"): ?>
<div class="text-center">
    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#roomsModal">
        Add Rooms
    </button>
</div>
<?php endif; ?>

<!-- Modal -->
<div class="modal fade" id="roomsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Rooms</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="">Room Name</label>
                <input type="text" name="room_name" class="form-control" required>
                <label for="">Room Type</label>
                <input type="text" name="room_type" class="form-control" required>            
                <label for="">Price</label>
                <input type="number" step=".01" name="room_price" class="form-control" required>
                <label for="">Total Rooms</label>
                <input type="number" name="total_rooms" class="form-control" required>
                <label for="">Photo of room</label><br>
                <input type="file" class="form-control" name="room_photo" required>
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
</div>   
<div class="row row-cols-1 row-cols-md-3 g-4 mt-2">
    <?php 
        $rooms = new Rooms();
        if($rooms->getAll() > 0): 
    ?>
        <?php foreach($rooms->getAll() as $room): ?>
            <div class="col">
                <div class="card">
                    <img src="uploads/<?=$room['room_photo']?>" class="card-img-top" alt="image" height="300px">
                    <div class="card-body">
                        <h5 class="card-title"><?=$room['room_name']?></h5>
                        <p class="card-text"><?=$room['room_type']?></p>
                        <p class="text-end">Price: <?=$room['room_price']?></p>
                        <p class="text-end">Total rooms: <?=$room['total_rooms']?></p>
                    </div>
                    <?php if($_SESSION['role'] === "admin"):?>
                    <div class="card-footer">
                        <small><a class="btn btn-warning" href="editRooms.php?id=<?=$room['id']?>">Edit</a></small>
                        <small><a class="btn btn-danger" href="delete.process.php?send=del&id=<?=$room['id']?>&name=<?=$room['room_photo']?>" onClick="return confirm('Do you want to delete??')">Delete</a></small>
                    </div>
                    <?php endif; ?>
                </div>
            </div>   
        <?php endforeach; ?>
        
    <?php
      else:
    ?>
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Alert: </strong> You should add some rooms first.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php
      endif;
    ?>
</div>



<?php include_once "layout/footer.php" ?>
