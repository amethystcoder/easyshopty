<?php
error_reporting(E_ALL ^ E_WARNING);
function create_withdrawal_id() {
    $char_list = ["Q","W","E","R","T","Y","U","I","O","P","A","S","D","F","G","H","J","K","L","Z","X","C",
                    "V","B","N","M","1","2","3","4","5","6","7","8","9"];
    $result = "WIT";
    for ($i=0; $i < 20; $i++) { 
        $result .= $char_list[(time() * random_int(1111,9999)) % (count($char_list) - 1)];
    }
    return $result;
}

    session_start();
    try {
        $user_id = empty($_SESSION["user_id"]) ? "" : $_SESSION["user_id"];
        $TRX_code = $_POST["TRX_code"];
        $paypassword = $_POST["paypassword"];
        $num = $_POST["num"];
        $users = json_decode(file_get_contents("users.json"),true);
        $withdrawals = json_decode(file_get_contents("withdrawals.json"),true);
        $orders = json_decode(file_get_contents("orders.json"),true);
        $wallet = json_decode(file_get_contents("wallet_info.json"),true);
        $user = null;
        $user_position = null;
        $pending_order_exists = false;
        $user_wallet = null;
        $present_order_amount = 0;
        if (!empty($user_id)) {
            for ($i=0; $i < count($users); $i++) { 
                if ($users[$i]["user_id"] == $user_id) {
                    $user = $users[$i];
                    $user_position = $i;
                    break;
                }
            }
            for ($i=0; $i < count($wallet); $i++) { 
                if ($wallet[$i]["user_id"] == $user_id) {
                    $user_wallet = $wallet[$i];
                    break;
                }
            }
            for ($i=0; $i < count($orders); $i++) { 
                if ($orders[$i]["user_id"] == $user_id && $orders[$i]["status"] == "pending") {
                    $pending_order_exists = true;
                    break;
                }
                if ($orders[$i]["user_id"] == $user_id && $orders[$i]["group"] == $user["group"]) {
                    $present_order_amount++;
                }
            }
            if($present_order_amount < 66){
                echo json_encode(array("code" => -1, "info" => "please complete all orders for the day before withdrawing"));
            }
            else{
                if ($pending_order_exists) {
                echo json_encode(array("code" => -1, "info" => "There are open orders in this account. In this state, you cannot continue to grab orders and withdraw cash"));
            }
            else {
                if (isset($user_wallet) && $user_wallet["paypassword"] != "") {
                    if($paypassword == $user_wallet["paypassword"]){
                        if ($user["balance"] >= $num) {
                            $new_withdrawal = array(
                                "withdrawal_id"=>create_withdrawal_id(),
                                "status" => "pending",
                                "user_id" => $user_id,
                                "num" => $num,
                                "TRX_code" => $TRX_code,
                                "date_of_withdrawal" => gmdate("M d Y H:i:s",time()),
                                "tymd" => time()
                            );
                            $withdrawals[count($withdrawals)] = $new_withdrawal;
                            $user["balance"] = round(($user["balance"] - $num),2);
                            $users[$user_position] = $user;
                            $saved_user_successfully = file_put_contents("users.json",json_encode($users));
                            $saved_successfully = file_put_contents("withdrawals.json",json_encode($withdrawals));
                            echo json_encode(array("code" => 0, "data" => $new_withdrawal, "message" => "created successfully"));
                        }
                        else {
                            echo json_encode(array("code" => 1, "info" => "you cannot withdraw more than your balance"));
                        }
                    }
                    else{
                        echo json_encode(array("code" => 2, "info" => "pay password is incorrect"));
                    }
                }
                else {
                    if(password_verify($paypassword,$user["pwd"])){
                        if ($user["balance"] >= $num) {
                            $new_withdrawal = array(
                                "withdrawal_id"=>create_withdrawal_id(),
                                "status" => "pending",
                                "user_id" => $user_id,
                                "num" => $num,
                                "TRX_code" => $TRX_code,
                                "date_of_withdrawal" => gmdate("M d Y H:i:s",time()),
                                "tymd" => time()
                            );
                            $withdrawals[count($withdrawals)] = $new_withdrawal;
                            $user["balance"] = round(($user["balance"] - $num),2);
                            $users[$user_position] = $user;
                            $saved_user_successfully = file_put_contents("users.json",json_encode($users));
                            $saved_successfully = file_put_contents("withdrawals.json",json_encode($withdrawals));
                            echo json_encode(array("code" => 0, "data" => $new_withdrawal, "info" => "created successfully"));
                        }
                        else {
                            echo json_encode(array("code" => 1, "info" => "you cannot withdraw more than your balance"));
                        }
                    }
                    else{
                        echo json_encode(array("code" => 2, "info" => "pay password is incorrect"));
                    }
                }
              }
            }
        }
        else {
            echo json_encode(array("code" => 4, "info" => "You are not logged in, kindly login to be able to withdraw"));
        }
    } catch (\Throwable $th) {
        echo json_encode(array("code" => 3, "info" => "some error occured"));
    }
?>
