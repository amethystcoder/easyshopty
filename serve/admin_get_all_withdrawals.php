<?php 
//error_reporting(E_ALL ^ E_WARNING);
    session_start();
    try{
        $admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"] ;
        if(!empty($admin_id)){
            $withdrawals = json_decode(file_get_contents("withdrawals.json"),true);
            $users = json_decode(file_get_contents("users.json"),true);
            for ($i=0; $i < count($withdrawals); $i++) {
                for ($j=0; $j < count($users); $j++) { 
                    if ($withdrawals[$i]["user_id"] == $users[$j]["user_id"]) {
                        $withdrawals[$i]["user"] = $users[$j];
                        break;
                    }
                }
            }
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
