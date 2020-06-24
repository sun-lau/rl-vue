<?php
// Include config file
require_once "config.php";
header('Content-Type: application/json');
ini_set('display_errors', 'Off');
date_default_timezone_set('Asia/Hong_Kong');
 

$stmt = $link->prepare("SELECT username, email, last_login_at FROM `users`");
$stmt->execute();
$res = $stmt->get_result();
$users = array();
while ($row = $res->fetch_assoc()) {
    array_push($users, array(
        "username" => $row["username"],
        "email" => $row["email"],
        "last_login_at" => $row["last_login_at"]
    ));   
}
$myObj->status = "success";
$myObj->users = $users;
echo json_encode($myObj);

?>