<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$sessionidsister = $_SESSION['idsister'];
$sql = "select r.barcode, r.code as rackcode, r.rackname, r.rows, r.col, r.description, lsc.name as sistername, lbranch.branch, lbuilding.description as buildingname, lfloor.floor, lroom.room FROM rack r
inner join location_sister_company lsc on lsc.id = r.idsistercompany 
inner join location_branch lbranch on lbranch.idbranch = r.idbranch
inner join location_building lbuilding on lbuilding.id = r.idbuilding
inner join location_floor lfloor on lfloor.id = r.idfloor
inner join location_room lroom on lroom.id = r.idroom where lsc.id = '".$sessionidsister."'";
$res = $conn->query($sql);

?>

<head>
    <style>

    </style>
</head>
<div class="content-wrapper">
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <h4><span class="font-weight-semibold">Master Rack</span></h4>
            <div class="page-title d-flex">
                <div class="row" style="width:100%;">
                    <div class="col-xl-12">
                        <a href="#myModal" data-toggle="modal"> <button onclick="setbranchonclick()"
                                class="btn btn-info" style="background-color:#26a69a !important;width:120px;"><i
                                    class="icon-add"></i> &nbsp Add Rack</button></a>
                    </div>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <table id="datatable_serverside" class="table table-hover table-bordered display nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Branch</th>
                                <th>Building</th>
                                <th>Floor</th>
                                <th>Rooms</th>
                                <th>Rack Name</th>
                                <th>Description</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
                <h5 class="modal-title">Add Rack</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>
            <div class="modal-body">
                <form id="myform">
                    <div class="form-group">
                        <label for="code">Code</label>
                        <input type="text" class="form-control" id="code">
                        <br>
                        <label for="cars">Sister:</label>
                        <input type="text" class="form-control" id="sister" value="<?= $name ?>" style="color:grey;"
                            readonly>
                        <br>
                        <label for="cars">Branch:</label>
                        <select id="branch" name="branch" class="form-control">
                        </select>
                        <br>
                        <label for="cars">Building:</label>
                        <select id="building" name="building" class="form-control">
                        </select>
                        <br>
                        <label for="cars">Floor:</label>
                        <select id="floor" name="floor" class="form-control">
                        </select>
                        <br>
                        <label for="cars">Rooms:</label>
                        <select id="room" name="room" class="form-control">
                        </select>
                        <br>
                        <label for="cars">Rack Name:</label>
                        <input type="text" class="form-control" id="rackname">
                        <br>
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description">

                        <br>
                        <br>
                        <div style="float:right;margin-bottom:20px;">
                            <button type="button" class="btn btn-primary" style="margin-right:10px;"
                                onclick="adddata()">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                id="canceladd">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="myModaledit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
                <h5 class="modal-title">Edit Rack</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>
            <div class="modal-body">
                <form id="myformedit">
                    <div class="form-group">
                        <input type="hidden" id="idchange">
                        <label for="code">Code</label>
                        <input type="text" class="form-control" id="codeedit" disabled>
                        <br>
                        <label for="cars">Sister:</label>
                        <input type="text" class="form-control" id="sisteredit" value="<?= $name ?>" style="color:grey;"
                            readonly>
                        <br>
                        <label for="cars">Branch:</label>
                        <select id="branchedit" name="branchedit" class="form-control">
                        </select>
                        <br>
                        <label for="cars">Building:</label>
                        <select id="buildingedit" name="buildingedit" class="form-control">
                        </select>
                        <br>
                        <label for="cars">Floor:</label>
                        <select id="flooredit" name="flooredit" class="form-control">
                        </select>
                        <br>
                        <label for="cars">Rooms:</label>
                        <select id="roomedit" name="roomedit" class="form-control">
                        </select>
                        <br>
                        <label for="cars">Rack Name:</label>
                        <input type="text" class="form-control" id="racknameedit">
                        <br>
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="descriptionedit">

                        <br>
                        <br>
                        <div style="float:right;margin-bottom:20px;">
                            <button type="button" class="btn btn-primary" style="margin-right:10px;"
                                onclick="changedata()">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                id="canceledit">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="myModalsubrack">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
                <h5 class="modal-title">Add Sub Rack</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>
            <div class="modal-body">
                <form id="myformsubrack">
                    <div class="form-group">
                        <input type="hidden" id="idrackaddsubrack">
                        <h4><label for="code">Sub Rack Code : </label>

                            <b><label id="codesubrackadd" disabled></label></b>
                        </h4>
                        <label for="cars">Row</label>
                        <input type="text" class="form-control" id="rowsubrackadd"
                            onkeypress="return isNumberKey(event)">
                        <br>
                        <label for="cars">Column</label>
                        <input type="text" class="form-control" id="colomsubrackadd"
                            onkeypress="return isNumberKey(event)">
                        <br>
                        <br>
                        <div style="float:right;margin-bottom:20px;">
                            <button type="button" class="btn btn-primary" style="margin-right:10px;"
                                onclick="addsubrack()">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                id="canceladdsubrack">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Modal -->
