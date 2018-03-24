<?php
    if(isset($_GET['menu'])){
        if($_GET['menu'] == 'usermanager'){
        $userstats = "active";
    $branchstats = "";
    $productstats = "";
    }else if($_GET['menu'] == 'branchmanager'){
        $userstats = "";
    $branchstats = "active";
    $productstats = "";
    }else{
        $userstats = "active";
    $branchstats = "";
    $productstats = "";
    }
    }else{
        $userstats = "active";
    $branchstats = "";
    $productstats = "";
    }
    
?>


    <nav class="navbar navbar-dark navbar-expand-md bg-primary rounded-bottom">
        <div class="container-fluid"><a href="auth.php" class="navbar-brand">Admin Menu</a><button data-toggle="collapse" data-target="#navcol-1" class="navbar-toggler"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                    <li role="presentation" class="nav-item"><a href="?menu=usermanager" class="nav-link <?php echo $userstats; ?>">จัดการผู้ใช้</a></li>
                    <li role="presentation" class="nav-item"><a href="?menu=branchmanager" class="nav-link <?php echo $branchstats; ?>">จัดการสาขา</a></li>
                </ul>

                <span class="ml-auto navbar-text" style="color:rgb(248,249,250);">ยินดีต้อนรับ <?php echo $_SESSION["roledesc"]; echo " "; echo $_SESSION["fname"]; echo " "; echo $_SESSION["lname"];?></span>
                <a href="logout.php"><button class="btn btn-light ml-auto" type="button" style="color:rgb(0,123,255);">Logout</button></a></div>
        </div>
    </nav>
