<?php 
session_start();
if (empty($_SESSION['email']) || empty($_SESSION['role'])){
    echo "<script type='text/javascript'>window.location = 'login.php';</script>";
    die();
}
include_once('main-assets/connection.php');
include('main-assets/header.php');
include('main-assets/sidebar.php');
// ------
$sql = "SELECT * FROM `products`";
$result = mysqli_query($con, $sql);
$total_products = mysqli_num_rows($result);
$data = array();
while($row = mysqli_fetch_assoc($result)){
    array_push($data,$row);
}
$total_purchase = 0;
$total_sale= 0;
foreach ($data as $key => $val) {
    $total_purchase += $val['cost_price'];
}
// -------
$sql = "SELECT * FROM `orders`";
$result = mysqli_query($con, $sql);
$total_orders = mysqli_num_rows($result);
$data = array();
while($row = mysqli_fetch_assoc($result)){
    array_push($data,$row);
}
$total_sale= 0;
foreach ($data as $key => $val) {
    $total_sale += $val['total'];
}
// -------
$sqli = "SELECT * FROM `categories`";
$result1 = mysqli_query($con, $sqli);
$total_categories = mysqli_num_rows($result1);
$data1 = array();
while($row = mysqli_fetch_assoc($result1)){
    array_push($data1,$row);
}
$total_cost_tax = 0;
$total_sale_tax= 0;
foreach ($data1 as $key => $val) {
    $total_cost_tax += $val['cost_tax'];
    $total_sale_tax += $val['sale_tax'];
}
// -------
$total_pur = $total_cost_tax+$total_purchase;
$total_sal = $total_sale_tax+$total_sale;
// -------
$sql2 = "SELECT * FROM `pos_users`";
$result2 = mysqli_query($con, $sql2);
$data5 = array();
while($row = mysqli_fetch_assoc($result2)){
    if($row['role'] == 'staff'){
        array_push($data5,$row);
    }
}
$total_users = count($data5);
?>
<style>
    .dash-count:hover{
        color: #ffffff !important;
    }
