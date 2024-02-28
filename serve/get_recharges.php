<?php
    session_start();
    try {
        $user_id = empty($_SESSION["user_id"]) ? "" : $_SESSION["user_id"];
        $user_name = empty($_SESSION["user_name"]) ? "" : $_SESSION["user_name"];
        $balance = empty($_SESSION["balance"]) ? 0 : $_SESSION["balance"];
        $deposits = json_decode(file_get_contents("deposits.json"),true);
        if (!empty($deposits)) {
            $user_deposit = [];
            for ($i=0; $i < count($deposits); $i++) { 
                if ($deposits["user_id"] == $user_id) {
                    $user_deposit[count($user_deposit)] = $deposits;
                }
            }
            echo json_decode($user_deposit);
        }
        else {
            echo json_encode([]);
        }
    } catch (\Throwable $th) {
        echo json_encode([]);
    }
?>