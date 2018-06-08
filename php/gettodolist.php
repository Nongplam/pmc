<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$userid = $_SESSION["id"];
$todolistquery="SELECT Todolist.id,todotype.type,Todolist.title,Todolist.detail,Todolist.url,user.fname,user.lname,Todolist.createdate,Todolist.status FROM Todolist,todotype,user WHERE user.id = Todolist.usergen AND todotype.id = Todolist.todotype AND Todolist.userrecive = '$userid' AND Todolist.status != '3'";
$res = array();
if($result = mysqli_query($con,$todolistquery)){

        while ($row = $result -> fetch_array(1)){

            $res[] =  $row ;

        }
        $todolist['records']= $res;
        echo   json_encode($todolist);
    }
