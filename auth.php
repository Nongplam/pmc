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
    $roletemp=$_SESSION["role"];
    
    $roledescquery = "SELECT rolesetting.rolethai FROM rolesetting WHERE rolesetting.rolename = '$roletemp'";
    $resultroledesc = mysqli_query($con,$roledescquery);     
    $rows = $resultroledesc->fetch_array(MYSQLI_ASSOC);    
    $_SESSION["roledesc"] = $rows['rolethai']; 
    
    $subbranchidquery = "SELECT subbranchid FROM `user` WHERE `username` LIKE '{$username}' AND `password` LIKE '{$password}'";
    $resultsubbranchid = mysqli_query($con,$subbranchidquery);     
    $rows = $resultsubbranchid->fetch_array(MYSQLI_ASSOC);    
    $_SESSION["subbranchid"] = $rows['subbranchid']; 
    $subbid = $_SESSION["subbranchid"];
    $subbranchnamequery = "SELECT name FROM `subbranch` WHERE `id` LIKE '{$_SESSION["subbranchid"]}'";
    $resultsubbranchname = mysqli_query($con,$subbranchnamequery);     
    $rows = $resultsubbranchname->fetch_array(MYSQLI_ASSOC);    
    $_SESSION["subbranchname"] = $rows['name']; 
    
    $subbranchmidquery = "SELECT mid FROM `subbranch` WHERE `id` LIKE '{$_SESSION["subbranchid"]}'";
    $resultsubbranchmid = mysqli_query($con,$subbranchmidquery);     
    $rows = $resultsubbranchmid->fetch_array(MYSQLI_ASSOC);    
    $_SESSION["masterbranchid"] = $rows['mid']; 
    $masterbranchtemp = $_SESSION["masterbranchid"];
    
    $logopathquery = "SELECT masterbranch.logopath FROM masterbranch WHERE masterbranch.id = '$masterbranchtemp'";
    $resultlogopath = mysqli_query($con,$logopathquery);     
    $rows = $resultlogopath->fetch_array(MYSQLI_ASSOC);
    $_SESSION["logourl"] = $rows['logopath']; 
    
    $branchtypequery="SELECT subbranch.branchtype FROM subbranch WHERE subbranch.id = '$subbid';";
    $branchtyperesult = mysqli_query($con, $branchtypequery);
    $branchtyperows = mysqli_fetch_assoc($branchtyperesult);
    $_SESSION["branchtype"] = $branchtyperows['branchtype'];
    
    
        
}
if(!empty($_SESSION["role"])){
    $role=$_SESSION["role"];
    $rulequery="SELECT rolesetting.rule FROM rolesetting WHERE rolesetting.rolename = '$role';";
    $ruleresult=mysqli_query($con,$rulequery);
    $rows = $ruleresult->fetch_array(MYSQLI_ASSOC);    
    $firstrule = explode(",",$rows['rule']);
    
    
    $firstfilequery="SELECT privilege.file FROM privilege WHERE privilege.id = '$firstrule[0]'";
    $firstfileresult=mysqli_query($con,$firstfilequery);
    $rows = $firstfileresult->fetch_array(MYSQLI_ASSOC);
    $firstfile = $rows['file']; 
    
    
    if(!empty($firstfile)){
        header("Location: $firstfile");             
    }else{
        header("Location: logout.php");
    }
}else{
    header("Location: logout.php");
}




//include 'mainbartest.php';
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
