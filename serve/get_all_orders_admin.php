<?php 

    session_start();
    try{
        $admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"] ;
        if(!empty($admin_id)){
            $orders = json_decode(file_get_contents("orders.json"),true);
            $users = json_decode(file_get_contents("users.json"),true);
            for ($i=0; $i < count($orders); $i++) {
                for ($j=0; $j < count($users); $j++) { 
                    if ($orders[$i]["user_id"] == $users[$j]["user_id"]) {
                        $orders[$i]["user"] = $users[$j];
                        break;
                    }
                }
            }
            echo json_encode(array("code"=> 0, "data"=>$orders));
        }
        else{
            echo json_encode(array("code"=> 1, "data"=>[]));
        }
    }
    catch(\Throwable $th){
        echo json_encode(array("code"=> 1, "data"=>[]));
    }

?>
