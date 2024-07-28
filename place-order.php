<?php
session_start();
if(empty($_SESSION['role'])){
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
                <h4>Order Management</h4>
                <h6>Enter Customer Details to Place Order</h6>
            </div>
        </div>
        <?php if(!empty($_GET['id'])){
            $str = $_GET['id'];
            $arr = explode(',',$str);
        ?>
        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Selected Products</h4>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <p>Enter Quantity for Products</p>
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
                                        $data = [];
                                        $data = mysqli_fetch_assoc($response);
                                        $cat_name = $data['product_category'];
                                        $sql = "SELECT * FROM `categories` WHERE `category_name`='$cat_name'";
                                        $result = mysqli_query($con, $sql);
                                        $categ = [];
                                        $categ = mysqli_fetch_assoc($result);
                                    ?>
                                    <td><?=$i?></td>
                                    <td><?=$data['product_sku']?></td>
                                    <td class="productimgname">
                                    <a href="product-details.php?id=<?=$data['id']?>" class="product-img">
                                            <img src="<?=$data['path']?>" alt="product">
                                        </a>
                                        <a href="product-details.php?id=<?=$data['id']?>"><?=$data['product_name']?></a>
                                    </td>
                                    <?php $sale_ok = $data['sale_price']+$categ['sale_tax'] ?>
                                    <td><?=$sale_ok?> AED</td>
                                    <td><?=$data['stock']?></td>
                                    <td><?=$data['size']?></td>
                                    <td><?=$data['color']?></td>
                                    <td><input type="number" data-price="<?=$sale_ok?>" class="sel_product" min="1" value="1"></td>
                                </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php }else{
            echo '<script type="text/javascript">window.location = "index.php";</script>';
        } ?>
        <div class="row pt-3">
            <div class="col-md-8 mx-auto">
                <?php if(!empty($_GET['id'])){
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM `products` WHERE `id`='$id'";
                    $result = mysqli_query($con, $sql);
                    $num = mysqli_num_rows($result);
                    $data = [];
                    $data = mysqli_fetch_assoc($result);
                    if($num < 1){
                        echo '<script type="text/javascript">window.location = "product-list.php";</script>';
                    }
                    $cat_name = $data['product_category'];
                    $sql = "SELECT * FROM `categories` WHERE `category_name`='$cat_name'";
                    $result = mysqli_query($con, $sql);
                    $categ = [];
                    $categ = mysqli_fetch_assoc($result);
                    $sale_ok = $data['sale_price']+$categ['sale_tax']
                    ?>
                    <form class="card" action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" value="<?=$_SESSION['email']?>" name="placed_by">
                        <input type="hidden" value="<?=$_GET['id']?>" name="products">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" required placeholder="Enter Customer Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" placeholder="Enter Customer's Email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" required placeholder="+92 311 1234567">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Complete Address</label>
                                        <input type="text" name="address" required placeholder="House # 01, Street # 02, Near anyplace, ABC Road, City ABC">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" name="city" required placeholder="City Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Courier</label>
                                        <select class="select text-capitalize" name="courier" required>
                                            <?php 
                                                $sql = "SELECT * FROM `couriers`";
                                                $result = mysqli_query($con, $sql);
                                                $categ = [];
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    array_push($categ, $row);
                                                }
                                            ?>
                                            <?php foreach ($categ as $key => $val) { ?>
                                                <?php if($val['status'] == '1'){ ?>
                                                    <option value="<?=$val['name']?>" ><?=$val['name']?></option>
                                                <?php }else{ ?>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 d-flex">
                                    <div id="appendPrice" class="d-flex mr-auto me-2">
                                        <b class="text-secondary fw-bold">Total Price:&nbsp;</b>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-submit me-2 ml-auto">Place Order</button>
                                </div>
                            </div>
                        </div>
                        <div id="toAppend"></div>
                    </form>
            </div>
                <?php  }else{
                    echo '<script type="text/javascript">window.location = "index.php";</script>';
                } ?>
        </div>
    </div>
</div>
<?php 
include('main-assets/footer.php');
if(isset($_POST["submit"])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $quantity = $_POST['quantity'];
    $courier = $_POST['courier'];
    $products = $_POST['products'];
    $order_by = $_POST['placed_by'];
    $total = $_POST['total_price'];
    if(empty($email)){
        $email = "Not Defined";
    }

    $arr2 = explode(',',$quantity);
    $arr1 = explode(',',$products);
    foreach ($arr1 as $key => $val){
        $q1=mysqli_query($con,"SELECT * FROM `products` WHERE `id`='$val'");
        $data = array();
        $data = mysqli_fetch_assoc($q1);
        $temp1 = $data['stock'];
        $temp2 = $arr2[$key];
        $temp3 = intval($temp1) - intval($temp2);
        $q1=mysqli_query($con,"UPDATE `products` SET `stock`='$temp3' WHERE `id`='$val'");
    }
    $q1=mysqli_query($con,"INSERT INTO orders(`name`,`email`,`phone`,`address`,`city`,`courier`,`product_sku`,`quantity`,`total`,`placed_by`) VALUES('$name','$email','$phone','$address','$city','$courier','$products','$quantity','$total','$order_by')");
    if(!$q1){
        echo '<script type="text/javascript">';
        echo 'Swal.fire({icon: "warning", title: "ERROR!", text: "Server Error, Try Again Later!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
        echo '</script>';
        echo mysqli_error($con);
    }else{
        echo '<script type="text/javascript">';
        echo 'Swal.fire({icon: "success", title: "Success!", text: "Order Placed!", type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1,});';
        echo '</script>';
    }
}
?>
<script>
    $(document).ready(function() {
    i= 1;
    temprice = 0;
    quantity = "";
    $(".sel_product").each(function(index, element) {
        var newValue = $(this).val();
        quantity += "," + newValue;
        price = $(this).attr('data-price');
        temprice = temprice + parseInt(price);
        i++;
    });
    quantity = quantity.replace(',', '');
    appendPrice = '<b class="text-primary fw-bold">'+temprice+' AED</b><input type="hidden" name="total_price" value="'+temprice+'"><input type="hidden" name="quantity" value="'+quantity+'">';
    $('#appendPrice').append(appendPrice);
    $(".sel_product").on('input', function(){
        $('#toAppend').empty();
        $('#appendPrice').empty();
        i= 1;
        temprice = 0;
        quantity = "";
        $(".sel_product").each(function(index, element){
            var newValue = $(this).val();
            var price = $(this).attr('data-price');
            quantity += "," + newValue;
            price = parseInt(price)*parseInt(newValue);
            temprice = temprice + price;
            i++;
        });
        quantity = quantity.replace(',', '');
        appendPrice = '<b class="text-secondary fw-bold">Total Price:&nbsp;</b><b class="text-primary fw-bold">'+temprice+' AED</b><input type="hidden" name="total_price" value="'+temprice+'"><input type="hidden" name="quantity" value="'+quantity+'">';
        $('#appendPrice').append(appendPrice);
      });
    });
</script>