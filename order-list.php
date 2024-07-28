<?php
session_start();
if(empty($_SESSION['role'])){
  echo "<script type='text/javascript'>window.location = 'index.php';</script>";
  die();
}
include('main-assets/header.php');
include('main-assets/sidebar.php');
require_once 'main-assets/connection.php';
$email = $_SESSION['email'];
if($_SESSION['role'] == 'admin'){
    $sql = "SELECT * FROM `orders` ORDER BY `timestamp`";
    $result = mysqli_query($con, $sql);
    $data = array();
    while($row = mysqli_fetch_assoc($result)){
        array_push($data,$row);
    }
}else{
    $sql = "SELECT * FROM `orders` WHERE `placed_by`='$email' ORDER BY `timestamp`";
    $result = mysqli_query($con, $sql);
    $data = array();
    while($row = mysqli_fetch_assoc($result)){
        array_push($data,$row);
    }
}
?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title w-100">
                <div class="row">
                    <?php if($_SESSION['role'] == 'admin'){ ?>
                        <div class="col-md-6">
                            <h4>Orders</h4>
                            <h6>View All Orders</h6>
                        </div>
                    <?php }else{ ?>
                        <div class="col-md-6">
                            <h4>View Orders</h4>
                            <h6>Orders Placed By Me</h6>
                        </div>
                    <?php } ?>
                    <div class="col-md-6 d-flex justify-content-end">
                        <h6 class="text-success">Click On Customer's Name to View Order Details</h6>
                    </div>
                </div>
            </div>
        </div>
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
                                <div class="form-group w-100">
                                    <label class="mb-1">Filter Orders <span style="font-size:12px;">(MM-DD-YYYY)</span></label>
                                    <input type="date" id="datepickerID" class="form-control" value="<?=date('Y-m-d')?>" min="2023-05-30" max="<?=date('Y-m-d')?>">
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table " id="userlist">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer's Name</th>
                                <th>Customer's Email</th>
                                <th>Customer's Phone</th>
                                <th>Customer's Address</th>
                                <th>Customer's City</th>
                                <th># of Products</th>
                                <th>Total Price</th>
                                <th>Courier</th>
                                <th>Order Status</th>
                                <?php if($_SESSION['role'] == 'admin'){ ?>
                                    <th>Order Placed By</th>
                                <?php } ?>
                                <th>Order Placed At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach ($data as $key => $val) { ?>
                                <tr>
                                    <td>ORD<?=$i?></td>
                                    <td><a href="order-details.php?id=<?=$val['id']?>"><?=$val['name']?></a></td>
                                    <td><?=$val['email']?></td>
                                    <td><?=$val['phone']?></td>
                                    <td><?=$val['address']?></td>
                                    <td><?=$val['city']?></td>
                                    <?php $temp = $val['quantity'];
                                        $temp1 = explode(',',$temp);
                                        $totalProducts = count($temp1);
                                     ?>
                                    <td><?=$totalProducts?></td>
                                    <td><?=$val['total']?> AED</td>
                                    <td><?=$val['courier']?></td>
                                    <td class="text-uppercase"><?=$val['status']?></td>
                                    <?php if($_SESSION['role'] == 'admin'){ ?>
                                        <td><?=$val['placed_by']?></td>
                                    <?php } ?>
                                    <td class="timestamp"><?=$val['timestamp']?></td>
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
        var dateInput = $('input[type="date"]');
        dateInput.on('input', function(){
            $('tr').removeAttr('style');
            var date = $(this).val();
            $('.timestamp').each(function(index) {
                temp = $(this).text();
                dateOk = temp.slice(0, -9);
                console.log(dateOk);
                if(dateOk != date){
                    $(this).parent().closest('tr').css('display','none');
                }
            });
        });
    });
</script>