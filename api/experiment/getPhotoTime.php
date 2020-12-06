<?php
    header('Content-type: application/json');
    require('config.php');
    date_default_timezone_set('Asia/Hong_Kong');
    //the last modified time and date of.
    $directory = 'BACTERIA_GROWTH-' . $_GET['equipment_id'];
    $names = array('sample_1', 'sample_2', 'sample_3', 'sample_4', 'sample_5', 'sample_6', 'sample_7', 'sample_8');
    foreach($names as $name){
        // $myObj[$name] = date("Y-M-d H:i:s", "storage/".$directory."/".$name.".jpg");
        $myObj[$name] = date("Y-m-d H:i:s", filemtime("storage/".$directory."/".$name.".jpg"));
    }
    echo json_encode($myObj);
?>