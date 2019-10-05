<?php
ini_set('display_errors', 'On');
header('Content-type: application/json');
require('config.php');
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");
// Check connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// $name = "set_1";
// $stmt = $conn->prepare('SELECT * FROM rl_ohm_law WHERE name = ?');
// $stmt->bind_param('s', $name); // 's' specifies the variable type => 'string'

// $stmt->execute();

// $result = $stmt->get_result();
// while ($row = $result->fetch_assoc()) {
//     // do something with $row
// }

$sql = "SELECT value FROM rl_ohm_law WHERE name='set_1' LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
if(isset($_GET['command'])){
    $sqla="UPDATE rl_ohm_law SET command='".$_GET['command']."' WHERE name='set_1'";
    if ($conn->query($sqla) === TRUE) {
        $return['value'] = $row['value'];
        $return['status'] = "success";
        echo json_encode($return);
    } else {
        $return['status'] = "error";
        echo json_encode($return);
    }

}else{
    $return['value'] = $row['value'];
    $return['status'] = "success";
    echo json_encode($return);
}
$conn->close();

?>