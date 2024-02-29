//get all deposits admin
<?php 

session_start();
try{
$admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"] ;
if(!empty($admin_id)){
$deposits = json_decode(file_get_contents("deposits.json"),true);
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
