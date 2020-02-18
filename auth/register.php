<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $myObj->status = "fail";
        $myObj->message = "please enter username";
        echo json_encode($myObj);
        die();
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $myObj->status = "fail";
                    $myObj->message = "This username is already taken";
                    echo json_encode($myObj);
                    die();
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                $myObj->status = "fail";
                $myObj->message = "database error";
                echo json_encode($myObj);
                die();
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate email
    if(empty(trim($_POST["email"]))){ 
        $myObj->status = "fail";
        $myObj->message = "please enter email";
        echo json_encode($myObj);
        die();
    }  else{
        $email = trim($_POST["email"]);
    }

    // Validate password
    if(empty(trim($_POST["password"]))){ 
        $myObj->status = "fail";
        $myObj->message = "please enter password";
        echo json_encode($myObj);
        die();
    } elseif(strlen(trim($_POST["password"])) < 6){
        $myObj->status = "fail";
        $myObj->message = "password must have at least 6 characters";
        echo json_encode($myObj);
        die();
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){  
        $myObj->status = "fail";
        $myObj->message = "please confirm password";
        echo json_encode($myObj);
        die(); 
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $myObj->status = "fail";
            $myObj->message = "password did not match";
            echo json_encode($myObj);
            die();
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
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
                // Redirect to login page
                $myObj->status = "success";
                echo json_encode($myObj);
            } else{
                $myObj->status = "fail";
                $myObj->message = "database error here";
                echo json_encode($myObj);
                die();
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>