<?php
session_start();
if($_SESSION['role']!="admin" || empty($_SESSION['role'])){
  echo "<script type='text/javascript'>window.location = 'index.php';</script>";
  die();
}
include('main-assets/header.php');
include('main-assets/sidebar.php');
require_once 'main-assets/connection.php';
$sql = "SELECT * FROM `products` ORDER BY `id`";
$result = mysqli_query($con, $sql);
$data = array();
while($row = mysqli_fetch_assoc($result)){
    array_push($data,$row);
}
?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product List</h4>
                <h6>Manage Products</h6>
            </div>
            <div class="page-btn">
                <a href="add-product.php" class="btn btn-added"><img src="assets/img/icons/plus.svg" alt="img" class="me-2">Add Product</a>
            </div>
        </div>

        <!-- /product list -->
        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-path">
                            <a class="btn btn-filter">
                                <img src="assets/img/icons/search-whites.svg" alt="img">
                            </a>
                        </div>
                        <div class="search-input">
                            <a class="btn btn-searchset">
                                <img src="assets/img/icons/search-white.svg" alt="img">
                            </a>
                        </div>
                    </div>
                    <div class="wordset">
                        <ul>
                            <li>
                                <h6 class="mb-1" style="font-size:13px">Filter Products By Quantity</h6>
                                <select class="select" id="filterProducts">
                                        <option value="null" disabled selected>Select option</option>
                                        <option value="zero">Zero</option>
                                        <option value="non_zero">Non-Zero</option>
                                        <option value="negative">Negative</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table" id="userlist">
                        <thead>
                            <tr>
                                <th>#</th>
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
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0;
                            foreach ($data as $key => $val) { ?>
                                <tr>
                                    <?php 
                                        $cat_name = $val['product_category'];
                                        $sql = "SELECT * FROM `categories` WHERE `category_name`='$cat_name'";
                                        $result = mysqli_query($con, $sql);
                                        $categ = [];
                                        $categ = mysqli_fetch_assoc($result);
                                    ?>
                                    <td><?=$val['id']?></td>
                                    <td><?=$val['product_sku']?></td>
                                    <td class="productimgname">
                                       <a href="product-details.php?id=<?=$val['id']?>" class="product-img">
                                            <img src="<?=$val['path']?>" alt="product">
                                        </a>
                                        <a href="product-details.php?id=<?=$val['id']?>"><?=$val['product_name']?></a>
                                    </td>
                                    <td><?=$val['product_category']?></td>
                                    <td><?=$val['cost_price']?></td>
                                    <?php $cost_ok = $val['cost_price']+$categ['cost_tax'] ?>
                                    <td><?=$cost_ok?></td>
                                    <td><?=$val['sale_price']?></td>
                                    <?php $sale_ok = $val['sale_price']+$categ['sale_tax'] ?>
                                    <td><?=$sale_ok?></td>
                                    <td class="productStock"><?=$val['stock']?></td>
                                    <td><?=$val['size']?></td>
                                    <td><?=$val['color']?></td>
                                    <?php if($val['status'] == 1){ ?>
                                        <td>
                                            <div class="status-toggle d-flex justify-content-between align-items-center">
                                                <input type="checkbox" id="product<?=$i?>" class="check product_status" data-id="<?=$val['id']?>" checked>
                                                <label for="product<?=$i?>" class="checktoggle">checkbox</label>
                                            </div>
                                        </td>
                                    <?php }else{ ?>
                                        <td>
                                            <div class="status-toggle d-flex justify-content-between align-items-center">
                                                <input type="checkbox" id="product<?=$i?>" class="check product_status" data-id="<?=$val['id']?>">
                                                <label for="product<?=$i?>" class="checktoggle">checkbox</label>
                                            </div>
                                        </td>
                                    <?php } ?>
                                    <td>
                                        <a class="me-3" href="add-product.php?id=<?=$val['id']?>">
                                            <img src="assets/img/icons/edit.svg" alt="img">
                                        </a>
                                        <a class="me-3" href="delete-product.php?id=<?=$val['id']?>">
                                            <img src="assets/img/icons/delete.svg" alt="img">
                                        </a>
                                    </td>
                                </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /product list -->
    </div>
</div>

<?php include('main-assets/footer.php'); ?>
<script>
    $(document).ready(function(){
        $(".product_status").change(function(){
            id = $(this).attr('data-id');
            if($(this).is(":checked")){
                status = '1';
            }else{
                status = '0';
            }
            check_dd(id,status);
        });
    });
    function check_dd(id,status) {
        thisID = id;
        thisSt = status;
        url = 'server.php?cmd=product_status';
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
    $(document).ready(function(){
        $("#filterProducts").change(function(){
            $('tr').removeAttr('style');
            value = $(this).val();
            if(value == 'zero'){
                $('.productStock').each(function(index) {
                    temp = $(this).text();
                    stock = parseFloat(temp);
                    if(stock != 0){
                        $(this).parent().closest('tr').css('display','none');
                    }
                });
            }else if(value == 'non_zero'){
                $('.productStock').each(function(index) {
                    temp = $(this).text();
                    stock = parseFloat(temp);
                    if(stock == 0){
                        $(this).parent().closest('tr').css('display','none');
                    }
                });
            }else if(value == 'negative'){
                $('.productStock').each(function(index) {
                    temp = $(this).text();
                    stock = parseFloat(temp);
                    if(stock >= 0){
                        $(this).parent().closest('tr').css('display','none');
                    }
                });
            }
        });
    });
</script>