<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();
try {
    $user_id = $_SESSION["user_id"];
    
    $order_id = $_POST["id"];
    $orders = json_decode(file_get_contents("orders.json"),true);
    $goods = json_decode(file_get_contents("product_list.json"),true);
    $users = json_decode(file_get_contents("users.json"),true);
    $tymd = null;
    $group = null;
    $user_order_count = 0;

    $user_status = "";
    for ($i=0; $i < count($users); $i++) { 
        if ($users[$i]["user_id"] == $user_id) {
            $user_status = $users[$i]["user_status"];
            $tymd = $users[$i]["tymd"];
            $group = $users[$i]["group"];
            break;
        }
    }

    for ($i=0; $i < count($orders); $i++) { 
        if ($orders[$i]["user_id"] == $user_id && $orders[$i]["group"] == $group) {
            $user_order_count++;
        }
    }

    /* $ord_num = 0;
    if ($user_grade == "Day 1") {
        $commission = 0.12;
    } elseif ($user_grade == "Day 2") {
        $commission = 0.13;
    } elseif ($user_grade == "Day 4") {
        $commission = 0.14;
    }elseif ($user_grade == "Day 6") {
        $commission = 0.14;
    } */
    $commission = 0;
    if ($group == "Day 4 own account (self)" && $user_order_count == 48) {
        $commission = 770;
    }
    else{
        if ($user_status == "VIP 1") {
            $commission = 0.12;
        } elseif ($user_status == "VIP 2") {
            $commission = 0.13;
        } elseif ($user_status == "VIP 3") {
            $commission = 0.14;
        }
    }

    for ($i=0; $i < count($goods); $i++) { 
        if ($goods[$i]["name"] == $group) {
            $goods = $goods[$i]["products"];
            break;
        }
    }

    if ($user_order_count <= count($goods)) {
        if($user_order_count <= $ord_num){}
        else{}
        $selected_product = $goods[$user_order_count - 1];
        for($i =0;$i<count($orders);$i++){
            if($orders[$i]["oid"] == $order_id){
                $selected_product["oid"] = $orders[$i]["oid"];
                $selected_product["addtime"] = $orders[$i]["addtime"];
                $selected_product["num"] = ($selected_product["goods_count"] * $selected_product["goods_price"]) + ($selected_product["goods_price"] * $commission);
                $selected_product["commission"] = $commission;
                $orders[$i]["goods"] = $selected_product; 
                $orders[$i]["user_id"] = $user_id;
                break;
            }
        }
        $saved = file_put_contents("orders.json",json_encode($orders));
        echo json_encode(array("code" => 0, "data" => [$selected_product]));
    }
    else{
        echo json_encode(array("code" => 2, "data" => "total maximum orders reached"));
    }
    
} catch (\Throwable $th) {
    echo json_encode(array("code" => 1, "data" => "an error occured"));
}

?>
