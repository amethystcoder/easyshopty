<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();

function get_user_with_username($user_arr,$username) {
    $p_user = null;
    for ($i=0; $i < count($user_arr); $i++) { 
        if($username == $user_arr[$i]["user_name"]){
            $p_user = $user_arr[$i];
            break;
        }
    }
    return $p_user;
}

function get_user_with_phone($user_arr,$phone) {
    $p_user = null;
    for ($i=0; $i < count($user_arr); $i++) { 
        if($phone == $user_arr[$i]["tel"]){
            $p_user = $user_arr[$i];
            break;
        }
    }
    return $p_user;
}

function get_user_with_invite_code($user_arr,$inv_code) {
    $p_user = null;
    for ($i=0; $i < count($user_arr); $i++) { 
        if($inv_code == $user_arr[$i]["referral_code"]){
            $p_user = $user_arr[$i];
            break;
        }
    }
    return $p_user;
}

function get_user($user_arr,$username,$phone,$inv_code) {
    $p_user = null;
    for ($i=0; $i < count($user_arr); $i++) { 
        if($username == $user_arr[$i]["user_name"] && $phone == $user_arr[$i]["tel"] && $inv_code == $user_arr[$i]["referral_code"]){
            $p_user = $user_arr[$i];
            break;
        }
    }
    return $p_user;
}

try {
    $admin_id = empty($_SESSION["admin_id"]) ? "" : $_SESSION["admin_id"];
    $addtime = $_GET["addtime"];
    $group_id = $_GET["group_id"];
    $level = $_GET["level"];
    $user = $_GET["user"];
    $selectList = $_GET["selectList"];
    $tel = $_GET["tel"];
    $username = $_GET["username"];
    $invite_code = $_GET["invite_code"];
    $users = json_decode(file_get_contents("users.json"),true);
    $user = null;
    $final = [];
    if (!empty($admin_id)) {
        //Get user
        if (!empty($username) && !empty($tel) && !empty($invite_code)) {
            $user = get_user($users,$username,$tel,$invite_code);
        }
        elseif (!empty($username)) {
            $user = get_user_with_username($users,$username);
        }
        elseif (!empty($tel)) {
            $user = get_user_with_phone($users,$tel);
        }
        elseif (!empty($invite_code)) {
            $user = get_user_with_invite_code($users,$invite_code);
        }

        if (isset($user)) {
            if (!empty($addtime)) {
                $final = [];
                for ($i=0; $i < count($users); $i++) { 
                    if ($users[$i]["date"] == $addtime && $user["user_id"] == $users[$i]["user_id"]) {
                        $final[count($final)] = $users[$i];
                    }
                }
                $users = $final;
            }
            if (!empty($level)) {
                $final = [];
                for ($i=0; $i < count($users); $i++) { 
                    if ($users[$i]["user_status"] == $level && $user["user_id"] == $users[$i]["user_id"]) {
                        $final[count($final)] = $users[$i];
                    }
                }
                $users = $final;
            }
            if (!empty($selectList)) {
                $final = [];
                for ($i=0; $i < count($users); $i++) { 
                    if ($users[$i]["is_real"] == $selectList && $user["user_id"] == $users[$i]["user_id"]) {
                        $final[count($final)] = $users[$i];
                    }
                }
                $users = $final;
            }
            if (!empty($group_id)) {
                $final = [];
                for ($i=0; $i < count($users); $i++) { 
                    if ($users[$i]["group"] == $group_id && $user["user_id"] == $users[$i]["user_id"]) {
                        $final[count($final)] = $users[$i];
                    }
                }
                $users = $final;
            }
        }
        else {
            if (!empty($addtime)) {
                $final = [];
                for ($i=0; $i < count($users); $i++) { 
                    if ($users[$i]["date"] == $addtime) {
                        $final[count($final)] = $users[$i];
                    }
                }
                $users = $final;
            }
            if (!empty($level)) {
                $final = [];
                for ($i=0; $i < count($users); $i++) { 
                    if ($users[$i]["user_status"] == $level) {
                        $final[count($final)] = $users[$i];
                    }
                }
                $users = $final;
            }
            if (!empty($selectList)) {
                $final = [];
                for ($i=0; $i < count($users); $i++) { 
                    if ($users[$i]["is_real"] == $selectList) {
                        $final[count($final)] = $users[$i];
                    }
                }
                $users = $final;
            }
            if (!empty($group_id)) {
                $final = [];
                for ($i=0; $i < count($users); $i++) { 
                    if ($users[$i]["group"] == $group_id) {
                        $final[count($final)] = $users[$i];
                    }
                }
                $users = $final;
            }
        }
        echo json_encode(array("code" => 0, "data"=>$users));
    }
}
 catch (\Throwable $th) {
    echo json_encode(array("code" => 1, "data"=>[]));
}

?>