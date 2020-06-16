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
    //check slot is available for booking

    //book it
    $stmt = $conn->prepare("UPDATE bookings SET username = ?, status = ?, token = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $status, $token_json,  $id);
    $username = $_POST['username'];
    $status = "BOOKED";
    $id = $_POST['slot_id'];
    $token->player = "aaaaaa";
    $token->observer = "bbbbbb";
    $token_json = json_encode($token);
    $stmt->execute();

    $myObj->status = "success";
    echo json_encode($myObj);

?>