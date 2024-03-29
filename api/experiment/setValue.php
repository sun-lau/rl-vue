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
    if(!isset($_POST['value'])){
        $myObj->status = "fail";
        $myObj->error = "no_post_value";
        echo json_encode($myObj);
        die();
    }
    $value = $_POST['value'];
    $experiment = $_POST['experiment'];
    $equipment_id = $_POST['equipment_id'];
    $device_id = $_POST['device_id'];
    if(isset($value)){

        $sql = "SELECT * FROM rl_experiment WHERE experiment='".$experiment."'AND equipment_id='".$equipment_id."'AND device_id='".$device_id."' LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            $myObj->status = "fail";
            $myObj->error = "no_record_found";
            echo json_encode($myObj);
            die();
        }

        while($row = $result->fetch_assoc()) {
            $db_value = $row["value"];
            $db_value_json = json_decode($db_value);
        }

        //insert new key or update key of value
        $value_json = json_decode($value);
        foreach($db_value_json as $name => $v){
            $new_value_json[$name] = $v;
        }
        foreach($value_json as $name => $v){
            $new_value_json[$name] = $v;
        }
        $new_value = json_encode($new_value_json);
        $current_time = time();
        $sql = "UPDATE rl_experiment SET value='".$new_value."',value_set_at='".$current_time."'  WHERE experiment='".$experiment."'AND equipment_id='".$equipment_id."'AND device_id='".$device_id."' LIMIT 1";

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