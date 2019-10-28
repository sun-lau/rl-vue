<?php
    ini_set('display_errors', 'On');
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
    $equipment_id = $_POST['equipment_id'];
    if(isset($command)){

        $sql = "SELECT * FROM rl_experiment WHERE equipment_id='".$equipment_id."' LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            $myObj->status = "fail";
            $myObj->error = "no_record_found";
            echo json_encode($myObj);
            die();
        }

        $sql = "UPDATE rl_experiment SET command='".$command."' WHERE equipment_id='".$equipment_id."'";

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