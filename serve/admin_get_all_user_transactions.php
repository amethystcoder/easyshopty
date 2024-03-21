<?php

error_reporting(E_ALL ^ E_WARNING);

session_start();
try {
    $admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"];
    $user_id = $_POST["user_id"];
    $all_user_data = [];
    if (!empty($admin_id) && !empty($user_id)) {
        $withdrawals = json_decode(file_get_contents("withdrawals.json"),true);
        $orders = json_decode(file_get_contents("orders.json"),true);
        $deposits = json_decode(file_get_contents("deposits.json"),true);
        $users = json_decode(file_get_contents("users.json"),true);
        $cummulative_withdrawals = 0;
        $cummulative_deposits = 0;
        for ($i=0; $i < count($users); $i++) { 
           if ($users[$i]["user_id"] == $user_id) {
                $all_user_data["user"] = $users[$i];
           }
        }
        $all_user_data["data"] = [];
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
                $all_user_data["data"][count($all_user_data["data"])] = $new_data;
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
                $all_user_data["data"][count($all_user_data["data"])] = $new_data;
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
                $all_user_data["data"][count($all_user_data["data"])] = $new_data;
                $cummulative_deposits++;
            }
        }
        $all_user_data["cummulative_withdrawals"] = $cummulative_withdrawals;
        $all_user_data["cummulative_deposits"] = $cummulative_deposits;
        echo json_encode(array("code"=> 0, "data"=>$all_user_data));
    }
    else {
        echo json_encode(array("code"=> 1, "data"=>[]));
    }
} catch (\Throwable $th) {
    echo json_encode(array("code"=> 2, "data"=>[]));
}

?>