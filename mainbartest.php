<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'php/connectDB.php';
    $role=$_SESSION["role"];
    $allowquery="SELECT rule FROM `rolesetting` WHERE rolesetting.rolename = '$role'";
    $allowqueryresult=mysqli_query($con,$allowquery);
    $allowruleraw=$allowqueryresult->fetch_array(MYSQLI_ASSOC);    
    $allowrule = explode(",",$allowruleraw["rule"]);  
?>


    <nav class="navbar navbar-dark navbar-expand-md bg-primary rounded-bottom">
        <div class="container-fluid">
            <a href="auth.php" class="navbar-brand">
                <?php echo strtoupper( $_SESSION["role"]); ?> Menu</a><button data-toggle="collapse" data-target="#navcol-1" class="navbar-toggler"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                    <?php 
                        foreach ($allowrule as $value) {
                            $rulequery="select * from privilege where privilege.id = '$value'";
                            $ruleresult=mysqli_query($con,$rulequery);
                            $ruledetail=$ruleresult->fetch_array(MYSQLI_ASSOC);                            
                            echo '<li role="presentation" class="nav-item" value="';
                            echo $value;
                            echo '"><a href="';
                            echo $ruledetail['file'];
                            echo '" id="menuitem" class="nav-link" value="';                            
                            echo $value;
                            echo '">';
                            echo $ruledetail['rulethai'];                            
                            echo '</a></li>';
                        }
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link">
                    แจ้งเตือน
                </a>

                    </li>
                </ul>


                <span class="ml-auto navbar-text" style="color:rgb(248,249,250);">ยินดีต้อนรับ <?php echo $_SESSION["roledesc"]; echo " "; echo $_SESSION["fname"]; echo " "; echo $_SESSION["lname"];?></span>
                <a href="logout.php"><button class="btn btn-light ml-auto" type="button" style="color:rgb(0,123,255);">Logout</button></a></div>
        </div>
    </nav>
    <br>
