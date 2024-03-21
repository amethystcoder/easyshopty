<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();

function get_user_with_username($user_arr,$username) {
    $p_user = null;
    for ($i=0; $i < count($user_arr); $i++) { 
        if($username == $user_arr[$i]["user_name"]){
            $p_user = $user_arr[$i];
            break;
        }
    }
    return $p_user;
}

function get_user_with_phone($user_arr,$phone) {
    $p_user = null;
    for ($i=0; $i < count($user_arr); $i++) { 
        if($phone == $user_arr[$i]["tel"]){
            $p_user = $user_arr[$i];
            break;
        }
    }
    return $p_user;
}

function get_user($user_arr,$username,$phone) {
    $p_user = null;
    for ($i=0; $i < count($user_arr); $i++) { 
        if($username == $user_arr[$i]["user_name"] && $phone == $user_arr[$i]["tel"]){
            $p_user = $user_arr[$i];
            break;
        }
    }
    return $p_user;
}

try {
    $admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"];
    $username = $_POST["username"]; 
    $status = $_POST["status"]; 
    $withdrawal_id = $_POST["oid"]; 
    $tel = $_POST["mobile"]; 
    $bankname = $_POST["bankname"]; 
    $addtime = $_POST["addtime"]; 
    $users = json_decode(file_get_contents("users.json"),true);
    $withdrawals = json_decode(file_get_contents("withdrawals.json"),true);
    $user = null;
    $final = [];
    if (!empty($admin_id)) {
        //Get user
        if (!empty($username) && !empty($tel)) {
            $user = get_user($users,$username,$tel);
        }
        elseif (!empty($username)) {
            $user = get_user_with_username($users,$username);
        }
        elseif (!empty($tel)) {
            $user = get_user_with_phone($users,$tel);
        }

        if (isset($user)) {
            if (!empty($addtime)) {
                $final = [];
                for ($i=0; $i < count($withdrawals); $i++) { 
                    if ($withdrawals[$i]["date_of_withdrawal"] == $addtime && $user["user_id"] == $withdrawals[$i]["user_id"]) {
                        $final[count($final)] = $withdrawals[$i];
                    }
                }
                $withdrawals = $final;
            }
            if (!empty($withdrawal_id)) {
                $final = [];
                for ($i=0; $i < count($withdrawals); $i++) { 
                    if ($withdrawals[$i]["withdrawal_id"] == $withdrawal_id && $user["user_id"] == $withdrawals[$i]["user_id"]) {
                        $final[count($final)] = $withdrawals[$i];
                    }
                }
                $withdrawals = $final;
            }
            if (!empty($status)) {
                $final = [];
                for ($i=0; $i < count($withdrawals); $i++) { 
                    if ($withdrawals[$i]["status"] == $status && $user["user_id"] == $withdrawals[$i]["user_id"]) {
                        $final[count($final)] = $withdrawals[$i];
                    }
                }
                $withdrawals = $final;
            }
            for ($i=0; $i < count($withdrawals); $i++) { 
                for ($j=0; $j < count($users); $j++) { 
                    if ($withdrawals[$i]["user_id"] == $users[$j]["user_id"]) {
                        $withdrawals[$i]["user"] = $users[$j];
                    }
                }
            }
        } else {
            if (!empty($addtime)) {
                $final = [];
                for ($i=0; $i < count($withdrawals); $i++) { 
                    if ($withdrawals[$i]["date_of_withdrawal"] == $addtime) {
                        $final[count($final)] = $withdrawals[$i];
                    }
                }
                $withdrawals = $final;
            }
            if (!empty($withdrawal_id)) {
                $final = [];
                for ($i=0; $i < count($withdrawals); $i++) { 
                    if ($withdrawals[$i]["withdrawal_id"] == $withdrawal_id) {
                        $final[count($final)] = $withdrawals[$i];
                    }
                }
                $withdrawals = $final;
            }
            if (!empty($status)) {
                $final = [];
                for ($i=0; $i < count($withdrawals); $i++) { 
                    if ($withdrawals[$i]["status"] == $status) {
                        $final[count($final)] = $withdrawals[$i];
                    }
                }
                $withdrawals = $final;
            }
            for ($i=0; $i < count($withdrawals); $i++) { 
                for ($j=0; $j < count($users); $j++) { 
                    if ($withdrawals[$i]["user_id"] == $users[$j]["user_id"]) {
                        $withdrawals[$i]["user"] = $users[$j];
                    }
                }
            }
        }
        echo json_encode(["code" => 0, "data" => $withdrawals, "info"=> "successful"]);
    }
    else{
        echo json_encode(["code" => 1, "data" => [], "info"=> "you are not logged in"]);
    }

} catch (\Throwable $th) {
    echo json_encode(["code" => 1, "data" => [], "info"=> "some issue occured"]);
}

?>