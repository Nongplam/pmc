<?php
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';

if(isset($_GET['username'])){
    $username=$_GET['username'];
    $password=$_GET['password'];    
    $query="select fname from user WHERE username LIKE '{$username}' AND password LIKE '{$password}'";
    $result = mysqli_query($con,$query);
    
    $fname=array();
    while ($rows = $result->fetch_array(MYSQLI_ASSOC)){
        array_push($fname,$rows['fname']);
    }
    if(!empty($fname[0])){
        echo $fname[0];
    }else{
        echo "Wrong";
    }
    
}

?>
