<?php

    session_start();
    try {
        $user_id = empty($_SESSION["user_id"]) ? "" : $_SESSION["user_id"];
        if (!empty($user_id)) {
            $users = json_decode(file_get_contents("users.json"),true);
            for ($i=0; $i < count($users); $i++) { 
                if ($users[$i]["user_id"] == $user_id) {
                    $users[$i]["code"] = 0;
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