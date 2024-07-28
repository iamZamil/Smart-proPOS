<?php 
require_once 'main-assets/connection.php';
$cmd = $_REQUEST['cmd'];
switch ($cmd){
    case 'user_status': {
        $id = $_REQUEST['id'];
        $status = $_REQUEST['status'];
        $q1=mysqli_query($con,"UPDATE `pos_users` SET `status`='$status' WHERE `id`='$id'");
        $response = "Error!";
        if(!$q1){
            echo $response;
        }else{
            $response = "Done!";
            echo $response;
        }
    }
    break;
    case 'product_status': {
        $id = $_REQUEST['id'];
        $status = $_REQUEST['status'];
        $q1=mysqli_query($con,"UPDATE `products` SET `status`='$status' WHERE `id`='$id'");
        $response = "Error!";
        if(!$q1){
            echo $response;
        }else{
            $response = "Done!";
            echo $response;
        }
    }
    break;
    case 'courier_status': {
        $id = $_REQUEST['id'];
        $status = $_REQUEST['status'];
        $q1=mysqli_query($con,"UPDATE `couriers` SET `status`='$status' WHERE `id`='$id'");
        $response = "Error!";
        if(!$q1){
            echo $response;
        }else{
            $response = "Done!";
            echo $response;
        }
    }
    break;
    case 'order_status': {
        $id = $_REQUEST['id'];
        $status = $_REQUEST['status'];
        $q1=mysqli_query($con,"UPDATE `orders` SET `status`='$status' WHERE `id`='$id'");
        $response = "Error!";
        if(!$q1){
            echo $response;
        }else{
            $response = "Done!";
            echo $response;
        }
    }
    break;
    case 'update_db': {
        $status = $_REQUEST['status'];
        if($status == 'inprocess'){
            return;
        }else if($status == 'delivered'){
            return;
        }else if($status == 'cancelled'){
            $products = $_REQUEST['products'];
            $quantity = $_REQUEST['quantity'];
            $arr2 = explode(',',$quantity);
            $arr1 = explode(',',$products);
            foreach ($arr1 as $key => $val){
                $q1=mysqli_query($con,"SELECT * FROM `products` WHERE `id`='$val'");
                $data = array();
                $data = mysqli_fetch_assoc($q1);
                $temp1 = $data['stock'];
                $temp2 = $arr2[$key];
                $temp3 = intval($temp1) + intval($temp2);
                $q1=mysqli_query($con,"UPDATE `products` SET `stock`='$temp3' WHERE `id`='$val'");
            }
        }
    }
    break;
    case 'filterData': {
        $inputDate = $_REQUEST['date'];
        $formattedDate = date("Y-m-d H:i:s", strtotime($inputDate));
        $tomorrow = date("Y-m-d H:i:s", strtotime($formattedDate."+1 day"));
        $sql = "SELECT * FROM `products` WHERE `timestamp` >= '$formattedDate' AND `timestamp` < '$tomorrow'";
        $result = mysqli_query($con, $sql);
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
        $sql = "SELECT * FROM `orders` WHERE `timestamp` >= '$formattedDate' AND `timestamp` < '$tomorrow'";
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

        $final = array();
        array_push($final,$total_sale,$total_purchase,$total_sale_tax,$total_cost_tax,$total_orders);
        $response = json_encode($final);
        echo $response;
    }
    break;
    case 'filterProducts':{
        $val = $_REQUEST['value'];
        if($val == 'zero'){

        }else if($val == 'non_zero'){

        }else if($val == 'negative'){
            
        }
    }
    break;
}
?>