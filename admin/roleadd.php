<?php
include_once "layout/header.php";

if($_SESSION['role'] === 'admin'){
    $admin = new Admin();
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        if(isset($_POST['addRole'])) {
            
            $err = "";
            $username = clean($_POST['username']);
            $password = clean($_POST['password']);
            $role = clean($_POST['role']);

            if(empty($username)){
                $err .= "Username required.<br>";
            }else{
                if(!preg_match("/^[a-zA-Z0-9 ]{5,50}$/", $username)){
                    $err .= "Username must be alphanumeric 5-50 characters";
                }
                if($admin->get($username) > 0){
                    $err .= "Username already exists.<br>";
                }
            }

            if(empty($password)){
                $err .= "Password required.<br>";
            }else{
                if(!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',$password)){
                    $err .= "Password must contain t least 8 characters<br>
                    <li>at least one lowercase char</li>
                    <li>at least one uppercase char</li>
                    <li>at least one digit</li>
                    <li>at least one speacial character</li>"
                    ;
                }
            }

            if(empty($role)){
                $err .= "Role must assigned.<br>";
            }

            if(empty($err)){

                $admin->addRole($username, $password, $role);
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


<h2>Add Role</h2>
<form action="" method="post">
    <div class="form-group">
        <label for="">Username</label>
        <input type="text" class="form-control" name="username" required>
        <label for="">Password</label>
        <input type="password" class="form-control" name="password" required>
        <label for="">Role</label>
        <select name="role" id="" class="form-control" required>
            <option value="">Select a Role</option>
            <option value="manager">Manager</option>
            <option value="reception">Reception</option>
        </select>
        <button class="form-control btn btn-info mt-2" type="submit" name="addRole">Add Role</button>
    </div>
</form>

<?php
}else{
    header("location:index.php");
    die;
}
include_once "layout/footer.php";
?>