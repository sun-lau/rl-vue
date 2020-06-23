<?php
ini_set('display_errors', 'Off');
chdir(dirname(__FILE__));
header('Content-type: application/json');
date_default_timezone_set('Asia/Hong_Kong');
$experiment = $_POST['experiment'];
$equipment_id = $_POST['equipment_id'];
$filename_prefix = $_POST['filename_prefix'];

$response = file_get_contents('https://picsum.photos/200/300');
$directory = $experiment."-".$equipment_id;
$name = $filename_prefix."_".date("Y_m_d_H_i");
if (!file_exists("storage/".$directory)) {
    mkdir("storage/".$directory, 0777, true);
}
file_put_contents("storage/".$directory."/".$name.".jpg", $response);

$myObj->status = "success";
echo json_encode($myObj);
?>