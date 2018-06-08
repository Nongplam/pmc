<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
if(!empty($_POST['status'])){
    $targetstatus = $_POST['status'];
    $targetid = $_POST['todoid'];
    
    $query="UPDATE Todolist SET Todolist.status = '$targetstatus' WHERE Todolist.id = '$targetid'";
    if(mysqli_query($con, $query)) {
            echo "Todo Updated";            
        }
        else {
            echo $con;
        }
}else{
    echo "empty";
}
