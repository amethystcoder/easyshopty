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
    $addtime = $_POST["addtime"];
    $status = $_POST["status"];
    $oid = $_POST["oid"];
    $tel = $_POST["mobile"];
    $username = $_POST["username"];
    $users = json_decode(file_get_contents("users.json"),true);
    $orders = json_decode(file_get_contents("orders.json"),true);
    $final_orders = [];
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
                for ($i=0; $i < count($orders); $i++) { 
                    if ($orders[$i]["goods"]["addtime"] == $addtime && $user["user_id"] == $orders[$i]["user_id"]) {
                        $final[count($final)] = $orders[$i];
                    }
                }
                $orders = $final;
            }
            if (!empty($oid)) {
                $final = [];
                for ($i=0; $i < count($orders); $i++) { 
                    if ($orders[$i]["oid"] == $oid && $user["user_id"] == $orders[$i]["user_id"]) {
                        $final[count($final)] = $orders[$i];
                    }
                }
                $orders = $final;
            }
            if (!empty($status)) {
                $final = [];
                for ($i=0; $i < count($orders); $i++) { 
                    if ($orders[$i]["status"] == $status && $user["user_id"] == $orders[$i]["user_id"]) {
                        $final[count($final)] = $orders[$i];
                    }
                }
                $orders = $final;
            }
            for ($i=0; $i < count($orders); $i++) { 
                for ($j=0; $j < count($users); $j++) { 
                    if ($orders[$i]["user_id"] == $users[$j]["user_id"]) {
                        $orders[$i]["user"] = $users[$j];
                    }
                }
            }
        } else {
            if (!empty($addtime)) {
                $final = [];
                for ($i=0; $i < count($orders); $i++) { 
                    if ($orders[$i]["goods"]["addtime"] == $addtime) {
                        $final[count($final)] = $orders[$i];
                    }
                }
                $orders = $final;
            }
            if (!empty($oid)) {
                $final = [];
                for ($i=0; $i < count($orders); $i++) { 
                    if ($orders[$i]["oid"] == $oid) {
                        $final[count($final)] = $orders[$i];
                    }
                }
                $orders = $final;
            }
            if (!empty($status)) {
                $final = [];
                for ($i=0; $i < count($orders); $i++) { 
                    if ($orders[$i]["status"] == $status) {
                        $final[count($final)] = $orders[$i];
                    }
                }
                $orders = $final;
            }
            for ($i=0; $i < count($orders); $i++) { 
                for ($j=0; $j < count($users); $j++) { 
                    if ($orders[$i]["user_id"] == $users[$j]["user_id"]) {
                        $orders[$i]["user"] = $users[$j];
                    }
                }
            }
        }
        echo json_encode(["code" => 0, "data" => $orders, "info"=> "successful"]);
    }
    else{
        echo json_encode(["code" => 1, "data" => [], "info"=> "you are not logged in"]);
    }

} catch (\Throwable $th) {
    echo json_encode(["code" => 1, "data" => [], "info"=> "some issue occured"]);
}

?>