<?php 
error_reporting(E_ALL ^ E_WARNING);
session_start();
try{
$user_id = empty($_SESSION["user_id"]) ? "" : $_SESSION["user_id"] ;
if(!empty($user_id)){
$deposits = json_decode(file_get_contents("deposits.json"),true);
$user_deposits = [];
for($i =0;$i<count($deposits);$i++){
if($deposits[$i]["user_id"] == $user_id && $deposits[$i]["status"] == "successful"){
$user_deposits[count($user_deposits)] = $deposits[$i];
}
}
echo json_encode(array("code"=> 0, "data"=>$user_deposits));
}
else{
echo json_encode(array("code"=> 2, "data"=>[]));
}
}
catch(Throwable $th){
echo json_encode(array("code"=> 1, "data"=>[]));
}

?>
