<?php
//error_reporting(E_ALL ^ E_WARNING);
session_start();
try{
    $deposit_id = $_POST["deposit_id"];
    $admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"];
    if(!empty($admin_id) && !empty($deposit_id)){
        $deposits = json_decode(file_get_contents("deposits.json"),true);
        $messages = json_decode(file_get_contents("messages.json"),true);
        for($i=0;$i < count($deposits);$i++){
            if($deposits[$i]["deposit_id"] == $deposit_id){
                $deposits[$i]["status"] = "declined";
                $new_message = ["message" => "Your recharge with id ".$deposits[$i]["deposit_id"]." and balance ".$deposits[$i]["price"]." has been declined","tymd"=>time(),"date"=>gmdate("M d Y H:i:s",time()),"success"=>"failure",
                "user_id" => $deposits[$i]["user_id"]];
                $messages[count($messages)] = $new_message;
                file_put_contents("messages.json",json_encode($messages));
            }//if
        }//for
        $saved_successfully = file_put_contents("deposits.json",json_encode($deposits));
        echo json_encode(array("code"=>0, "data"=> $saved_successfully));
    }//if
    else{
        echo json_encode(array("code"=>1, "data"=> "you are not logged in or the deposit does not exist"));
    }
}//try
catch(Throwable $th){
echo json_encode(array("code"=>1, "data"=> "an issue occured please try again later"));
}


?>
