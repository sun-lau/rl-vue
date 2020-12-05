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
    if(!isset($_POST['command'])){
        $myObj->status = "fail";
        $myObj->error = "missing_post_command";
        echo json_encode($myObj);
        die();
    }
    if(!isset($_POST['session_token'])){
        $myObj->status = "fail";
        $myObj->error = "missing_session_token";
        echo json_encode($myObj);
        die();
    }
    $session_token = $_POST['session_token'];
    $role = $_POST['role'];
    $command = $_POST['command'];
    $experiment = $_POST['experiment'];
    $equipment_id = $_POST['equipment_id'];
    $device_id = $_POST['device_id'];

    
    $session_device = "session";
    //check session_token valid
    if($session_token!='super'){
        if($role!="super"){
            $with_valid_session_token = false;
            $stmt = $conn->prepare("SELECT * FROM rl_experiment WHERE experiment = ? AND equipment_id = ? AND device_id = ? LIMIT 1");
            $stmt->bind_param("sss", $experiment, $equipment_id, $session_device );
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()) {
                if($session_token == json_decode($row["value"])->{$role}){
                    $with_valid_session_token = true;
                }
            }
            if(!$with_valid_session_token){
                $myObj->status = "fail";
                $myObj->error = "invalid_session_token";
                echo json_encode($myObj);
                die();
            }
        }
    }
    //set command
    $current_time = time();
    $stmt = $conn->prepare("UPDATE rl_experiment SET command = ?, command_set_at= ? WHERE experiment = ? AND equipment_id = ? AND device_id = ? LIMIT 1");
    $stmt->bind_param("sssss", $command, $current_time, $experiment, $equipment_id, $device_id);
    $stmt->execute();
    $myObj->status = "success";
    echo json_encode($myObj);
    $conn->close();
?>