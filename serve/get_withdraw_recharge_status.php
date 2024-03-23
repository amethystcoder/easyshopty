<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();
try {
    $withdrawals = json_decode(file_get_contents("withdrawals.json"),true);
    $deposits = json_decode(file_get_contents("deposits.json"),true);
    $time = (empty($_GET["last_check"]) || $_GET["last_check"] == "undefined") ? time() : $_GET["last_check"];
    $t_data = ["withdraw_count" => 0, "recharge_count" => 0];
    for ($i=0; $i < count($withdrawals); $i++) { 
        if ($withdrawals[$i]["tymd"] < $time && $withdrawals[$i]["tymd"] > ($time - 300)) {
            $t_data["withdraw_count"]++;
        }
    }
    for ($i=0; $i < count($deposits); $i++) { 
        if ($deposits[$i]["tymd"] < $time && $deposits[$i]["tymd"] > ($time - 30)) {
            $t_data["recharge_count"]++;   
        }
    }
    $t_data["last_check"] = $time;
    echo json_encode(array("code" => 0, "data" => $t_data));
} catch (\Throwable $th) {
    echo json_encode(array("code" => 1, "data" => []));
}
?>