</style>
    <?php if($_SESSION['role'] == 'admin'){ ?>
            <div class="page-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-md-3 ml-auto">
                            <div class="form-group w-100">
                                <label class="mb-1">Filter Results <span style="font-size:12px;">(MM-DD-YYYY)</span></label>
                                <input type="date" id="datepickerID" class="form-control" value="<?=date('Y-m-d')?>" min="2023-05-30" max="<?=date('Y-m-d')?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="dash-widget">
                                <div class="dash-widgetimg">
                                    <span><img src="assets/img/icons/dash1.svg" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5><span class="counters" data-count="<?=$total_purchase?>" id="t_purchase"><?=$total_purchase?></span> AED</h5>
                                    <h6>Total Purchase(+Tax)</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="dash-widget dash1">
                                <div class="dash-widgetimg">
                                    <span><img src="assets/img/icons/dash2.svg" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5><span class="counters" data-count="<?=$total_sale?>" id="t_sale"><?=$total_sale?></span> AED</h5>
                                    <h6>Ovreall Sales</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="dash-widget dash2">
                                <div class="dash-widgetimg">
                                    <span><img src="assets/img/icons/dash3.svg" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5><span class="counters" data-count="<?=$total_cost_tax?>" id="t_cost_tax"><?=$total_cost_tax?></span> AED</h5>
                                    <h6>Overall Cost Tax</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="dash-widget dash3">
                                <div class="dash-widgetimg">
                                    <span><img src="assets/img/icons/dash4.svg" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5><span class="counters" data-count="<?=$total_sale_tax?>" id="t_sale_tax"><?=$total_sale_tax?></span> AED</h5>
                                    <h6>Overall Sales Tax</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12 d-flex">
                            <a class="dash-count" href="order-list.php">
                                <div class="dash-counts">
                                    <h4 id="t_orders"><?=$total_orders?></h4>
                                    <h5>Orders</h5>
                                </div>
                                <div class="dash-imgs">
                                    <i data-feather="user-check"></i> 
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12 d-flex">
                            <a class="dash-count das2" href="user-list.php">
                                <div class="dash-counts">
                                    <h4><?=$total_users-1?></h4>
                                    <h5>Staff</h5>
                                </div>
                                <div class="dash-imgs">
                                    <i data-feather="user"></i>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12 d-flex">
                            <a class="dash-count das1" href="product-list.php">
                                <div class="dash-counts">
                                    <h4><?=$total_products?></h4>
                                    <h5>Products</h5>
                                </div>
                                <div class="dash-imgs">
                                    <i data-feather="file"></i> 
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12 d-flex">
                            <a class="dash-count das3" href="category-list.php">
                                <div class="dash-counts">
                                    <h4><?=$total_categories?></h4>
                                    <h5>Categories</h5>
                                </div>
                                <div class="dash-imgs">
                                    <i data-feather="file-text"></i>  
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php 
                        $sql = "SELECT * FROM `products` ORDER BY `timestamp` DESC LIMIT 5";
                        $result = mysqli_query($con, $sql);
                        $data = array();
                        while($row = mysqli_fetch_assoc($result)){
                            array_push($data,$row);
                        }
                    ?>
                    <div class="card mb-0">
                        <div class="card-body">
                            <h4 class="card-title">Recently Added Products</h4>
                            <div class="table-responsive dataview">
                                <table class="table datatable ">
                                    <thead>
                                        <tr>
                                            <th>SKU</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Cost Price</th>
                                            <th>Cost incl. Tax</th>
                                            <th>Sales Price</th>
                                            <th>Sales incl. Tax</th>
                                            <th>Stock</th>
                                            <th>Size</th>
                                            <th>Color</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1;
                                        foreach ($data as $key => $val) { ?>
                                            <tr>
                                                <?php 
                                                    $cat_name = $val['product_category'];
                                                    $sql = "SELECT * FROM `categories` WHERE `category_name`='$cat_name'";
                                                    $result = mysqli_query($con, $sql);
                                                    $categ = [];
                                                    $categ = mysqli_fetch_assoc($result);
                                                ?>
                                                <td><?=$val['product_sku']?></td>
                                                <td class="productimgname">
                                                <a href="product-details.php?id=<?=$val['id']?>" class="product-img">
                                                        <img src="<?=$val['path']?>" alt="product">
                                                    </a>
                                                    <a href="product-details.php?id=<?=$val['id']?>"><?=$val['product_name']?></a>
                                                </td>
                                                <td><?=$val['product_category']?></td>
                                                <td><?=$val['cost_price']?> AED</td>
                                                <?php $cost_ok = $val['cost_price']+$categ['cost_tax'] ?>
                                                <td><?=$cost_ok?> AED</td>
                                                <td><?=$val['sale_price']?> AED</td>
                                                <?php $sale_ok = $val['sale_price']+$categ['sale_tax'] ?>
                                                <td><?=$sale_ok?> AED</td>
                                                <td><?=$val['stock']?></td>
                                                <td><?=$val['size']?></td>
                                                <td><?=$val['color']?></td>
                                            </tr>
                                        <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }else{ ?>
            <div class="page-wrapper pagehead">
                <div class="content">
                    <div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Dashboard</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a>Dashboard</a></li>
									<li class="breadcrumb-item active">Product List</li>
								</ul>
							</div>
						</div>
					</div>
                    <?php 
                        $sql = "SELECT * FROM `products`";
                        $result = mysqli_query($con, $sql);
                        $data = array();
                        while($row = mysqli_fetch_assoc($result)){
                            if($row['status']=='1'){
                                array_push($data,$row);
                            }
                        }
                    ?>
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="row py-3">
                                <div class="col-md-6">
                                    <h4 class="card-title mb-0">Select Products to Place Order</h4>
                                    <p class="text-red">Empty the search field, before placing order.</p>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <a class="me-3 btn btn-primary text-white" id="place_order" href="#" style="display:none">Place Order</a>
                                </div>
                            </div>
                            <div class="table-responsive dataview">
                                <table class="table datatable" id="userlist">
                                    <thead>
                                        <tr>
                                            <th>...</th>
                                            <th>#</th>
                                            <th>SKU</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Size</th>
                                            <th>Color</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1;
                                        foreach ($data as $key => $val) { ?>
                                            <tr>
                                                <?php 
                                                    $cat_name = $val['product_category'];
                                                    $sql = "SELECT * FROM `categories` WHERE `category_name`='$cat_name'";
                                                    $result = mysqli_query($con, $sql);
                                                    $categ = [];
                                                    $categ = mysqli_fetch_assoc($result);
                                                ?>
                                                <td><input type="checkbox" class="checkbox_z" name="checkbox[]" data-id="<?=$val['id']?>"></td>
                                                <td><?=$i?></td>
                                                <td><?=$val['product_sku']?></td>
                                                <td class="productimgname">
                                                <a href="product-details.php?id=<?=$val['id']?>" class="product-img">
                                                        <img src="<?=$val['path']?>" alt="product">
                                                    </a>
                                                    <a href="product-details.php?id=<?=$val['id']?>"><?=$val['product_name']?></a>
                                                </td>
                                                <td><?=$val['product_category']?></td>
                                                <?php $sale_ok = $val['sale_price']+$categ['sale_tax'] ?>
                                                <td><?=$sale_ok?> AED</td>
                                                <td><?=$val['stock']?></td>
                                                <td><?=$val['size']?></td>
                                                <td><?=$val['color']?></td>
                                            </tr>
                                        <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        </div>
        <!-- /Main Wrapper -->


<?php
include('main-assets/footer.php');
?>
<script>
    $(document).ready(function(){
        $(".checkbox_z").change(function(){
            checked = $("input[type='checkbox']:checked").length;
            if(checked > 0){
                link = "place-order.php?id=";
                $('input[type=checkbox]:checked').each(function(index){
                    id = $(this).attr('data-id');
                    link += "," + id
                });
                link = link.replace(',', '')
                $("#place_order").attr("href",link);
                $("#place_order").css('display','');
            }else{
                $("#place_order").css('display','none');
            }
        });
    });
    setInterval(function(){
        checked = $("input[type='checkbox']:checked").length;
        if(checked > 0){
            link = "place-order.php?id=";
            $('input[type=checkbox]:checked').each(function(index){
                id = $(this).attr('data-id');
                link += "," + id
            });
            link = link.replace(',', '')
            $("#place_order").attr("href",link);
            $("#place_order").css('display','');
        }
    }, 200);
    $(document).ready(function() {
        var dateInput = $('input[type="date"]');
        dateInput.on('input', function(){
            var selectedDate = $(this).val();
            $.ajax({
            url: 'server.php?cmd=filterData',
            type: 'POST',
            data: { date: selectedDate },
            success: function(result) {
                response = JSON.parse(result);
                $('#t_sale').html(response[0]);
                $('#t_purchase').html(response[1]);
                $('#t_sale_tax').html(response[2]);
                $('#t_cost_tax').html(response[3]);
                $('#t_orders').html(response[4]);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
            });
        });
    });
</script>