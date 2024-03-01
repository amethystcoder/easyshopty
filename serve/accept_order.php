<?php
session_start();
try{
$order_id = $_POST["order_id"];
$admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"];
if(!empty($admin_id) && !empty($order_id)){
$orders = json_decode(file_get_content("orders.json"),true);
for($i=0;$i < count($orders);$i++){
if($orders[$i]["order_id"] == $order_id){
$orders[$i]["status"] = "successful";
}//if
}//for
$saved_successfully = file_put_content(json_encode($orders),"orders.json");
echo json_encode(array("code"=>0, "data"=> $saved_successfully));
}//if
else{
echo json_encode(array("code"=>1, "data"=> false));
}
}//try
catch(Throwable $th){
echo json_encode(array("code"=>1, "data"=> false));
}


?>
