<?php


session_start();
try{
$user_id = empty($_SESSION["user_id"]) ? "" : $SESSION["user_id"];
$new_password = $_POST["new_password"];
$confirm_password = $_POST["confirm_password"];
if(!empty($user_id)){
$users = json_decode(file_get_contents("users.json"),true);
for($i = 0;$i < count($users); $i++){
if($users[$i]["user_id"] == $user_id && $new_password == $confirm_password){
$users[$i]["pwd"] = password_hash($confirm_password,PASSWORD_BCRYPT);
$saved = file_put_contents("users.json",json_encode($users));
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
catch(){
echo json_encode(array("code" => 1,"data"=> false, "message" => "an error occurred changing your password"));
}
?>