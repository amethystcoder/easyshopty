<?php
session_start();
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
    $orders = json_decode(file_get_contents("orders.json"),true);
    $selected_product = [];
    $selected_product["code"] = 0;
    $selected_product["oid"] = create_oid();
    $selected_product["addtime"] = gmdate("Y-m-d",time());
    $selected_product["status"] = "pending";
    $orders[count($orders)] = $selected_product;
    $saved = file_put_contents("orders.json",json_encode($orders));
    echo json_encode($selected_product);
} catch (\Throwable $th) {
    echo json_encode(["code" => 0, "info"=>"an error occured"]);
}

?>