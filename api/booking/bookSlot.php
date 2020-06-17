<?php 
    date_default_timezone_set('Asia/Hong_Kong');
    header('Content-type: application/json');
    require('config.php');
    if($_POST['auth_token']=="undefined"){
        $myObj->status = "fail";
        $myObj->message = "missing user info";
        echo json_encode($myObj);
        die();
    }
    if($_POST['slot_id']=="undefined"){
        $myObj->status = "fail";
        $myObj->message = "missing slot id";
        echo json_encode($myObj);
        die();
    }

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //check slot is available for booking

    //check auth_token valid
    $stmt = $conn->prepare("SELECT * FROM users WHERE auth_token = ? LIMIT 1");
    $stmt->bind_param("s", $_POST['auth_token']);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    if($row != NULL ){
        $username = $row['username'];
        //book it
        $stmt = $conn->prepare("UPDATE bookings SET username = ?, status = ?, session_token = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $status, $token_json,  $id);
        $username = $username;
        $status = "BOOKED";
        $id = $_POST['slot_id'];
        $token->player = generateRandomString(6);
        $token->observer = generateRandomString(6);
        $token_json = json_encode($token);
        $stmt->execute();
    
        $myObj->status = "success";
        echo json_encode($myObj);

    }else{
        $myObj->status = "fail";
        $myObj->message = "invalid token";
        echo json_encode($myObj);
    }

    

    function generateRandomString($length = 12) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
?>