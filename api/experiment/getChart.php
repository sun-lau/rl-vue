<?php
header('Content-Type: application/json');
require('config.php');
$experiment = $_GET['experiment'];
$equipment_id = $_GET['equipment_id'];
$file = "charts/".$experiment."_".$equipment_id.".json";
$json = json_decode(file_get_contents($file),TRUE);

echo json_encode($json);