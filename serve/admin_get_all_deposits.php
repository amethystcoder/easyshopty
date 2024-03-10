<?php 

session_start();
try{
$admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"] ;
if(!empty($admin_id)){
$deposits = json_decode(file_get_contents("deposits.json"),true);
$users = json_decode(file_get_contents("users.json"),true);
            for ($i=0; $i < count($deposits); $i++) {
                for ($j=0; $j < count($users); $j++) { 
                    if ($deposits[$i]["user_id"] == $users[$j]["user_id"]) {
                        $deposits[$i]["user"] = $users[$j];
                        break;
                    }
                }
            }
echo json_encode(array("code"=> 0, "data"=>$deposits));
}
else{
echo json_encode(array("code"=> 1, "data"=>[]));
}
}
catch(Throwable $th){
echo json_encode(array("code"=> 1, "data"=>[]));
}

?>
