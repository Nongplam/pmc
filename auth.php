<?php
header('Content-Type: text/html; charset=utf-8');
include 'php/connectDB.php';
session_start();

if(isset($_POST['username'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $idquery = "SELECT id FROM `user` WHERE `username` LIKE '{$username}' AND `password` LIKE '{$password}'";
    $resultid = mysqli_query($con,$idquery);     
    $rows = $resultid->fetch_array(MYSQLI_ASSOC);    
    $_SESSION["id"] = $rows['id'];
    
    $fnamequery = "SELECT fname FROM `user` WHERE `username` LIKE '{$username}' AND `password` LIKE '{$password}'";
    $resultfname = mysqli_query($con,$fnamequery);     
    $rows = $resultfname->fetch_array(MYSQLI_ASSOC);    
    $_SESSION["fname"] = $rows['fname'];
    
    $lnamequery = "SELECT lname FROM `user` WHERE `username` LIKE '{$username}' AND `password` LIKE '{$password}'";
    $resultlname = mysqli_query($con,$lnamequery);     
    $rows = $resultlname->fetch_array(MYSQLI_ASSOC);    
    $_SESSION["lname"] = $rows['lname'];
    
    $rolequery = "SELECT role FROM `user` WHERE `username` LIKE '{$username}' AND `password` LIKE '{$password}'";
    $resultrole = mysqli_query($con,$rolequery);     
    $rows = $resultrole->fetch_array(MYSQLI_ASSOC);    
    $_SESSION["role"] = $rows['role'];
    
    $roledescquery = "SELECT roledesc FROM `user` WHERE `username` LIKE '{$username}' AND `password` LIKE '{$password}'";
    $resultroledesc = mysqli_query($con,$roledescquery);     
    $rows = $resultroledesc->fetch_array(MYSQLI_ASSOC);    
    $_SESSION["roledesc"] = $rows['roledesc']; 
    
    $subbranchidquery = "SELECT subbranchid FROM `user` WHERE `username` LIKE '{$username}' AND `password` LIKE '{$password}'";
    $resultsubbranchid = mysqli_query($con,$subbranchidquery);     
    $rows = $resultsubbranchid->fetch_array(MYSQLI_ASSOC);    
    $_SESSION["subbranchid"] = $rows['subbranchid']; 
    
    $subbranchnamequery = "SELECT name FROM `subbranch` WHERE `id` LIKE '{$_SESSION["subbranchid"]}'";
    $resultsubbranchname = mysqli_query($con,$subbranchnamequery);     
    $rows = $resultsubbranchname->fetch_array(MYSQLI_ASSOC);    
    $_SESSION["subbranchname"] = $rows['name']; 
    
    $subbranchmidquery = "SELECT mid FROM `subbranch` WHERE `id` LIKE '{$_SESSION["subbranchid"]}'";
    $resultsubbranchmid = mysqli_query($con,$subbranchmidquery);     
    $rows = $resultsubbranchmid->fetch_array(MYSQLI_ASSOC);    
    $_SESSION["masterbranchid"] = $rows['mid'];
}
include 'mainbar.php';
//------------------------------------------------------------------------------
/*if($_SESSION["id"] != null){
    if($_SESSION["role"] == 'admin'){
        echo '<div class="container">';
        include 'adminNavbar.php';
        echo "</div>";
        if(!isset($_GET['menu'])){
            include 'usermanager.php';
        } else if ($_GET['menu'] == 'usermanager'){
            include 'usermanager.php';
        } else if($_GET['menu'] == 'branchmanager'){
            include 'branchmanager.php';
        }
        
        
    } else if($_SESSION["role"] == 'mainstoragemanager'){
        echo '<div class="container">';
        include 'mainstoragemgrNavbar.php';
        echo "</div>";
        
        if(!isset($_GET['menu'])){
            include 'stock.php';
        } else if ($_GET['menu'] == 'stockmanager'){
            include 'stock.php';
        } else if ($_GET['menu'] == 'brandmanager'){
            include 'brand.php';
        } else if($_GET['menu'] == 'companymanager'){
            include 'company.php';
        } else if($_GET['menu'] == 'productmanager'){
            include 'product.php';
        }
        
    } else if($_SESSION["role"] == 'cashier'){
        include 'pos.php';
    } else if($_SESSION["role"] == 'branchmgr'){
        print_r($_SESSION);
    } else if($_SESSION["role"] == 'branchstockmanager'){
        //print_r($_SESSION);
        echo '<div class="container">';
        include 'stockmgrNavbar.php';
        echo "</div>";
        if(!isset($_GET['menu'])){
            include 'stocktoshelf.php';
        }else if ($_GET['menu'] == 'stocktoshelf'){
            include 'stocktoshelf.php';
        }
        
    }
        
    }*/
//------------------------------------------------------------------------------

//include 'productmanager.php';
?>
