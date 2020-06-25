<?php 
    ini_set('display_errors', 'Off');
    require_once "config.php";
    date_default_timezone_set('Asia/Hong_Kong');
    header('Content-Type: application/json');
    if($_POST['auth_token']=="undefined"){
        $myObj->status = "fail";
        $myObj->message = "missing user info";
        echo json_encode($myObj);
        die();
    }

    //check slot is available for booking
    $message="";
    //check auth_token valid
    $stmt = $link->prepare("SELECT * FROM users WHERE auth_token = ? LIMIT 1");
    $stmt->bind_param("s", $_POST['auth_token']);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    if($row['username'] == "admin" ){
        //loop create record
        $batch_content = $_POST['batch_content'];
        $contents = explode("\n", $batch_content);
        foreach($contents as $content) {
            $info = explode(",", $content);
            $username = $info[0];
            $email = $info[1];
            $password = $info[2];
            //create record one by one

            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);
                
                // Set parameters
                $param_username = $username;
                $param_email = $email;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    $message = $message ."<br>". $username.": <span style='color:green'>success</span>";
                } else{
                    $message = $message ."<br>". $username.": <span style='color:red'>fail</span>";
                }
            }
        }
        $myObj->status = "success";
        $myObj->message = $message;
        echo json_encode($myObj);
    }else{
        $myObj->status = "fail";
        $myObj->message = "invalid token";
        echo json_encode($myObj);
    }
?>