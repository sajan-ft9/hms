<?php 
include_once "layout/header.php";

$Rooms = new Rooms();
$RoomNumber = new RoomNumber();
$Customer = new Customer();
$Booking = new Booking();

?>
<h2>Book</h2>
<h4>Room Details:</h4>
<form action="" method="POST">
    <label for="">Room Number</label>
    <select name="roomtype" class="form-control" required>
        <option value="">Select Room Number</option>
        <?php 
            if($RoomNumber->getAll() > 0): 
                foreach($RoomNumber->getAll() as $room): 
        ?>
        <option value="<?=$room['roomnumber']?>"><?php echo $room['roomnumber']. " [".$room['roomtype']."]" ?></option>
        <?php 
                endforeach;
            endif;
        ?>
    </select>
    <label for="">Check In Date</label>
    <input class="form-control" type="date" name="checkin" min="<?=date("Y-m-d")?>">
    <label for="">Check Out Date</label>
    <input type="date" name="checkout" class="form-control" min="<?=date("Y-m-d")?>">
    <h4>Customer Details</h4>
    <label for="">Full Name</label>
    <input type="text" name="name" class="form-control" required>
    <label for="">Email</label>
    <input type="email" name="email" class="form-control" required>
    <label for="">Contact</label>
    <input type="tel" name="contact" id="contact" class="form-control" required>
    <label for="">Address</label>
    <input type="text" name="address" class="form-control" required>
    <label for="">Certification Document</label>
    <select name="certification" class="form-control">
        <option value="">Select Certification Type</option>
        <option value="citienship">Citizenship</option>
        <option value="license">License</option>
        <option value="voterid">Voter ID</option>
    </select>
    <label for="">Document Number</label>
    <input type="text" name="documentnumber" class="form-control" required>
    <button type="submit" name="Booking" class="mt-2 btn btn-primary form-control">Book</button>
</form>
<div>
</div>
<?php 
include_once "layout/footer.php";
?>