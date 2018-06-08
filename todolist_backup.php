<html>

<head>
    <meta charset="utf-8">
    <title>Todolist</title>
    <script src="js/lib/angular.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/lib/jquery-3.3.1.min.js"></script>
    <script src="js/lib/bootstrap.min.js" type="text/javascript"></script>
    <!--<style>
        .modal-lg {
            max-width: 70%;
        }

    </style>-->

</head>

<body>
    <div class="container" id="todolist">
        <h3>Todolist</h3>
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr class="text-dark">
                    <th>ประเภท</th>
                    <th>หัวข้อ</th>
                    <th>รายละอียด</th>
                    <th>ผู้ส่ง</th>
                    <th>วันที่ส่ง</th>
                    <th>สถานะ</th>
                </tr>
            </thead>
            <tbody id="todotablebody">
            </tbody>
        </table>

    </div>
</body>
<script>
    $(document).ready(function() {
        $("#todolist").ready(function() {
            $.get("php/gettodolist.php", function(data) {
                var todos = jQuery.parseJSON(data);
                //console.log(todos.records);
                if (todos.records.length >= 1) {
                    for (var i = 0; i < todos.records.length; i++) {
                        var tdata = '<tr><td>' + todos.records[i]['type'] + '</td><td>' +
                            todos.records[i]['title'] + '</td><td>';

                        if (todos.records[i]['status'] != '1') {
                            tdata = tdata + '<a href="' + todos.records[i]['url'] + '">' + todos.records[i]['detail'].strike() + '</a></td><td>' +
                                todos.records[i]['fname'] + ' ' + todos.records[i]['lname'] + '</td><td>' +
                                todos.records[i]['createdate'] + '</td><td>';

                        } else {
                            tdata = tdata + '<a href="' + todos.records[i]['url'] + '">' + todos.records[i]['detail'] + '</td><td>' +
                                todos.records[i]['fname'] + ' ' + todos.records[i]['lname'] + '</a></td><td>' +
                                todos.records[i]['createdate'] + '</td><td>';
                        }


                        if (todos.records[i]['status'] == '1') {
                            tdata = tdata + '<input type="checkbox" class="checkintable" value="' + todos.records[i]['status'] + ',' + todos.records[i]['id'] + '">' + '</td></tr>';
                        } else {
                            tdata = tdata + '<input type="checkbox" class="checkintable" value="' + todos.records[i]['status'] + ',' + todos.records[i]['id'] + '" checked>' + '</td></tr>';
                        }
                        $("#todotablebody").append(tdata);
                    }
                } else {
                    var tdata = '<tr><td>' + 'ว่าง' + '</td><td>' +
                        'ว่าง' + '</td><td>' +
                        'ว่าง' + '</td><td>' +
                        'ว่าง' + ' ' + 'ว่าง' + '</td><td>' +
                        'ว่าง' + '</td><td>' +
                        'ว่าง' + '</td></tr>';
                    $("#todotablebody").append(tdata);
                }

                $(".checkintable").click(function() {
                    //console.log(this.value);
                    //console.log(this);
                    var res = this.value.split(",");
                    if (res[0] == '1') {
                        var status = '2';
                        $.post("php/updatetodoliststatus.php", {
                            status: status,
                            todoid: res[1]
                        }, function(result) {
                            $("#todotablebody").html('');
                            //alert($(location).attr('pathname'));
                            $.triggerReady();
                        });
                    } else {
                        var status = '1';
                        $.post("php/updatetodoliststatus.php", {
                            status: status,
                            todoid: res[1]
                        }, function(result) {
                            $("#todotablebody").html('');
                            //alert($(location).attr('pathname'));
                            $.triggerReady();
                        });
                    }
                });


            });
        });


    });

    // Overrides jQuery-ready and makes it triggerable with $.triggerReady
    // This script needs to be included before other scripts using the jQuery-ready.
    // Tested with jQuery 1.10.1
    (function() {
        var readyList = [];

        // Store a reference to the original ready method.
        var originalReadyMethod = jQuery.fn.ready;

        // Override jQuery.fn.ready
        jQuery.fn.ready = function() {
            if (arguments.length && arguments.length > 0 && typeof arguments[0] === 'function') {
                readyList.push(arguments[0]);
            }

            // Execute the original method.
            originalReadyMethod.apply(this, arguments);
        };

        // Used to trigger all ready events
        $.triggerReady = function() {
            $(readyList).each(function() {
                this();
            });
        };
    })();

</script>

</html>
