<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();
try{
    $withdrawal_id = $_POST["withdrawal_id"];
    $admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"];
    if(!empty($admin_id) && !empty($withdrawal_id)){
        $withdrawals = json_decode(file_get_contents("withdrawals.json"),true);
        $users = json_decode(file_get_contents("users.json"),true);
        for($i=0;$i < count($withdrawals);$i++){
            if($withdrawals[$i]["withdrawal_id"] == $withdrawal_id){
                $withdrawals[$i]["status"] = "successful";
                $messages = json_decode(file_get_contents("messages.json"),true);
                $new_message = ["message" => "Your withdrawal with id ".$withdrawals[$i]["withdrawal_id"]."and balance ".round($withdrawals[$i]["num"],2)." has been accepted","tymd"=>time(),"date"=>gmdate("M d Y H:i:s",time()),"success"=>"success",
                "user_id" => $withdrawals[$i]["user_id"]];
                $messages[count($messages)] = $new_message;
                file_put_contents("messages.json",json_encode($messages));
                break;
            }//if
        }//for
        file_put_contents("users.json",json_encode($users));
        $saved_successfully = file_put_contents("withdrawals.json",json_encode($withdrawals));
        echo json_encode(array("code"=>0, "data"=> $saved_successfully, "info"=> "change successful, please reload page"));
    }//if
    else{
        echo json_encode(array("code"=>1, "data"=> "you are not logged in or the withdrawal does not exist"));
    }
}//try
catch(Throwable $th){
    echo json_encode(array("code"=>1, "data"=> "an issue occured, please try again later"));
}


?>
