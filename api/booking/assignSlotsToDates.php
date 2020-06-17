<?php 
    date_default_timezone_set('Asia/Hong_Kong');
    header('Content-type: application/json');
    require('config.php');
    if($_POST['start_date']=="undefined"){
        $myObj->status = "fail";
        $myObj->message = "missing start date";
        echo json_encode($myObj);
        die();
    }
    if($_POST['end_date']=="undefined"){
        $myObj->status = "fail";
        $myObj->message = "missing end date";
        echo json_encode($myObj);
        die();
    }

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("INSERT INTO bookings (date, start_at, end_at, experiment, equipment_id, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $param_date, $param_start_at, $param_end_at, $param_experiment, $param_equipment_id, $param_status);
    $experiment = $_POST['experiment'];
    $equipment_id = $_POST['equipment_id'];
    $status = "IDLE";
    $date = $_POST['start_date'];
    $init = true;
    $cnt = 0;
    while(1){
        if($init){
            $current = $_POST['start_date']." ".$_POST['start_from'].":00";
            $init = false;
        }else{
            $current = date('Y-m-d H:i:s', strtotime($current)+intval($_POST['rest'])*60);
        }
        if($current>$_POST['end_date']."23:59:59"){
            break;
        }
        if($cnt>10000){
            break;
        }
        $start_at = $current;
        $current = date('Y-m-d H:i:s', strtotime($current)+intval($_POST['duration'])*60);
        $end_at = $current;
        $param_date = date('Y-m-d',strtotime($current) );
        $param_start_at = $start_at;
        $param_end_at = $end_at;
        $param_experiment = $experiment;
        $param_equipment_id = $equipment_id;
        $param_status = $status;
        $stmt->execute();
        $cnt++;
    }
    $myObj->status = "success";
    $myObj->count = $cnt;
    echo json_encode($myObj);

?>