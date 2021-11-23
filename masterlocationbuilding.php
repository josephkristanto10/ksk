<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$sessionidsister = $_SESSION['idsister'];
$sql = "select lssb.idsetupsisterbranch, lssb.code, lsc.name as sistername, lbranch.branch from location_setup_sister_branch lssb 
		inner join location_sister_company lsc on lsc.id = lssb.idsistercompany 
		inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch where lsc.id = '".$sessionidsister."'";
$res = $conn->query($sql);
$listlocation = array();
if($res -> num_rows>0)
{
	while($r = mysqli_fetch_array($res))
	{
		$listlocation[] = $r;
	}
}
?>


<div class="content-wrapper">
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <h4><span class="font-weight-semibold">Master Building</span></h4>
            <div class="page-title d-flex">
                <div class="row" style="width:100%;">
                    <div class="col-xl-12">
                        <a href="#myModal" data-toggle="modal"> <button type="button"
                                style="background-color:#26a69a !important; color:white; width:150px;"
                                class="btn btn-indigo btn-labeled btn-labeled-left" onclick="cancel()"
                                data-toggle="modal" data-target="#modal_form">
                                <b><i class="icon-plus-circle2"></i></b> Add Building
                            </button></a>
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
                            <th>ID</th>
                                <th>Code</th>
                                <th>Building Name</th>
                                <th>Branch</th>
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
                <h5 class="modal-title">Add Building</h5>
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
                        <label for="code">Building Name</label>
                        <input type="text" class="form-control" id="name">
                        <br>
                        <label for="code">Branch</label>
							<select id="location" name="location" class="form-control">
								<?php
									for($i = 0; $i < count($listlocation); $i++)
									{
										echo "<option value = '".$listlocation[$i]['idsetupsisterbranch']."'>".Ucfirst($listlocation[$i]['branch'])."</option>";
									}
								?>
							</select>
                        <br>
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description">
                        <br>
                        <b>Floor Choose</b><a href="#selectfloor" onclick="loadfloor(this)" data-toggle="modal"
                            data-backdrop="static" data-keyboard="false">Select Floor</a>
                        <br><br>
                        <div id="containerpilihlantai" style="max-height:100px !important;">

                        </div>
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
<div class="modal fade" id="myModaledit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
                <h5 class="modal-title">Edit Building</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>
            <div class="modal-body">
                <form id="myformedit">
                    <div class="form-group">
                        <input type="hidden" id="idchange">
                        <label for="code">Code</label>
                        <input type="text" class="form-control" id="codeedit">
                        <br>
                        <label for="code">Building Name</label>
                        <input type="text" class="form-control" id="nameedit">
                        <br>
                        <label for="code">Location</label>
                        <select id="locationedit" name="locationedit" class="form-control">
                            <?php
									for($i = 0; $i < count($listlocation); $i++)
									{
										echo "<option value = '".$listlocation[$i]['idsetupsisterbranch']."'>".Ucfirst($listlocation[$i]['sistername'])." - ".Ucfirst($listlocation[$i]['branch'])."</option>";
									}
								?>
                        </select>
                        <br>
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="descriptionedit">
                        <br>
                        <b>Floor Choose</b><a href="#selectfloor" onclick="loadfloor(this)" data-toggle="modal"
                            data-backdrop="static" data-keyboard="false">Select Floor</a>
                        <br><br>
                        <div id="containerpilihlantai" style="max-height:100px !important;">

                        </div>
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

