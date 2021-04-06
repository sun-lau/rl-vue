<?php
    ini_set('display_errors', 'Off');
    chdir(dirname(__FILE__));
    header('Content-type: application/json');
    date_default_timezone_set('Asia/Hong_Kong');
    require('config.php');
    $experiment = $_POST['experiment'];
    $equipment_id = $_POST['equipment_id'];
    $filename_prefix = $_POST['filename_prefix'];

    if($filename_prefix == "sample_1" || $filename_prefix == "sample_2" || $filename_prefix == "sample_3" || $filename_prefix == "sample_4" || $filename_prefix == "auto_sample_1" || $filename_prefix == "auto_sample_2" || $filename_prefix == "auto_sample_3" || $filename_prefix == "auto_sample_4" ){
        $camera_url = 'https://stem-video-ap.polyu.edu.hk/stream/BACTERIA_GROWTH_00/CAM0008/image';    
    }else{
        $camera_url = 'https://stem-video-ap.polyu.edu.hk/stream/BACTERIA_GROWTH_00/CAM0009/image';
    }
    $response = file_get_contents($camera_url);
    $directory = $experiment."-".$equipment_id;
    if (!file_exists("storage/".$directory)) {
        mkdir("storage/".$directory, 0777, true);
    }
    file_put_contents("storage/".$directory."/".$filename_prefix.".jpg", $response);    //for user
    $archive = $experiment."-".$equipment_id."-archive";
    if (!file_exists("storage/".$archive)) {
        mkdir("storage/".$archive, 0777, true);
    }
    $name = $filename_prefix."_".date("Y_m_d_H_i_s");
    file_put_contents("storage/".$archive."/".$name.".jpg", $response);   //for archive
    $myObj->status = "success";
    echo json_encode($myObj);

    // for debugging
    // define('SLACK_WEBHOOK', 'https://hooks.slack.com/services/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');
    // $message = "";
    // $message .= "Set Photo: " . $experiment."\n";
    // $message .= "Equipment ID: " . $equipment_id."\n";
    // $message .= "File Name Prefix: " . $filename_prefix."\n";
    // $message .= "Archive Name: " . $name."\n";
    // slack($message);

    // function slack($text){
    //     $message = array('payload' => json_encode(array('text' => $text)));
    //     $c = curl_init(SLACK_WEBHOOK);
    //     curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($c, CURLOPT_POST, true);
    //     curl_setopt($c, CURLOPT_POSTFIELDS, $message);
    //     curl_exec($c);
    //     curl_close($c);
    // }

?>