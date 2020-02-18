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
$equipment_id = $_GET['equipment_id'];
$device_id = $_GET['device_id'];
if(isset($_GET['equipment_id'])){


    $sql = "SELECT * FROM rl_experiment WHERE equipment_id='".$equipment_id."'AND device_id='".$device_id."' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            $myObj->command = $row["command"];
            $myObj->value_got_at = $row["value_got_at"];
            $myObj->value_set_at = $row["value_set_at"];
            $myObj->command_got_at = $row["command_got_at"];
            $myObj->command_set_at = $row["command_set_at"];
            $myObj->status = "success";
            //else return not yet ready
            $sql = "UPDATE rl_experiment SET command_got_at=".$current_time."  WHERE equipment_id='".$equipment_id."'AND device_id='".$device_id."' LIMIT 1";
            if ($conn->query($sql) === TRUE) { 
                echo json_encode($myObj);
                //else return not yet ready
                $conn->close();
                die();
            }
        }
    } else {
        $myObj->status = "fail";
        $myObj->error = "no_record";
        echo json_encode($myObj);
    }

}else {
    $myObj->status = "fail";
    $myObj->error = "no_record";
    echo json_encode($myObj);
}

?>