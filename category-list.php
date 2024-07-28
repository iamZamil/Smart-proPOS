<?php
session_start();
if($_SESSION['role']!="admin" || empty($_SESSION['role'])){
  echo "<script type='text/javascript'>window.location = 'index.php';</script>";
  die();
}
include('main-assets/header.php');
include('main-assets/sidebar.php');
require_once 'main-assets/connection.php';
$sql = "SELECT * FROM `categories` ORDER BY `id`";
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
                <h4>Category List</h4>
                <h6>Manage Categories</h6>
            </div>
            <div class="page-btn">
                <a href="add-category.php" class="btn btn-added"><img src="assets/img/icons/plus.svg" alt="img"
                        class="me-2">Add Category</a>
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
                                <h6 style="font-size: 13px;">Delete Button Will Permanently Delete Selected Category!</h6>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table " id="userlist">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Cost Tax</th>
                                <th>Sales Tax</th>
                                <th>Description</th>
                                <th>Number Of Products</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;
                            foreach ($data as $key => $val) { ?>
                                <tr>
                            <?php 
                                $cat_name = $val['category_name'];
                                $sql = "SELECT * FROM `products` WHERE `product_category`='$cat_name'";
                                $result = mysqli_query($con, $sql);
                                $num = mysqli_num_rows($result);
                                $categ= [];
                                while($row = mysqli_fetch_assoc($result)) {
                                    array_push($categ, $row);
                                }
                                $numF = 0;
                                foreach ($categ as $key => $value) {
                                    $numF += $value['stock'];
                                }
                            ?>
                                    <td><?=$i?></td>
                                    <td><?=$val['category_name']?></td>
                                    <td><?=$val['cost_tax']?> AED</td>
                                    <td><?=$val['sale_tax']?> AED</td>
                                    <td><?=$val['category_desc']?></td>
                                    <td><?=$num?></td>
                                    <td><?=$numF?></td>
                                    <td>
                                        <a class="me-3" href="add-category.php?id=<?=$val['id']?>">
                                            <img src="assets/img/icons/edit.svg" alt="img">
                                        </a>
                                        <a class="me-3" href="delete-category.php?id=<?=$val['id']?>">
                                            <img src="assets/img/icons/delete.svg" alt="img">
                                        </a>
                                    </td>
                                </tr>
                            <?php $i++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /product list -->
    </div>
</div>

<?php include('main-assets/footer.php'); ?>
<?php 

?>