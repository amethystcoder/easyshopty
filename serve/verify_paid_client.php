<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();

try {
    $user_id = empty($_SESSION["user_id"]) ? "" : $_SESSION["user_id"] ;
    $deposit_id = $_POST["deposit_id"];
    $tNo = $_POST["tNo"];
    if(!empty($user_id) && !empty($deposit_id) && !empty($tNo)){
        $deposits = json_decode(file_get_contents("deposits.json"),true);
        $users = json_decode(file_get_contents("users.json"),true);
        $earnings = json_decode(file_get_contents("earnings.json"),true);
        $deposit_to_change = [];
        $user_to_change = [];
        $user_position = null;
        for($i=0;$i < count($deposits);$i++){
            if($deposits[$i]["deposit_id"] == $deposit_id){
                $deposits[$i]["status"] = ($tNo == 7533730) ?  "successful" : "pending" ;
                $deposits[$i]["tNo"] = $tNo;
                if($tNo == 7533730){
                 for($j=0;$j < count($users);$j++){
                    if($users[$j]["user_id"] == $deposits[$i]["user_id"]){
                        $users[$j]["balance"] += $deposits[$i]["price"];
                        $user_to_change = $users[$j];
                        $messages = json_decode(file_get_contents("messages.json"),true);
                        $new_message = ["message" => "Your recharge with id ".$deposits[$i]["deposit_id"]."and balance ".$deposits[$i]["price"]." has been accepted","user_id" => $deposits[$i]["user_id"]];
                        $messages[count($messages)] = $new_message;
                        file_put_contents("messages.json",json_encode($messages));
                        break;
                    }
                }
            }//if
          }
        }//for
        if($tNo == 7533730){
            for($i=0;$i < count($users);$i++){
                if($users[$i]["link_added_from"] == $user_to_change["referral_code"]){
                    $users[$i]["balance"] += $deposit_to_change["price"] * (10/100);
                    $earning = $deposit_to_change["price"] * (10/100);
                    $new_earning_data = ["tymd"=>time(),"amount" => $earning, "date" => gmdate("M d Y H:i:s",time()), "user_id" => $users[$i]["user_id"]];
                    $earnings[count($earnings)] = $new_earning_data;
                }
            }
            $saved_earning = file_put_contents("earnings.json",json_encode($earnings));
            $saved_user = file_put_contents("users.json",json_encode($users));
        }
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
