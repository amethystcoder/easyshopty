<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();

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
    if (!empty($username)) {
        $filtered = [];
        for ($i=0; $i < count($users); $i++) { 
            if($username == $users[$i]["user_name"]){
                $filtered[count($filtered)] = $users[$i];
            }
        }
        $users = $filtered;
    }
    echo json_encode($_POST);

} catch (\Throwable $th) {
    //throw $th;
}

?>