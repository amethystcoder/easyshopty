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
    $user_order_count = 0;

    for ($i=0; $i < count($orders); $i++) { 
        if ($orders[$i]["user_id"] == $user_id) {
            $user_order_count++;
        }
    }

    $user_status = "";
    for ($i=0; $i < count($users); $i++) { 
        if ($users[$i]["user_id"] == $user_id) {
            $user_status = $users[$i]["user_status"];
            $tymd = $users[$i]["tymd"];
            break;
        }
    }
    $commission = 0;
    if ($user_status == "VIP 1") {
        $commission = 0.12;
    } elseif (user_status == "VIP 2") {
        $commission = 0.13;
    } elseif ($user_status == "VIP 3") {
        $commission = 0.14;
    }

    $new_tymd = time()-$tymd;
    $time = 60 * 60 * 24;
    $v_time = round($new_tymd / $time);
    $mist = 0;
    
    if ($v_time < 1) {
        //$goods = $products["1"];
    }
    elseif ($v_time > 1 && $v_time <= 2 ) {
       //$goods = $products["2"];
    }
    elseif ($v_time > 3 && $v_time <= 4 ) {
        //$goods = $products["4"];
    }
    if ($user_order_count <= count($goods)) {
        $selected_product = $goods[$user_order_count];
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