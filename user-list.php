<?php
session_start();
if($_SESSION['role']!="admin" || empty($_SESSION['role'])){
  echo "<script type='text/javascript'>window.location = 'index.php';</script>";
  die();
}
include('main-assets/header.php');
include('main-assets/sidebar.php');
require_once 'main-assets/connection.php';
$sql = "SELECT * FROM `pos_users` ORDER BY `id`";
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
                <h4>User List</h4>
                <h6>Manage Users</h6>
            </div>
            <div class="page-btn">
                <a href="add-user.php" class="btn btn-added"><img src="assets/img/icons/plus.svg" alt="img"
                        class="me-2">Add User</a>
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
                                <h6 style="font-size: 13px;">Delete Button Will Permanently Delete Selected User!</h6>
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
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Password</th>
                                <th>Access</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;
                                foreach ($data as $key => $val) {
                                    if($val['email']=='riothunter_admin@mail.com'){
                                        continue;
                                    }
                                    if($val['email']=='riothunter_staff@mail.com'){
                                        continue;
                                    }
                                ?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$val['first_name']?> <?=$val['last_name']?></td>
                                    <td><?=$val['email']?></td>
                                    <td><?=$val['phone']?></td>
                                    <td><?=$val['password']?></td>
                                    <?php if($val['status'] == 1){ ?>
                                        <td>
                                            <div class="status-toggle d-flex justify-content-between align-items-center">
                                                <input type="checkbox" id="product<?=$i?>" class="check user_status" data-id="<?=$val['id']?>" checked>
                                                <label for="product<?=$i?>" class="checktoggle">checkbox</label>
                                            </div>
                                        </td>
                                    <?php }else{ ?>
                                        <td>
                                            <div class="status-toggle d-flex justify-content-between align-items-center">
                                                <input type="checkbox" id="product<?=$i?>" class="check user_status" data-id="<?=$val['id']?>">
                                                <label for="product<?=$i?>" class="checktoggle">checkbox</label>
                                            </div>
                                        </td>
                                    <?php } ?>
                                    <td>
                                        <a class="me-3" href="add-user.php?id=<?=$val['id']?>">
                                            <img src="assets/img/icons/edit.svg" alt="img">
                                        </a>
                                        <a class="me-3" href="delete-user.php?id=<?=$val['id']?>">
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
        $(".user_status").change(function(){
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
        url = 'server.php?cmd=user_status';
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
</script>