<?php
    try {
        $admin_username = $_POST["admin_username"]
        $password = $_POST["pwd"];
$actual_admin_password = "$2y$10$iNLqBSMS0BHWwoHmR5OXx.FYvOjFZ4UsHGkJdUuHHhVgtZYz9J0pW";
//Admin password is BLKr35dU

        if ($admin_username != "L8sD5" || !password_verify($password,$actual_admin_password)) {
            echo json_encode(
                array(
                    "code" => 1,
                    "info" => "password is incorrect"
                )
            );
        }
        else{
/*         
            session_start();
            $_SESSION["admin_id"] = "duKF46mNfy473Gw6BSY";
            $_SESSION["admin_name"] = "admin";
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
