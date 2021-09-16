<?php 
include_once "layout/header.php";
if($_SESSION['role'] === 'manager'){
    $admin = new Admin();
    if($admin->getReception() > 0):
?>
<h2><u>Reception List</u></h2>
<table class="table table-dark table-striped table-bordered">
    <thead>
        <tr>
            <th>Username</th>
            <th>Role</th>
            <!-- <th colspan="2" class="text-center">Action</th> -->
        </tr>
    </thead>

    <tbody>
        <?php foreach($admin->getReception() as $rec): ?>
        <tr>
            <td><?=$rec['username']?></td>
            <td><?=$rec['role']?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php 
else:
    echo "
    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Error:</strong> No receptionists.
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>
      ";
endif;
include_once "layout/footer.php";
}else{
    header("index.php");
} ?>
