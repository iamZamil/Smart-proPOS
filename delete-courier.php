<?php 
session_start();
if($_SESSION['role']!="admin" || empty($_SESSION['role'])){
  echo '<script type="text/javascript">window.location = "index.php";</script>';
  die();
}
require_once 'main-assets/connection.php';
if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM `couriers` WHERE `id`='$id'";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    if($num > 0){
        $sql = "DELETE FROM `couriers` WHERE `id`='$id'";
        $result = mysqli_query($con, $sql);
        if(!$result){
            echo '<script type="text/javascript">window.location = "courier-list.php";</script>';
        }else{
            echo '<script type="text/javascript">window.location = "courier-list.php";</script>';
        }
    }else{
        echo '<script type="text/javascript">window.location = "courier-list.php";</script>';
        die();
    }
}else{
    echo '<script type="text/javascript">window.location = "index.php";</script>';
    die();
}
echo '<script type="text/javascript">window.location = "index.php";</script>';
?>