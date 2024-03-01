<?php
session_start();
try{
$deposit_id = $_POST["deposit_id"];
$admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"];
if(!empty($admin_id) && !empty($deposit_id)){
$deposits = json_decode(file_get_content("deposits.json"),true);
$users = json_decode(file_get_content("users.json"),true);
$deposit_to_change = [];
$user_to_change = [];
for($i=0;$i < count($deposits);$i++){
if($deposits[$i]["deposit_id"] == $deposit_id){
$deposits[$i]["status"] = "successful";
$deposit_to_change = $deposits[$i];
for($i=0;$i < count($users);$i++){
if($users[$i]["user_id"] == $deposits[$i]["user_id"]){
$users[$i]["balance"] += $deposits[$i]["balance"];
$user_to_change = $users[$i];
break;
}
}
break;
}//if
}//for
for($i=0;$i < count($users);$i++){
if($users[$i]["link_added_from"] == $user_to_change["referral_code"]){
$users[$i]["balance"] += $deposit_to_change["balance"] * (10/100);
}
}
$saved_successfully = file_put_content(json_encode($deposits),"deposits.json") && file_put_content(json_encode($users),"users.json");
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
