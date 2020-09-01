<?php
// Include config file
    header('Content-Type: application/json');
    ini_set('display_errors', 'On');
    date_default_timezone_set('Asia/Hong_Kong');
    define('SLACK_WEBHOOK', 'https://hooks.slack.com/services/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');
    
    require('config.php');
    $conn = new mysqli($servername, $username, $password, $dbname);
    mysqli_set_charset($conn, "utf8");
    // Check connection

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $nowtime = time();
    $stmt = $conn->prepare("SELECT * FROM `rl_experiment` ORDER BY experiment, equipment_id, device_id");
    $stmt->execute();
    $res = $stmt->get_result();
    $equipments = array();
    while ($row = $res->fetch_assoc()) {
        $time_diff = $nowtime - intval($row["command_got_at"]);
        if(intval($row["command_got_at"]) != 0){
            if( $time_diff > 3600 ){
                $message = "";
                $message .= "Experiment: " . $row["experiment"];
                $message .= "Equipment ID: " . $row["equipment_id"];
                $message .= "Device ID: : " . $row["device_id"];
                $message .= "Last Report: : " . $time_diff ."sec";
                echo "1";
                slack($message);
            }else{
                echo "0";
            }
        }
    }

    function slack($text){
        $message = array('payload' => json_encode(array('text' => $text)));
        $c = curl_init(SLACK_WEBHOOK);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $message);
        curl_exec($c);
        curl_close($c);
    }
?>