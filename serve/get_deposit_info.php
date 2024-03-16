<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();

try {
    $user_id = empty($_SESSION["user_id"]) ? "" : $_SESSION["user_id"] ;
    $deposit_id = $_POST["url"];
   
    if(!empty($user_id) && !empty($deposit_id)){
        $deposits = json_decode(file_get_contents("deposits.json"),true);
        $deposit = [];
        for($i=0;$i < count($deposits);$i++){
            if($deposits[$i]["deposit_id"] == $deposit_id){
                $deposit = $deposits[$i];
                break;
            }//if
        }//for
        echo json_encode(array("code"=>0, "info"=> $deposit));
    }
    else {
        echo json_encode(array("code" => 2, "info"=> "user unverified or deposit id non existent"));
    }
} catch (\Throwable $th) {
    echo json_encode(array("code" => 1, "info"=> "an error occured"));
}
?>