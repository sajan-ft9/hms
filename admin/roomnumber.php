<?php 
    include_once "layout/header.php";
    require_once "../includes/init.php";
  
    $rooms = new Rooms();
    $roomNumber = new RoomNumber();

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        if(isset($_POST['roomNoAdd'])) {
            
            $err = "";
            $room_num = clean($_POST['roomnumber']);
            $roomtype = clean($_POST['roomtype']);
        
            if(empty($room_num)) {
                $err .= "Room number required<br>";
            }else{
                if($roomNumber->find_room($room_num) > 0 ){
                    $err .= "Room number already exists.<br>";
                }
                if($room_num < 0){
                  $err .= "Room number cannot be negative.<br>";
                }
                elseif($room_num > 100000000) {
                  $err .= "Not valid room number<br>";
                }
            }  

            if(empty($err)) {

                $roomNumber->addRoomNumber($room_num, $roomtype);

            }else{
                echo "
                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                  <strong>Error:</strong> $err
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                  ";
            }

        }


        if(isset($_POST['toggleBook'])) {
        
          $err = "";
          $book = $_POST['book'];
          $roomnumber = $_POST['roomnumber'];
          if(empty($book)){
            $err .= "Empty.<br>";
          }
          if(empty($roomnumber)){
            $err .= "Empty.<br>";
          }
          if(empty($err)){
            $roomNumber->toggleBook($book, $roomnumber);
            echo "<script>window.location.replace('reloader.php?loc=roomnumber.php')</script>";
            die;
          }
          else{
            echo $err;
          }
      }
    }        

?>

<h2><u>Dashboard</u></h2>

<!-- Admin -->
<?php
if($_SESSION['role'] === 'admin'):
?>
<!-- Button trigger modal -->
<div class="text-center">
    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#roomNumber">
        Add Room Number
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="roomNumber" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Room Number</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="">Room Number</label>
                <input type="number" name="roomnumber" class="form-control" required>
                <label for="">Room Type</label>
                <select class="form-control" name="roomtype" required>
                    <option value="">Select Room Type</option>
                    <?php 
                      if($rooms->getAll() > 0):
                        foreach($rooms->getAll() as $room):?>
                            <option value="<?=$room['room_type']?>"><?=$room['room_type']?></option>
                        <?php
                        endforeach;
                      endif;
                    ?>
                </select>          
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="roomNoAdd" class="btn btn-success">Save changes</button>
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
      <th scope="col">Available</th>
      <th colspan="2" scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
      <?php 
        if($roomNumber->getAll() > 0):
            foreach($roomNumber->getAll() as $room): ?>
                 <tr>
                    <th scope="row"><?=$room['roomnumber']?></th>
                    <td><?=$room['roomtype']?></td>
                    <?php 
                        if($room['isempty'] == "true"):?>
                            <td><i class="fa fa-check text-success" aria-hidden="true"></i></td>
                    <?php
                        else:?>
                            <td><i class="fa fa-times text-danger" aria-hidden="true"></i></td>
                    <?php
                        endif;
                    ?>
                    <td><a class="btn btn-warning" href="editRoomNumber.php?id=<?=$room['roomnumber']?>">Edit</a></td>
                    <td><a class="btn btn-danger" href="roomnumberdelete.process.php?send=del&id=<?=$room['roomnumber']?>" onClick="return confirm('Do you want to delete??')">Delete</a></td>
                </tr>
        <?php
          endforeach;
        else:
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Alert: </strong> You should add some rooms first.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php
        endif;
      ?>
  </tbody>
</table>
</div>

<?php
endif;
?>

<!-- end Admin -->

<!-- Reception -->

<?php
if($_SESSION['role'] === 'reception'):
?>
<div class="mt-2">
    <h4>All Rooms</h4>
    <table class="table table-striped table-dark">
  <thead>
    <tr>
      <th scope="col">Room No.</th>
      <th scope="col">Room Type</th>
      <th scope="col">Available</th>
      <th colspan="2" scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
      <?php 
        if($roomNumber->getAll() > 0):
            foreach($roomNumber->getAll() as $room): ?>
                 <tr>
                    <th scope="row"><?=$room['roomnumber']?></th>
                    <td><?=$room['roomtype']?></td>
                    <?php 
                        if($room['isempty'] == "true"):?>
                            <td><i class="fa fa-check text-success" aria-hidden="true"></i></td>
                    <?php
                        else:?>
                            <td><i class="fa fa-times text-danger" aria-hidden="true"></i></td>
                    <?php
                        endif;
                    ?>
                    <?php if($room['isempty'] == 'true'):?>
                      <td>
                        <form action="" method="POST">
                          <input type="hidden" name="roomnumber" value="<?=$room['roomnumber']?>">
                          <input name="book" type="hidden" value="false">
                          <button class="btn btn-success" type="submit" name="toggleBook">Book</button>
                        </form>
                      </td>
                    <?php
                      else:
                        if($room['isempty'] == 'false'):?>
                          <td>
                            <form action="" method="POST">
                              <input type="hidden" name="roomnumber" value="<?=$room['roomnumber']?>">
                              <input name="book" type="hidden" value="true">
                              <button class="btn btn-danger" type="submit" name="toggleBook">Checkout</button>
                            </form>
                          </td>
                        <?php
                        endif;
                    ?>
                    <?php    
                    endif; 
                    ?>
                    <td></td>
                </tr>
        <?php
          endforeach;
        else:
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Alert: </strong> You should add some rooms first.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php
        endif;
      ?>
  </tbody>
</table>
</div>

<?php endif; ?>

<!-- end Reception -->

<!-- Reception -->

<?php
if($_SESSION['role'] === 'manager'):
?>
<div class="mt-2">
    <h4>All Rooms</h4>
    <table class="table table-striped table-dark">
  <thead>
    <tr>
      <th scope="col">Room No.</th>
      <th scope="col">Room Type</th>
      <th scope="col">Available</th>
    </tr>
  </thead>
  <tbody>
      <?php 
        if($roomNumber->getAll() > 0):
            foreach($roomNumber->getAll() as $room): ?>
                 <tr>
                    <th scope="row"><?=$room['roomnumber']?></th>
                    <td><?=$room['roomtype']?></td>
                    <?php 
                        if($room['isempty'] == "true"):?>
                            <td><i class="fa fa-check text-success" aria-hidden="true"></i></td>
                    <?php
                        else:?>
                            <td><i class="fa fa-times text-danger" aria-hidden="true"></i></td>
                    <?php
                        endif;
                    ?>
                </tr>
        <?php
          endforeach;
        else:
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Alert: </strong> You should add some rooms first.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php
        endif;
      ?>
  </tbody>
</table>
</div>

<?php endif; ?>

<!-- end manager -->



<?php include_once "layout/footer.php" ?>