</body>

</html>
<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
    $(function () {
        loadData();
        getbranch();
    });
    var globalrackname = "";
    var globalrow = "0";
    var globalcol = "0";
    var dt = "";

    function format(d, idperrow) {
        var rackname = $("#rackname" + idperrow).text();
        //   alert(idperrow);
        // var tableresult = await loaddatapersubrack(idperrow);

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterrack.php",
                method: 'POST',
                data: {
                    tipe: "loadsubrack",
                    myrack: idperrow
                },
                success: function (result) {
                    return result;
                    alert("test");
                    
                }  
            });
        // alert(tableresult);
    
        // alert(tableresult);
        // var title = "<tr><th style = 'line-height:0.35;' >Code</th> <th>Subrack</th><th>Row</th><th>Coloumn</th><th>Status</th></tr>";
        return "<a href='#myModalsubrack' data-toggle='modal' onclick = openmodalsubrack("+ idperrow +") ><span class='pointer-element badge badge-success' data-id='1' style = 'margin-right:10px;float:left;background-color:#26a69a;margin-top:10px;margin-bottom:20px;'><i class='icon-plus3'></i></span></a><h4 style = 'margin-top:10px;margin-bottom:20px;float:left; font-size:12pt;color:#324148;'><span class='font-weight-semibold'>Sub Rack For Rack A</span></h4> <table class = 'w-100' style = 'margin-bottom:20px;'><tr><th style = 'line-height:0.35;' >Code</th><th>Sub Rack Name</th><th>Rows</th><th>Column</th><th>Status</th> </tr> "+""+"</table>";
        // "<tr>"
      
    }

    function openmodalsubrack(idrow) {
        
        $("#idrackaddsubrack").val(idrow);
        var rackname = $("#rackname" + idrow).text();
        globalrackname = rackname;
     
        settexttocode();
    };
    $("#rowsubrackadd").on('keyup', function (e) {

        globalrow = $("#rowsubrackadd").val();
        if (globalrow == "") {
            globalrow = 0;
        }
        settexttocode();
    });
    $("#colomsubrackadd").on('keyup', function (e) {

        globalcol = $("#colomsubrackadd").val();
        if (globalcol == "") {
            globalcol = 0;
        }
        settexttocode();
    });

    function settexttocode() {
        $("#codesubrackadd").text(globalrackname + "-" + globalrow + "-" + globalcol);
    };

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode <= 48 || charCode > 57))
            return false;
        return true;
    };

    function loaddatapersubrack(idrack){
        // alert(idrack);
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterrack.php",
                method: 'POST',
                data: {
                    tipe: "loadsubrack",
                    myrack: idrack
                },
                success: function (result) {
                    return result;
                }  
            });
    };

    function addsubrack() {
  
        var code = $("#codesubrackadd").text();
        var row = $("#rowsubrackadd").val();
        var col = $("#colomsubrackadd").val();
        var idrack = $("#idrackaddsubrack").val();
        if (row == "" || col == "") {
            Swal.fire({
                icon: 'error',
                title: 'Empty Field',
                text: 'Requirement data cannot be empty',
                confirmButtonColor: '#e00d0d',
            });
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterrack.php",
                method: 'POST',
                data: {
                    tipe: "addsubrack",
                    mycode: code,
                    myrack: idrack

                },
                success: function (result) {
                    if (result == "sukses") {
                        success();
                        Swal.fire({
                            title: 'Data Saved',
                            text: 'Data Inputted Successfully',
                            icon: 'success',
                            confirmButtonColor: '#53d408',
                            allowOutsideClick: false,
                        }).then((result) => {
                            $("#codesubrackadd").text(globalrackname + "-0-0");
                            $("#myformsubrack").trigger("reset");
                            $("#canceladdsubrack").click();
                        });
                    } else {
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Exists',
                            text: 'Duplicate Entry For This Sub Rack Row & Column',
                            confirmButtonColor: '#e00d0d',
                        });
                    }
                }
            });
        }

    }

    function loadData() {
        var dt = $("#datatable_serverside").DataTable({
            processing: true,
            deferRender: true,
            serverSide: true,
            destroy: true,
            iDisplayInLength: 10,
            scrollX: true,
            order: [
                [0, 'asc']
            ],
            ajax: {
                url: 'process/masterrack.php',
                method: 'POST',
                data: {
                    tipe: "load"
                }
            },
            columns: [{
                    name: 'expand',
                    className: 'text-center align-middle',
                    class: "details-control",
                },
                {
                    name: 'Code',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Branch',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Building',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Floor',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Rooms',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Rackname',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Description',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Status',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Action',
                    searchable: false,
                    orderable: false,
                    className: 'text-center align-middle'
                }

            ]
        });

        var detailRows = [];

        $('#datatable_serverside tbody').on('click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt.row(tr);
            var idx = $.inArray(tr.attr('id'), detailRows);

            var badge = tr.find('span.badge');
            //  alert(idtest);
            var icon = tr.find('i');
            if (row.child.isShown()) {
                tr.removeClass('details');
                row.child.hide();

                detailRows.splice(idx, 1);

                tr.removeClass('shown');
                badge.first().removeClass('badge-danger');
                badge.first().addClass('badge-success');
                icon.first().removeClass('icon-minus3');
                icon.first().addClass('icon-plus3');
            } else {
                tr.addClass('details');


                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterrack.php",
                method: 'POST',
                data: {
                    tipe: "loadsubrack",
                    myrack: badge[0].id
                },
                success: function (result) {
                    // $("#idrackaddsubrack").val(idrow);
                    var rackname = $("#rackname" + badge[0].id).text();
                    // return "<a href='#myModalsubrack' data-toggle='modal' onclick = openmodalsubrack("+ idperrow +") ><span class='pointer-element badge badge-success' data-id='1' style = 'margin-right:10px;float:left;background-color:#26a69a;margin-top:10px;margin-bottom:20px;'><i class='icon-plus3'></i></span></a><h4 style = 'margin-top:10px;margin-bottom:20px;float:left; font-size:12pt;color:#324148;'><span class='font-weight-semibold'>Sub Rack For Rack A</span></h4> <table class = 'w-100' style = 'margin-bottom:20px;'><tr><th style = 'line-height:0.35;' >Code</th><th>Sub Rack Name</th><th>Rows</th><th>Column</th><th>Status</th> </tr></table>";
                    row.child("<a href='#myModalsubrack' data-toggle='modal' onclick = openmodalsubrack("+ badge[0].id +") ><span class='pointer-element badge badge-success' data-id='1' style = 'margin-right:10px;float:left;background-color:#26a69a;margin-top:10px;margin-bottom:20px;'><i class='icon-plus3'></i></span></a><h4 style = 'margin-top:10px;margin-bottom:20px;float:left; font-size:12pt;color:#324148;'><span class='font-weight-semibold'>Sub Rack For Rack "+rackname+"</span></h4> <table class = 'w-100' style = 'margin-bottom:20px;'><tr><th style = 'line-height:0.35;' >Code</th><th>Sub Rack Name</th><th>Rows</th><th>Column</th><th>Status</th> </tr> "+result+"</table>").show();
                    
                }  
            });
            

                // Add to the 'open' array
                if (idx === -1) {
                    detailRows.push(tr.attr('id'));
                }
                //  detailRows
                tr.addClass('shown');
                badge.first().removeClass('badge-success');
                badge.first().addClass('badge-danger');
                icon.first().removeClass('icon-plus3');
                icon.first().addClass('icon-minus3');
            }
            //  onclickdatarow();
        });

        dt.on('draw', function () {
            $.each(detailRows, function (i, id) {
                $('#' + id + ' td.details-control').trigger('click');
            });
        });
    };



    // Reload table
    function success() {
        $('#datatable_serverside').DataTable().ajax.reload(null, false);
    };

    function setbranchonclick() {
        getbranch();


    }

    function getbranch() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterrack.php",
            method: 'POST',
            data: {
                tipe: "getbranch"

            },
            success: function (result) {
                var mysplit = result.split("|");

                if (mysplit[0] == "none") {
                    $("#branch").html("");

                } else {
                    $("#branch").html(result).promise().done(function () {

                    });
                }
                $("#sister").val(mysplit[1]);
                $("#branch").trigger("change");
            }
        });
    };

    $("#branch").on('change', function () {
        //    alert("test");


        //  alert(myoptionid);
        var myid = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterrack.php",
            method: 'POST',
            data: {
                tipe: "getbuilding",
                idbranch: myid

            },
            success: function (result) {
                // alert(result);
                if (result == "none") {
                    $("#building").html("");
                } else {
                    $("#building").html(result).promise().done(function () {});
                }
                $("#building").trigger("change");
            }
        });
    }).trigger('change');
    $("#building").on('change', function () {
        var myidbranch = $("#branch").val();
        var myid = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterrack.php",
            method: 'POST',
            data: {
                tipe: "getfloor",
                idbuilding: myid,
                idbranch: myidbranch

            },
            success: function (result) {
                // alert(result);
                if (result == "none") {
                    $("#floor").html("");
                } else {
                    $("#floor").html(result).promise().done(function () {

                        // if(!globalid =="")
                        // {

                        // }
                    });
                }
                $("#floor").trigger("change");
            }
        });
    }).trigger('change');
    $("#floor").on('change', function () {
        var mybranchid = $('#branch').val();
        var mybuilding = $('#building').val();
        var myid = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterrack.php",
            method: 'POST',
            data: {
                tipe: "getroom",
                idfloor: myid,
                idbranch: mybranchid,
                idbuilding: mybuilding

            },
            success: function (result) {
                // alert(result);
                if (result == "none") {
                    $("#room").html("");
                } else {
                    $("#room").html(result).promise().done(function () {

                        // if(!globalid =="")
                        // {

                        // }
                    });
                }
                $("#room").trigger("change");
            }
        });
    }).trigger('change');


    function adddata() {
        var code = $("#code").val();
        var branch = $("#branch").val()
        var building = $("#building").val()
        var floor = $("#floor").val()
        var rooms = $("#room").val()
        var rackname = $("#rackname").val();
        var description = $('#description').val();
        if (code == "" || rackname == "" || description == "" || branch == null || building == null || floor == null ||
            rooms == null) {
                Swal.fire({
                        icon: 'error',
                        title: 'Empty Field',
                        text: 'Requirement data cannot be empty',
                        confirmButtonColor: '#e00d0d',
                    });
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterrack.php",
                method: 'POST',
                data: {

                    tipe: "add",
                    mycode: code,
                    mybranch: branch,
                    mybuilding: building,
                    myfloor: floor,
                    myrooms: rooms,
                    myrackname: rackname,
                    mydescription: description

                },
                success: function (result) {
                    //    alert(result);
                    if (result == "sukses") {
                        success();
                        Swal.fire({
                            title: 'Data Saved',
                            text: 'Data Inputted Successfully',
                            icon: 'success',
                            confirmButtonColor: '#53d408',
                            allowOutsideClick: false,
                        }).then((result) => {
                            $("#myform").trigger("reset");
                            $("#canceladd").click();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Exists',
                            text: 'Duplicate Entry For This Rack',
                            confirmButtonColor: '#e00d0d',
                        });
                    }


                }
            });
        }

    }



    // Edit

    var globalbuilding = "";
    var globalfloor = "";
    var globalroom = "";

    function openmodaledit(element) {
        getbranchedit()
        var idelement = element.id.split("-");
        var idsister = idelement[2];
        var idbranch = idelement[3];
        var idbuilding = idelement[4];
        var idfloor = idelement[5];
        var idroom = idelement[6];
        globalbuilding = idbuilding;
        globalfloor = idfloor;
        globalroom = idroom;
        var code = $("#code" + idelement[1]).text();
        var rackname = $("#rackname" + idelement[1]).text();
        var description = $("#description" + idelement[1]).text();
        $('#branchedit option[value=' + idbranch + ']').prop('selected', true);
        $('#branchedit').trigger('change');
        $("#codeedit").val(code);
        $("#racknameedit").val(rackname);
        $("#descriptionedit").val(description);
        $("#idchange").val(idelement[1]);
    }

    function getbranchedit() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterrack.php",
            method: 'POST',
            data: {
                tipe: "getbranch"

            },
            success: function (result) {
                var mysplit = result.split("|");

                if (mysplit[0] == "none") {
                    $("#branchedit").html("");

                } else {
                    $("#branchedit").html(result).promise().done(function () {

                    });
                }
                $("#sisteredit").val(mysplit[1]);
                $("#branchedit").trigger("change");
                // console.log(mysplit);




            }
        });
    };

    $("#branchedit").on('change', function () {
        //    alert("test");


        //  alert(myoptionid);
        var myid = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterrack.php",
            method: 'POST',
            data: {
                tipe: "getbuilding",
                idbranch: myid

            },
            success: function (result) {
                // alert(result);
                if (result == "none") {
                    $("#buildingedit").html("");
                } else {
                    $("#buildingedit").html(result).promise().done(function () {
                        if (!globalbuilding == "") {
                            $('#buildingedit').find('option[value="' + globalbuilding +
                                '"]').prop('selected', true);
                        }
                    });
                }
                $("#buildingedit").trigger("change");
            }
        });
    }).trigger('change');
    $("#buildingedit").on('change', function () {
        var myidbranch = $("#branchedit").val();
        var myid = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterrack.php",
            method: 'POST',
            data: {
                tipe: "getfloor",
                idbuilding: myid,
                idbranch: myidbranch

            },
            success: function (result) {
                // alert(result);
                if (result == "none") {
                    $("#flooredit").html("");
                } else {
                    $("#flooredit").html(result).promise().done(function () {

                        if (!globalfloor == "") {
                            $('#flooredit').find('option[value="' + globalfloor + '"]')
                                .prop('selected', true);
                        }
                    });
                }
                $("#flooredit").trigger("change");
            }
        });
    }).trigger('change');
    $("#flooredit").on('change', function () {
        var mybranchid = $('#branchedit').val();
        var mybuilding = $('#buildingedit').val();
        var myid = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterrack.php",
            method: 'POST',
            data: {
                tipe: "getroom",
                idfloor: myid,
                idbranch: mybranchid,
                idbuilding: mybuilding

            },
            success: function (result) {
                // alert(result);
                if (result == "none") {
                    $("#roomedit").html("");
                } else {
                    $("#roomedit").html(result).promise().done(function () {

                        if (!globalroom == "") {
                            $('#roomedit').find('option[value="' + globalroom + '"]').prop(
                                'selected', true);
                        }
                    });
                }
                $("#roomedit").trigger("change");
            }
        });
    }).trigger('change');


    function adddata() {
        var code = $("#code").val();
        var branch = $("#branch").val()
        var building = $("#building").val()
        var floor = $("#floor").val()
        var rooms = $("#room").val()
        var rackname = $("#rackname").val();
        var description = $('#description').val();
        if (code == "" || rackname == "" || description == "" || branch == null || building == null || floor == null ||
            rooms == null) {
            Swal.fire({
                icon: 'error',
                title: 'Empty Field',
                text: 'Code / Branch / Building / Floor / Rooms / Rack Name / Description cannot be empty',
                confirmButtonColor: '#e00d0d',
            });
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterrack.php",
                method: 'POST',
                data: {

                    tipe: "add",
                    mycode: code,
                    mybranch: branch,
                    mybuilding: building,
                    myfloor: floor,
                    myrooms: rooms,
                    myrackname: rackname,
                    mydescription: description

                },
                success: function (result) {
                    //    alert(result);
                    if (result == "sukses") {
                        success();
                        Swal.fire({
                            title: 'Data Saved',
                            text: 'Data Inputted Successfully',
                            icon: 'success',
                            confirmButtonColor: '#53d408',
                            allowOutsideClick: false,
                        }).then((result) => {
                            $("#myform").trigger("reset");
                            $("#canceladd").click();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Exists',
                            text: 'Duplicate Entry For This Rack',
                            confirmButtonColor: '#e00d0d',
                        });
                    }


                }
            });
        }

    }

    function changedata() {
        var changeid = $("#idchange").val();
        var code = $("#codeedit").val();
        var branch = $("#branchedit").val()
        var building = $("#buildingedit").val()
        var floor = $("#flooredit").val()
        var rooms = $("#roomedit").val()
        var rackname = $("#racknameedit").val();
        var description = $('#descriptionedit').val();
        if (code == "" || rackname == "" || description == "" || branch == null || building == null || floor == null ||
            rooms == null || rackname == null) {
                Swal.fire({
                        icon: 'error',
                        title: 'Empty Field',
                        text: 'Requirement data cannot be empty',
                        confirmButtonColor: '#e00d0d',
                    });
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterrack.php",
                method: 'POST',
                data: {
                    tipe: "changedata",
                    myid: changeid,
                    mycode: code,
                    mybranch: branch,
                    mybuilding: building,
                    myfloor: floor,
                    myrooms: rooms,
                    myrackname: rackname,
                    mydescription: description

                },
                success: function (result) {
                    // alert(result);
                    if (result == "sukses") {
                        success();
                        Swal.fire({
                            title: 'Data Changed',
                            text: 'Data Changed Successfully',
                            icon: 'success',
                            confirmButtonColor: '#53d408',
                            allowOutsideClick: false,
                        }).then((result) => {
                            $("#myformedit").trigger("reset");
                            $("#canceledit").click();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Duplicated Data',
                            text: 'Duplicate Entry For This Rack',
                            confirmButtonColor: '#e00d0d',
                        });
                    }




                }
            });
        }
    }

    function setstatus(setactionto) {
        var elements = setactionto.split("-");
        var myid = elements[0];
        var mystat = elements[1];
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterrack.php",
            method: 'POST',
            data: {
                tipe: "setstatus",
                myidchange: myid,
                stat: mystat
            },
            success: function (result) {

                success();
                Swal.fire({
                    title: 'Status Changed',
                    text: 'Status Changed Successfully',
                    icon: 'success',
                    confirmButtonColor: '#53d408',
                    allowOutsideClick: false,
                }).then((result) => {

                });


            }
        });
    }

    function onclickdatarow() {
        var tr = $(this).closest('tr');
        var badge = tr.find('span.badge');
        var icon = tr.find('i');
        var row = table.row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            badge.first().removeClass('badge-danger');
            badge.first().addClass('badge-success');
            icon.first().removeClass('icon-minus3');
            icon.first().addClass('icon-plus3');
        } else {
            row.child(rowDetail(row.data())).show();
            tr.addClass('shown');
            badge.first().removeClass('badge-success');
            badge.first().addClass('badge-danger');
            icon.first().removeClass('icon-plus3');
            icon.first().addClass('icon-minus3');
        }
    }
</script>