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
    $goods = json_decode(file_get_contents("product_list.json"),true);
    
    if (count($goods) > 0) {
        $selected_product = $goods[random_int(0,count($goods)-1)];
        $selected_product["code"] = 0;
        $selected_product["oid"] = create_oid();
        echo json_encode($selected_product);
    }
    else {
        echo json_encode(["code" => 1, "info"=>"no goods available"]);
    }
} catch (\Throwable $th) {
    echo json_encode(["code" => 1, "info"=>"an error occured"]);
}

?>