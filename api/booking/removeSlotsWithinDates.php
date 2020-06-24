<?php 
    ini_set('display_errors', 'Off');
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
    
    $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE start_at >= ? AND end_at <= ? AND experiment = ? AND equipment_id = ? ");
    $stmt->bind_param("sssss",$status, $start_date, $end_date, $experiment, $equipment_id);
    $status = "HOLDED";
    $start_date = $_POST['start_date']." 00:00:00";
    $end_date = $_POST['end_date']." 23:59:59";
    $experiment = $_POST['experiment'];
    $equipment_id = $_POST['equipment_id'];
    $stmt->execute();

    $myObj->status = "success";
    $myObj->updated_rows = $stmt->affected_rows;
    echo json_encode($myObj);
    $stmt->close();


?>