<?php
header('Content-Type: application/json');
require('config.php');
$experiment = $_GET['experiment'];
$equipment_id = $_GET['equipment_id'];
$role = $_GET['role'];
$session_token = $_GET['session_token'];

if(!isset($_GET['experiment'])){
    $myObj->status = "fail";
    $myObj->error = "missing_experiment";
    echo json_encode($myObj);
    die();
}
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

$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");
// Check connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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

$file = "charts/".$experiment."_".$equipment_id.".json";
$json = json_decode(file_get_contents($file),TRUE);

echo json_encode($json);