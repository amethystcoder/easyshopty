<?php

session_start();

if (empty($_SESSION["last_admin_activity"])) {
    echo json_encode(["result" => false]);
}
else {
    $exp_time = 60 * 15;//15minutes
    if ((time() - $_SESSION["last_activity"]) > $exp_time) {
        session_unset();
        session_destroy();
        echo json_encode(["result" => false]);
    }
    else {
        echo json_encode(["result" => true]);
    }
}

?>