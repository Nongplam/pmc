<?php
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$data=json_decode(file_get_contents("php://input"));

$bid=$data->bid;


$query="delete from brand where bid='$bid'";

if(mysqli_query($con, $query)) {
            echo "Data Deleted";
        }
        else {
            echo "Error";
        }


?>
