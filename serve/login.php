<?php
    error_reporting(E_ALL ^ E_WARNING);

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

    try {
        $phone_number = $_POST["pre"].$_POST["tel"];
        $password = $_POST["pwd"];

        $logged_in_users = file_get_contents("users.json");
        $users = json_decode($logged_in_users,true);
        $user = null;
        $num = -1;

        for ($i=0; $i < count($users); $i++) { 
            if ($users[$i]["tel"] == $phone_number) {
                $user = $users[$i];
                $num = $i;
                break;
            }
        }

        if (!isset($user) || $user == null) {
            echo json_encode(
                array(
                    "code" => 1,
                    "info" => "user does not exist"
                )
            );
        }
        elseif (!password_verify($password,$user["pwd"])) {
            echo json_encode(
                array(
                    "code" => 1,
                    "info" => "password is incorrect"
                )
            );
        }
        else{
            $users[$num]["ip_address"] = get_ip();
            $saved = file_put_contents("users.json",json_encode($users));
            session_start();
            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["user_name"] = $user["user_name"];
            $_SESSION["balance"] = $user["balance"];
            echo json_encode(
                array(
                    "code" => 0,
                    "info" => "login sucessful"
                )
            );
        }
    } catch (\Throwable $th) {
        echo json_encode(
            array(
                "code" => 2,
                "info" => "am issue occured while logging in"
            )
        );
    }
    

?>