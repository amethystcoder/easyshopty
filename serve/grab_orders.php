<?php

session_start();
error_reporting(E_ALL ^ E_WARNING);
function create_oid() {
    $char_list = ["Q","W","E","R","T","Y","U","I","O","P","A","S","D","F","G","H","J","K","L","Z","X","C",
                    "V","B","N","M","1","2","3","4","5","6","7","8","9"];
    $result = "SYS";
    for ($i=0; $i < 18; $i++) { 
        $result .= $char_list[(time() * random_int(1111,9999)) % (count($char_list) - 1)];
    }
    return $result;
}

try {
    $user_id = empty($_SESSION["user_id"]) ? "" : $_SESSION["user_id"] ;
    $orders = json_decode(file_get_contents("orders.json"),true);
    $users = json_decode(file_get_contents("users.json"),true);
    $user = null;
    $user_position = null;
    $order_amount = 0;
    $incomplete_order_exists = false;
    if (!empty($user_id)) {
        for ($i=0; $i < count($users); $i++) { 
            if ($users[$i]["user_id"] == $user_id) {
                $user = $users[$i];
                $user_position = $i;
                break;
            }
        }
        
        if ($user["balance"] < 5) {
            echo json_encode(["code" => 1, "info"=>"you need to have minimum of 5TRX to make/complete an order"]);
        }
        else {
            for ($i=0; $i < count($orders); $i++) { 
                if ($orders[$i]["status"] == "pending" && $orders[$i]["user_id"] == $user_id) {
                    $incomplete_order_exists = true;
                }
                if ($orders[$i]["group"] == $user["group"] && $orders[$i]["user_id"] == $user_id){
                    $order_amount++;
                }
            }
            $max_amt = 0;
            if ($user["user_status"] == "VIP 1"){
                $max_amt = 66;
            }
            else if($user["user_status"] == "VIP 2"){
                $max_amt = 68;
            }
            else if($user["user_status"] == "VIP 3"){
                $max_amt = 70;
            }
            if($order_amount => $max_amt){
                echo json_encode(["code" => 4, "info"=>"maximum day order of ".$max_amt." reached. Wait for next day before ordering again"]);
            }
            else{
                if ($incomplete_order_exists) {
                echo json_encode(["code" => 2, "info"=>"please complete all pending orders before making a new order"]);
            }
            else {
                $selected_product = [];
                $selected_product["code"] = 0;
                $selected_product["oid"] = create_oid();
                $selected_product["addtime"] = gmdate("M d Y H:i:s",time());
                $selected_product["tymd"] = time();
                $selected_product["status"] = "pending";
                $selected_product["group"] = $user["group"];
                $orders[count($orders)] = $selected_product;
                $user["order_state_amount"]--;
                $users[$user_position] = $user;
                $saved_user = file_put_contents("users.json",json_encode($users));
                $saved = file_put_contents("orders.json",json_encode($orders));
                echo json_encode($selected_product);
            }
            }
        }
    }
    else {
        echo json_encode(["code" => 4, "info"=>"you are not logged in, log in to grab orders"]);
    }
    
} catch (\Throwable $th) {
    echo json_encode(["code" => 3, "info"=>"an error occured"]);
}

?>
