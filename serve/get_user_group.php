<?php

$user_status = $_SESSION["user_status"];

if($user_status == "VIP 1"){
    echo 1;
}
elseif ($user_status == "VIP 2") {
    echo 2;
}
elseif ($user_status == "VIP 3") {
    echo 3;
}
else {
    echo 0;
}
?>