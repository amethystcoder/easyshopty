<?php 
error_reporting(E_ALL ^ E_WARNING);
    session_start();
    try{
        $user_id = empty($_SESSION["user_id"]) ? "" : $_SESSION["user_id"];
        if(!empty($user_id)){
            $orders = json_decode(file_get_contents("orders.json"),true);
            $user_orders = [];
            for($i =0;$i<count($orders);$i++){
                if($orders[$i]["user_id"] == $user_id){
                    $user_orders[count($user_orders)] = $orders[$i];
                }
            }
            echo json_encode(array("code"=> 0, "data"=>$user_orders));
        }
        else{
            echo json_encode(array("code"=> 2, "data"=>[]));
        }
    }
    catch(Throwable $th){
        echo json_encode(array("code"=> 1, "data"=>[]));
    }

?>
