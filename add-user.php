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
        <div class="page-header">
            <div class="page-title">
                <h4>User Management</h4>
                <h6>Add User</h6>
            </div>
        </div>
        <!-- /Update -->
        <?php if(!empty($_GET['id'])){ ?>
            <?php 
                $id = $_GET['id'];
                $sql = "SELECT * FROM `pos_users` WHERE `id`='$id'";
                $result = mysqli_query($con, $sql);
                $num = mysqli_num_rows($result);
                $user = [];
                $user = mysqli_fetch_assoc($result);
                if($num > 0){
            ?>
            <form class="card" action="" method="POST">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="first_name_up" value="<?=$user['first_name']?>" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="last_name_up" value="<?=$user['last_name']?>" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email_up" value="<?=$user['email']?>" required>
                                <input type="hidden" name="email_old" value="<?=$user['email']?>">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input type="password" name="password_up" class=" pass-input" value="<?=$user['password']?>" required>
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="phone_up" placeholder="+92 300 1234567" value="<?=$user['phone']?>" required>
                                <input type="hidden" name="phone_old" value="<?=$user['phone']?>">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Role</label>
                                <select class="select" name="role_up" required>
                                    <?php if($user['role'] == 'staff'){ ?>
                                        <option value="staff" selected>Staff</option>
                                        <option value="admin">Admin</option>
                                    <?php }else{ ?>
                                        <option value="admin" selected>Admin</option>
                                        <option value="staff">Staff</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12  text-end">
                            <button type="submit" name="update" class="btn btn-submit me-2">Update User</button>
                        </div>
                    </div>
                </div>
            </form>
        <?php }else{
            echo '<script type="text/javascript">window.location = "add-user.php";</script>';
        } }else{ ?>
        <!-- /Update -->
        <!-- /add -->
            <form class="card" action="" method="POST">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="first_name" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="last_name" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input type="password" name="password" class=" pass-input" required>
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="phone" placeholder="+92 300 1234567" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Role</label>
                                <select class="select" name="role" required>
                                    <option value="staff">Staff</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12  text-end">
                            <button type="submit" name="submit" class="btn btn-submit me-2">Add User</button>
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
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    $sql1 = "SELECT * FROM `pos_users` WHERE `email`='$email'";
    $sql2 = "SELECT * FROM `pos_users` WHERE `phone`='$phone'";
    $result1 = mysqli_query($con, $sql1);
    $result2 = mysqli_query($con, $sql2);
    $num1 = mysqli_num_rows($result1);
    $num2 = mysqli_num_rows($result2);
    if($num1 > 0){
        echo '<script type="text/javascript">';
        echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "This Email is already in use!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
        echo '</script>';
        die();
    }else if($num2 > 0){
        echo '<script type="text/javascript">';
        echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "This Phone Number is already in use!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
        echo '</script>';
        die();
    }else{
        $q1=mysqli_query($con,"INSERT INTO pos_users(`email`,`first_name`,`last_name`,`Password`,`role`,`phone`) VALUES('$email','$first_name','$last_name','$password','$role','$phone')");
        if(!$q1){
            echo '<script type="text/javascript">';
            echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "You might be using duplicate data! Cant insert!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
            echo '</script>';
            echo mysqli_error($con);
        }else{
            echo '<script type="text/javascript">';
            echo 'Swal.fire({icon: "success", title: "Success!", text: "User Added!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
            echo '</script>';
        }
    }
}
if(isset($_POST["update"])){
    $first_name = $_POST['first_name_up'];
    $last_name = $_POST['last_name_up'];
    $email = $_POST['email_up'];
    $password = $_POST['password_up'];
    $phone = $_POST['phone_up'];
    $role = $_POST['role_up'];
    $prev_email = $_POST['email_old'];
    $prev_phone = $_POST['phone_old'];

    if($prev_email != $email){
        $sql1 = "SELECT * FROM `pos_users` WHERE `email`='$email'";
        $result1 = mysqli_query($con, $sql1);
        $num1 = mysqli_num_rows($result1);
        if($num1 > 0){
            echo '<script type="text/javascript">';
            echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "This Email is already in use!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
            echo '</script>';
            die();
        }else{
            $q1=mysqli_query($con,"UPDATE `pos_users` SET `email`='$email',`password`='$password',`phone`='$phone',`first_name`='$first_name',`last_name`='$last_name',`role`='$role' WHERE `id`='$id' ");
            if(!$q1){
                echo '<script type="text/javascript">';
                echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "You might be using duplicate data! Cant insert!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
                echo '</script>';
                echo mysqli_error($con);
            }else{
                echo '<script type="text/javascript">';
                echo 'Swal.fire({icon: "success", title: "Success!", text: "User Updated! (Reload Page to See Updated Profile)", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
                echo '</script>';
            }
        }
    }else if($prev_phone != $phone){
        $sql2 = "SELECT * FROM `pos_users` WHERE `phone`='$phone'";
        $result2 = mysqli_query($con, $sql2);
        $num2 = mysqli_num_rows($result2);
        if($num2 > 0){
            echo '<script type="text/javascript">';
            echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "This Phone Number is already in use!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
            echo '</script>';
            die();
        }else{
            $q1=mysqli_query($con,"UPDATE `pos_users` SET `email`='$email',`password`='$password',`phone`='$phone',`first_name`='$first_name',`last_name`='$last_name',`role`='$role' WHERE `id`='$id' ");
            if(!$q1){
                echo '<script type="text/javascript">';
                echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "You might be using duplicate data! Cant insert!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
                echo '</script>';
                echo mysqli_error($con);
            }else{
                echo '<script type="text/javascript">';
                echo 'Swal.fire({icon: "success", title: "Success!", text: "User Updated! (Reload Page to See Updated Profile)", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
                echo '</script>';
            }
        }
    }else{
        $q1=mysqli_query($con,"UPDATE `pos_users` SET `email`='$email',`password`='$password',`phone`='$phone',`first_name`='$first_name',`last_name`='$last_name',`role`='$role' WHERE `id`='$id' ");
        if(!$q1){
            echo '<script type="text/javascript">';
            echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "You might be using duplicate data! Cant insert!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
            echo '</script>';
            echo mysqli_error($con);
        }else{
            echo '<script type="text/javascript">';
            echo 'Swal.fire({icon: "success", title: "Success!", text: "User Updated! (Reload Page to See Updated Profile)", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
            echo '</script>';
        }
    }
}
?>