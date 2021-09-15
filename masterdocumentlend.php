<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$idsister = $_SESSION['idsister'];
$sqlbranch = "select lbranch.idbranch, lbranch.branch from location_setup_sister_branch inner join location_branch lbranch on lbranch.idbranch = location_setup_sister_branch.idbranch where location_setup_sister_branch.idsistercompany = '$idsister'";
$resbranch  = $conn->query($sqlbranch);
$mybranch = array();
if($resbranch -> num_rows>0)
{
	while($j = mysqli_fetch_array($resbranch))
	{
		$mybranch[] = $j;
	}
}
$sqldivisi = "select * from divisi";
$resdivisi = $conn->query($sqldivisi);
$mydivisi = array();
if($resdivisi -> num_rows>0)
{
	while($j = mysqli_fetch_array($resdivisi))
	{
		$mydivisi[] = $j;
	}
}
$sqluser= "select * from karyawan";
$resuser = $conn->query($sqluser);
$myuser = array();
if($resuser -> num_rows>0)
{
	while($j = mysqli_fetch_array($resuser))
	{
		$myuser[] = $j;
	}
}
?>

<head>
    <style>
        #myModalshowdetail .modal-body {
            height: 300px !important;
            overflow-y: hidden;
        }

        #myModalshowdetail .modal-dialog {
            -webkit-transform: translate(0, -50%);
            -o-transform: translate(0, -50%);
            transform: translate(0, -50%);
            top: 50%;
            margin: 0 auto;
        }
        #myModalreturn .modal-body{
            height:250px !important;
        }
        
    </style>

</head>
<!-- Main navbar -->


