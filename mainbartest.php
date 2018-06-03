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


    <head>
        <!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="js/lib/popper.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/lib/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/lib/jquery-3.3.1.min.js"></script>-->

    </head>

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
                </ul>

                <span class="ml-auto navbar-text" style="color:rgb(248,249,250);">ยินดีต้อนรับ <?php echo $_SESSION["roledesc"]; echo " "; echo $_SESSION["fname"]; echo " "; echo $_SESSION["lname"];?></span>
                <a href="logout.php"><button class="btn btn-light ml-auto" type="button" style="color:rgb(0,123,255);">Logout</button></a></div>
        </div>
    </nav>
    <br>
    <!--<button type="button" class="btn btn-danger" id="testbtn">Test BTN</button>-->

    <?php         
        /*if(isset($_POST['pagenumber'])){            
            $pagenumber=$_POST['pagenumber'];
            $getpagequery="select file from privilege where privilege.id = '$pagenumber'";
            $getpageresult=mysqli_query($con,$getpagequery);
            $getpage=$getpageresult->fetch_array(MYSQLI_ASSOC);            
            include $getpage['file'];            
        }*/
    ?>

    <!--<div id="insertpagehere" class="container">
        <form action="mainbartest.php" method="post" id="pageform">
            <input type="hidden" name="pagenumber" id="pagenumber">

        </form>
    </div>-->
    <!--<script>
        $(document).ready(function() {
            $(".nav-item").click(function() {
                console.log(this.value);
                $("#pagenumber").val(this.value);
                $("#pageform").submit();
            });
        });

    </script>-->
    <!--<script>
        $(document).ready(function() {
            $("#testbtn").click(function() {
                var i = 0;
                var arrtemp = [];
                $("li.nav-item").each(function() {
                    arrtemp.push(this.value);
                });
                $("#pagenumber").val(arrtemp[0]);
                $("#pageform").submit();
            });
        });
    </script>-->
    <!--<script>
        $(document).ready(function() {
            $("#li.nav-item").ready(function() {
                var checker = "<?php if(isset($_POST['pagenumber'])){ echo $_POST['pagenumber']; }  ?>";
                if (checker == "") {
                    var i = 0;
                    var arrtemp = [];
                    $("li.nav-item").each(function() {
                        arrtemp.push(this.value);
                    });
                    $("#pagenumber").val(arrtemp[0]);
                    $("#pageform").submit();
                }
            });
        });

    </script>-->
