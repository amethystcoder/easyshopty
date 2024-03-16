<?php 
error_reporting(E_ALL ^ E_WARNING);
session_start();
try{
$admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"] ;
if(!empty($admin_id)){
$deposits = json_decode(file_get_contents("deposits.json"),true);
$user_deposits = [];
for($i =0;$i<count($deposits);$i++){
if($deposits[$i]["status"] == "pending"){
$user_deposits[count($user_deposits)] = $deposits[$i];
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
