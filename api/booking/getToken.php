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
    $username = $_GET['username'];
    $slot_id = $_GET['slot_id'];

    
    $sql = "SELECT * FROM bookings WHERE id=".$slot_id ." LIMIT 1 ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $slots = array();
        $row = $result->fetch_assoc();
        $myObj->token = $row["token"];
        echo json_encode($myObj);
    } else {
        $myObj->status = "fail";
        $myObj->error = "no_record";
        echo json_encode($myObj);
        die();
    }
?>