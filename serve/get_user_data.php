<?php
error_reporting(E_ALL ^ E_WARNING);
    session_start();
    try {
        $user_id = empty($_SESSION["user_id"]) ? "" : $_SESSION["user_id"];
        if (!empty($user_id)) {
            $users = json_decode(file_get_contents("users.json"),true);
            $earnings = json_decode(file_get_contents("earnings.json"),true);
            $total_earnings = 0;
            $earnings_today = 0;
            $tymd_now = time() - (60 * 60 * 24);
            //TODO Remember to add earnings to result data
            for ($i=0; $i < count($users); $i++) { 
                if ($users[$i]["user_id"] == $user_id) {
                    $users[$i]["code"] = 0;
                    for ($j=0; $j < count($earnings); $j++) { 
                        if ($earnings[$j]["user_id"] == $users[$i]["user_id"]) {
                            if ($earnings[$j]["tymd"] < time() && $earnings[$j]["tymd"] > $tymd_now) {
                                $earnings_today += $earnings[$j]["amount"];
                            }
                            $total_earnings += $earnings[$j]["amount"];
                        }
                    }
                    $users[$i]["earnings"] = $total_earnings;
                    $users[$i]["earnings_today"] = $total_earnings;
                    echo json_encode($users[$i]);
                    break;
                }
            }
        }
        else {
            echo json_encode(array("code" => 1, "message" => "login or register to use this app"));
        }
    } catch (\Throwable $th) {
        echo json_encode(array("code" => 1, "message" => "some issues occured"));
    }
?>