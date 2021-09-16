<?php 
if(!isset($_GET['name'])){
    header("location:index.php");
    die;
}
if($_GET['name'] === 'admin'){
    header("location:index.php");
    die;
}
include_once "layout/header.php";
if($_SESSION['role'] === "admin"){
    $admin = new Admin();
    $old = $admin->get($_GET['name']);

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        if(isset($_POST['editStaff'])) {
            $err = "";
            $role = clean($_POST['role']);
            $username = clean($_GET['name']);

            if(empty($role)){
                $err .= "Role is empty.<br>";
            }else{
                if($role === 'admin'){
                    $err .= "Cannot assign.<br>";
                }
            }
            if(empty($err)){
                $admin->editStaffRole($role, $username);
                echo "<script>window.location.replace('userslist.php')</script>";
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
<h2>Edit User: <?=$old['username']?></h2>
<form action="useredit.php?name=<?=$old['username']?>" method="POST">
    <label for="">Change Role</label>
    <select name="role" class="form-control" id="" required>
        <option value="">Select a role</option>
        <option value="manager" <?php echo $old['role'] == "manager" ? "selected" : "" ?>>Manager</option>
        <option value="reception" <?php echo $old['role'] == "reception" ? "selected" : "" ?> >Reception</option>
    </select>
    <button type="submit" class="mt-2 btn btn-info" name="editStaff">Update</button>
    <a href="userslist.php" class="mt-2 btn btn-dark">Close</a>
</form>
<?php
include_once "layout/footer.php";
}else{
    header("location:index.php");
}
?>