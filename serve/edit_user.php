<?php
//error_reporting(E_ALL ^ E_WARNING);
session_start();
    try{
        $admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"];
        if(!empty($admin_id)){
            $users = json_decode(file_get_contents("users.json"),true);
            $user_id = $_POST["user_id"];
            $trading_status = $_POST["trading_status"];
            $user_status = $_POST["user_status"];
            $overlay = $_POST["overlay"];
            $user_name = $_POST["user_name"];
            $tel = $_POST["tel"];
            $balance = $_POST["balance"];
            $pwd = $_POST["pwd"];
            $frozen = $_POST["frozen"];
            $transfer_password = $_POST["transfer_password"];
            for ($i=0; $i < count($users); $i++) { 
                if ($users[$i]["user_id"] == $user_id) {
                    if (!empty($user_status)) {
                        $users[$i]["user_status"] = $user_status;
                    }
                    if (!empty($user_name)) {
                        $users[$i]["user_name"] = $user_name;
                    }
                    if (!empty($tel)) {
                        $users[$i]["tel"] = $tel;
                    }
                    if (!empty($balance)) {
                        $users[$i]["balance"] = $balance;
                    }
                    if (!empty($pwd)) {
                        $users[$i]["pwd"] = password_hash($pwd,PASSWORD_BCRYPT);
                    }
                    if (!empty($overlay)) {
                        $users[$i]["group"] = $overlay;
                        $users[$i]["order_state_amount"] = 66;
                    }
                    break;
                }
            }
            $saved = file_put_contents("users.json",json_encode($users));
            echo json_encode(array("code"=> 0, "data"=>[]));
        }
        else{
            echo json_encode(array("code"=> 1, "data"=>[]));
        }
    }
    catch(\Throwable $th){
        echo json_encode(array("code"=> 2, "data"=>[]));
    }

?>