<?php

error_reporting(E_ALL ^ E_WARNING);
session_start();

try {
    $admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"];
    $type = $_POST["type"];
    $addtime = $_POST["addtime"];
    $user_id = $_POST["user_id"];
    $orders = json_decode(file_get_contents("orders.json"),true);
    $users = json_decode(file_get_contents("users.json"),true);
    $withdrawals = json_decode(file_get_contents("withdrawals.json"),true);
    $deposits = json_decode(file_get_contents("deposits.json"),true);
    $cummulative_withdrawals = 0;
    $cummulative_deposits = 0;
    $result = ["data" => []];
    if (!empty($admin_id) && !empty($user_id)) {
        for ($i=0; $i < count($users); $i++) { 
            if ($users[$i]["user_id"] == $user_id) {
                $result["user"] = $users[$i];
            }
         }
        //filter based on type
        if ($type == '') {
            if (!empty($addtime)) {
                for ($i=0; $i < count($orders); $i++) { 
                    if ($orders[$i]["user_id"] == $user_id && $orders[$i]["addtime"] == $addtime) {
                        $new_data = array(
                            "user_id" => $orders[$i]["user_id"],
                            "order_number" => $orders[$i]["oid"],
                            "amount" => $orders[$i]["goods"]["goods_price"],
                            "date" => $orders[$i]["addtime"],
                            "type" => "order",
                            "state" => "expenses"
                        );
                        $result["data"][count($result["data"])] = $new_data;
                    }
                }
                for ($i=0; $i < count($withdrawals); $i++) { 
                    if ($withdrawals[$i]["user_id"] == $user_id && $withdrawals[$i]["date_of_withdrawal"] == $addtime) {
                        $new_data = array(
                            "user_id" => $withdrawals[$i]["user_id"],
                            "order_number" => $withdrawals[$i]["withdrawal_id"],
                            "amount" => $withdrawals[$i]["num"],
                            "date" => $withdrawals[$i]["date_of_withdrawal"],
                            "type" => "withdrawal",
                            "state" => "income"
                        );
                        $result["data"][count($result["data"])] = $new_data;
                        $cummulative_withdrawals++;
                    }
                }
                for ($i=0; $i < count($deposits); $i++) { 
                    if ($deposits[$i]["user_id"] == $user_id && $deposits[$i]["date"] == $addtime) {
                        $new_data = array(
                            "user_id" => $deposits[$i]["user_id"],
                            "order_number" => $deposits[$i]["deposit_id"],
                            "amount" => $deposits[$i]["price"],
                            "date" => $deposits[$i]["date"],
                            "type" => "deposit",
                            "state" => "income"
                        );
                        $result["data"][count($result["data"])] = $new_data;
                        $cummulative_deposits++;
                    }
                }
            } else {
                for ($i=0; $i < count($orders); $i++) { 
                    if ($orders[$i]["user_id"] == $user_id) {
                        $new_data = array(
                            "user_id" => $orders[$i]["user_id"],
                            "order_number" => $orders[$i]["oid"],
                            "amount" => $orders[$i]["goods"]["goods_price"],
                            "date" => $orders[$i]["addtime"],
                            "type" => "order",
                            "state" => "expenses"
                        );
                        $result["data"][count($result["data"])] = $new_data;
                    }
                }
                for ($i=0; $i < count($withdrawals); $i++) { 
                    if ($withdrawals[$i]["user_id"] == $user_id) {
                        $new_data = array(
                            "user_id" => $withdrawals[$i]["user_id"],
                            "order_number" => $withdrawals[$i]["withdrawal_id"],
                            "amount" => $withdrawals[$i]["num"],
                            "date" => $withdrawals[$i]["date_of_withdrawal"],
                            "type" => "withdrawal",
                            "state" => "income"
                        );
                        $result["data"][count($result["data"])] = $new_data;
                        $cummulative_withdrawals++;
                    }
                }
                for ($i=0; $i < count($deposits); $i++) { 
                    if ($deposits[$i]["user_id"] == $user_id) {
                        $new_data = array(
                            "user_id" => $deposits[$i]["user_id"],
                            "order_number" => $deposits[$i]["deposit_id"],
                            "amount" => $deposits[$i]["price"],
                            "date" => $deposits[$i]["date"],
                            "type" => "deposit",
                            "state" => "income"
                        );
                        $result["data"][count($result["data"])] = $new_data;
                        $cummulative_deposits++;
                    }
                }
            }
            
        }
        if ($type == 'orders') {
            for ($i=0; $i < count($orders); $i++) { 
                if (!empty($addtime)) {
                    if ($orders[$i]["user_id"] == $user_id && $orders[$i]["addtime"] == $addtime) {
                        $new_data = array(
                            "user_id" => $orders[$i]["user_id"],
                            "order_number" => $orders[$i]["oid"],
                            "amount" => $orders[$i]["goods"]["goods_price"],
                            "date" => $orders[$i]["addtime"],
                            "type" => "order",
                            "state" => "expenses"
                        );
                        $result["data"][count($result["data"])] = $new_data;
                    }
                }
                else {
                    if ($orders[$i]["user_id"] == $user_id) {
                        $new_data = array(
                            "user_id" => $orders[$i]["user_id"],
                            "order_number" => $orders[$i]["oid"],
                            "amount" => $orders[$i]["goods"]["goods_price"],
                            "date" => $orders[$i]["addtime"],
                            "type" => "order",
                            "state" => "expenses"
                        );
                        $result["data"][count($result["data"])] = $new_data;
                    }
                }
            }
        }
        if ($type == 'recharge') {
            for ($i=0; $i < count($deposits); $i++) { 
                if (!empty($addtime)) {
                    if ($deposits[$i]["user_id"] == $user_id && $deposits[$i]["date"] == $addtime) {
                        $new_data = array(
                            "user_id" => $deposits[$i]["user_id"],
                            "order_number" => $deposits[$i]["deposit_id"],
                            "amount" => $deposits[$i]["price"],
                            "date" => $deposits[$i]["date"],
                            "type" => "deposit",
                            "state" => "income"
                        );
                        $result["data"][count($result["data"])] = $new_data;
                        $cummulative_deposits++;
                    }
                }
                else {
                    if ($deposits[$i]["user_id"] == $user_id) {
                        $new_data = array(
                            "user_id" => $deposits[$i]["user_id"],
                            "order_number" => $deposits[$i]["deposit_id"],
                            "amount" => $deposits[$i]["price"],
                            "date" => $deposits[$i]["date"],
                            "type" => "deposit",
                            "state" => "income"
                        );
                        $result["data"][count($result["data"])] = $new_data;
                        $cummulative_deposits++;
                    }
                }
            }
        }
        if ($type == 'withdraw') {
            for ($i=0; $i < count($withdrawals); $i++) { 
                if (!empty($addtime)) {
                    if ($withdrawals[$i]["user_id"] == $user_id && $withdrawals[$i]["date_of_withdrawal"] == $addtime) {
                        $new_data = array(
                            "user_id" => $withdrawals[$i]["user_id"],
                            "order_number" => $withdrawals[$i]["withdrawal_id"],
                            "amount" => $withdrawals[$i]["num"],
                            "date" => $withdrawals[$i]["date_of_withdrawal"],
                            "type" => "withdrawal",
                            "state" => "income"
                        );
                        $result["data"][count($result["data"])] = $new_data;
                        $cummulative_withdrawals++;
                    }
                }
                else{
                    if ($withdrawals[$i]["user_id"] == $user_id) {
                        $new_data = array(
                            "user_id" => $withdrawals[$i]["user_id"],
                            "order_number" => $withdrawals[$i]["withdrawal_id"],
                            "amount" => $withdrawals[$i]["num"],
                            "date" => $withdrawals[$i]["date_of_withdrawal"],
                            "type" => "withdrawal",
                            "state" => "income"
                        );
                        $result["data"][count($result["data"])] = $new_data;
                        $cummulative_withdrawals++;
                    }
                }
            }
        }
        if ($type == 'rejected withdraw') {
            for ($i=0; $i < count($withdrawals); $i++) {
                if (!empty($addtime)) {
                    if ($withdrawals[$i]["user_id"] == $user_id && $withdrawals[$i]["status"] == "rejected" && 
                    $withdrawals[$i]["date_of_withdrawal"] == $addtime) {
                        $new_data = array(
                            "user_id" => $withdrawals[$i]["user_id"],
                            "order_number" => $withdrawals[$i]["withdrawal_id"],
                            "amount" => $withdrawals[$i]["num"],
                            "date" => $withdrawals[$i]["date_of_withdrawal"],
                            "type" => "withdrawal",
                            "state" => "income"
                        );
                        $result["data"][count($result["data"])] = $new_data;
                        $cummulative_withdrawals++;
                    }
                }
                else{
                    if ($withdrawals[$i]["user_id"] == $user_id && $withdrawals[$i]["status"] == "rejected") {
                        $new_data = array(
                            "user_id" => $withdrawals[$i]["user_id"],
                            "order_number" => $withdrawals[$i]["withdrawal_id"],
                            "amount" => $withdrawals[$i]["num"],
                            "date" => $withdrawals[$i]["date_of_withdrawal"],
                            "type" => "withdrawal",
                            "state" => "income"
                        );
                        $result["data"][count($result["data"])] = $new_data;
                        $cummulative_withdrawals++;
                    }
                }
                
            }
        }
        $result["cummulative_withdrawals"] = $cummulative_withdrawals;
        $result["cummulative_deposits"] = $cummulative_deposits;
        echo json_encode(array("code"=> 0, "data"=>$result));
    }
    else {
        echo json_encode(array("code"=> 1, "data"=>[]));
    }
} catch (\Throwable $th) {
    echo json_encode(array("code"=> 2, "data"=>[]));
}
?>