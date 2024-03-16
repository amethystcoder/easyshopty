<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();

try {
    $user_id = empty($_SESSION["user_id"]) ? "" : $_SESSION["user_id"] ;
    if(!empty($user_id)){
        $messages = json_decode(file_get_contents("messages.json"),true);
        $user_messages = [];
        for($i=0;$i < count($messages);$i++){
            if($messages[$i]["user_id"] == $user_id){
                $user_messages[count($user_messages)] = $messages[$i];
            }//if
        }//for
        echo json_encode(array("code"=>0, "data"=> $user_messages, "info"=> "successful"));
    }
    else {
        echo json_encode(array("code" => 2, "info"=> "user unverified"));
    }
} catch (\Throwable $th) {
    echo json_encode(array("code" => 1, "info"=> "an error occured"));
}
?>