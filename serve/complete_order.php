<?php

    session_start();

    try {
        $user_id = empty($_SESSION["user_id"]) ? "" : $_SESSION["user_id"];
        $order_id = $_POST["oid"];
        if ($user_id) {
            $orders = json_decode(file_get_contents("orders.json"),true);
            for($i =0;$i<count($orders);$i++){
                if($orders[$i]["oid"] == $order_id){
                    $orders[$i]["status"] = "completed";
                }
            }
            $saved = file_put_contents("orders.json",json_encode($orders));
            echo json_encode(array("code" => 0, "info" => "success"));
        }
        else{
            echo json_encode(array("code" => 2, "info" => "you are not signed in... sign in or register to place an order"));
        }
    } catch (\Throwable $th) {
        echo json_encode(array("code" => 1, "info" => "some error occured"));
    }

?>