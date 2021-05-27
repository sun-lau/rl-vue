<?php
// Include config file
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
    //check on/off start
    $sql = "SELECT value FROM rl.rl_config WHERE name='health_check_on'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $on_off = $row["value"];
        }
    }
    echo 'Slack Notification is '.$on_off."<br>";
    //check on/off end
    $nowtime = time();
    $stmt = $conn->prepare("SELECT * FROM `rl_experiment` ORDER BY experiment, equipment_id, device_id");
    $stmt->execute();
    $res = $stmt->get_result();
    $equipments = array();
    while ($row = $res->fetch_assoc()) {
        $time_diff = $nowtime - intval($row["command_got_at"]);
        if(intval($row["command_got_at"]) != 0){
            $message = "";
            $message .= "Experiment: " . $row["experiment"]."\n";
            $message .= "Equipment ID: " . $row["equipment_id"]."\n";
            $message .= "Device ID: : " . $row["device_id"]."\n";
            $message .= "Last Report: : " . $time_diff/60 ."mins";
            if( $time_diff > 3600 ){
                echo $message."<br>";
                if($row["experiment"] == "BACTERIA_GROWTH"){
                    continue;
                }
                if($on_off == '1'){
                slack($message);
                }
            }else{
                echo $message."<br>";
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