<div class="content-wrapper">
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline" style="height:100px;">
            <h4><span class="font-weight-semibold">Lend Document </span></h4>
            <div class="page-title d-flex">
                <div class="row" style="width:100%;">
                    <div class="col-xl-12">
                        <a href="#myModal" data-toggle="modal"><button class="btn btn-info"
                                style="display:none;background-color:#26a69a !important;width:140px;"><i
                                    class="icon-add"></i> &nbsp Lend Document</button></a>
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
                                <th>No Transaction</th>
                                <th>Branch</th>
                                <th>NIK</th>
                                <th>Employee Name</th>
                                <th>Document</th>
                                <th>Date Range</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModalshowdetail">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
						<h5 class="modal-title" id = "Titlemodaldisplacement">Displacement Detail</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div> -->
            <div class="modal-body">
                <form id="myform">
                    <h5 class="modal-title"
                        style="font-size:18px;width:450px;margin-right:auto;margin-left:auto;text-align:center;color:black;">
                        #<label id="transactionno"></label> Transaction's Detail Report</h5>
                    <div class="form-group">
                        <br>
                        <table class="w-100" style="text-align:left;border:1px solid white;">
                            <tr>
                                <th style="padding:10px;">#</th>
                                <th>From</th>
                                <th>Moved To</th>
                            </tr>
                            <tr>
                                <td style="text-align:center;border:1px solid transparent;width:120px;padding:10px;">
                                    Branch</td>
                                <td style="text-align:center;border:1px solid transparent;padding:10px;"><label
                                        id="branchfrom">-</label></td>
                                <td style="text-align:center;border:1px solid transparent;padding:10px;"><label
                                        id="branchto">-</label></td>
                            <tr>
                            <tr>
                                <td style="text-align:center;border:1px solid transparent;width:120px;padding:10px;">
                                    Room</td>
                                <td style="text-align:center;border:1px solid transparent;padding:10px;"><label
                                        id="roomfrom">-</label></td>
                                <td style="text-align:center;border:1px solid transparent;padding:10px;"><label
                                        id="roomto">-</label></td>
                            <tr>
                            <tr>
                                <td style="text-align:center;border:1px solid transparent;width:120px;padding:10px;">
                                    Rack</td>
                                <td style="text-align:center;border:1px solid transparent;padding:10px;"><label
                                        id="rackfrom">-</label></td>
                                <td style="text-align:center;border:1px solid transparent;padding:10px;"><label
                                        id="rackto">-</label></td>
                            <tr>
                        </table>


                        <br class="clear" />

                        <br class="clear" />
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
                <h5 class="modal-title">Add Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>
            <div class="modal-body">
                <form id="myform">
                    <div class="form-group">
                        <label for="idsistercompany">sistercompany</label><input type="text" class="form-control"
                            name="idsistercompany" id="idsistercompany" value="<?php echo $_SESSION['namasister'];?>"
                            disabled />
                        <br class="clear" />
                        <label for="code">Code</label><input type="text" class="form-control" name="code" id="code" />
                        <br class="clear" />
                        <label for="idbranch">branch</label>
                        <select class="form-control" id="idbranch">
                            <?php
                                for($i = 0 ; $i < count($mybranch); $i++)
                                {
                                    echo '<option value = "'.$mybranch[$i]['idbranch'].'">'.$mybranch[$i]['branch'].'</option>';
                                }
                                ?>
                        </select>
                        <br class="clear" />
                        <label for="iddivisi">divisi</label>
                        <select class="form-control" id="iddivisi">
                            <?php
                                for($i = 0 ; $i < count($mydivisi); $i++)
                                {
                                    echo '<option value = "'.$mydivisi[$i]['id'].'">'.$mydivisi[$i]['divisi'].'</option>';
                                }
                                ?>
                        </select>
                        <br class="clear" />
                        <label for="iddepartement">departement</label>
                        <select class="form-control" id="iddepartment">
                        </select>
                        <br class="clear" />
                        <label for="name">Name</label><input type="text" class="form-control" name="name" id="name" />
                        <br class="clear" />
                        <label for="tanggaldokumen">Tanggaldokumen</label><input type="text"
                            class="form-control pickadate" name="tanggaldokumen" id="tanggaldokumen" />
                        <br class="clear" />

                        <br class="clear" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="adddata()">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="canceladd">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalreturn">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
                <h5 class="modal-title">Return Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>
            <div class="modal-body">
                <form id="myform">
                    <div class="form-group">
                    <input type="hidden"   id="idreturn" disabled />
                        <label for="idsistercompany">No Transaction</label><input type="text" class="form-control"
                            name="notransactions" id="notransactions" disabled />
                        <br class="clear" />
                        <label for="code">Document Name</label><input type="text" class="form-control" name="documentnames" id="documentnames" disabled />
                        <label for="code">NIK User</label><input type="text" class="form-control" name="nikuser" id="nikuser" disabled />
                        <label for="code">NIK Admin</label>
                        <select class="form-control" id="nikadmin">
                            <?php
                                for($i = 0 ; $i < count($myuser); $i++)
                                {
                                    echo '<option value = "'.$myuser[$i]['nik'].'|'.$myuser[$i]['nama'].'">'.$myuser[$i]['nik'].'-'.$myuser[$i]['nama'].'</option>';
                                }
                                ?>
                        </select>
                        
                        <br class="clear" />

                        <br class="clear" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="addreturn()">Return Document</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="canceladd">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModaledit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
                <h5 class="modal-title">Edit Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>
            <div class="modal-body">
                <form id="myformedit">
                    <div class="form-group">
                        <input type="hidden" id="idchange">
                        <label for="idgroup">Sister Company</label><input type="text" class="form-control"
                            value="<?php echo $_SESSION['namasister']; ?>" disabled />
                        <br class="clear" />
                        <label for="code">Code</label><input type="text" class="form-control" name="code"
                            id="codeedit" />
                        <br class="clear" />
                        <label for="idbranch">branch</label>
                        <select class="form-control" id="idbranchedit">
                            <?php
                                for($i = 0 ; $i < count($mybranch); $i++)
                                {
                                    echo '<option value = "'.$mybranch[$i]['idbranch'].'">'.$mybranch[$i]['branch'].'</option>';
                                }
                                ?>
                        </select>
                        <br class="clear" />
                        <label for="iddivisi">divisi</label>
                        <select class="form-control" id="iddivisiedit">
                            <?php
                                for($i = 0 ; $i < count($mydivisi); $i++)
                                {
                                    echo '<option value = "'.$mydivisi[$i]['id'].'">'.$mydivisi[$i]['divisi'].'</option>';
                                }
                                ?>
                        </select>
                        <br class="clear" />
                        <label for="iddepartement">departement</label>
                        <select class="form-control" id="iddepartmentedit">
                        </select>
                        <br class="clear" />
                        <label for="name">Name</label><input type="text" class="form-control" name="name"
                            id="nameedit" />
                        <br class="clear" />
                        <label for="tanggaldokumen">Tanggaldokumen</label><input type="text"
                            class="form-control pickadate" name="tanggaldokumen" id="tanggaldokumenedit" />
                        <br class="clear" />

                        <br class="clear" />

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="changedata()">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="canceledit">Cancel</button>
            </div>
        </div>
    </div>
