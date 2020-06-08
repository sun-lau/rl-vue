<?php
header('Content-Type: application/json');
require('config.php');
$equipment_id = $_GET['equipment_id'];
$file = "charts/".$equipment_id.".json";
$json = json_decode(file_get_contents($file),TRUE);

echo json_encode($json);