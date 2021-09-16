<?php

include_once "layout/header.php";

if($_SESSION['role'] === 'admin'):
$admin = new Admin();
?>
<h2>Users List</h2>
<?php if($admin->getAll() > 0):
?>
<table class="table table-dark table-striped table-bordered">
    <thead>
        <tr>
            <th>Username</th>
            <th>Role</th>
            <th colspan="2" class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
            <?php
                foreach($admin->getAll() as $staff):    
        ?>
            <tr>
            <td><?=$staff['username']?></td>
            <td><?=$staff['role']?></td>
            <td class="text-center"><a href="useredit.php?name=<?=$staff['username']?>" class="btn btn-warning">Edit</a></td>
            <td class="text-center"><a href="userdelete.php?senduser=delstaff&name=<?=$staff['username']?>" class="btn btn-danger" onClick="return confirm('Do you want to delete??')">Delete</a></td>
        </tr>    
        <?php 
        endforeach;?>
            </tbody>
</table>
<?php
    else: 
        echo " <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                  <strong>Error:</strong> No data
                </div>";  
    endif; ?>
<?php
else:
    echo "<script>window.location.replace('index.php');</script>";
    die;
endif;
?>
<?php
include_once "layout/footer.php"
?>