<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();

try {
    $admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"];
    echo json_encode($_POST);
    /* $addtime = $_GET["addtime"];
    $agent_id = $_GET["agent_id"];
    $agent_service_id = $_GET["agent_service_id"];
    $group_id = $_GET["group_id"];
    $level = $_GET["level"];
    $order = $_GET["order"];
    $selectList = $_GET["selectList"];
    $tel = $_GET["tel"];
    $username = $_GET["username"]; */
    /* $users = json_decode(file_get_contents("users.json"),true);
    if (!empty($username)) {
        $filtered = [];
        for ($i=0; $i < count($users); $i++) { 
            if($username == $users[$i]["user_name"]){
                $filtered[count($filtered)] = $users[$i];
            }
        }
        $users = $filtered;
    } */
    //echo json_encode([]);

} catch (\Throwable $th) {
    //throw $th;
}

?>