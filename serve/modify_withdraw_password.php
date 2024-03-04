<?php


session_start();
try{
$user_id = empty($_SESSION["user_id"]) ? "" : $SESSION["user_id"];
$new_password = $_POST["new_pwd"];
$confirm_password = $_POST["password_confirm"];
if(!empty($user_id)){
$withdrawals = json_decode(file_get_contents("withdrawals.json"),true);
for($i = 0;$i < count($withdrawals); $i++){
if($withdrawals[$i]["user_id"] == $user_id && $new_password == $confirm_password){
$withdrawals[$i]["paypassword"] = password_hash($confirm_password,PASSWORD_BCRYPT);
$saved = file_put_contents("withdrawals.json",json_encode($withdrawals));
echo json_encode(array("code" => 0,"data"=> true, "message" => "changed successfully"));
break;
}
else{
echo json_encode(array("code" => 2,"data"=> false, "message" => "passwords are not the same or user doesn't exist"));
break;
}
}
}
else{
echo json_encode(array("code" => 3,"data"=> false, "message" => "session doesn't exist, please login to change your password"));
}
}
catch(\Throwable $th){
echo json_encode(array("code" => 1,"data"=> false, "message" => "an error occurred changing your password"));
}
?>
