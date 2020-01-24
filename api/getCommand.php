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

$current_time = date("Y-m-d H:i:s");
$equipment_id = $_GET['equipment_id'];
if(isset($equipment_id)){
    $sql = "UPDATE rl_experiment SET command_get_at='".$current_time."'  WHERE equipment_id='".$equipment_id."'";
    if ($conn->query($sql) === TRUE) { 
        $sql = "SELECT * FROM rl_experiment WHERE equipment_id='".$equipment_id."' LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $myObj->command = $row["command"];
                $myObj->value_get_at = $row["value_get_at"];
                $myObj->value_set_at = $row["value_set_at"];
                $myObj->command_get_at = $row["command_get_at"];
                $myObj->command_set_at = $row["command_set_at"];
                $myObj->status = "success";
                echo json_encode($myObj);
                //else return not yet ready
                $conn->close();
                die();
            }
        } else {
            $myObj->status = "fail";
            $myObj->error = "no_record";
            echo json_encode($myObj);
        }
    }
}else {
    $myObj->status = "fail";
    $myObj->error = "no_record";
    echo json_encode($myObj);
}

?>