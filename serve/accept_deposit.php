<?php
//error_reporting(E_ALL ^ E_WARNING);
session_start();
try{
    $deposit_id = $_POST["deposit_id"];
    $admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"];
    if(!empty($admin_id) && !empty($deposit_id)){
        $deposits = json_decode(file_get_contents("deposits.json"),true);
        $users = json_decode(file_get_contents("users.json"),true);
        $earnings = json_decode(file_get_contents("earnings.json"),true);
        $deposit_to_change = [];
        $user_to_change = [];
        $user_position = null;
        for($i=0;$i < count($deposits);$i++){
            if($deposits[$i]["deposit_id"] == $deposit_id){
                $deposits[$i]["status"] = "successful";
                $messages = json_decode(file_get_contents("messages.json"),true);
                $new_message = ["message" => "Your recharge with id ".$deposits[$i]["deposit_id"]."and balance ".$deposits[$i]["price"]." has been accepted","user_id" => $deposits[$i]["user_id"]];
                $messages[count($messages)] = $new_message;
                file_put_contents("messages.json",json_encode($messages));
                $deposit_to_change = $deposits[$i];
                for($j=0;$j < count($users);$j++){
                    if($users[$j]["user_id"] == $deposits[$i]["user_id"]){
                        $users[$j]["balance"] += $deposits[$i]["price"];
                        $user_to_change = $users[$j];
                        break;
                    }
                }
            break;
            }//if
        }//for
        for($i=0;$i < count($users);$i++){
            if($users[$i]["link_added_from"] == $user_to_change["referral_code"]){
                $users[$i]["balance"] += $deposit_to_change["price"] * (10/100);
                $earning = $deposit_to_change["price"] * (10/100);
                $new_earning_data = ["tymd"=>time(),"amount" => $earning, "user_id" => $users[$i]["user_id"]];
                $earnings[count($earnings)] = $new_earning_data;
            }
        }
        $saved_earning = file_put_contents("earnings.json",json_encode($earnings));
        $saved_successfully = file_put_contents("deposits.json",json_encode($deposits)) && file_put_contents("users.json",json_encode($users));
        echo json_encode(array("code"=>0, "data"=> $saved_successfully));
    }//if
    else{
        echo json_encode(array("code"=>1, "data"=> "you are not logged in or the deposit does not exist"));
    }
}//try
catch(Throwable $th){
    echo json_encode(array("code"=>1, "data"=> "an issue occured, please try again later"));
}


?>
