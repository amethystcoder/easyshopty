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
    //get orders
    if (!empty($oid)) {
        for ($i=0; $i < count($orders); $i++) { 
            if ($orders[$i]["oid"] == $oid) {
                $final_orders[count($final_orders)] = $$orders[$i];
                break;
            }
        }
        echo json_encode(["code" => 0, "data" => $final_orders]);
        
    }
    if (isset($user)) {
        
    }
    else{}

} catch (\Throwable $th) {
    //throw $th;
}

?>