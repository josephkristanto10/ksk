<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$sql = "select * from country";
$res = $conn->query($sql);
?>
        <div class="content-wrapper">
            <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <h4><span class="font-weight-semibold">Master Country</span></h4> 
                    <div class="page-title d-flex">
                        <div class = "row" style = "width:100%;">
                            <div class = "col-xl-12" >
							<a href="#myModal" data-toggle="modal"> <button class = "btn btn-info" style = "background-color:#26a69a !important;width:150px;"><i class = "icon-add"></i> &nbsp Add Country</button></a>
                            </div>
                        </div>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card" >
                        <table id = "datatable_serverside" class="table table-hover table-bordered display nowrap w-100">
                                <thead>
                                <tr class="text-center">
                                        <th>Country</th>     
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
						<h5 class="modal-title">Add Country</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
                        <form id = "myform">
						<div class="form-group">
							<label for="description">Country</label>
							<input type="text" class="form-control" id="Country">
							
							<br>
							<div style = "float:right;margin-bottom:20px;">
							<button type="button" class="btn btn-primary" style = "margin-right:10px;" onclick="addcountry()">Save</button>
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
						<h5 class="modal-title">Edit Country</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
                        <form id = "myformedit">
						<div class="form-group">
                            <input type = "hidden" id = "idchange">
							<label for="description">Country</label>
							<input type="text" class="form-control" id="Countryedit">
							
							<br>
							<div style = "float:right;margin-bottom:20px;">
							<button type="button" class="btn btn-primary" style = "margin-right:10px;" onclick="changecountry()">Save</button>
						    <button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceledit">Cancel</button>
							</div>
						</div>
                       </form>
					</div>
					
				</div>
			</div>
		</div>
</body>

</html>
<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
	$(function() {
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
         order: [[0, 'asc']],
         ajax: { 
            url: 'process/mastercountry.php',
            method: 'POST',
            data: { tipe: "load"  }
        },
         columns: [
            { name: 'country', className: 'text-center align-middle' },
            { name: 'status', className: 'text-center align-middle' },
            { name: 'action', searchable: false, orderable: false, className: 'text-center align-middle' }
            
         ]
      });
   };
   function openmodal(element){
    var idelement = element.id.split("-");
    var nama = $("#country" + idelement[1]).text();
     $("#Countryedit").val(nama);
     $("#idchange").val(idelement[1]);
}

function changecountry(){
        var countryedit = $("#Countryedit").val();
        var changeid = $("#idchange").val();
        if(countryedit == "" )
        {
                         Swal.fire({
                            icon: 'error',
                            title: 'Empty Field',
                            text: 'Country tidak boleh kosong',
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
                url: "process/mastercountry.php",
                method: 'POST',
                data: {
                    tipe: "change",
                    mycountry : countryedit,
                    myid: changeid
                    
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
                            title: 'Duplicated Country Name',
                            text: 'Duplicate Entry For This Country',
                            confirmButtonColor: '#e00d0d',
                        });
                    }
                  
                  
                }
            });

        }
    }
   function addcountry() {
            var country = $('#Country').val();
            if(country == "")
            {
                Swal.fire({
                            icon: 'error',
                            title: 'Empty Field',
                            text: 'Country tidak boleh kosong',
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
                url: "process/mastercountry.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    mycountry: country
                    
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
                                $("#myform").trigger("reset");
                                $("#canceladd").click();
                            });
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Exists',
                            text: 'Duplicate Entry For This Country',
                            confirmButtonColor: '#e00d0d',
                        });
                    }
                  
                  
                }
            });
            }
          
        };

   // Reload table
   function success() {
      $('#datatable_serverside').DataTable().ajax.reload(null, false);
   };

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
                url: "process/mastercountry.php",
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