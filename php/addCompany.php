<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/5/2018
 * Time: 2:10 PM
 */
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$data=json_decode(file_get_contents("php://input"));
$masterbranchid=$_SESSION["masterbranchid"];

if($data){
    $cname=mysqli_real_escape_string($con, $data->cname);
    $agent = mysqli_real_escape_string($con,$data ->agent);
    $contact = mysqli_real_escape_string($con,$data -> contact);
    $tel = mysqli_real_escape_string($con,$data -> tel);
    $mail = mysqli_real_escape_string($con,$data -> mail);

        $stm1="INSERT INTO company (cname, agent,contact,tel,mail,masterbranchid) VALUE ('$cname','$agent','$contact','$tel','$mail','$masterbranchid')";
        if(mysqli_query($con, $stm1)) {


            $sql  = "SELECT cid FROM company WHERE cname='$cname' AND  agent ='$agent' AND contact='$contact' AND  tel ='$tel'   AND  mail = '$mail' AND masterbranchid = $masterbranchid ";

            $result = mysqli_query($con, $sql);

            $row = $result -> fetch_array(1);
            $cid = $row["cid"];
            echo "{\"Insert\":true,
                    \"cid\" : \"".$cid."\" }";
        }
        else {
            echo "{\"Insert\":false}";
        }


}

?>