<?php
error_reporting(E_ALL ^ E_WARNING);
    session_start();
    try {
        $user_id = empty($_SESSION["user_id"]) ? "" : $_SESSION["user_id"];
        $user_name = empty($_SESSION["user_name"]) ? "" : $_SESSION["user_name"];
        $balance = empty($_SESSION["balance"]) ? 0 : $_SESSION["balance"];
        $deposits = json_decode(file_get_contents("deposits.json"),true);
        if (count($deposits) > 0) {
            $user_deposit = [];
            for ($i=0; $i < count($deposits); $i++) { 
                if ($deposits[$i]["user_id"] == $user_id) {
                    $user_deposit[count($user_deposit)] = $deposits[$i];
                }
            }
            echo json_encode($user_deposit);
        }
        else {
            echo json_encode([]);
        }
    } catch (\Throwable $th) {
        echo json_encode([]);
    }
?>