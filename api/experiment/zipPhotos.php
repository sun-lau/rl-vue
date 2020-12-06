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

// if(!isset($_POST['session_token'])){
//     $myObj->status = "fail";
//     $myObj->error = "missing_session_token";
//     echo json_encode($myObj);
//     die();
// }
$session_token = $_POST['session_token'];
$role = $_POST['role'];
$experiment = $_POST['experiment'];
$equipment_id = $_POST['equipment_id'];
$device_id = $_POST['device_id'];
$session_device = "session";
//check session_token valid
/*
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
*/


$rootPath = realpath('storage/'.$experiment.'-'.$equipment_id.'-latest');

// Initialize archive object
$zip = new ZipArchive();
$zip->open('storage/'.$experiment.'-'.$equipment_id.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}

// Zip archive will be created only after closing object
$zip->close();
$myObj->status = "success";
echo json_encode($myObj);

?>