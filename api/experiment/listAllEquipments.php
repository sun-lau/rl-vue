<?php
// Include config file
header('Content-Type: application/json');
ini_set('display_errors', 'Off');
date_default_timezone_set('Asia/Hong_Kong');
 
require('config.php');
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");
// Check connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$stmt = $conn->prepare("SELECT * FROM `rl_experiment` ORDER BY experiment, equipment_id, device_id");
$stmt->execute();
$res = $stmt->get_result();
$equipments = array();
while ($row = $res->fetch_assoc()) {
    array_push($equipments, array(
        "experiment" => $row["experiment"],
        "equipment_id" => $row["equipment_id"],
        "device_id" => $row["device_id"],
        "command" => $row["command"],
        "value" => $row["value"],
        "command_set_at" => $row["command_set_at"],
        "command_got_at" => $row["command_got_at"],
        "value_set_at" => $row["value_set_at"],
        "value_got_at" => $row["value_got_at"],
    ));   
}
$myObj->status = "success";
$myObj->equipments = $equipments;
echo json_encode($myObj);

?>