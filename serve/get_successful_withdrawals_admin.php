<?php 

session_start();
try{
$admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"] ;
if(!empty($admin_id)){
$withdrawals = json_decode(file_get_contents("withdrawals.json"),true);
$user_withdrawals = [];
for($i =0;$i<count($withdrawals);$i++){
if($withdrawals[$i]["status"] == "successful"){
$user_withdrawals[count($user_withdrawals)] = $withdrawals[$i];
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
