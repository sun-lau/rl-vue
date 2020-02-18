<?php
header('Content-Type: application/json');
require('config.php');

$chart = $_POST['chart'];
$equipment_id = $_POST['equipment_id'];

$file = "chart.json";
// $str = "0,38|0.1,39|0.2,40|0.3,41";
$array = explode("|", $chart);
$json = array();
foreach($array as $arr){
    $item = explode(",", $arr);
    array_push($json, array(
        "x"=>floatval($item[0]),
        "y"=>floatval($item[1])
    ));
}
file_put_contents($file, json_encode($json));

//set database value


$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");
// Check connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$value_json = array( 
    "chart_at"=>time()
); 
   
$equipment_id = "asdfgh";
$device_id = $_POST['device_id'];


$sql = "SELECT * FROM rl_experiment WHERE equipment_id='".$equipment_id."'AND device_id='".$device_id."' LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $myObj->status = "fail";
    $myObj->error = "no_record_found";
    echo json_encode($myObj);
    die();
}

while($row = $result->fetch_assoc()) {
    $db_value = $row["value"];
    $db_value_json = json_decode($db_value);
}

//insert new key or update key of value
foreach($db_value_json as $name => $v){
    $new_value_json[$name] = $v;
}
foreach($value_json as $name => $v){
    $new_value_json[$name] = $v;
}
$new_value = json_encode($new_value_json);
$current_time = time();
$sql = "UPDATE rl_experiment SET value='".$new_value."',value_set_at='".$current_time."'  WHERE equipment_id='".$equipment_id."'AND device_id='".$device_id."' LIMIT 1";

if ($conn->query($sql) === TRUE) {
    $myObj->status = "success";
} else {
    $myObj->status = "fail";
    $myObj->error = "update_error";
}
echo json_encode($myObj);
$conn->close();

