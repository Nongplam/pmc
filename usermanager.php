<?php
//delete when debug complete!!!!!
//session_start();
//print_r($_SESSION);
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>จัดการผู้ใช้</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="js/lib/angular.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/lib/jquery-3.3.1.min.js"></script>
        <script src="js/lib/popper.min.js"></script>
        <script src="js/lib/bootstrap.min.js"></script>
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
        if (!in_array("7", $allowrule)){
            header("Location: auth.php");
        }
     ?>
        <div class="container" ng-app="usermanagerApp" ng-controller="usersCtrl">
            <!--<nav class="navbar navbar-dark navbar-expand-md bg-primary">
                <div class="container-fluid"><a href="#" class="navbar-brand">จัดการผู้ใช้</a><button data-toggle="collapse" data-target="#navcol-1" class="navbar-toggler"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
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
                            <h4>ค้นหาผู้ใช้ :</h4>
                        </div>
                        <div class="col">
                            <input class="form-control" id="myuserInput" type="text" ng-model="usersearchInput" placeholder="Search..">
                        </div>
                        <div class="col"><button class="btn btn-primary" type="button" id="adduser">เพิ่มผู้ใช้งาน</button></div>
                    </div>
                    <div class="row"><label>รายชื่อผู้ใช้</label>
                        <div class="table-responsive" ng-init="getallUser()">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width:80px;">ชื่อ</th>
                                        <th>นามสกุล</th>
                                        <th>หน้าที่</th>
                                        <th>รหัสสาขา</th>
                                        <th>สาขา</th>
                                        <th style="width:66px;">แก้ไข</th>
                                        <th style="width:66px;">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="x in users | filter:usersearchInput">
                                        <td>{{x.fname}}</td>
                                        <td>{{x.lname}}</td>
                                        <td>{{x.roledesc}}</td>
                                        <td>{{x.subbranchid}}</td>
                                        <td>{{x.name}}</td>
                                        <td><button class="edituserbtn btn btn-info" id="edituserbtn" ng-click="setedituservalue(x.id,x.fname,x.lname,x.role,x.roledesc,x.subbranchid,x.username,x.password,x.userinfo)" data-toggle="modal" data-target="#editusermodal">Edit</button></td>
                                        <td><button class="btn btn-danger" ng-click="deleteUser(x.id)" type="button">ลบผู้ใช้</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--...................................addusermodalstart...........................-->
            <div role="dialog" tabindex="-1" class="modal fade" id="addnewusermodal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#4395e1;">
                            <h4 class="modal-title" style="color:rgb(255,255,255);">เพิ่มข้อมูลผู้ใช้งาน</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                        <div class="modal-body" ng-init="getallSubbranch()">
                            <form id="formnewuser">
                                <div class="form-row newuserrowbuffer">
                                    <div class="col"><label class="col-form-label">ชื่อ :</label></div>
                                    <div class="col"><input type="text" class="form-control" ng-model="newfname" style="width:171px;" id="newuserfname" />
                                    </div>
                                    <div class="col"><label class="col-form-label">สกุล :</label></div>
                                    <div class="col"><input type="text" class="form-control" ng-model="newlname" style="width:180px;" id="newuserlname" /></div>
                                </div>
                                <div class="form-row">
                                    <div class="col"><label class="col-form-label">หน้าที่ :</label></div>
                                    <div class="col">
                                        <select class="form-control" ng-model="newrole" ng-change="setnewroleDesc()" style="width:300px;" id="newuserrole">
                                        <option value="admin" selected>ผู้ดูแลระบบ</option>
                                        <option value="mainstoragemanager" >พนักงานสต๊อกสำนักงานใหญ่</option>
                                        <option value="branchstockmanager" >พนักงานสต๊อกสาขาย่อย</option>
                                        <option value="cashier" >พนักงานคิดเงินหน้าร้าน</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-row" ng-show="issubemploy">
                                    <div class="col"><label class="col-form-label">ประจำสาขา :</label></div>
                                    <div class="col">
                                        <select class="form-control" ng-model="newusersubbranch" ng-change="setnewroleDesc()" style="width:300px;" id="newusersubbranch">
                                            <option ng-repeat="y in subbranchs" value="{{y.id}}">{{y.name}}</option>                                        
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row newuserrowbuffer">
                                    <div class="col"><label class="col-form-label">Username :</label></div>
                                    <div class="col"><input type="text" class="form-control" ng-model="newusername" style="width:345px;" id="newuserusername" /></div>
                                </div>
                                <div class="form-row newuserrowbuffer">
                                    <div class="col"><label class="col-form-label">Password :</label></div>
                                    <div class="col"><input type="password" class="form-control" ng-model="newpassword" style="width:345px;" id="newuserpassword" /></div>
                                </div>
                                <div class="form-row newuserrowbuffer">
                                    <div class="col"><label class="col-form-label">user info :</label></div>
                                    <div class="col"><textarea type="text" class="form-control" ng-model="newinfo" style="width:345px;" id="newuserinfo">ข้อมูลผู้ใช้</textarea></div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" type="button" data-dismiss="modal">ปิด</button>
                            <button class="btn btn-primary" type="submit" id="submitnewuser" data-dismiss="modal" form="formnewuser" ng-click="submitnewUser()">เพิ่มผู้ใช้</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--......................................endmodal...................................-->
            <!--...................................editusermodalstart...........................-->
            <div role="dialog" tabindex="-1" class="modal fade" id="editusermodal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#4395e1;">
                            <h4 class="modal-title" style="color:rgb(255,255,255);">แก้ไขข้อมูลผู้ใช้งาน</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                        <div class="modal-body">
                            <form id="formedituser">
                                <div class="form-row edituserrowbuffer">
                                    <div class="col"><label class="col-form-label">ชื่อ :</label></div>
                                    <div class="col"><input type="text" class="form-control" ng-model="editfname" style="width:171px;" id="edituserfname" />
                                        <input type="hidden" class="form-control" ng-model="editid" style="width:171px;" id="edituserid" />
                                    </div>
                                    <div class="col"><label class="col-form-label">สกุล :</label></div>
                                    <div class="col"><input type="text" class="form-control" ng-model="editlname" style="width:180px;" id="edituserlname" /></div>
                                </div>
                                <div class="form-row">
                                    <div class="col"><label class="col-form-label">หน้าที่ :</label></div>
                                    <div class="col">
                                        <select class="form-control" ng-model="editrole" ng-change="seteditroleDesc()" style="width:300px;" id="edituserrole">
                                        <option value="admin">ผู้ดูแลระบบ</option>
                                        <option value="mainstoragemanager">พนักงานสต๊อกสำนักงานใหญ่</option>
                                        <option value="branchstockmanager" >พนักงานสต๊อกสาขาย่อย</option>
                                        <option value="cashier" >พนักงานคิดเงินหน้าร้าน</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-row" ng-show="issubemploy">
                                    <div class="col"><label class="col-form-label">ประจำสาขา :</label></div>
                                    <div class="col">
                                        <select class="form-control" ng-model="editusersubbranch" ng-change="seteditroleDesc()" style="width:300px;" id="editusersubbranch">
                                            <option ng-repeat="y in subbranchs" value="{{y.id}}">{{y.name}}</option>                                        
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row edituserrowbuffer">
                                    <div class="col"><label class="col-form-label">Username :</label></div>
                                    <div class="col"><input type="text" class="form-control" ng-model="editusername" style="width:345px;" id="edituserusername" /></div>
                                </div>
                                <div class="form-row edituserrowbuffer">
                                    <div class="col"><label class="col-form-label">Password :</label></div>
                                    <div class="col"><input type="password" class="form-control" ng-model="editpassword" style="width:345px;" id="edituserpassword" /></div>
                                </div>
                                <div class="form-row edituserrowbuffer">
                                    <div class="col"><label class="col-form-label">user info :</label></div>
                                    <div class="col"><textarea type="text" class="form-control" ng-model="editinfo" style="width:345px;" id="edituserinfo">ข้อมูลผู้ใช้</textarea></div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" type="button" data-dismiss="modal">ปิด</button>
                            <button class="btn btn-primary" type="submit" id="submitedituser" data-dismiss="modal" form="formedituser" ng-click="submiteditUser()">แก้ไขผู้ใช้</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--......................................endmodal...................................-->
        </div>
        <script>
            var app = angular.module('usermanagerApp', []);
            app.controller('usersCtrl', function($scope, $http) {
                $scope.issubemploy = false;
                $scope.newroledesc = 'พนักงานสต๊อกสำนักงานใหญ่';
                $scope.newrole = '';
                $scope.newfname = '';
                $scope.usersearchInput = '';
                $scope.getallUser = function() {
                    $http.get("php/getallUser.php").then(function(response) {
                        $scope.users = response.data.records;

                        angular.forEach($scope.users, function(value, key) {
                            console.log(key + ': ' + value.fname);
                            /*value.fname += "55";
                            console.log(key + ': ' + value.fname);*/

                        });
                    });
                }
                $scope.acctest = function() {
                    forEach($scope.users, function(value, key) {
                        console.log(key + ': ' + value.fname);
                        /*value.fname += "55";
                        console.log(key + ': ' + value.fname);*/

                    });
                }
                $scope.resubEmploy = function() {
                    $scope.issubemploy = false;
                }
                $scope.getallSubbranch = function() {
                    $http.get("php/getallSubbranch.php").then(function(response) {
                        $scope.subbranchs = response.data.records;
                    });
                }
                $scope.getBranchnames = function(id) {
                    var a = "";
                    $.ajax({
                        async: false,
                        url: "php/getBranchname.php?id=" + id,
                        success: function(data) {
                            a = data;
                        }
                    });
                    return a;
                }
                $scope.submitnewUser = function() {
                    $http.post("php/insertnewUser.php", {
                        'fname': $scope.newfname,
                        'lname': $scope.newlname,
                        'role': $scope.newrole,
                        'roledesc': $scope.newroledesc,
                        'subbranch': $scope.newusersubbranch,
                        'username': $scope.newusername,
                        'info': $scope.newinfo,
                        'password': $scope.newpassword
                    }).then(function(data) {
                        $scope.newfname = null;
                        $scope.newlname = null;
                        $scope.newrole = null;
                        $scope.newroledesc = null;
                        $scope.newusername = null;
                        $scope.newpassword = null;
                        $scope.newinfo = null;
                        //$scope.getallUser();
                        location.reload();
                    });
                }
                $scope.setnewroleDesc = function() {
                    var role = $scope.newrole;
                    if (role == 'mainstoragemanager') {
                        $scope.newroledesc = 'พนักงานสต๊อกสำนักงานใหญ่';
                        $scope.issubemploy = false;
                    } else if (role == 'branchstockmanager') {
                        $scope.newroledesc = 'พนักงานสต๊อกสาขาย่อย';
                        $scope.issubemploy = true;
                    } else if (role == 'cashier') {
                        $scope.newroledesc = 'พนักงานคิดเงินหน้าร้าน';
                        $scope.issubemploy = true;
                    } else if (role == 'admin') {
                        $scope.newroledesc = 'ผู้ดูแลระบบ';
                        $scope.issubemploy = false;
                    } else {
                        $scope.newroledesc = 'blank';
                        $scope.issubemploy = false;
                    }
                    //console.log($scope.newroledesc);
                }
                $scope.seteditroleDesc = function() {
                    var role = $scope.editrole;
                    if (role == 'mainstoragemanager') {
                        $scope.editroledesc = 'พนักงานสต๊อกสำนักงานใหญ่';
                        $scope.issubemploy = false;
                    } else if (role == 'branchstockmanager') {
                        $scope.editroledesc = 'พนักงานสต๊อกสาขาย่อย';
                        $scope.issubemploy = true;
                    } else if (role == 'cashier') {
                        $scope.editroledesc = 'พนักงานคิดเงินหน้าร้าน';
                        $scope.issubemploy = true;
                    } else if (role == 'admin') {
                        $scope.editroledesc = 'ผู้ดูแลระบบ';
                        $scope.issubemploy = false;
                    } else {
                        $scope.editroledesc = 'blank';
                        $scope.issubemploy = false;
                    }
                    //console.log($scope.newroledesc);
                }
                $scope.setedituservalue = function(id, fname, lname, role, roledesc, subbranch, username, password, userinfo) {
                    $scope.editid = id;
                    $scope.editfname = fname;
                    $scope.editlname = lname;
                    $scope.editrole = role;
                    $scope.editroledesc = roledesc;
                    $scope.editusersubbranch = subbranch;
                    $scope.editusername = username;
                    $scope.editpassword = password;
                    $scope.editinfo = userinfo;
                    if (role == 'admin' || role == 'mainstoragemanager') {
                        $scope.issubemploy = false;
                    } else {
                        $scope.issubemploy = true;
                    }
                }
                $scope.submiteditUser = function() {
                    $http.post("php/updateUser.php", {
                        'id': $scope.editid,
                        'fname': $scope.editfname,
                        'lname': $scope.editlname,
                        'role': $scope.editrole,
                        'roledesc': $scope.editroledesc,
                        'subbranch': $scope.editusersubbranch,
                        'username': $scope.editusername,
                        'password': $scope.editpassword,
                        'info': $scope.editinfo

                    }).then(function(data) {
                        $scope.editid = null;
                        $scope.editfname = null;
                        $scope.editlname = null;
                        $scope.editrole = null;
                        $scope.editroledesc = null;
                        $scope.editusername = null;
                        $scope.editpassword = null;
                        $scope.editinfo = null;
                        //$scope.getallUser();
                        location.reload();
                    });
                }
                $scope.deleteUser = function(userid) {
                    swal({
                            title: "คุณแน่ใจหรือไม่",
                            text: "ยืนยันการลบข้อมูล",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((data) => {
                            if (data) {
                                $http.post("php/deleteUser.php", {
                                    'id': userid
                                }).then(function(data) {
                                    swal("ลบข้อมูลเสร็จสิ้น", "ข้อมูลของคุณถูกลบ", "success");
                                    location.reload();
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
                $("#adduser").click(function() {
                    $("#addnewusermodal").modal("show");
                })
            })

        </script>
        <script>
            $(document).ready(function() {
                $(".edituserbtn").click(function() {
                    $("#editusermodal").modal("show");
                });
            });

        </script>
    </body>

    <script src="dist/sweetalert.min.js"></script>


    </html>
