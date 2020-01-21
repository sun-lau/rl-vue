<?php
header('Content-Type: application/json');
$file = "experiment/chart.json";
$json = json_decode(file_get_contents($file),TRUE);

echo json_encode($json);