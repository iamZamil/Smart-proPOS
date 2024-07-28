<?php
session_start();
require_once 'dompdf/autoload.inc.php'; 
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
    $sql = "SELECT * FROM `orders` WHERE `id`='$id'";
    $result = mysqli_query($con, $sql);
    $data = array();
    $data = mysqli_fetch_assoc($result);
}
?>


<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Orders</h4>
                <h6>Details Of Order Named <b class="fw-bold"><?=$data['name']?></b></h6>
            </div>
            <?php if($_SESSION['role'] == 'admin'){ ?>
                <?php if($data['status'] == 'cancelled'){ ?>
                    <div class="page-btn">
                        <h6 class="mb-1 btn-primary text-white py-2 px-3 rounded">Cancelled / Returned</h6>
                    </div>
                <?php }else{ ?>
                <div class="page-btn w-25">
                    <h6 class="mb-1">Change Order Status Here</h6>
                    <select class="select" id="order_status" data-id="<?=$_GET['id']?>">
                        <?php if($data['status'] == 'inprocess'){ ?>
                            <option value="inprocess" selected>inprocess</option>
                            <option value="delivered">delivered</option>
                            <option value="cancelled">cancelled / returned</option>
                        <?php }else if($data['status'] == 'delivered'){ ?>
                            <option value="inprocess">inprocess</option>
                            <option value="delivered" selected>delivered</option>
                            <option value="cancelled">cancelled / returned</option>
                        <?php }else if($data['status'] == 'cancelled'){ ?>
                            <option value="inprocess" >inprocess</option>
                            <option value="delivered">delivered</option>
                            <option value="cancelled" selected>cancelled / returned</option>
                        <?php } ?>
                    </select>
                </div>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-md-12 mx-auto">
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
                                    <h4>Order Placed By</h4>
                                    <h6><?=$data['placed_by']?></h6>
                                </li>
                                <li>
                                    <h4>Customer's Name</h4>
                                    <h6><?=$data['name']?></h6>
                                </li>
                                <li>
                                    <h4>Customer's Email</h4>
                                    <h6><?=$data['email']?></h6>
                                </li>
                                <li>
                                    <h4>Customer's Phone</h4>
                                    <h6><?=$data['phone']?></h6>
                                </li>
                                <li>
                                    <h4>Customer's Address</h4>
                                    <h6><?=$data['address']?></h6>
                                </li>
                                <li>
                                    <h4>Customer's City</h4>
                                    <h6><?=$data['city']?></h6>
                                </li>
                                <li>
                                    <input type="hidden" id="quantity" value="<?=$data['quantity']?>">
                                    <input type="hidden" id="products" value="<?=$data['product_sku']?>">
                                    <?php $temp = $data['product_sku'];
                                        $temp1 = explode(',',$temp);
                                        $totalProducts = count($temp1);
                                     ?>
                                    <h4>No. Of Products</h4>
                                    <h6><?=$totalProducts?></h6>
                                </li>
                                <li>
                                    <h4>Total Price</h4>
                                    <h6><?=$data['total']?> AED</h6>
                                </li>
                                <li>
                                    <h4>Selected Courier</h4>
                                    <h6><?=$data['courier']?></h6>
                                </li>
                                <li>
                                    <h4>Order Placed At</h4>
                                    <h6><?=$data['timestamp']?></h6>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            $str = $data['product_sku'];
            $arr = explode(',',$str);
        ?>
        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="card-title">Ordered Products</h4>
                    </div>
                </div>
                <div class="table-responsive dataview">
                    <table class="table datatable" id="userlist">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>SKU</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;
                            foreach ($arr as $key => $val) { ?>
                                <tr>
                                    <?php 
                                        $query = "SELECT * FROM `products` WHERE `id`='$val'";
                                        $response = mysqli_query($con, $query);
                                        $data1 = [];
                                        $data1 = mysqli_fetch_assoc($response);
                                        $cat_name = $data1['product_category'];
                                        $sql = "SELECT * FROM `categories` WHERE `category_name`='$cat_name'";
                                        $result = mysqli_query($con, $sql);
                                        $categ = [];
                                        $categ = mysqli_fetch_assoc($result);
                                        $temp1 = $data['quantity'];
                                        $temp = explode(',',$temp1);
                                    ?>
                                    <td><?=$i?></td>
                                    <td><?=$data1['product_sku']?></td>
                                    <td class="productimgname">
                                    <a href="product-details.php?id=<?=$data1['id']?>" class="product-img">
                                            <img src="<?=$data1['path']?>" alt="product">
                                        </a>
                                        <a href="product-details.php?id=<?=$data1['id']?>"><?=$data1['product_name']?></a>
                                    </td>
                                    <?php $sale_ok = $data1['sale_price']+$categ['sale_tax'] ?>
                                    <td><?=$sale_ok?> AED</td>
                                    <td><?=$data1['stock']?></td>
                                    <td><?=$data1['size']?></td>
                                    <td><?=$data1['color']?></td>
                                    <td><?=$temp[$key]?></td>
                                </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('main-assets/footer.php'); ?>
<script>
    $(document).ready(function(){
        $("#order_status").change(function(){
            id = $(this).attr('data-id');
            status = $(this).val();
            check_dd(id,status);
            update_db(status);
        });
    });
    function check_dd(id,status){
        thisID = id;
        thisSt = status;
        url = 'server.php?cmd=order_status';
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                'id': thisID,
                'status': thisSt
            },
            success: function (data) {
                response = JSON.stringify(data);
                // console.log(response);
            },
            error: function() {
                alert('Error occured');
            }
        });
    };
    function update_db(status){
        thisSt = status;
        products = $('#products').val();
        quantity = $('#quantity').val();
        url = 'server.php?cmd=update_db';
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                'status': thisSt,
                'quantity': quantity,
                'products': products
            },
            success: function (data) {
                response = JSON.stringify(data);
                // console.log(response);
            },
            error: function() {
                alert('Error occured');
            }
        });
    };
</script>