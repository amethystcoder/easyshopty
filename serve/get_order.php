<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();
try {
    $user_id = $_SESSION["user_id"];
    
    $order_id = $_POST["oid"];
    $orders = json_decode(file_get_contents("orders.json"),true);
    $order = [];
    if (!empty($user_id)) {
        for ($i=0; $i < count($orders); $i++) { 
            if ($orders[$i]["oid"] == $order_id) {
                $order = $orders[$i];
                break;
            }
        }
        echo json_encode(array("code" => 0, "data" => [$order]));
    }
    else{
        echo json_encode(array("code" => 1, "info" => "you are not logged in"));
    }
    
} catch (\Throwable $th) {
    echo json_encode(array("code" => 1, "info" => "an error occured"));
}

?>