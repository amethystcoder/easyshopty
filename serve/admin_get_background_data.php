<?php
error_reporting(E_ALL ^ E_WARNING);
function get_total_commissions($arr){
    $count = 0;
    for ($i=0; $i < count($arr); $i++) { 
        if ($arr[$i]["user_status"] == "VIP 1") {
            $count += 0.12;
        }
        if ($arr[$i]["user_status"] == "VIP 2") {
            $count += 0.13;
        }
        if ($arr[$i]["user_status"] == "VIP 3") {
            $count += 0.14;
        }
        return $count;
    }
}
function get_total_user_balance($arr){
    $count = 0;
    for ($i=0; $i < count($arr); $i++) { 
        $count += $arr[$i]["balance"];
    }
    return $count;
}
function get_number_of_people_withdrawing($withdrawals) {
    $users_count = [];
    $lister = false;
    for ($i=0; $i < count($withdrawals); $i++) { 
        $lister = false;
        for ($j=0; $j < count($users_count); $j++) { 
            if ($users_count[$j] == $withdrawals[$i]["user_id"]) {
                $lister = true;
                break;
            }
        }
        if (!$lister) {
            $users_count[count($users_count)] = $withdrawals[$i]["user_id"];
        }
    }
    return count($users_count);
}
session_start();

try {
    $admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"];
    if (!empty($admin_id)) {
        $orders = json_decode(file_get_contents("orders.json"),true);
        $deposits = json_decode(file_get_contents("deposits.json"),true);
        $transactions = json_decode(file_get_contents("transactions.json"),true);
        $users = json_decode(file_get_contents("users.json"),true);
        $withdrawals = json_decode(file_get_contents("withdrawals.json"),true);
        $wallets = json_decode(file_get_contents("wallet_info.json"),true);
        $background_data = array(
            "order_count"=> count($orders),
            "transaction_count"=> count($transactions),
            "deposit_count"=> count($deposits),
            "user_count"=> count($users),
            "withdrawal_count"=> count($withdrawals),
            "wallet_count"=> count($wallets),
            "total_user_balance" => get_total_user_balance($users),
            "total_order_grabbing_commission" => get_total_commissions($users),
            "total_number_of_people_withdrawing_cash"=>get_number_of_people_withdrawing($withdrawals)
        );
        echo json_encode(array("code"=>0, "data"=>$background_data));
    }
    else {
        echo json_encode(array("code"=>1, "data"=>[]));
    }
} catch (\Throwable $th) {
    echo $th;//json_encode(array("code"=>2, "data"=>[]));
}
?>