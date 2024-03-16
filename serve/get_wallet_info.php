<?php
error_reporting(E_ALL ^ E_WARNING);
    session_start();
    try {
        $user_id = empty($_SESSION["user_id"]) ? "" : $_SESSION["user_id"];
        $wallet = json_decode(file_get_contents("wallet_info.json"),true);
        $user_wallet = null;
        for ($i=0; $i < count($wallet); $i++) { 
            if ($wallet[$i]["user_id"] == $user_id) {
                $user_wallet = $wallet[$i];
                break;
            }
        }
        if (isset($user_wallet)) {
            echo json_encode(array("code" => 0, "data" => $user_wallet));
        }
        else {
            echo json_encode(array("code" => 1, "info" => "withdrawal data not found"));
        }
    } catch (\Throwable $th) {
        echo json_encode(array("code" => 2, "info" => "some error occured processing your request"));
    }

?>