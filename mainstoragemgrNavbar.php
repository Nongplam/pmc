<?php
    if(isset($_GET['menu'])){
        if($_GET['menu'] == 'stockmanager'){
        $stockstats = "active";
    $brandstats = "";
            $companystats = "";
    $productstats = "";
    }else if($_GET['menu'] == 'brandmanager'){
        $stockstats = "";
    $brandstats = "active";
            $companystats = "";
    $productstats = "";
    }else if($_GET['menu'] == 'companymanager'){
        $stockstats = "";
    $brandstats = "";
            $companystats = "active";
    $productstats = "";
    }else if($_GET['menu'] == 'productmanager'){
        $stockstats = "";
    $brandstats = "";
            $companystats = "";
    $productstats = "active";
    }else{
        $stockstats = "active";
    $brandstats = "";
            $companystats = "";
    $productstats = "";
    }
    }else{
        $stockstats = "active";
    $brandstats = "";
        $companystats = "";
    $productstats = "";
    }
    
?>


    <nav class="navbar navbar-dark navbar-expand-md bg-primary rounded-bottom">
        <div class="container-fluid"><a href="auth.php" class="navbar-brand">Storagemanager Menu</a><button data-toggle="collapse" data-target="#navcol-1" class="navbar-toggler"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                    <li role="presentation" class="nav-item"><a href="?menu=stockmanager" class="nav-link <?php echo $stockstats; ?>">จัดการคลัง</a></li>
                    <li role="presentation" class="nav-item"><a href="?menu=brandmanager" class="nav-link <?php echo $brandstats; ?>">จัดการข้อมูลแบรนด์</a></li>
                    <li role="presentation" class="nav-item"><a href="?menu=companymanager" class="nav-link <?php echo $companystats; ?>">จัดการข้อมูลบริษัท</a></li>
                    <li role="presentation" class="nav-item"><a href="?menu=productmanager" class="nav-link <?php echo $productstats; ?>">จัดการข้อมูลยา</a></li>
                </ul>

                <span class="ml-auto navbar-text" style="color:rgb(248,249,250);">ยินดีต้อนรับ <?php echo $_SESSION["roledesc"]; echo "<br>"; echo $_SESSION["subbranchname"]; echo "<br>"; echo $_SESSION["fname"]; echo " "; echo $_SESSION["lname"];?></span>
                <a href="logout.php"><button class="btn btn-light ml-auto" type="button" style="color:rgb(0,123,255);">Logout</button></a></div>
        </div>
    </nav>
