<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'php/connectDB.php';
    $role=$_SESSION["role"];
    $allowquery="SELECT rule FROM `rolesetting` WHERE rolesetting.rolename = '$role'";
    $allowqueryresult=mysqli_query($con,$allowquery);
    $allowruleraw=$allowqueryresult->fetch_array(MYSQLI_ASSOC);    
    $allowrule = explode(",",$allowruleraw["rule"]);  
//echo $role;
?>




    <nav class="navbar navbar-dark navbar-expand-md bg-primary rounded-bottom">
        <div class="container-fluid">
            <a href="auth.php" class="navbar-brand"><!--
                <?php echo strtoupper( $_SESSION["role"]); ?> Menu--><img src="img/icon/druglogo.png" height="35" /></a><button data-toggle="collapse" data-target="#navcol-1" class="navbar-toggler"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                    <?php 
                    $menuarr = array();
                    foreach ($allowrule as $value) {
                            $rulequery="select * from privilege where privilege.id = '$value'";
                            $ruleresult=mysqli_query($con,$rulequery);
                            $ruledetail=$ruleresult->fetch_array(MYSQLI_ASSOC);
                            if($ruledetail['inmenu'] != null){
                            array_push($menuarr,$ruledetail['inmenu']);
                            }                            
                        }
                    $menuarr = array_unique($menuarr);
                    foreach($menuarr as $menuid){
                        echo "<div class='dropdown'>";
                        echo "<button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
                        $menunamequery="SELECT menutype.menuname FROM menutype WHERE menutype.menuid = $menuid";
                        $menunameresult = mysqli_query($con, $menunamequery);
                        $menunamerows = mysqli_fetch_assoc($menunameresult);
                        $menuname = $menunamerows['menuname'];
                        echo $menuname;    
                        echo "</button>";
                        echo "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>";
                        $minimenuquery="SELECT * FROM privilege WHERE privilege.inmenu = '$menuid' AND LOCATE(privilege.id,(SELECT rolesetting.rule FROM rolesetting WHERE rolesetting.rolename = '$role')) > 0";
                        $minimenuresult=mysqli_query($con,$minimenuquery);
                        while ($rows = $minimenuresult->fetch_array(MYSQLI_ASSOC)){                            
                            //array_push($product,$rows['bname']);
                            echo "<a class='dropdown-item' href='";
                            echo $rows['file'];
                            echo "'>";
                            echo $rows['rulethai'];
                            echo "</a>";
                        }
                        echo "</div>";
                        echo "</div>";
                        
                    }
                        foreach ($allowrule as $value) {
                            $rulequery="select * from privilege where privilege.id = '$value'";
                            $ruleresult=mysqli_query($con,$rulequery);
                            $ruledetail=$ruleresult->fetch_array(MYSQLI_ASSOC);                            
                            if($ruledetail['inmenu'] == null){
                                echo '<li role="presentation" class="nav-item" value="';
                            echo $value;
                            echo '"><a href="';
                            echo $ruledetail['file'];
                            echo '" id="menuitem" class="nav-link text-light" value="';                            
                            echo $value;
                            echo '">';
                            //echo "<button class='btn btn-primary'>";
                            echo $ruledetail['rulethai'];  
                            //echo "</button>";
                            echo '</a></li>';
                            }                            
                        }
                    ?>

                </ul>

                <span class="ml-auto mr-sm-2" style="color:rgb(248,249,250);"><?php echo $_SESSION["roledesc"]; echo "<br>"; echo $_SESSION["fname"]; echo " "; echo $_SESSION["lname"];?></span>
                <div class="">
                    <button class="btn btn-light mr-sm-2 text-primary" data-toggle="modal" data-target="#notiModal">แจ้งเตือน | Todo
                        <span class="badge badge-warning" id="notinumber"></span>
                    </button>
                    <div id='notidropdown'>
                    </div>

                </div>
                <a href="logout.php"><button class="btn btn-light ml-auto" type="button" style="color:rgb(0,123,255);">Logout</button></a>


            </div>
        </div>
    </nav>
    <br>

    <!-- Modal -->
    <div class="modal fade" id="notiModal" tabindex="-1" role="dialog" aria-labelledby="notiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-light" id="notiModalLabel">รายการแจ้งเตือน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                </div>
                <div class="modal-body">
                    <div id="notitable" class="container">

                    </div>
                    <div class="container">
                        <hr>
                    </div>
                    <div id="todohere">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $("#notidropdown").ready(function() {
                $.get("php/getNoti.php", function(data) {
                    $("#notitable").html(data);
                    $.get("php/todolist.php", function(data) {
                        $("#todohere").html(data);
                    });
                    /*setTimeout(function() {
                        var notiCount = 0;
                        var noticounter = 0;
                        notiCount = $('.notirow').length;
                        var arrlength = $('.todorows').length;
                        for (var j = 0; j < arrlength; j++) {
                            if ($('.todorows')[j].lastChild.children["0"].value.split(",")[0] == '1') {
                                noticounter = noticounter + 1;
                            }
                        }
                        noticounter = noticounter + notiCount;
                        $("#notinumber").text(noticounter);
                    }, 400);*/
                });
            });

        });

    </script>
