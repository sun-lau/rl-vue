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

$session_token = $_POST['session_token'];
$role = $_POST['role'];
$experiment = $_POST['experiment'];
$equipment_id = $_POST['equipment_id'];
$device_id = $_POST['device_id'];
$session_device = "session";


$rootPath = realpath('storage/'.$experiment.'-'.$equipment_id);

$zip = new ZipArchive();
$zip->open('storage/'.$experiment.'-'.$equipment_id.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    if (!$file->isDir())
    {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);
        $zip->addFile($filePath, $relativePath);
    }
}
$zip->close();
$myObj->status = "success";
echo json_encode($myObj);

?>