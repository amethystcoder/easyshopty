<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();
try {
    $user_id = empty($_SESSION["user_id"]) ? "" : $_SESSION["user_id"] ;
    if(!empty($user_id)){
        $orders = json_decode(file_get_contents("orders.json"),true);
        $users = json_decode(file_get_contents("users.json"),true);
        $response = [];
        for ($i=0; $i < count($users); $i++) { 
            if ($users[$i]["user_id"] == $user_id) {
                $response["balance"] = $users[$i]["balance"];
                $response["user_id"] = $users[$i]["user_id"];
                $response["user_status"] = $users[$i]["user_status"];
                break;
            }
        }
        $order_count = 0;
        $complete_order_count = 0;
        $incomplete_order_count = 0;
        for ($i=0; $i < count($orders); $i++) { 
            if ($orders[$i]["user_id"] == $user_id && $orders[$i]["status"] == "pending") {
                $order_count++;
                $incomplete_order_count++;
            }
            elseif ($orders[$i]["user_id"] == $user_id && $orders[$i]["status"] == "completed") {
                $order_count++;
                $complete_order_count++;
            }
        }
        $response["all_orders"] = $order_count;
        $response["completed_orders"] = $complete_order_count;
        $response["pending_orders"] = $incomplete_order_count;
        echo json_encode(array("code" => 0,"data"=> $response, "message" => "successful"));
    }
    else {
        echo json_encode(array("code" => 3,"data"=> false, "message" => "session doesn't exist, please login to change your password"));
    }
} catch (\Throwable $th) {
    echo json_encode(array("code" => 1,"data"=> false, "message" => "an error occurred"));
}

?>