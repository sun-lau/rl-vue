<?php
// Include config file
require_once "config.php";
header('Content-Type: application/json');
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $myObj->status = "fail";
        $myObj->message = "please enter username";
        echo json_encode($myObj);
        die();
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $myObj->status = "fail";
        $myObj->message = "please enter password";
        echo json_encode($myObj);
        die();
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password, auth_token FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $auth_token);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            
                            if($auth_token==""){    //first login
                                // Prepare an update statement
                                $sql = "UPDATE users SET auth_token = ? WHERE id = ?";
                                
                                if($stmt = mysqli_prepare($link, $sql)){
                                    // Bind variables to the prepared statement as parameters
                                    mysqli_stmt_bind_param($stmt, "si", $param_token, $id);
                                    
                                    // Set parameters
                                    $param_token =  generateRandomString();
                                    
                                    // Attempt to execute the prepared statement
                                    if(mysqli_stmt_execute($stmt)){
                                        $myObj->status = "success";
                                        $myObj->username = $username;
                                        $myObj->token = $param_token;
                                        echo json_encode($myObj);
                                    } else{
                                        $myObj->status = "fail";
                                        $myObj->message = "update token error";
                                        echo json_encode($myObj);
                                    }
                                }
                            }else{  //not first login, return old token
                                $myObj->status = "success";
                                $myObj->username = $username;
                                $myObj->token = $auth_token;
                                echo json_encode($myObj);
                            }
                        } else{
                            // Display an error message if password is not valid
                            $myObj->status = "fail";
                            $myObj->message = "invalid password";
                            echo json_encode($myObj);
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $myObj->status = "fail";
                    $myObj->message = "no account found";
                    echo json_encode($myObj);
                }
            } else{
                $myObj->status = "fail";
                $myObj->message = "database error";
                echo json_encode($myObj);
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
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