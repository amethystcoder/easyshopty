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
    $status = $_POST["status"];
    $status2 = $_POST["status2"];
    $recharge_type = $_POST["recharge_type"];
    $deposit_id = $_POST["oid"];
    $username = $_POST["username"];
    $addtime = $_POST["addtime"];
    $tel = $_POST["tel"];
    $users = json_decode(file_get_contents("users.json"),true);
    $deposits = json_decode(file_get_contents("deposits.json"),true);
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
                for ($i=0; $i < count($deposits); $i++) { 
                    if ($deposits[$i]["date"] == $addtime && $user["user_id"] == $deposits[$i]["user_id"]) {
                        $final[count($final)] = $deposits[$i];
                    }
                }
                $deposits = $final;
            }
            if (!empty($deposit_id)) {
                $final = [];
                for ($i=0; $i < count($deposits); $i++) { 
                    if ($deposits[$i]["deposit_id"] == $deposit_id && $user["user_id"] == $deposits[$i]["user_id"]) {
                        $final[count($final)] = $deposits[$i];
                    }
                }
                $deposits = $final;
            }
            if (!empty($status)) {
                $final = [];
                for ($i=0; $i < count($deposits); $i++) { 
                    if ($deposits[$i]["status"] == $status && $user["user_id"] == $deposits[$i]["user_id"]) {
                        $final[count($final)] = $deposits[$i];
                    }
                }
                $deposits = $final;
            }
            for ($i=0; $i < count($deposits); $i++) { 
                for ($j=0; $j < count($users); $j++) { 
                    if ($deposits[$i]["user_id"] == $users[$j]["user_id"]) {
                        $deposits[$i]["user"] = $users[$j];
                    }
                }
            }
        } else {
            if (!empty($addtime)) {
                $final = [];
                for ($i=0; $i < count($deposits); $i++) { 
                    if ($deposits[$i]["date"] == $addtime) {
                        $final[count($final)] = $deposits[$i];
                    }
                }
                $deposits = $final;
            }
            if (!empty($deposit_id)) {
                $final = [];
                for ($i=0; $i < count($deposits); $i++) { 
                    if ($deposits[$i]["deposit_id"] == $deposit_id) {
                        $final[count($final)] = $deposits[$i];
                    }
                }
                $deposits = $final;
            }
            if (!empty($status)) {
                $final = [];
                for ($i=0; $i < count($deposits); $i++) { 
                    if ($deposits[$i]["status"] == $status) {
                        $final[count($final)] = $deposits[$i];
                    }
                }
                $deposits = $final;
            }
            for ($i=0; $i < count($deposits); $i++) { 
                for ($j=0; $j < count($users); $j++) { 
                    if ($deposits[$i]["user_id"] == $users[$j]["user_id"]) {
                        $deposits[$i]["user"] = $users[$j];
                    }
                }
            }
        }
        echo json_encode(["code" => 0, "data" => $deposits, "info"=> "successful"]);
    }
    else{
        echo json_encode(["code" => 1, "data" => [], "info"=> "you are not logged in"]);
    }


} catch (\Throwable $th) {
    echo json_encode(["code" => 1, "data" => [], "info"=> "some issue occured"]);
}

?>