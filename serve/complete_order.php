<?php

    session_start();

    try {
        $user_id = empty($_SESSION["user_id"]) ? "" : $_SESSION["user_id"];
        $order_id = $_POST["oid"];
        if ($user_id) {
            $orders = json_decode(file_get_contents("orders.json"),true);
            $users = json_decode(file_get_contents("users.json"),true);
            $user = null;
            for($i =0;$i<count($users);$i++){
                if($users[$i]["user_id"] == $user_id){
                    $user = $users[$i];
                }
            }
            if (isset($user)) {
                for($i =0;$i<count($orders);$i++){
                    if($orders[$i]["oid"] == $order_id){
                        $amnt = $orders[$i]["goods"]["goods_price"] * $orders[$i]["goods"]["goods_count"] + 5;
                        if ($user["balance"] < $amnt) {
                            $gap = $amnt - $user["balance"];
                            echo json_encode(array("code" => 2, "info" => "balance not enough. there is a gap of ".$gap));
                            break;
                        }
                        else {
                            $orders[$i]["status"] = "completed";
                            $saved = file_put_contents("orders.json",json_encode($orders));
                            echo json_encode(array("code" => 0, "info" => "success"));
                            break;
                        }
                    }
                }
                
            }
            else {
                echo json_encode(array("code" => 2, "info" => "user does not exist"));
            }
        }
        else{
            echo json_encode(array("code" => 2, "info" => "you are not signed in... sign in or register to place an order"));
        }
    } catch (\Throwable $th) {
        echo json_encode(array("code" => 1, "info" => "some error occured"));
    }

?>