</div>
</body>

</html>
<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
    $(function () {
        loadData();
        $('#tanggaldokumen').pickadate({
            format: 'yyyy-mm-dd'
        });
        $('#tanggaldokumenedit').pickadate({
            format: 'yyyy-mm-dd'
        });

    });

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
                url: 'process/masterdocumentlend.php',
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
                    name: 'No Transaction',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Branch',
                    className: 'text-center align-middle'
                },
                {
                    name: 'NIK',
                    className: 'text-center align-middle'
                },
                {
                    name: 'EmployeeName',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Document',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Date',
                    className: 'text-center align-middle'
                }

            ]
        });

        var detailRows = [];

        $('#datatable_serverside tbody').on('click', 'tr td.details-control span.badge', function () {
            var tr = $(this).closest('tr');
            var row = dt.row(tr);
            var idx = $.inArray(tr.attr('id'), detailRows);

            var badge = tr.find('span.badge');
            //  alert(idtest);
            if (row.child.isShown()) {
                tr.removeClass('details');
                row.child.hide();

                detailRows.splice(idx, 1);

                tr.removeClass('shown');
                badge.first().removeClass('badge-danger');
                badge.first().addClass('badge-success');
            } else {
                tr.addClass('details');

                var splitidrow = this.id.split("~");
                var jenisrow = splitidrow[0];
                var idrow = splitidrow[1];
                // alert(jenisrow);
                var buildingname = $("#buildingname" + idrow).val();
                // alert(idrow);
                var floor = $("#floor" + idrow).val();
                var room = $("#room" + idrow).val();
                var nik = $("#nik" + idrow).text();
                var employeename = $("#nama" + idrow).text();
                var document = $("#documentname" + idrow).text();
                var startdate = $("#startdate" + idrow).val();
                var enddate = $("#enddate" + idrow).val();
                var compare = $("#status" + idrow).val();
                var transaction = $("#notransaction"+idrow).text();
                var stringcolor = "color:green;";
                if (compare == "Late") {
                    stringcolor = "color:red;";
                }
                // var divsquare = "<span class = 'mi-subdirectory-arrow-right' style = 'font-size: 3em;height:100px;float:left';margin-left:10px></span><div style = 'margin-left:40px;margin-top:5px;text-align : left;float:left;'> <h4>Lend Detail</h4><p>Building : <b>"+buildingname+" </b></p> <p>Floor : <b>"+floor+" </b></p> </p> <p>Room : <b>"+room+" </b></p> </div><div style = 'margin-left:60px;margin-top:5px;text-align : left;float:left;'> <h4>&nbsp</h4> <p>NIK : <b>"+buildingname+" </b></p> <p>Employee Name : <b>"+floor+" </b></p> </p> <p>Document : <b>"+room+" </b></p> </div><div style = 'margin-left:60px;margin-top:5px;text-align : left;float:left;'> <h4>&nbsp</h4> <p>Start Date : <b>"+buildingname+" </b></p><p>End Date : <b>"+buildingname+" </b></p> <p>Status : <b style = 'color:green;'> Clear </b></p>  </div>";

                var card = "";
                if (jenisrow == "detail") {
                    //detail
                    card =
                        '<span class = "mi-subdirectory-arrow-right" style = "font-size: 3em;height:100px;float:left;margin-left:10px"></span><div class="card" style = "min-width:250px !important;float:left;margin-left:10px;"><div class="card-header header-elements-inline"><h5 class="card-title">Lend Detail</h5></div>	<div class="card-body" style="text-align:left;"><p>Building : <b>' +
                        buildingname + ' </b></p> <p>Floor : <b>' + floor + ' </b></p>  <p>Room : <b>' + room +
                        ' </b></p></div></div> 	</div> <div class="card" style = "min-width:250px !important;float:left;margin-left:10px;"><div class="card-header header-elements-inline"><h5 class="card-title"> Personal Detail</h5><div class="header-elements"><div class="list-icons"></div></div></div>	<div class="card-body" style="text-align:left;"><p>NIK : <b>' +
                        nik + ' </b></p> <p>Employee Name : <b>' + employeename +
                        ' </b></p> </p> <p>Document : <b>' + document +
                        ' </b></p></div>	</div></div><div class="card" style = "min-width:250px !important;float:left;margin-left:10px;"><div class="card-header header-elements-inline"><h5 class="card-title"> Lend Status</h5><div class="header-elements"><div class="list-icons"></div></div></div>	<div class="card-body" style="text-align:left; "><p>Start Date : <b>' +
                        startdate + ' </b></p><p>End Date : <b>' + enddate +
                        ' </b></p> <p>Status : <b style = "' + stringcolor + '"> ' + compare +
                        '</b></p></div>	</div>';
                        row.child(card).show();

                } else {
                    // extend

                             $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: "process/masterdocumentlend.php",
                                method: 'POST',
                                data: {
                                    tipe: "getdocumentlog",
                                    myidlend: idrow,
                                    mytransaction : transaction
                                },
                                success: function (result) {
                                  
                                        card =result;
                                    
                                   
                                        row.child(card).show();
                                    // alert(result);
                                  


                                }
                            });
                   
                }

               



                // Add to the 'open' array
                if (idx === -1) {
                    detailRows.push(tr.attr('id'));
                }
                //  detailRows
                tr.addClass('shown');
                badge.first().removeClass('badge-success');
                badge.first().addClass('badge-danger');
            }
            //  onclickdatarow();

            dt.on('draw', function () {
                $.each(detailRows, function (i, id) {
                    $('#' + id + ' td.details-control').trigger('click');
                });
            });
        });




        // Extend Menu


    };








    // Reload table
    function success() {
        $('#datatable_serverside').DataTable().ajax.reload(null, false);
    };


    function addreturn(){
       var myid =  $("#idreturn").val();
       var nikuser = $("#nik"+myid).text();
       var namauser = $("#nama"+myid).text();
       
       var nikadmin = $("#nikadmin").val();
       var splitnikadmin = nikadmin.split("|");
       var namadmin = $("#nik"+myid).text();
    //    alert(nikpenerima + " - " + nikadmin);

                          $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: "process/masterdocumentlend.php",
                                method: 'POST',
                                data: {
                                    tipe: "addreturndocument",
                                    myidlend: myid,
                                    mynikuser : nikuser,
                                    mynikadmin : splitnikadmin[0]
                                },
                                success: function (result) {

                                  
                                    var notransaction = $("#notransaction" + myid).text();
                                    var mydocument = $("#documentname"+myid).text();
                                    var mynik = $("#nik"+myid).text();
                                    $("#notransactions").val(notransaction);
                                    $("#documentnames").val(mydocument);
                                    $("#nikuser").val(mynik);
                                  
                                    var returndata = '<li class="media"><div class="mr-3"><a href="#" class="btn bg-transparent border-success text-success rounded-round border-2 btn-icon legitRipple"><i class="icon-redo2"></i></a></div><div class="media-body">'+mydocument+' from transaction #'+notransaction+' has been returned from <b>'+nikuser+"-"+namauser+'</b> to Admin <b>'+splitnikadmin[0]+"-"+splitnikadmin[1]+'</b><div class="text-muted">This report, created on </div>	</div></li>  '       ;
                                    $("#mybody" + myid).html("");
                                    $("#mybody" + myid).append(returndata);
                                    // alert(result);
                                  


                                }
                            });



    }

    //setinactive active
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
            url: "process/masterdocument.php",
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

    function openmodalreturn(element)
    {
      
        var myid = element.id;
        $("#idreturn").val(myid);
        var notransaction = $("#notransaction" + myid).text();
        var mydocument = $("#documentname"+myid).text();
        var mynik = $("#nik"+myid).text();
        $("#notransactions").val(notransaction);
        $("#documentnames").val(mydocument);
        $("#nikuser").val(mynik);
    }
    function openmodaldisplacement(element) {
        var myid = element.id;

        var branchfrom = $("#branchfrom" + myid).val();
        var roomfrom = $("#roomfrom" + myid).val();
        var rackfrom = $("#rackfrom" + myid).val();
        var subrackfrom = $("#codefrom" + myid).val();

        var branchto = $("#branchto" + myid).val();
        var roomto = $("#roomto" + myid).val();
        var rackto = $("#rackto" + myid).val();
        var subrackto = $("#codeto" + myid).val();
        var transact = $("#transaction" + myid).val();
        $("#branchfrom").html(branchfrom);
        $("#roomfrom").html(roomfrom);
        $("#rackfrom").html(rackfrom + " ( " + subrackfrom + " )");

        $("#branchto").html(branchto + "");
        $("#roomto").html(roomto + "");
        $("#rackto").html(rackto + " ( " + subrackto + " )");

        $("#transactionno").html(transact);
    }
    var globaldepartment = "";

    function openmodaledit(element) {


        // $row['id'].'-'.$row['idsistercompany'].'-'.$row['idbranch'].'-'.$row['iddivisi'].'-'.$row['iddepartement']
        var idelement = element.id.split("-");
        var idbranch = idelement[3];
        var iddivisi = idelement[4];
        var iddepartement = idelement[5];
        globaldepartment = iddepartement;

        var code = $("#code" + idelement[1]).text();
        var tanggaldokumen = $("#tanggaldokumen" + idelement[1]).text();
        var name = $("#name" + idelement[1]).text();
        $("#codeedit").val(code);
        $("#tanggaldokumenedit").val(tanggaldokumen);
        $("#nameedit").val(name);
        $('#idbranchedit option[value=' + idbranch + ']').prop('selected', true);
        $('#iddivisiedit option[value=' + iddivisi + ']').prop('selected', true);
        $("#iddivisiedit").trigger('change');
        $("#idchange").val(idelement[1]);
    }
    $("#group").on('change', function () {
        var myid = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterassets.php",
            method: 'POST',
            data: {
                tipe: "getsubgroup",
                idgroup: myid

            },
            success: function (result) {
                // alert(result);
                if (result == "none") {
                    $("#subgroup").html("");

                } else {
                    $("#subgroup").html(result).promise().done(function () {


                    });
                }
                $("#subgroup").trigger('change');


            }
        });
    }).trigger('change');
    $("#subgroup").on('change', function () {
        var myid = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterassets.php",
            method: 'POST',
            data: {
                tipe: "getcategory",
                idsubgroup: myid

            },
            success: function (result) {
                // alert(result);
                if (result == "none") {
                    $("#category").html("");
                } else {
                    $("#category").html(result).promise().done(function () {});
                }
            }
        });
    }).trigger('change');
    $("#groupedit").on('change', function () {
        var myid = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterassets.php",
            method: 'POST',
            data: {
                tipe: "getsubgroup",
                idgroup: myid

            },
            success: function (result) {
                // alert(result);
                if (result == "none") {
                    $("#subgroupedit").html("");

                } else {
                    $("#subgroupedit").html(result).promise().done(function () {
                        if (!globalsubgroup == "") {
                            // alert(globalid);
                            $('#subgroupedit').find('option[value="' + globalsubgroup +
                                '"]').prop('selected', true);
                        }

                    });
                }
                $("#subgroupedit").trigger('change');


            }
        });
    }).trigger('change');
    $("#subgroupedit").on('change', function () {
        var myid = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterassets.php",
            method: 'POST',
            data: {
                tipe: "getcategory",
                idsubgroup: myid

            },
            success: function (result) {
                // alert(result);
                if (result == "none") {
                    $("#categoryedit").html("");
                } else {
                    $("#categoryedit").html(result).promise().done(function () {
                        if (!globalcategory == "") {
                            // alert(globalid);
                            $('#categoryedit').find('option[value="' + globalcategory +
                                '"]').prop('selected', true);
                        }
                    });
                }
            }
        });
    }).trigger('change');

    function adddata() {
        var code = $("#code").val();
        var idbranch = $('#idbranch').val();
        var iddivisi = $('#iddivisi').val();
        var iddepartement = $('#iddepartment').val();
        var name = $('#name').val();
        var tanggaldokumen = $('#tanggaldokumen').val();
        if (code == "" || name == "" || tanggaldokumen == "" || idbranch == null || iddivisi == null || iddepartement ==
            null) {
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
                url: "process/masterdocument.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    code: code,
                    idbranch: idbranch,
                    iddivisi: iddivisi,
                    iddepartement: iddepartement,
                    name: name,
                    tanggaldokumen: tanggaldokumen

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
                            text: 'Duplicate Entry For This Document',
                            confirmButtonColor: '#e00d0d',
                        });
                    }


                }
            });
        }


    }

    function changedata() {
        var changeid = $("#idchange").val();
        var codeedit = $("#codeedit").val();
        var branchedit = $('#idbranchedit').val();
        var iddivisiedit = $('#iddivisiedit').val();
        var iddepartmentedit = $('#iddepartmentedit').val();
        var name = $('#nameedit').val();
        var tanggaldokumen = $('#tanggaldokumenedit').val();
        if (codeedit == "" || name == "" || tanggaldokumen == "" || branchedit == null || iddivisiedit == null ||
            iddepartmentedit == null) {
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
                url: "process/masterdocument.php",
                method: 'POST',
                data: {


                    tipe: "changedata",
                    myid: changeid,
                    code: codeedit,
                    branch: branchedit,
                    divisi: iddivisiedit,
                    department: iddepartmentedit,
                    name: name,
                    tanggal: tanggaldokumen

                },
                success: function (result) {
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
                            title: 'Data Exists',
                            text: 'Duplicate Entry For This Assets',
                            confirmButtonColor: '#e00d0d',
                        });
                    }




                }
            });
        }
    }

    $("#iddivisi").on('change', function () {
        var myid = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterdocument.php",
            method: 'POST',
            data: {
                tipe: "getdepartment",
                iddivisi: myid

            },
            success: function (result) {
                if (result == "none") {
                    $("#iddepartment").html("");

                } else {
                    $("#iddepartment").html(result).promise().done(function () {

                    });
                }



            }
        });
    }).trigger('change');
    $("#iddivisiedit").on('change', function () {
        var myid = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterdocument.php",
            method: 'POST',
            data: {
                tipe: "getdepartment",
                iddivisi: myid

            },
            success: function (result) {
                if (result == "none") {
                    $("#iddepartmentedit").html("");

                } else {
                    $("#iddepartmentedit").html(result).promise().done(function () {

                        if (!globaldepartment == "") {

                            $('#iddepartmentedit').find('option[value="' +
                                globaldepartment + '"]').prop('selected', true);
                        }
                    });
                }



            }
        });
    }).trigger('change');
</script>