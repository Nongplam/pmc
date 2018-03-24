<?php
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

$data=json_decode(file_get_contents("php://input"));
$id=$data->preshelfid;
$query="delete from shelfprepare where id='$id'";

if(mysqli_query($con, $query)) {
            echo "Data Deleted";
        }
        else {
            echo "Error";
        }


?>
