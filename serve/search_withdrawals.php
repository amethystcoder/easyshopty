<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();

try {
    $admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"];
    echo json_encode($_POST);
    $username = $_POST["username"]; 
    $status = $_POST["status"]; 
    $withdrawal_id = $_POST["oid"]; 
    $tel = $_POST["mobile"]; 
    $bankname = $_POST["bankname"]; 
    $addtime = $_POST["addtime"]; 
    $users = json_decode(file_get_contents("users.json"),true);
    $withdrawals = json_decode(file_get_contents("withdrawals.json"),true);
    if (!empty($username)) {
        $filtered = [];
        for ($i=0; $i < count($users); $i++) { 
            if($username == $users[$i]["user_name"]){
                $filtered[count($filtered)] = $users[$i];
            }
        }
        $users = $filtered;
    }

} catch (\Throwable $th) {
    //throw $th;
}

?>