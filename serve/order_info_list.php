<?php
session_start();
try {
    $user_id = $_SESSION["user_id"];
    
    $order_id = $_POST["id"];
    $orders = json_decode(file_get_contents("orders.json"),true);
    $goods = json_decode(file_get_contents("product_list.json"),true);
    $users = json_decode(file_get_contents("users.json"),true);

    $user_status = "";
    for ($i=0; $i < count($users); $i++) { 
        if ($users[$i]["user_id"] == $user_id) {
            $user_status = $users[$i]["user_status"];
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
    
    $selected_product = $goods[random_int(0,count($goods)-1)];
    for($i =0;$i<count($orders);$i++){
        if($orders[$i]["oid"] == $order_id){
            $orders[$i]["goods"] = $selected_product; 
            $orders[$i]["user_id"] = $user_id;
            $selected_product["oid"] = $orders[$i]["oid"];
            $selected_product["addtime"] = $orders[$i]["addtime"];
            $selected_product["num"] = ($selected_product["goods_count"] * $selected_product["goods_price"]) + ($selected_product["goods_price"] * $commission);
            $selected_product["commission"] = $commission;
            break;
        }
    }
    $saved = file_put_contents("orders.json",json_encode($orders));
    echo json_encode(array("code" => 0, "data" => [$selected_product]));
    
} catch (\Throwable $th) {
    echo json_encode(array("code" => 0, "data" => "an error occured"));
}

?>