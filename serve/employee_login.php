<?php
error_reporting(E_ALL ^ E_WARNING);
    session_start();
    try {
        $employee_username = $_POST["employee_username"];
        $password = $_POST["pwd"];

        $extracted_employees = file_get_contents("employees.json");
        $all_employees = json_decode($extracted_employees,true);
        $employee = null;

        for ($i=0; $i < count($all_employees); $i++) { 
            if ($all_employees[$i]["employee_username"] == $employee_username) {
                $employee = $all_employees[$i];
                break;
            }
        }

        if (!isset($employee) || $employee == null) {
            echo json_encode(
                array(
                    "code" => 1,
                    "info" => "user does not exist"
                )
            );
        }
        elseif (!password_verify($password,$employee["pwd"])) {
            echo json_encode(
                array(
                    "code" => 1,
                    "info" => "password is incorrect"
                )
            );
        }
        else{
            session_start();
            $_SESSION["employee_id"] = $employee["employee_id"];
            $_SESSION["employee_username"] = $employee["employee_username"];
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
