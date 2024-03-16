<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();

try {
    $admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"];
    $addtime = $_GET["addtime"];
    $agent_id = $_GET["agent_id"];
    $agent_service_id = $_GET["agent_service_id"];
    $group_id = $_GET["group_id"];
    $level = $_GET["level"];
    $order = $_GET["order"];
    $selectList = $_GET["selectList"];
    if($selectList == "-1"){ $selectList = "verified"; }
    else { $selectList = "unverified"; }
    $tel = $_GET["tel"];
    $username = $_GET["username"];
    $invite_code = $_GET["invite_code"];
    $users = json_decode(file_get_contents("users.json"),true);
    if (!empty($username)) {
        $filtered = [];
        for ($i=0; $i < count($users); $i++) { 
            if($username == $users[$i]["user_name"]){
                $filtered[count($filtered)] = $users[$i];
            }
        }
        $users = $filtered;
    }
    if (!empty($selectList)) {
        $filtered = [];
        for ($i=0; $i < count($users); $i++) { 
            if($selectList == $users[$i]["is_real"]){
                $filtered[count($filtered)] = $users[$i];
            }
        }
        $users = $filtered;
    }
    if (!empty($tel)) {
        $filtered = [];
        for ($i=0; $i < count($users); $i++) { 
            if($tel == $users[$i]["tel"]){
                $filtered[count($filtered)] = $users[$i];
            }
        }
        $users = $filtered;
    }
    if (!empty($level) && $level != "-1" ) {
        $level = "VIP ".$level;
        $filtered = [];
        for ($i=0; $i < count($users); $i++) { 
            if($level == $users[$i]["user_status"]){
                $filtered[count($filtered)] = $users[$i];
            }
        }
        $users = $filtered;
    }
    if (!empty($addtime)) {
        $filtered = [];
        for ($i=0; $i < count($users); $i++) { 
            if($addtime == $users[$i]["date"]){
                $filtered[count($filtered)] = $users[$i];
            }
        }
        $users = $filtered;
    }
    if (!empty($invite_code)) {
        $filtered = [];
        for ($i=0; $i < count($users); $i++) { 
            if($invite_code == $users[$i]["referral_code"]){
                $filtered[count($filtered)] = $users[$i];
            }
        }
        $users = $filtered;
    }
    echo json_encode(array("code" => 0, "data"=>$users));

} catch (\Throwable $th) {
    echo json_encode(array("code" => 1, "data"=>[]));
}

?>