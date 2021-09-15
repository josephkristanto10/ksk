<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$sql = "select * from divisi";
$res = $conn->query($sql);
?>

        <div class="content-wrapper">
            <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <h4><span class="font-weight-semibold">Master Division</span></h4> 
                    <div class="page-title d-flex">
                        <div class = "row" style = "width:100%;">
                            <div class = "col-xl-12" >
							<a href="#myModal" data-toggle="modal"> <button class = "btn btn-info" style = "background-color:#26a69a !important;width:150px;"><i class = "icon-add"></i> &nbsp Add Division</button></a>
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


                        <table id = "datatable_serverside" class="table table-hover table-bordered display nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Division</th>                      
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
                        <h5 class="modal-title">Add Division</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>

                    </div>
                    <div class="modal-body">
                        <form id = "myformadd">
                        <div class="form-group">
                            <label for="code">Division</label>
                            <input type="text" class="form-control" id="divisionadd">
                            <br>
                            <label for="description">Description</label>
                            <input type="text" class="form-control" id="descriptionadd">
                            <br>

                            <div style="float:right;margin-bottom:20px;">
                                <button type="button" class="btn btn-primary" style="margin-right:10px;"
                                    onclick="addata()">Save</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceladd">Cancel</button>
                            </div>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="editModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
                        <h5 class="modal-title">Edit Division</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>

                    </div>
                    <div class="modal-body">
                        <form id = "myformedit">
                        <div class="form-group">
                        <input type = "hidden" id = "idchange">
                            <label for="code">Division</label>
                            <input type="text" class="form-control" id="divisionedit">
                            <br>
                            <label for="description">Description</label> 
                            <input type="text" class="form-control" id="descriptionedit">
                            <br>

                            <div style="float:right;margin-bottom:20px;">
                                <button type="button" class="btn btn-primary" style="margin-right:10px;"
                                    onclick="changedata()">Save</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceledit">Cancel</button>
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
                url: 'process/masterdivision.php',
                method: 'POST',
                data: {
                    tipe: "load"
                }
            },
            columns: [{
                    name: 'Division',
                    
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
    function openmodal(element){
        var idelement = element.id.split("-");
        var divisi = $("#divisi" + idelement[1]).text();
        var description = $("#description" + idelement[1]).text();
        $('#divisionedit').val(divisi);
        $('#descriptionedit').val(description);
        $("#idchange").val(idelement[1]);
    }
    function changedata(){
        var divisiedit = $("#divisionedit").val();
        var descedit = $("#descriptionedit").val();
        var changeid = $("#idchange").val();
        if(divisiedit == "" || descedit == "" )
        {
                         Swal.fire({
                            icon: 'error',
                            title: 'Empty Field',
                            text: 'Division / Description tidak boleh kosong',
                            confirmButtonColor: '#e00d0d',
                        });
        }
        else{


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterdivision.php",
                method: 'POST',
                data: {
                    tipe: "change",
                    myid : changeid,
                    mydivisi: divisiedit,
                    mydescription : descedit
                    
                },
                success: function (result) {
                   
                     if(result == "sukses")
                    {
                        success();
                        Swal.fire({
                                title: 'Data Saved',
                                text: 'Data Inputted Successfully',
                                icon: 'success',
                                confirmButtonColor: '#53d408',
                                allowOutsideClick: false,
                            }).then((result) => {
                                $("#myformedit").trigger("reset");
                                $("#canceledit").click();
                            });
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Duplicated Division Name',
                            text: 'Duplicate Entry For This Division',
                            confirmButtonColor: '#e00d0d',
                        });
                    }
                  
                  
                }
            });

        }
    }

    // Reload table
    function success() {
        $('#datatable_serverside').DataTable().ajax.reload(null, false);
    };

    function addata(){
	var divisi = $("#divisionadd").val();
    var description = $('#descriptionadd').val();
           

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterdivision.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    mydivisi: divisi,
                    mydescription : description
                    
                },
                success: function (result) {
                   
                     if(result == "sukses")
                    {
                        success();
                        Swal.fire({
                                title: 'Data Saved',
                                text: 'Data Inputted Successfully',
                                icon: 'success',
                                confirmButtonColor: '#53d408',
                                allowOutsideClick: false,
                            }).then((result) => {
                                $("#myformadd").trigger("reset");
                                $("#canceladd").click();
                            });
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Duplicated Division Name',
                            text: 'Duplicated Entry For This Division',
                            confirmButtonColor: '#e00d0d',
                        });
                    }
                  
                  
                }
            });
}

   //setinactive active
   function setstatus(setactionto){
    var elements = setactionto.split("-");
    var myid = elements[0];
    var mystat = elements[1];
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterdivision.php",
                method: 'POST',
                data: {
                    tipe: "setstatus",
                    myidchange : myid,
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
</script>