<div class="modal fade" id="selectfloor">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
                <h5 class="modal-title">Select Floor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="myforms">
                    <div class="form-group">

                        <table id="datatable_floor" class="table table-hover table-bordered display nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Floor</th>

                                </tr>
                            </thead>
                            </tbody>
                            </tbody>

                        </table>
                        <div style="float:right;margin-bottom:20px;">
                            <button type="button" class="btn btn-primary" id="pilihaset" style="margin-right:10px;"
                                onclick="pilihlantai()">Choose</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                id="canceladd">Cancel</button>
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
<script type="text/javascript"
    src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
    var datatablefloor = null;
    var arridselectedassetadd = [];

    function openselectasset() {
        loadfloor();
    }

    $('#selectfloor').on('shown.bs.modal', function () {
        // var idcategories = $("#categories").val();
        // if (iddefaultcategories != idcategories) {
        //     iddefaultcategories = idcategories;
        //     loadasset(idcategories);
        // }
        datatablefloor.columns.adjust();
    });

    function loadfloor() {
        datatablefloor = $("#datatable_floor").DataTable({
            processing: true,
            deferRender: true,
            serverSide: true,
            scrollX: true,
            responsive: true,
            autoWidth: true,
            destroy: true,

            iDisplayInLength: 10,
            // scrollX: true,
            order: [
                [1, 'asc']
            ],
            columnDefs: [{
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                }
            }],
            ajax: {
                url: 'process/masterbuilding.php',
                method: 'POST',
                data: {
                    tipe: "loadfloor"
                },

            },
            columns: [{
                    searchable: false,
                    orderable: false,
                    name: '#',
                    className: 'checkboxfloor'
                },
                {
                    name: 'code',
                    className: 'text-center align-middle'
                },
                {
                    name: 'floor',
                    className: 'text-center align-middle'
                }
            ]
        });

    }

    $(function () {
        loadData();
    });


    function loadData() {
        $("#datatable_serverside").DataTable({
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
                url: 'process/masterbuilding.php',
                method: 'POST',
                data: {
                    tipe: "load"
                }
            },
            columnDefs: [{
                targets: [0],
                visible: false
            }, ],
            columns: [
                {
                    name: 'id',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Code',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Building Name',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Location',
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
    };

    function pilihlantai() {
        var count = 0;
        var arrselectedasset = [];
        arridselectedassetadd = [];
        $("#datatable_floor tbody input[type='checkbox']").each(function () {

            var checked = this.checked;

            if (checked == true) {
                var myid = this.id;
                var splitid = myid.split("_");
                var myfixid = $(this).closest('td').next('td').find('label').attr('id').split("_");
                arridselectedassetadd.push(myfixid[1]);
                var codefloor = $("#code_" + myfixid[1]).text();
                var namefloor = $("#floor_" + myfixid[1]).text();
                arrselectedasset.push(codefloor + "~~" + namefloor);
                count += 1;
            }


        });


        $("#containerpilihlantai").html("");
        $("#containerpilihlantai").append(
            "<table id = 'tablepilihasset' class = 'table table-hover table-bordered display nowrap w-100'><tr><th>Code</th><th>Floor</th></tr><tbody>"
        );
        for (var i = 0; i < arrselectedasset.length; i++) {
            var split = arrselectedasset[i].split("~~");
            $("#tablepilihasset").append("<tr><td>" + split[0] + "</td><td>" + split[1] + "</td></tr>");
        }
        $("#containerpilihlantai").append("</tbody></table>");
        $("#selectfloor").modal("toggle");
    }

    // Reload table
    function success() {
        $('#datatable_serverside').DataTable().ajax.reload(null, false);
    };
    var globallocation = "";

    function openmodaledit(element) {

        var idelement = element.id.split("-");
        var idlocation = idelement[2];
        globallocation = idlocation

        var code = $("#code" + idelement[1]).text();
        var name = $("#name" + idelement[1]).text();
        var desc = $("#description" + idelement[1]).text();

        $('#locationedit option[value=' + idlocation + ']').prop('selected', true);
        $("#nameedit").val(name);
        $('#codeedit').val(code);
        $('#descriptionedit').val(desc);
        $("#idchange").val(idelement[1]);
    }

    function adddata() {
        if (arridselectedassetadd.length > 0) {
            var mycode = $("#code").val();
            var mybuildingname = $("#name").val();
            var mydesc = $("#description").val();
            var location = $("#location").val();
            if ( location == "" || mybuildingname == "" || mycode == "" || mydesc == "") {
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
                    url: "process/masterbuilding.php",
                    method: 'POST',
                    data: {
                        tipe: "add",
                        code: mycode,
                        name: mybuildingname,
                        selectedfloor : arridselectedassetadd,
                        branch : location,
                        desc: mydesc

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
                                $("#myform").trigger("reset");
                                $("#canceladd").click();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Data Exists',
                                text: 'Duplicate Entry For This Code & Name',
                                confirmButtonColor: '#e00d0d',
                            });
                        }
                    }
                });
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'No Floor Checked ',
                text: 'Please choose at least 1 floor for this building',
                confirmButtonColor: '#e00d0d',
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
            url: "process/masterbuilding.php",
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

    function changedata() {
        var changeid = $("#idchange").val();
        var changecode = $("#codeedit").val();
        var changename = $("#nameedit").val();
        var changelocation = $("#locationedit").val();
        var changedesc = $("#descriptionedit").val();
        if (changecode == "" || changedesc == "" || changelocation == null || changename == "") {
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
                url: "process/masterbuilding.php",
                method: 'POST',
                data: {
                    tipe: "changedata",
                    myid: changeid,
                    mycode: changecode,
                    myname: changename,
                    myloc: changelocation,
                    mydesc: changedesc

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
                            title: 'Duplicated Setup Data',
                            text: 'Duplicate Entry For This Setup Data',
                            confirmButtonColor: '#e00d0d',
                        });
                    }




                }
            });
        }
    }
</script>