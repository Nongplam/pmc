<?php
//delete when debug complete!!!!!
//session_start();
//print_r($_SESSION);
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>จัดการสาขา</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="js/lib/angular.min.js"></script>
        <script src="js/lib/jquery-3.3.1.min.js"></script>
        <script src="js/lib/popper.min.js"></script>
        <script src="js/lib/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            .form-row {
                margin-bottom: 17px;
            }

        </style>
    </head>

    <body>
        <?php 
    include 'mainbartest.php';
    $role=$_SESSION["role"];
    $allowquery="SELECT rule FROM `rolesetting` WHERE rolesetting.rolename = '$role'";
    $allowqueryresult=mysqli_query($con,$allowquery);
    $allowruleraw=$allowqueryresult->fetch_array(MYSQLI_ASSOC);    
    $allowrule = explode(",",$allowruleraw["rule"]);
        if (!in_array("1", $allowrule)){
            header("Location: auth.php");
        }
     ?>
        <div class="container" ng-app="subbranchmanagerApp" ng-controller="subbranchsCtrl">
            <!--<nav class="navbar navbar-dark navbar-expand-md bg-primary">
                <div class="container-fluid"><a href="#" class="navbar-brand">จัดการสาขา</a><button data-toggle="collapse" data-target="#navcol-1" class="navbar-toggler"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navcol-1">
                        <ul class="nav navbar-nav">
                            <li role="presentation" class="nav-item"><a href="#" class="nav-link active">First Item</a></li>
                            <li role="presentation" class="nav-item"><a href="#" class="nav-link">Second Item</a></li>
                            <li role="presentation" class="nav-item"><a href="#" class="nav-link">Third Item</a></li>
                        </ul>

                        <span class="ml-auto navbar-text" style="color:rgb(248,249,250);">ยินดีต้อนรับ <?php echo $_SESSION["roledesc"]; echo " "; echo $_SESSION["fname"]; echo " "; echo $_SESSION["lname"];?></span>
                        <a href="http://localhost/pmc/logout.php"><button class="btn btn-light ml-auto" type="button" style="color:rgb(0,123,255);">Logout</button></a></div>
                </div>
            </nav>-->
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center" style="margin-bottom: 20px;">
                        <div class="col-auto">
                            <h4>ค้นหาสาขา :</h4>
                        </div>
                        <div class="col">
                            <input class="form-control" id="mysubbranchInput" type="text" ng-model="subbranchsearchInput" placeholder="Search..">
                        </div>
                        <div class="col"><button class="btn btn-primary" type="button" id="addsubbranch">เพิ่มสาขา</button></div>
                    </div>
                    <div class="row"><label>รายชื่อสาขา</label>
                        <div class="table-responsive" ng-init="getallSubbranch()">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>รหัสสาขา</th>
                                        <th>ชื่อสาขา</th>
                                        <th>ข้อมูลสาขา</th>
                                        <th>โทรศัพท์</th>
                                        <th style="width:66px;">แก้ไข</th>
                                        <th style="width:66px;">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="x in subbranchs | filter:subbranchsearchInput">
                                        <td>{{x.id}}</td>
                                        <td>{{x.name}}</td>
                                        <td>{{x.info}}</td>
                                        <td>{{x.tel}}</td>
                                        <td><button class="editsubbranchbtn btn btn-info" id="editsubbranchbtn" ng-click="seteditsubbranchvalue(x.id,x.name,x.tel,x.info)" data-target="#editsubbranchmodal" data-toggle="modal">Edit</button></td>
                                        <td><button class="btn btn-danger" ng-click="deleteSubbranch(x.id)" type="button">ลบสาขา</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--...................................addsubbranchmodalstart...........................-->
            <div role="dialog" tabindex="-1" class="modal fade" id="addnewsubbranchmodal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#4395e1;">
                            <h4 class="modal-title" style="color:rgb(255,255,255);">เพิ่มสาขา</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                        <div class="modal-body">
                            <form id="formnewsubbranch">
                                <div class="form-row newsubbranchrowbuffer">
                                    <div class="col"><label class="col-form-label">ชื่อสาขา :</label></div>
                                    <div class="col"><input type="text" class="form-control" ng-model="newsubbranchname" style="width:auto;" id="newsubbranchfname" />
                                    </div>
                                </div>
                                <div class="form-row newsubbranchrowbuffer">
                                    <div class="col"><label class="col-form-label">เบอร์โทรศัพท์ :</label></div>
                                    <div class="col"><input type="text" class="form-control" ng-model="newsubbranchtel" maxlength="10" style="width:auto;" id="newsubbranchlname" /></div>
                                </div>
                                <div class="form-row newsubbranchrowbuffer">
                                    <div class="col"><label class="col-form-label">ข้อมูลสาขา :</label></div>
                                    <div class="col"><textarea type="text" class="form-control" ng-model="newsubbranchinfo" style="width:345px;" id="newsubbranchinfo">ข้อมูลสาขา</textarea></div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" type="button" data-dismiss="modal">ปิด</button>
                            <button class="btn btn-primary" type="submit" id="submitnewsubbranch" data-dismiss="modal" form="formnewsubbranch" ng-click="submitnewSubbranch()">เพิ่มสาขา</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--......................................endmodal...................................-->
            <!--...................................editsubbranchmodalstart...........................-->
            <div role="dialog" tabindex="-1" class="modal fade" id="editsubbranchmodal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#4395e1;">
                            <h4 class="modal-title" style="color:rgb(255,255,255);">แก้ไขข้อมูลสาขา</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                        <div class="modal-body">
                            <form id="formeditsubbranch">
                                <div class="form-row newsubbranchrowbuffer">
                                    <div class="col"><label class="col-form-label">ชื่อสาขา :</label></div>
                                    <div class="col"><input type="text" class="form-control" ng-model="editsubbranchname" style="width:auto;" id="editsubbranchfname" />
                                        <input type="hidden" class="form-control" ng-model="editsubbranchid" style="width:auto;" id="editsubbranchid" />
                                    </div>
                                </div>
                                <div class="form-row newsubbranchrowbuffer">
                                    <div class="col"><label class="col-form-label">เบอร์โทรศัพท์ :</label></div>
                                    <div class="col"><input type="text" class="form-control" ng-model="editsubbranchtel" maxlength="10" style="width:auto;" id="editsubbranchlname" /></div>
                                </div>
                                <div class="form-row newsubbranchrowbuffer">
                                    <div class="col"><label class="col-form-label">ข้อมูลสาขา :</label></div>
                                    <div class="col"><textarea type="text" class="form-control" ng-model="editsubbranchinfo" style="width:345px;" id="editsubbranchinfo">ข้อมูลสาขา</textarea></div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" type="button" data-dismiss="modal">ปิด</button>
                            <button class="btn btn-primary" type="submit" id="submiteditSubbranch" data-dismiss="modal" form="formeditsubbranch" ng-click="submiteditSubbranch()">แก้ไขสาขา</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--......................................endmodal...................................-->
        </div>
        <script>
            var app = angular.module('subbranchmanagerApp', []);
            app.controller('subbranchsCtrl', function($scope, $http) {

                $scope.subbranchsearchInput = '';

                $scope.getallSubbranch = function() {
                    $http.get("php/getallSubbranch.php").then(function(response) {
                        $scope.subbranchs = response.data.records;
                    });
                }
                $scope.submitnewSubbranch = function() {
                    $http.post("php/insertnewSubbranch.php", {
                        'name': $scope.newsubbranchname,
                        'tel': $scope.newsubbranchtel,
                        'info': $scope.newsubbranchinfo
                    }).then(function(data) {
                        $scope.newsubbranchname = null;
                        $scope.newsubbranchtel = null;
                        $scope.newsubbranchinfo = null;
                        $scope.getallSubbranch();
                        //location.reload();
                    });
                }
                $scope.seteditsubbranchvalue = function(id, name, tel, info) {
                    $scope.editsubbranchid = id;
                    $scope.editsubbranchname = name;
                    $scope.editsubbranchtel = tel;
                    $scope.editsubbranchinfo = info;
                }
                $scope.submiteditSubbranch = function() {
                    $http.post("php/updateSubbranch.php", {
                        'id': $scope.editsubbranchid,
                        'name': $scope.editsubbranchname,
                        'tel': $scope.editsubbranchtel,
                        'info': $scope.editsubbranchinfo

                    }).then(function(data) {
                        $scope.editsubbranchid = null;
                        $scope.editsubbranchname = null;
                        $scope.editsubbranchtel = null;
                        $scope.editsubbranchinfo = null;
                        //$scope.getallSubbranch();
                        location.reload();
                    });
                }
                $scope.deleteSubbranch = function(subbranchid) {
                    swal({
                            title: "คุณแน่ใจหรือไม่",
                            text: "ยืนยันการลบข้อมูล",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((data) => {
                            if (data) {
                                $http.post("php/deleteSubbranch.php", {
                                    'id': subbranchid
                                }).then(function(data) {
                                    swal("ลบข้อมูลเสร็จสิ้น", "ข้อมูลของคุณถูกลบ", "success");
                                    $scope.getallSubbranch();
                                });
                            } else {
                                swal("ยกเลิกการลบข้อมูลสำเร็จ");
                            }
                        });
                }
            })

        </script>
        <script>
            $(document).ready(function() {
                $("#addsubbranch").click(function() {
                    $("#addnewsubbranchmodal").modal("show");
                })
            })

        </script>
        <!--<script>
            $(document).ready(function() {
                $(".editsubbranchbtn").ready(function() {
                    $(".editsubbranchbtn").click(function() {
                        console.log("Work");
                        $("#editsubbranchmodal").modal("show");
                    });
                });

            });

        </script>-->
    </body>

    <script src="dist/sweetalert.min.js"></script>


    </html>
