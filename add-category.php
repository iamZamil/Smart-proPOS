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
    <div class="content">
        
        <!-- /Update -->
        <?php if(!empty($_GET['id'])){ ?>
            <?php 
                $id = $_GET['id'];
                $sql = "SELECT * FROM `categories` WHERE `id`='$id'";
                $result = mysqli_query($con, $sql);
                $num = mysqli_num_rows($result);
                $data = [];
                $data = mysqli_fetch_assoc($result);
                if($num > 0){
            ?>
            <div class="page-header">
                <div class="page-title">
                    <h4>Category Management</h4>
                    <h6>Update Category</h6>
                </div>
            </div>
            <form class="card" action="" method="POST">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" name="name_up" value="<?=$data['category_name']?>" required>
                                <input type="hidden" name="name_old" value="<?=$data['category_name']?>">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Cost Tax (AED)</label>
                                <input type="number" step="any" name="cost_tax_up" value="<?=$data['cost_tax']?>" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Sales Tax (AED)</label>
                                <input type="number" step="any" name="sales_tax_up" value="<?=$data['sale_tax']?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="desc_up" placeholder="Minor details about category" required class="form-control"><?=$data['category_desc']?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12  text-end">
                            <button type="submit" name="update" class="btn btn-submit me-2">Update Category</button>
                        </div>
                    </div>
                </div>
            </form>
        <?php }else{
            echo '<script type="text/javascript">window.location = "add-category.php";</script>';
        } }else{ ?>
        <!-- /Update -->
        <!-- /add -->
            <div class="page-header">
                <div class="page-title">
                    <h4>Category Management</h4>
                    <h6>Add New Category</h6>
                </div>
            </div>
            <form class="card" action="" method="POST">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" name="name" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Cost Tax (AED)</label>
                                <input type="number" step="any" name="cost_tax" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Sales Tax (AED)</label>
                                <input type="number" step="any" name="sales_tax" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="desc" placeholder="Minor details about category" required class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12  text-end">
                            <button type="submit" name="submit" class="btn btn-submit me-2">Add Category</button>
                        </div>
                    </div>
                </div>
            </form>
        <!-- /add -->
        <?php } ?>
    </div>
</div>
<?php
include('main-assets/footer.php');
if(isset($_POST["submit"])){
    $name = $_POST['name'];
    $cost = $_POST['cost_tax'];
    $sale = $_POST['sales_tax'];
    $desc = $_POST['desc'];

    $sql = "SELECT * FROM `categories` WHERE `category_name`='$name'";
    $result = mysqli_query($con, $sql);
    if(!$result){
        $num = 0;
    }else{
        $num = mysqli_num_rows($result);
    }
    if($num > 0){
        echo '<script type="text/javascript">';
        echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "Category Already Exists!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
        echo '</script>';
        die();
    }else{
        $q1=mysqli_query($con,"INSERT INTO categories(`category_name`,`category_desc`,`cost_tax`,`sale_tax`) VALUES('$name','$desc','$cost','$sale')");
        if(!$q1){
            echo '<script type="text/javascript">';
            echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "Server Error, Try Again Later!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
            echo '</script>';
            echo mysqli_error($con);
        }else{
            echo '<script type="text/javascript">';
            echo 'Swal.fire({icon: "success", title: "Success!", text: "Category Added!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
            echo '</script>';
        }
    }
}
if(isset($_POST["update"])){
    $name = $_POST['name_up'];
    $cost = $_POST['cost_tax_up'];
    $sale = $_POST['sales_tax_up'];
    $desc = $_POST['desc_up'];
    $prev_name = $_POST['name_old'];

    if($prev_name != $name){
        $sql1 = "SELECT * FROM `categories` WHERE `category_name`='$name'";
        $result1 = mysqli_query($con, $sql1);
        $num1 = mysqli_num_rows($result1);
        if($num1 > 0){
            echo '<script type="text/javascript">';
            echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "Category already exists!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
            echo '</script>';
            die();
        }else{
            $q1=mysqli_query($con,"UPDATE `categories` SET `category_name`='$name',`category_desc`='$desc',`cost_tax`='$cost',`sale_tax`='$sale' WHERE `id`='$id' ");
            if(!$q1){
                echo '<script type="text/javascript">';
                echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "Server Error, Try Again Later!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
                echo '</script>';
                echo mysqli_error($con);
            }else{
                echo '<script type="text/javascript">';
                echo 'Swal.fire({icon: "success", title: "Success!", text: "Category Updated! (Reload Page to See Updated Details)", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
                echo '</script>';
            }
        }
    }else{
        $q1=mysqli_query($con,"UPDATE `categories` SET `category_name`='$name',`category_desc`='$desc',`cost_tax`='$cost',`sale_tax`='$sale' WHERE `id`='$id' ");
        if(!$q1){
            echo '<script type="text/javascript">';
            echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "Server Error, Try Again Later!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
            echo '</script>';
            echo mysqli_error($con);
        }else{
            echo '<script type="text/javascript">';
            echo 'Swal.fire({icon: "success", title: "Success!", text: "Category Updated! (Reload Page to See Updated Details)", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
            echo '</script>';
        }
    }
}
?>