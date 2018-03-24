<?php
    if(isset($_GET['menu'])){
        if($_GET['menu'] == 'stocktoshelf'){
        $stockstats = "active";
        $brandstats = "";
        }else if($_GET['menu'] == 'packmanager'){
        $stockstats = "";
        $brandstats = "active";
        }else{
        $stockstats = "active";
        $brandstats = ""; 
        }
        }else{
        $stockstats = "active";
        $brandstats = "";
        }
    
?>


    <nav class="navbar navbar-dark navbar-expand-md bg-primary rounded-bottom">
        <div class="container-fluid"><a href="auth.php" class="navbar-brand">Stockmanager Menu</a><button data-toggle="collapse" data-target="#navcol-1" class="navbar-toggler"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                    <li role="presentation" class="nav-item"><a href="?menu=stocktoshelf" class="nav-link <?php echo $stockstats; ?>">นำสินค้าเข้าชั้นวาง</a></li>
                    <li role="presentation" class="nav-item"><a href="?menu=packmanager" class="nav-link <?php echo $brandstats; ?>">จัดชุดสินค้า</a></li>
                </ul>

                <span class="ml-auto navbar-text" style="color:rgb(248,249,250);">ยินดีต้อนรับ <?php echo $_SESSION["roledesc"]; echo "<br>"; echo $_SESSION["subbranchname"]; echo "<br>"; echo $_SESSION["fname"]; echo " "; echo $_SESSION["lname"];?></span>
                <a href="logout.php"><button class="btn btn-light ml-auto" type="button" style="color:rgb(0,123,255);">Logout</button></a></div>
        </div>
    </nav>
