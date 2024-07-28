<?php
session_start();
if($_SESSION['role']!="admin" || empty($_SESSION['role'])){
  echo "<script type='text/javascript'>window.location = 'index.php';</script>";
  die();
}
include('main-assets/header.php');
include('main-assets/sidebar.php');
require_once 'main-assets/connection.php';
?>
<div class="page-wrapper">
    <?php if(!empty($_GET['id'])){ ?>
    <?php 
            $id = $_GET['id'];
            $sql = "SELECT * FROM `couriers` WHERE `id`='$id'";
            $result = mysqli_query($con, $sql);
            $num = mysqli_num_rows($result);
            $data = [];
            $data = mysqli_fetch_assoc($result);
            if($num > 0){
        ?>
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Couriers Management</h4>
                <h6>Update Courier</h6>
            </div>
        </div>
        <form class="card" action="" method="POST">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name_up" required value="<?=$data['name']?>">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="select" name="status_up" required>
                            <?php if($data['status'] == "1"){ ?>
                                <option value="1" selected>Publish</option>
                                <option value="0">UnPublish</option>
                            <?php }else{ ?>
                                <option value="1">Publish</option>
                                <option value="0" selected>UnPublish</option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12  text-end">
                        <button type="submit" name="update" class="btn btn-submit me-2">Update Courier</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php }else{
            echo '<script type="text/javascript">window.location = "add-courier.php";</script>';
    } }else{ ?>
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Couriers Management</h4>
                <h6>Add Courier</h6>
            </div>
        </div>
        <form class="card" action="" method="POST">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" required>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="select" name="status" required>
                                <option value="1">Publish</option>
                                <option value="0">UnPublish</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12  text-end">
                        <button type="submit" name="submit" class="btn btn-submit me-2">Add Courier</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php } ?>
</div>
<?php
include('main-assets/footer.php');
if(isset($_POST["submit"])){
    $name = $_POST['name'];
    $status = $_POST['status'];
    $q1=mysqli_query($con,"INSERT INTO couriers(`name`,`status`) VALUES('$name','$status')");
    if(!$q1){
        echo '<script type="text/javascript">';
        echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "You might be using duplicate data! Cant insert!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
        echo '</script>';
        echo mysqli_error($con);
    }else{
        echo '<script type="text/javascript">';
        echo 'Swal.fire({icon: "success", title: "Success!", text: "Courier Added!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
        echo '</script>';
    }
}
if(isset($_POST["update"])){
    $name = $_POST['name_up'];
    $status = $_POST['status_up'];
    $q1=mysqli_query($con,"UPDATE `couriers` SET `name`='$name',`status`='$status' WHERE `id`='$id' ");
    if(!$q1){
        echo '<script type="text/javascript">';
        echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "You might be using duplicate data! Cant insert!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
        echo '</script>';
        echo mysqli_error($con);
    }else{
        echo '<script type="text/javascript">';
        echo 'Swal.fire({icon: "success", title: "Success!", text: "Courier Updated!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
        echo '</script>';
    }
}
?>