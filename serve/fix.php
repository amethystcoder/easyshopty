<?php
$users = json_decode(file_get_contents("users.json"),true);
$plex = json_decode(file_get_contents("hashed_admin_password.json"),true);
$fixed = file_put_contents("users.json","new user added");
$fix_second = file_put_contents("hashed_admin_password.json","new fixes made");
?>
