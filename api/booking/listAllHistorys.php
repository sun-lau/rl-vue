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


$sql = "SELECT * FROM bookings WHERE status='BOOKED' ORDER BY start_at, date";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $historys = array();
    while($row = $result->fetch_assoc()) {
        array_push($historys, array(
            "date" => $row["date"],
            "start_at" => $row["start_at"],
            "end_at" => $row["end_at"],
            "experiment" => $row["experiment"],
            "equipment_id" => $row["equipment_id"],
            "username" => $row["username"],
            "has_entered" => $row["has_entered"]
        ));           
    }
    $myObj->status = "success";
    $myObj->rows = $result->num_rows;
    $myObj->historys = $historys;
    echo json_encode($myObj);
} else {
    $myObj->status = "fail";
    $myObj->error = "no_record";
    echo json_encode($myObj);
}

?>