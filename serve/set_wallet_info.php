<?php

session_start();
try {
    $id_number = $_POST["id_number"];//wallet address
    $tel = $_POST["tel"];
    $username = $_POST["username"];
    $paypassword = $_POST["paypassword"];
    $user_id = $_SESSION["user_id"];
    $data_exists = false;
    if(!empty($user_id)){
        $data = json_decode(file_get_contents("wallet_info.json"),true);
        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]["user_id"] == $user_id) {
                $data_exists = true;
                $data[$i]["id_number"] = $id_number;
                $data[$i]["tel"] = $tel;
                $data[$i]["username"] = $username;
                $data[$i]["paypassword"] = $paypassword;
                $data[$i]["date"] = gmdate("M d Y H:i:s",time());
            }
        }
        if (!$data_exists) {
            $new_wallet_info = array();
            $new_wallet_info["id_number"] = $id_number;
            $new_wallet_info["tel"] = $tel;
            $new_wallet_info["username"] = $username;
            $new_wallet_info["paypassword"] = $paypassword;
            $new_wallet_info["user_id"] = $user_id;
            $new_wallet_info["date"] = gmdate("M d Y H:i:s",time());
            $new_wallet_info["tymd"] = time();
            $data[count($data)] = $new_wallet_info;
        }
        $saved_successfully = file_put_contents("wallet_info.json",json_encode($data));
        echo json_encode(array("code" => 0, "message" => "saved successfully"));
    }
    else{
        echo json_encode(array("code" => 1, "message" => "you are not logged in"));
    }
} catch (\Throwable $th) {
    echo json_encode(array("code" => 2, "message" => "some issue occured"));
}

?>