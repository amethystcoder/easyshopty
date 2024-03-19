<?php

session_start();
if(session_destroy()){
    echo json_encode(array("code" => 0, "data" => true));
}
else {
    echo json_encode(array("code" => 1, "data" => false));
}

?>