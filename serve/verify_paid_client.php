<?php

session_start();

try {
    $user_id = empty($_SESSION["user_id"]) ? "" : $_SESSION["user_id"] ;
    $deposit_id = $_POST["deposit_id"];
    $tNo = $_POST["tNo"];
    if(!empty($user_id) && !empty($deposit_id) && !empty($tNo)){
        $deposits = json_decode(file_get_contents("deposits.json"),true);
        for($i=0;$i < count($deposits);$i++){
            if($deposits[$i]["deposit_id"] == $deposit_id){
                $deposits[$i]["status"] = "pending";
                $deposits[$i]["tNo"] = $tNo;
            }//if
        }//for
        $saved_successfully = file_put_contents("deposits.json",json_encode($deposits));
        echo json_encode(array("code"=>0, "info"=> "saved_successfully"));
    }
    else {
        echo json_encode(array("code" => 2, "info"=> "user unverified or deposit id non existent"));
    }
} catch (\Throwable $th) {
    echo json_encode(array("code" => 1, "info"=> "an error occured"));
}
?>