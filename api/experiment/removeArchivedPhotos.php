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

    $experiment = $_POST['experiment'];
    $equipment_id = $_POST['equipment_id'];
    $rootPath = realpath('storage/'.$experiment.'-'.$equipment_id).'-archive';
    // remove all files in archive
    $files = glob($rootPath.'/*'); // get all file names
    foreach($files as $file){ // iterate files
        if(is_file($file)) {
            unlink($file); // delete file
        }
    }
    $myObj->status = "success";
    echo json_encode($myObj);

?>