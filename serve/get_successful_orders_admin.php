<?php 

session_start();
try{
$admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"] ;
if(!empty($admin_id)){
$orders = json_decode(file_get_contents("orders.json"),true);
$user_orders = [];
for($i =0;$i<count($orders);$i++){
if($orders[$i]["status"] == "completed"){
$user_orders[count($user_orders)] = $orders[$i];
}
}
echo json_encode(array("code"=> 0, "data"=>$orders));
}
else{
echo json_encode(array("code"=> 1, "data"=>[]));
}
}
catch(Throwable $th){
echo json_encode(array("code"=> 1, "data"=>[]));
}

?>
