<?php
ini_set('display_errors', 'Off');
header('Content-type: application/json');
require('config.php');
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");
// Check connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$equipment_id = $_GET['equipment_id'];
if(isset($_GET['equipment_id'])){
    $sql = "SELECT * FROM rl_experiment WHERE equipment_id='".$equipment_id."' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            //if value_write_at > value_read_at
            $value = $row["value"];
            //update
            $myObj->value = $value;
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

?>