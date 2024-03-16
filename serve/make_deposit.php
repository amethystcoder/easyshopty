<?php
error_reporting(E_ALL ^ E_WARNING);
function generate_deposit_id() {
    $char_list = ["Q","W","E","R","T","Y","U","I","O","P","A","S","D","F","G","H","J","K","L","Z","X","C",
                    "V","B","N","M","1","2","3","4","5","6","7","8","9"];
    $result = "DEP";
    for ($i=0; $i < 20; $i++) { 
        $result .= $char_list[(time() * random_int(1111,9999)) % (count($char_list) - 1)];
    }
    return $result;
}

session_start();
try {
    $user_id = empty($_SESSION["user_id"]) ? "" : $_SESSION["user_id"] ;
if(!empty($user_id)){
    $price = $_POST["price"];
    $deposit_id = generate_deposit_id();
    $type = $_POST["type"];
    $deposits = json_decode(file_get_contents("deposits.json"),true);
    $new_deposit = array(
        "price"=> $price,
        "type"=> $type,
        "deposit_id"=> $deposit_id,
        "user_id" => $user_id,
        "status" => "unpaid",
        "date" => gmdate("M d Y H:i:s",time()),
        "tymd" => time()
    );
    $deposits[count($deposits)] = $new_deposit;
    $saved_successfully = file_put_contents("deposits.json",json_encode($deposits));
    echo json_encode(array("code" => 0, "info"=> array("num" => $deposit_id)));
}
else{
    echo json_encode(array("code" => 2, "info"=> "user unverified"));
}
} catch (\Throwable $th) {
    echo json_encode(array("code" => 1, "info"=> "an error occured"));
}


?>