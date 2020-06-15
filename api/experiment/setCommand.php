<?php
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
        $myObj->error = "no_post_command";
        echo json_encode($myObj);
        die();
    }
    $command = $_POST['command'];
    $experiment = $_POST['experiment'];
    $equipment_id = $_POST['equipment_id'];
    $device_id = $_POST['device_id'];
    if(isset($command)){

        $sql = "SELECT * FROM rl_experiment WHERE experiment='".$experiment."'AND equipment_id='".$equipment_id."'AND device_id='".$device_id."' LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            $myObj->status = "fail";
            $myObj->error = "no_record_found";
            echo json_encode($myObj);
            die();
        }

        $current_time = time();
        $sql = "UPDATE rl_experiment SET command='".$command."',command_set_at='".$current_time."'  WHERE experiment='".$experiment."'AND equipment_id='".$equipment_id."'AND device_id='".$device_id."' LIMIT 1";

        if ($conn->query($sql) === TRUE) {
            $myObj->status = "success";
        } else {
            $myObj->status = "fail";
            $myObj->error = "update_error";
        }
        echo json_encode($myObj);
        $conn->close();


    }

?>