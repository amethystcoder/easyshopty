<?php
session_start();
try{
$deposit_id = $_POST["deposit_id"];
$admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"];
if(!empty($admin_id) && !empty($deposit_id)){
$deposits = json_decode(file_get_content("deposits.json"),true);
for($i=0;$i < count($deposits);$i++){
if($deposits[$i]["deposit_id"] == $deposit_id){
$deposits[$i]["status"] = "failed";
}//if
}//for
$saved_successfully = file_put_content(json_encode($deposits),"deposits.json");
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
