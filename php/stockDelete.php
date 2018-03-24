<?php
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$data=json_decode(file_get_contents("php://input"));
$sid=$data->sid;
$query="delete from stock where sid='$sid'";

if(mysqli_query($con, $query)) {
            echo "Data Deleted";
        }
        else {
            echo "Error";
        }


?>
