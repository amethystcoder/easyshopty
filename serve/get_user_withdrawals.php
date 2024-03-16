<?php 
error_reporting(E_ALL ^ E_WARNING);
session_start();
try{
$user_id = empty($_SESSION["user_id"]) ? "" : $_SESSION["user_id"] ;
if(!empty($user_id)){
$withdrawals = json_decode(file_get_contents("withdrawals.json"),true);
$user_withdrawals = [];
for($i =0;$i<count($withdrawals);$i++){
if($withdrawals[$i]["user_id"] == $user_id){
$user_withdrawals[count($user_withdrawals)] = $withdrawals[$i];
}
}
echo json_encode(array("code"=> 0, "data"=>$user_withdrawals));
}
else{
echo json_encode(array("code"=> 2, "data"=>[]));
}
}
catch(Throwable $th){
echo json_encode(array("code"=> 1, "data"=>[]));
}

?>
