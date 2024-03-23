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
        $earnings = json_decode(file_get_contents("earnings.json"),true);

        $users_yesterday = 0;
        $users_today = 0;
        $orders_yesterday = 0;
        $orders_today = 0;
        $withdrawals_yesterday = 0;
        $withdrawals_today = 0;
        $earnings_yesterday = 0;
        $earnings_today = 0;
        $recharges_yesterday = 0;
        $recharges_today = 0;
        $users_recharging_today = [];
        $users_recharging_yesterday = [];
        $users_withdrawing_today = [];
        $users_withdrawing_yesterday = [];

        $date_today = gmdate("M d Y H:i:s",time());
        $day_today = explode(" ",$date_today)[1];

        for ($i=0; $i < count($users); $i++) { 
            $user_day = explode(" ",$users[$i]["date"]);
            if ($user_day == $day_today) {
                $users_today++;
            }
            if ($user_day == ($day_today - 1)) {
                $users_yesterday++;
            }
        }
        for ($i=0; $i < count($orders); $i++) { 
            $order_day = explode(" ",$orders[$i]["goods"]["addtime"]);
            if ($order_day == $day_today) {
                $orders_today++;
            }
            if ($order_day == ($day_today - 1)) {
                $orders_yesterday++;
            }
        }
        for ($i=0; $i < count($withdrawals); $i++) { 
            $withdrawal_day = explode(" ",$withdrawals[$i]["date_of_withdrawal"]);
            if ($withdrawal_day == $day_today) {
                $withdrawals_today++;
                $users_withdrawals_today = array_search($withdrawals[$i]["user_id"],$users_withdrawing_today);
                if(empty($users_withdrawals_today) && !isset($users_withdrawals_today)){
                    $users_withdrawing_today[count($users_withdrawing_today)] = $withdrawals[$i]["user_id"];
                }
            }
            if ($withdrawal_day == ($day_today - 1)) {
                $withdrawals_yesterday++;
                $users_withdrawals_yesterday = array_search($withdrawals[$i]["user_id"],$users_withdrawing_yesterday);
                if(empty($users_withdrawals_yesterday) && !isset($users_withdrawals_yesterday)){
                    $users_withdrawing_yesterday[count($users_withdrawing_yesterday)] = $withdrawals[$i]["user_id"];
                }
            }
        }
        for ($i=0; $i < count($earnings); $i++) { 
            $earning_day = explode(" ",$earnings[$i]["date"]);
            if ($earning_day == $day_today) {
                $earnings_today++;
            }
            if ($earning_day == ($day_today - 1)) {
                $earnings_yesterday++;
            }
        }
        for ($i=0; $i < count($deposits); $i++) { 
            $deposit_day = explode(" ",$deposits[$i]["date"]);
            if ($deposit_day == $day_today) {
                $recharges_today++;
                $users_recharges_today = array_search($deposits[$i]["user_id"],$users_recharging_today);
                if(empty($users_recharges_today) && !isset($users_recharges_today)){
                    $users_recharging_today[count($users_recharging_today)] = $deposits[$i]["user_id"];
                }
            }
            if ($deposit_day == ($day_today - 1)) {
                $recharges_yesterday++;
                $users_recharges_yesterday = array_search($deposits[$i]["user_id"],$users_recharging_yesterday);
                if(empty($users_recharges_yesterday) && !isset($users_recharges_yesterday)){
                    $users_recharging_yesterday[count($users_recharging_yesterday)] = $deposits[$i]["user_id"];
                }
            }
            
        }
        
        $background_data = array(
            "order_count"=> count($orders),
            "transaction_count"=> count($transactions),
            "deposit_count"=> count($deposits),
            "user_count"=> count($users),
            "withdrawal_count"=> count($withdrawals),
            "wallet_count"=> count($wallets),
            "total_user_balance" => get_total_user_balance($users),
            "total_order_grabbing_commission" => count($earnings),
            "total_number_of_people_withdrawing_cash"=>get_number_of_people_withdrawing($withdrawals),
            "users_yesterday" => $users_yesterday,
            "users_today" => $users_today,
            "orders_yesterday" => $orders_yesterday,
            "orders_today" => $orders_today,
            "withdrawals_yesterday" => $withdrawals_yesterday,
            "withdrawals_today" => $withdrawals_today,
            "earnings_yesterday" => $earnings_yesterday,
            "earnings_today" => $earnings_today,
            "recharges_yesterday" => $recharges_yesterday,
            "recharges_today" => $recharges_today,
            "users_recharging_today" => count($users_recharging_today),
            "users_recharging_yesterday" => count($users_recharging_yesterday),
            "users_withdrawing_today" => count($users_withdrawing_today),
            "users_withdrawing_yesterday" => count($users_withdrawing_yesterday)
        );
        echo json_encode(array("code"=>0, "data"=>$background_data));
    }
    else {
        echo json_encode(array("code"=>1, "data"=>[]));
    }
} catch (\Throwable $th) {
    echo json_encode(array("code"=>2, "data"=>[]));
}
?>