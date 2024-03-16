<?php
error_reporting(E_ALL ^ E_WARNING);
    try{
        $employee_username = $_POST["employee_username"];
        $phone_number = $_POST["pre"].$_POST["tel"];
        $password = $_POST["pwd"];
        $deposit_password = $_POST["deposit_password"];

        if (!empty($employee_username) && !empty($phone_number)) {
            if (!empty($password) && $deposit_password == $password) {
                $employees = json_decode(file_get_contents("employees.json"),true);
                $employee_exists = false;
                for ($i=0; $i < count($employees); $i++) { 
                    if ($employees[$i]["tel"] == $phone_number) {
                        $employee_exists = true;
                        break;
                    }
                }
                if (!$employee_exists) {
                    $new_employee = array(
                        "tel"=> $phone_number,
                        "pwd" => password_hash($password,PASSWORD_BCRYPT),
                        "employee_username" => $employee_username,
                        "employee_id" => base64_encode(time())
                   );
                    $employees[count($employees)] = $new_employee;
                    $saved = file_put_contents("employees.json",json_encode($employees));
                    if (!isset($saved)) {
                        echo json_encode(array("code" => 3,"info" => "an issue occured registering you"));
                    }
                    else {
                        session_start();
                        $_SESSION["employee_id"] = $new_employee["user_id"];
                        $_SESSION["employee_username"] = $new_employee["employee_username"];
                        echo json_encode(array("code" => 0,"info" => "registration sucessful"));
                    }
                }
                else {
                    echo json_encode(array("code" => 4,"info" => "an employee with this phone number already exists"));
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
