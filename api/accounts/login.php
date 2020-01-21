<?php
    header("Access-Control-Allow-Origin: *");
    if($_POST["username"]!="test"){
        $arr = array(
            'error' => "invalid_username"
        );
        echo json_encode($arr);
        die();
    }
    if($_POST["password"]!="test"){
        $arr = array(
            'error' => "invalid_password"
        );
        echo json_encode($arr);
        die();
    }
    $arr = array(
        'auth_token' => "asd123",
        'nickname'  => "Test User"
    );
    echo json_encode($arr);

?>