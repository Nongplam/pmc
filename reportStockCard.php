<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 5/30/2018
 * Time: 4:15 PM
 */


?>
<html>

<head>
    <meta charset="utf-8">
    <title>PcmStore</title>
    <script src="js/lib/angular.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/lib/jquery-3.3.1.min.js"></script>
    <script src="js/lib/bootstrap.min.js" type="text/javascript"></script>

</head>

<body>
        <?php
          /*  include 'mainbartest.php';
            $role=$_SESSION["role"];
            $allowquery="SELECT rule FROM `rolesetting` WHERE rolesetting.rolename = '$role'";
            $allowqueryresult=mysqli_query($con,$allowquery);
            $allowruleraw=$allowqueryresult->fetch_array(MYSQLI_ASSOC);
            $allowrule = explode(",",$allowruleraw["rule"]);
            if (!in_array("10", $allowrule)){
                header("Location: auth.php");
            }*/
        ?>


<div class="container">

    <table>
        <thead>
            <tr>
                <th>วัน/เวลา</th>
                <th>ใบสั่งซื้อ</th>
                <th>เลขลอต</th>
                <th>เลขที่ใบเสร็จ</th>
                <th>วันหมดอายุ</th>
                <th>ราคาขาย</th>
                <th>ต้นทุน</th>
                <th>จำนวน</th>
                <th>ยอดคงเหลือ</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

</div>








</body>








</html>

