<?php
header('Content-Type: application/json');
require('config.php');
$file = "experiment/chart.json";
$json = json_decode(file_get_contents($file),TRUE);

echo json_encode($json);