<?php
    ini_set('display_errors', 'Off');
    date_default_timezone_set('Asia/Hong_Kong');
    header('Content-type: application/json');
    require('config.php');
    if($_POST['auth_token']=="undefined"){
        $myObj->status = "fail";
        $myObj->message = "missing user info";
        echo json_encode($myObj);
        die();
    }
    $conn = new mysqli($servername, $username, $password, $dbname);
    mysqli_set_charset($conn, "utf8");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    //check auth_token valid
    $stmt = $conn->prepare("SELECT * FROM users WHERE auth_token = ? LIMIT 1");
    $stmt->bind_param("s", $_POST['auth_token']);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    if($row != NULL ){
        $username = $row['username'];
        //get session_token from booking record
        $stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ? LIMIT 1");
        $stmt->bind_param("s", $_POST['slot_id']);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
    
        $myObj->status = "success";
        $myObj->session_token = $row['session_token'];
        echo json_encode($myObj);

    }else{
        $myObj->status = "fail";
        $myObj->message = "invalid token";
        echo json_encode($myObj);
    }

?>