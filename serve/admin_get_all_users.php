<?php 

    session_start();
    try{
        $admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"] ;
        if(!empty($admin_id)){
            $users = json_decode(file_get_contents("users.json"),true);
            echo json_encode(array("code"=> 0, "data"=>$users));
        }
        else{
            echo json_encode(array("code"=> 1, "data"=>[]));
        }
    }
    catch(\Throwable $th){
        echo json_encode(array("code"=> 1, "data"=>[]));
    }

?>