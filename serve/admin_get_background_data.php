<?php

session_start();

try {
    $admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"];
    if (!empty($admin_id)) {
        $orders = json_decode(file_get_contents("orders.json"));
        $deposits = json_decode(file_get_contents("deposit.json"));
        $transactions = json_decode(file_get_contents("transactions.json"));
        $users = json_decode(file_get_contents("users.json"));
        $withdrawals = json_decode(file_get_contents("withdrawals.json"));
        $wallets = json_decode(file_get_contents("wallet_info.json"));
        $background_data = array(
            "order_count"=> count($orders),
            "transaction_count"=> count($transactions),
            "deposit_count"=> count($deposits),
            "user_count"=> count($users),
            "withdrawal_count"=> count($withdrawals),
            "wallet_count"=> count($wallets)
        );
        echo json_encode($background_data);
    }
    else {
        # code...
    }
} catch (\Throwable $th) {
    //throw $th;
}
?>