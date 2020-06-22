<?php
ini_set('display_errors', 'Off');
date_default_timezone_set('Asia/Hong_Kong');
header('Content-type: application/json');
require('config.php');
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");
// Check connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$current_time = time();
$experiment = $_GET['experiment'];
$equipment_id = $_GET['equipment_id'];
$device_id = $_GET['device_id'];
$session_token = $_GET['session_token'];
$role = $_GET['role'];
$session_device = "session";
if(!isset($_GET['equipment_id'])){
    $myObj->status = "fail";
    $myObj->error = "missing_equipment_id";
    echo json_encode($myObj);
    die();
}

if(!isset($_GET['session_token'])){
    $myObj->status = "fail";
    $myObj->error = "missing_session_token";
    echo json_encode($myObj);
    die();
}

//check session_token valid
$with_valid_session_token = false;
$stmt = $conn->prepare("SELECT * FROM rl_experiment WHERE experiment = ? AND equipment_id = ? AND device_id = ? LIMIT 1");
$stmt->bind_param("sss", $experiment, $equipment_id, $session_device );
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    if($session_token == json_decode($row["value"])->{$role}){
        $with_valid_session_token = true;
    }
}
if(!$with_valid_session_token){
    $myObj->status = "fail";
    $myObj->error = "invalid_session_token";
    echo json_encode($myObj);
    die();

}
$stmt = $conn->prepare("SELECT * FROM rl_experiment WHERE experiment = ? AND equipment_id = ? AND device_id = ? LIMIT 1");
$stmt->bind_param("sss", $experiment, $equipment_id, $device_id );
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $myObj->value = $row["value"];
    $myObj->value_got_at = $row["value_got_at"];
    $myObj->value_set_at = $row["value_set_at"];
    $myObj->command_got_at = $row["command_got_at"];
    $myObj->command_set_at = $row["command_set_at"];
    $myObj->status = "success";
    //else return not yet ready
    $sql = "UPDATE rl_experiment SET value_got_at='".$current_time."'  WHERE experiment='".$experiment."'AND equipment_id='".$equipment_id."'AND device_id='".$device_id."' LIMIT 1";
    if ($conn->query($sql) === TRUE) { 
        echo json_encode($myObj);
        //else return not yet ready
        $conn->close();
        die();
    }
}
?>