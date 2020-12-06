<?php
    header('Content-type: application/json');
    //the last modified time and date of.
    $directory = 'BACTERIA_GROWTH-set_0';
    $name = 'sample_1';
    $file = "storage/".$directory."/".$name.".jpg";
    
    //Get the last modified time using the filemtime function.
    //This function will return a Unix timestamp.
    $lastModifiedTimestamp = filemtime($file);
    
    //Convert the timestamp into a human-readable format
    //and print it out.
    $lastModifiedDatetime = date("d M Y H:i:s", $lastModifiedTimestamp);
    
    echo "$file was last modified on $lastModifiedDatetime";
?>