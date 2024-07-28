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
                $sql = "SELECT * FROM `products` WHERE `id`='$id'";
                $result = mysqli_query($con, $sql);
                $num = mysqli_num_rows($result);
                $data = [];
                $data = mysqli_fetch_assoc($result);
                if($num > 0){
            ?>
            <div class="page-header">
                <div class="page-title">
                    <h4>Product Management</h4>
                    <h6>Update Product</h6>
                </div>
            </div>
            <form class="card" action="" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Product SKU</label>
                                <input type="text" name="sku_up" value="<?=$data['product_sku']?>" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="name_up" value="<?=$data['product_name']?>" required>
                                <input type="hidden" name="name_old" value="<?=$data['product_name']?>">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Product Size</label>
                                <input type="text" name="size_up" value="<?=$data['size']?>" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Product Color</label>
                                <input type="text" name="color_up" value="<?=$data['color']?>" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Cost Price (AED)</label>
                                <input type="number" step="any" name="cost_price_up" value="<?=$data['cost_price']?>" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Sales Price (AED)</label>
                                <input type="number" step="any" name="sales_price_up" value="<?=$data['sale_price']?>" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" name="stock_up" value="<?=$data['stock']?>" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Update Category</label>
                                <select class="select text-capitalize" name="category_up" required>
                                    <?php 
                                        $sql = "SELECT * FROM `categories`";
                                        $result = mysqli_query($con, $sql);
                                        $categ = [];
                                        while($row = mysqli_fetch_assoc($result)) {
                                            array_push($categ, $row);
                                        }
                                        $prev_cat = $data['product_category'];
                                    ?>
                                    <?php foreach ($categ as $key => $val) { ?>
                                        <?php if($prev_cat == $val['category_name']){ ?>
                                            <option value="<?=$val['category_name']?>" selected><?=$val['category_name']?></option>
                                        <?php }else{ ?>
                                        <option value="<?=$val['category_name']?>"><?=$val['category_name']?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="select" name="status_up">
                                    <?php if($data['status']=='1'){ ?>
                                        <option value="1" selected>Published</option>
                                        <option value="0">Un Published</option>
                                    <?php }else{ ?>
                                        <option value="1">Published</option>
                                        <option value="0" selected>Un Published</option>
                                        <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Product Image</label>
                                <div class="image-upload">
                                    <input type="file" name="file" value="" class="thisImage" onchange="readURL(this);">
                                    <div class="image-uploads">
                                        <img src="assets/img/icons/upload.svg" alt="img">
                                        <h4>Drag and drop a file to upload</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" id="show_img">
                            <div class="form-group">
                                <img id="blah" src="<?=$data['path']?>" alt="image not found / not uploaded yet" width="150" height="150"/>
                                <a class="px-1" id="delete_img" onclick="delURL()">
                                    <img src="assets/img/icons/delete.svg" alt="img">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-12  text-end">
                            <button type="submit" name="update" class="btn btn-submit me-2">Update Product</button>
                        </div>
                    </div>
                </div>
            </form>
        <?php }else{
            echo '<script type="text/javascript">window.location = "add-product.php";</script>';
        } }else{ ?>
        <!-- /Update -->
        <!-- /add -->
            <div class="page-header">
                <div class="page-title">
                    <h4>Product Management</h4>
                    <h6>Add New Product</h6>
                </div>
            </div>
            <form class="card" action="" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Product SKU</label>
                                <input type="text" name="sku" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Cost Price (AED)</label>
                                <input type="number" step="any" name="cost_price" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sales Price (AED)</label>
                                <input type="number" step="any" name="sales_price" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" name="stock" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Select Category</label>
                                <select class="select text-capitalize" name="category" required>
                                    <?php 
                                        $sql = "SELECT * FROM `categories`";
                                        $result = mysqli_query($con, $sql);
                                        $categ = [];
                                        while($row = mysqli_fetch_assoc($result)) {
                                            array_push($categ, $row);
                                        }
                                    ?>
                                   <?php foreach($categ as $key => $value){ ?>
                                        <option value="<?=$value['category_name']?>"><?=$value['category_name']?></option> 
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Size</label>
                                <input type="text" name="size">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Color</label>
                                <input type="text" name="color">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="select" name="status">
                                    <option value="1">Published</option>
                                    <option value="0">Un Published</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Product Image</label>
                                <div class="image-upload">
                                    <input type="file" required class="thisImage" name="image" onchange="readURL(this);">
                                    <div class="image-uploads">
                                        <img src="assets/img/icons/upload.svg" alt="img">
                                        <h4>Drag and drop a file to upload</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" id="show_img" style="display:none;">
                            <div class="form-group">
                                <img id="blah" src="#" alt="image"/>
                                <a class="px-1" id="delete_img" onclick="delURL()">
                                    <img src="assets/img/icons/delete.svg" alt="img">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-12  text-end">
                            <button type="submit" name="submit" class="btn btn-submit me-2">Add Product</button>
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
    $sku = $_POST['sku'];
    $name = $_POST['name'];
    $cost = $_POST['cost_price'];
    $sale = $_POST['sales_price'];
    $categ = $_POST['category'];
    $stock = $_POST['stock'];
    $status = $_POST['status'];
    $size = $_POST['size'];
    $color = $_POST['color'];

    // if (!empty($_FILES["image"]["name"])) {
        $target_dir = "assets/products/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo '<script language="javascript">alert("Sorry, Only JPG, JPEG & PNG files are allowed.");</script>';
        }else{
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            $q1=mysqli_query($con,"INSERT INTO products(`product_sku`,`product_name`,`product_category`,`cost_price`,`sale_price`,`size`,`color`,`stock`,`status`,`path`) VALUES('$sku','$name','$categ','$cost','$sale','$size','$color','$stock','$status','$target_file')");
            if(!$q1){
                echo '<script type="text/javascript">';
                echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "Server Error, Try Again Later!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
                echo '</script>';
                echo mysqli_error($con);
            }else{
                echo '<script type="text/javascript">';
                echo 'Swal.fire({icon: "success", title: "Success!", text: "Product Added!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
                echo '</script>';
            }
        }
    // }else{
    //     $q1=mysqli_query($con,"INSERT INTO products(`product_name`,`product_category`,`cost_price`,`sale_price`,`stock`,`status`) VALUES('$name','$categ','$cost','$sale','$stock','$status')");
    //     if(!$q1){
    //         echo '<script type="text/javascript">';
    //         echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "Server Error, Try Again Later!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
    //         echo '</script>';
    //         echo mysqli_error($con);
    //     }else{
    //         echo '<script type="text/javascript">';
    //         echo 'Swal.fire({icon: "success", title: "Success!", text: "Product Added!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
    //         echo '</script>';
    //     }
    // }
}
if(isset($_POST["update"])){
    $name = $_POST['name_up'];
    $cost = $_POST['cost_price_up'];
    $sale = $_POST['sales_price_up'];
    $categ = $_POST['category_up'];
    $stock = $_POST['stock_up'];
    $status = $_POST['status_up'];
    $size = $_POST['size_up'];
    $color = $_POST['color_up'];
    $sku = $_POST['sku_up'];
    $prev_name = $_POST['name_old'];

    $is_uploading = $_FILES["file"]["error"];
    $can_pass = $is_uploading == 0 ? true : false;

    $target_dir = "assets/products/";
    $target_file = $target_dir . basename($_FILES['file']["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if($prev_name != $name){
        $sql1 = "SELECT * FROM `products` WHERE `product_name`='$name'";
        $result1 = mysqli_query($con, $sql1);
        $num1 = mysqli_num_rows($result1);
        if($num1 > 0){
            echo '<script type="text/javascript">';
            echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "Product already exists!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
            echo '</script>';
        }else{
            if($can_pass){
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    echo '<script language="javascript">alert("Sorry, Only JPG, JPEG & PNG files are allowed.");</script>';
                }else{
                    move_uploaded_file($_FILES['file']["tmp_name"], $target_file);
                    $q1=mysqli_query($con,"UPDATE `products` SET `product_name`='$name',`product_category`='$categ',`cost_price`='$cost',`sale_price`='$sale',`stock`='$stock',`status`='$status',`path`='$target_file',`size`='$size',`color`='$color',`product_sku`='$sku' WHERE `id`='$id' ");
                    if(!$q1){
                        echo '<script type="text/javascript">';
                        echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "Server Error, Try Again Later!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
                        echo '</script>';
                        echo mysqli_error($con);
                    }else{
                        echo '<script type="text/javascript">';
                        echo 'Swal.fire({icon: "success", title: "Success!", text: "Product Updated! (Reload Page to See Updated Details)", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
                        echo '</script>';
                    }
                }
            }else{
                $q1=mysqli_query($con,"UPDATE `products` SET `product_name`='$name',`product_category`='$categ',`cost_price`='$cost',`sale_price`='$sale',`stock`='$stock',`status`='$status',`size`='$size',`color`='$color',`product_sku`='$sku' WHERE `id`='$id' ");
                if(!$q1){
                    echo '<script type="text/javascript">';
                    echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "Server Error, Try Again Later!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
                    echo '</script>';
                    echo mysqli_error($con);
                }else{
                    echo '<script type="text/javascript">';
                    echo 'Swal.fire({icon: "success", title: "Success!", text: "Product Updated! (Reload Page to See Updated Details)", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
                    echo '</script>';
                }
            }
        }
    }else{
        if($can_pass){
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                echo '<script language="javascript">alert("Sorry, Only JPG, JPEG & PNG files are allowed.");</script>';
            }else{
                move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
                $q1=mysqli_query($con,"UPDATE `products` SET `product_name`='$name',`product_category`='$categ',`cost_price`='$cost',`sale_price`='$sale',`stock`='$stock',`status`='$status',`path`='$target_file',`size`='$size',`color`='$color',`product_sku`='$sku' WHERE `id`='$id' ");
                if(!$q1){
                    echo '<script type="text/javascript">';
                    echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "Server Error, Try Again Later!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
                    echo '</script>';
                    echo mysqli_error($con);
                }else{
                    echo '<script type="text/javascript">';
                    echo 'Swal.fire({icon: "success", title: "Success!", text: "Product Updated! (Reload Page to See Updated Details)", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
                    echo '</script>';
                }
            }
        }else{
            $q1=mysqli_query($con,"UPDATE `products` SET `product_name`='$name',`product_category`='$categ',`cost_price`='$cost',`sale_price`='$sale',`stock`='$stock',`status`='$status',`size`='$size',`color`='$color',`product_sku`='$sku' WHERE `id`='$id' ");
            if(!$q1){
                echo '<script type="text/javascript">';
                echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "Server Error, Try Again Later!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
                echo '</script>';
                echo mysqli_error($con);
            }else{
                echo '<script type="text/javascript">';
                echo 'Swal.fire({icon: "success", title: "Success!", text: "Product Updated! (Reload Page to See Updated Details)", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
                echo '</script>';
            }
        }
    }
}
?>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
            $('#blah').attr('src', e.target.result).width(150).height(150);
            };
            $('#show_img').css("display", "block");
            reader.readAsDataURL(input.files[0]);
        }
    }
    function delURL(){
        input = $('.thisImage');
        input.val('');
        $('#blah').attr('src', '#');
        $('#show_img').css("display", "none");
    }
</script>