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
    $token = $_GET['token'];
    $myObj->status = "success";
    // $myObj->status = "fail";
    // $myObj->error = "no_record";
    echo json_encode($myObj);
?>