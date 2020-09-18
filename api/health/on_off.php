<?php
// Include config file
    header('Content-Type: application/json');
    ini_set('display_errors', 'On');
    date_default_timezone_set('Asia/Hong_Kong');
    require('config.php');
    $conn = new mysqli($servername, $username, $password, $dbname);
    mysqli_set_charset($conn, "utf8");
    // Check connection
    $to = $_GET['to'];
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE rl.rl_config SET value='$to' WHERE name='health_check_on' ";
    
    if ($conn->query($sql) === TRUE) {
      echo "Success";
    } else {
      echo "Error updating record: " . $conn->error;
    }

?>