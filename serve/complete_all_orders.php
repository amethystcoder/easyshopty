<?php
error_reporting(E_ALL ^ E_WARNING);
    session_start();

    try {
        $user_id = empty($_SESSION["user_id"]) ? "" : $_SESSION["user_id"];
        if ($user_id) {
            $orders = json_decode(file_get_contents("orders.json"),true);
            $users = json_decode(file_get_contents("users.json"),true);
            $earnings = json_decode(file_get_contents("earnings.json"),true);
            $incomplete_balance = false;
            $user = null;
            for($i =0;$i<count($users);$i++){
                if($users[$i]["user_id"] == $user_id){
                    $user = $users[$i];
                    $user_position = $i;
                    break;
                }
            }
            for($i =0;$i<count($orders);$i++){
                if($orders[$i]["user_id"] == $user_id && $orders[$i]["status"] != "failed"){
                    $amnt = $orders[$i]["goods"]["goods_price"] * $orders[$i]["goods"]["goods_count"] + 5;
                        if ($user["balance"] < $amnt) {
                            $gap = $amnt - $user["balance"];
                            $incomplete_balance = true;
                            break;
                        }
                        else{
                            $user["balance"] -= ($amnt - 5);
                            $orders[$i]["status"] = "completed";
                            $earning = ($orders[$i]["goods"]["num"] * $orders[$i]["goods"]["commission"]);
                            $new_earning_data = ["tymd"=>time(),"amount" => $earning, "date" => gmdate("M d Y H:i:s",time()),"user_id" => $user["user_id"]];
                            $user["balance"] += $earning;
                            $earnings[count($earnings)] = $new_earning_data;
                        }
                }
            }
            if ($incomplete_balance) {
                echo json_encode(array("code" => 2, "info" => "balance not enough. there is a gap of ".$gap));
            } else {
                $users[$user_position] = $user;
                $saved_earning = file_put_contents("earnings.json",json_encode($earnings));
                $saved = file_put_contents("orders.json",json_encode($orders));
                $saved_user = file_put_contents("users.json",json_encode($users));
                echo json_encode(array("code" => 0, "info" => "success"));
            }
        }
        else{
            echo json_encode(array("code" => 2, "info" => "you are not signed in... sign in or register to place an order"));
        }
    } catch (\Throwable $th) {
        echo json_encode(array("code" => 1, "info" => "some error occured"));
    }

?>