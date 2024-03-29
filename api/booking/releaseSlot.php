<?php 
    date_default_timezone_set('Asia/Hong_Kong');
    header('Content-type: application/json');
    require('config.php');
    if($_POST['username']=="undefined"){
        $myObj->status = "fail";
        $myObj->message = "missing user info";
        echo json_encode($myObj);
        die();
    }
    if($_POST['slot_id']=="undefined"){
        $myObj->status = "fail";
        $myObj->message = "missing slot id";
        echo json_encode($myObj);
        die();
    }

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //check slot is already booked

    //check auth_token valid
    $stmt = $conn->prepare("SELECT username FROM users WHERE auth_token = ? LIMIT 1");
    $stmt->bind_param("s", $_POST['auth_token']);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    if($row != NULL ){
        $username = $row['username'];   //todo: check this slot username
        $stmt = $conn->prepare("UPDATE bookings SET status = ?, username = '', session_token = '' WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $status = "IDLE";
        $id = $_POST['slot_id'];
        $stmt->execute();
        $myObj->status = "success";
        echo json_encode($myObj);
    }else{
        $myObj->status = "fail";
        $myObj->message = "invalid token";
        echo json_encode($myObj);
    }

?>