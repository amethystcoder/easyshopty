<?php 

    session_start();
    try{
        $admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"];
        $user_id = $_GET["user_id"];
        if(!empty($admin_id) && !empty($user_id)){
            $users = json_decode(file_get_contents("users.json"),true);
            $deposits = json_decode(file_get_contents("deposits.json"),true);
            $withdrawals = json_decode(file_get_contents("withdrawals.json"),true);
            $user = null;
            for ($i=0; $i < count($users); $i++) { 
                if($users[$i]["user_id"] == $user_id){
                    $users[$i]["cummulative_withdrawals"] = 0;
                    $users[$i]["cummulative_withdrawal_amount"] = 0;
                    $users[$i]["cummulative_deposits"] = 0;
                    $users[$i]["cummulative_deposit_amount"] = 0;
                    for ($j=0; $j < count($deposits); $j++) { 
                        if ($users[$i]["user_id"] == $deposits[$j]["user_id"]) {
                            $users[$i]["cummulative_deposits"]++;
                            $users[$i]["cummulative_deposit_amount"] += $deposits[$j]["price"];
                        }
                    }
                    for ($k=0; $k < count($withdrawals); $k++) { 
                        if ($users[$i]["user_id"] == $deposits[$j]["user_id"]) {
                            $users[$i]["cummulative_withdrawals"]++;
                            $users[$i]["cummulative_withdrawal_amount"] += $withdrawals[$k]["num"];
                        }
                    }
                    $user = $users[$i];
                    break;
                }
            }
            echo json_encode(array("code"=> 0, "data"=>$user));
        }
        else{
            echo json_encode(array("code"=> 1, "data"=>[]));
        }
    }
    catch(\Throwable $th){
        echo json_encode(array("code"=> 1, "data"=>[]));
    }

?>