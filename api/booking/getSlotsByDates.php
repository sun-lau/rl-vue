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

$current_time = date('Y-m-d H:i:s');
$start_date =  $_GET['start_date'];
$end_date =  $_GET['end_date'];
$equipment_id = $_GET['equipment_id'];
$date = $_GET['date'];

if(isset($start_date)){

    $sql = "SELECT * FROM bookings WHERE equipment_id='".$equipment_id."'AND date>='".$start_date."'AND date<='".$end_date."' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $slots = array();
        while($row = $result->fetch_assoc()) {
            array_push($slots, array(
                "id" => $row["id"],
                "username" => $row["username"],
                "start_at" => $row["start_at"],
                "end_at" =>  $row["end_at"],
                "status" => $row["status"]
            ));            
        }
        $myObj->status = "success";
        $myObj->slots = $slots;
        echo json_encode($myObj);
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