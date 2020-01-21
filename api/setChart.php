<?php
header('Content-Type: application/json');

$chart = $_POST['chart'];
$equipment_id = $_POST['equipment_id'];

$file = "experiment/chart.json";
// $str = "0,38|0.1,39|0.2,40|0.3,41";
$array = explode("|", $chart);
$json = array();
foreach($array as $arr){
    $item = explode(",", $arr);
    array_push($json, array(
        "x"=>floatval($item[0]),
        "y"=>floatval($item[1])
    ));
}


file_put_contents($file, json_encode($json));

echo json_encode(array(
    "status" => "success"
));