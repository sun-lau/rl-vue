<?php
$received = file_get_contents('php://input');
$fileToWrite = "experiment/cam.jpg";
file_put_contents($fileToWrite, $received);


?>