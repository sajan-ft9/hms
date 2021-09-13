<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<div class="container login-container">
<a class="btn btn-primary mt-3" href="index.php">Home</a>

            <div class="row">
                <div class="col-md-6 m-auto login-form-1">
                    <h3>Login</h3>
                    <form method="POST">
                        <div class="form-group">
                            <input class="form-control" type="text" name="username" class="form-control" placeholder="Username *" required/>
                        </div>
                        <div class="form-group mt-2">
                            <input class="form-control" type="password" name="password" class="form-control" placeholder="Your Password *" value="" required/>
                        </div>
                        <div class="form-group mt-2">
                            <input class="btn btn-info" type="submit" name="adminlogin" class="btnSubmit" value="Login" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

<?php  

    require_once "../includes/init.php";

     if($_SERVER['REQUEST_METHOD'] == "POST"){

        if(isset($_POST['adminlogin'])) {
            $err = "";
            $username = clean($_POST['username']);
            $password = clean($_POST['password']);

            if(empty($username)){
                $err .= "Username required.<br>";
            }
            if(empty($password)){
                $err .= "Password required.<br>";
            }

            if(empty($err)){
                $admin = new Admin();
                
                if($admin->get($username) > 0){
                    $verify = $admin->get($username);
                    if($verify['password'] === $password && $verify['role'] === "admin"){
                        session_start();
                        $_SESSION['logged'] = "Admin";
                        $_SESSION['role'] = $verify['role'];

                        header("Location:../admin/index.php");
                        die;
                    }
                    else{
                        echo "
                    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                      <strong>Error:</strong> Invalid password.
                      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                      ";
                    }
                }
                else{
                    echo "
                    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                      <strong>Error:</strong> No such user.
                      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                      ";
                }
                
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