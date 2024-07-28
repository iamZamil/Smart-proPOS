<?php
session_start();
if(empty($_SESSION['role'])){
  echo "<script type='text/javascript'>window.location = 'index.php';</script>";
  die();
}else if(empty($_GET['id'])){
    echo "<script type='text/javascript'>window.location = 'index.php';</script>";
    die();
}else{
    include('main-assets/header.php');
    include('main-assets/sidebar.php');
    require_once 'main-assets/connection.php';
    $id = $_GET['id'];
    $sql = "SELECT * FROM `products` WHERE `id`='$id'";
    $result = mysqli_query($con, $sql);
    $data = array();
    $data = mysqli_fetch_assoc($result);
}
?>


<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4><?=$data['product_name']?></h4>
                <h6>Details Of Product</h6>
            </div>
            <?php if($_SESSION['role'] == 'admin'){ ?>
                <div class="page-btn">
                    <a href="add-product.php?id=<?=$id?>" class="btn btn-added"><img src="assets/img/icons/edit.svg" alt="img" class="me-2">Edit Product</a>
                </div>
            <?php } ?>
        </div>
        <!-- /add -->
        <div class="row">
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <div class="bar-code-view">
                            <img src="assets/img/barcode1.png" alt="barcode">
                            <a class="printimg">
                                <img src="assets/img/icons/printer.svg" alt="print">
                            </a>
                        </div> -->
                        <div class="productdetails">
                            <ul class="product-bar">
                                <li>
                                    <h4>Product Name</h4>
                                    <h6><?=$data['product_name']?></h6>
                                </li>
                                <li>
                                    <h4>Category</h4>
                                    <h6><?=$data['product_category']?></h6>
                                </li>
                                <?php 
                                    $cat_name = $data['product_category'];
                                    $sql = "SELECT * FROM `categories` WHERE `category_name`='$cat_name'";
                                    $result = mysqli_query($con, $sql);
                                    $categ = [];
                                    $categ = mysqli_fetch_assoc($result);
                                    $cost_ok = $data['cost_price']+$categ['cost_tax'];
                                    $sale_ok = $data['sale_price']+$categ['sale_tax'];
                                ?>
                                <?php if($_SESSION['role'] == 'admin'){ ?>
                                <li>
                                    <h4>Cost Price</h4>
                                    <h6><?=$data['cost_price']?> AED</h6>
                                </li>
                                <li>
                                    <h4>Cost Price Including Tax</h4>
                                    <h6><?=$cost_ok?> AED</h6>
                                </li>
                                <li>
                                    <h4>Sale Price</h4>
                                    <h6><?=$data['sale_price']?> AED</h6>
                                </li>
                                <?php } ?>
                                <li>
                                    <h4>Sales Price Including Tax</h4>
                                    <h6><?=$sale_ok?> AED</h6>
                                </li>
                                <li>
                                    <h4>Size</h4>
                                    <h6><?=$data['size']?></h6>
                                </li>
                                <li>
                                    <h4>Color</h4>
                                    <h6><?=$data['color']?></h6>
                                </li>
                                <li>
                                    <h4>Stock</h4>
                                    <h6><?=$data['stock']?></h6>
                                </li>
                                <li>
                                    <h4>Status</h4>
                                    <h6>
                                        <?php if($data['status']==1){
                                            echo "Published";
                                        }else{
                                            echo "Not Published";
                                        }
                                        ?>
                                    </h6>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="slider-product-details">
                            <div class="owl-carousel owl-theme product-slide">
                                <div class="slider-product">
                                    <img src="<?=$data['path']?>" alt="img">
                                    <!-- <h4>macbookpro.jpg</h4>
                                    <h6>581kb</h6> -->
                                </div>
                                <!-- <div class="slider-product">
                                    <img src="" alt="img">
                                    <h4>macbookpro.jpg</h4>
                                    <h6>581kb</h6>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /add -->
    </div>
</div>

<?php include('main-assets/footer.php'); ?>