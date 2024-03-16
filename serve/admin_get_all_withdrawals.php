<?php 
error_reporting(E_ALL ^ E_WARNING);
    session_start();
    try{
        $admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"] ;
        if(!empty($admin_id)){
            $withdrawals = json_decode(file_get_contents("withdrawals.json"),true);
            echo json_encode(array("code"=> 0, "data"=>$withdrawals));
        }
        else{
         echo json_encode(array("code"=> 1, "data"=>[]));
        }
    }
    catch(Throwable $th){
        echo json_encode(array("code"=> 1, "data"=>[]));
    }

?>
