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
if(isset($_GET['equipment_id'])){
    //check session_token valid

    // $stmt = $conn->prepare("SELECT * FROM rl_experiment WHERE experiment = ? AND equipment_id = ? ");
    // $stmt->bind_param("ss", $experiment, $equipment_id );
    // $stmt->execute();
    // $res = $stmt->get_result();
    // while ($row = $res->fetch_assoc()) {
    //     if($row["device_id"]=="session"){
    //         echo "ok";
    //     }
    // }


    $sql = "SELECT * FROM rl_experiment WHERE experiment='".$experiment."'AND equipment_id='".$equipment_id."'AND device_id='".$device_id."' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
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