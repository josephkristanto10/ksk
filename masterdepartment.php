<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$sql = "select * from divisi";
$res = $conn->query($sql);
$myrow = array();
if($res -> num_rows>0)
{
    while($r = mysqli_fetch_array($res))
    {
        $myrow[] = $r;
    }
}
?>

        <div class="content-wrapper">
            <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <h4><span class="font-weight-semibold">Master Department</span></h4> 
                    <div class="page-title d-flex">
                        <div class = "row" style = "width:100%;">
                            <div class = "col-xl-12" >
							<a href="#myModal" data-toggle="modal"> <button class = "btn btn-info" style = "background-color:#26a69a !important;width:150px;"><i class = "icon-add"></i> &nbsp Add Department</button></a>
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
                                        <th>Divisi</th>
                                        <th>Department</th>                        
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
						<h5 class="modal-title">Add Department</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">??</span>
						</button>

					</div>
					<div class="modal-body">
                        <form id = "myform">
						<div class="form-group">
							<label for="code">Division</label>
                            <select id="division" name="division" class="form-control">
                                <?php
                                for($i = 0 ; $i < count($myrow); $i++)
                                {
                                    echo '<option value="'.$myrow[$i]['id'].'">'.$myrow[$i]['divisi'].'</option>';
                                }
                                ?>
								
							</select>
							<br>
							<label for="description">Department</label>
							<input type="text" class="form-control" id="department">
							<br>
							<label for="description">Description</label>
							<input type="text" class="form-control" id="description">
							<br>
							<div style = "float:right;margin-bottom:20px;">
							<button type="button" class="btn btn-primary" style = "margin-right:10px;" onclick="adddata()">Save</button>
						    <button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceladd">Close</button>
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
						<h5 class="modal-title">Edit Department</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">??</span>
						</button>

					</div>
					<div class="modal-body">
                        <form id = "myformedit">
						<div class="form-group">
                        <input type = "hidden" id = "idchange">
							<label for="code">Division</label>
                            <select id="divisionedit" name="divisionedit" class="form-control">
                                <?php
                                for($i = 0 ; $i < count($myrow); $i++)
                                {
                                    echo '<option value="'.$myrow[$i]['id'].'">'.$myrow[$i]['divisi'].'</option>';
                                }
                                ?>
								
							</select>
							<br>
							<label for="description">Department</label>
							<input type="text" class="form-control" id="departmentedit">
							<br>
							<label for="description">Description</label>
							<input type="text" class="form-control" id="descriptionedit">
							<br>
							<div style = "float:right;margin-bottom:20px;">
							<button type="button" class="btn btn-primary" style = "margin-right:10px;" onclick="changedata()">Save</button>
						    <button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceledit">Close</button>
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
            url: 'process/masterdepartment.php',
            method: 'POST',
            data: { tipe: "load"  }
        },
         columns: [
            { name: 'Divisi', className: 'text-center align-middle' },
            { name: 'Department', className: 'text-center align-middle' },
            { name: 'Description', className: 'text-center align-middle' },
            { name: 'Status', className: 'text-center align-middle' },
            { name: 'Action', searchable: false, orderable: false, className: 'text-center align-middle' }
            
         ]
      });
   };

   // Reload table
   function success() {
      $('#datatable_serverside').DataTable().ajax.reload(null, false);
   };

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
                url: "process/masterdepartment.php",
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
   };

   function adddata(){
	   var division = $("#division").val();
	   var department = $("#department").val();
	   var desc = $("#description").val();
	   if(desc == "" || division == null || department == "")
	   {
						Swal.fire({
                            icon: 'error',
                            title: 'Empty Field',
                            text: 'Group / Category / Description Is Empy',
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
                url: "process/masterdepartment.php",
                method: 'POST',
                data: {
                    tipe: "adddepartment",
                    mydiv : division,
					mydepar : department,
					mydesc : desc
                    
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
                            title: 'Duplicated Department Name',
                            text: 'Duplicate Entry For This Department',
                            confirmButtonColor: '#e00d0d',
                        });
					}
                 
                   
                  
                  
                }
            });
							
	   }
   }

   function changedata(){
	 var changeid = $("#idchange").val();
	 var changedivision = $("#divisionedit").val();
	 var changedepartment = $("#departmentedit").val();
	 var changedescription = $('#descriptionedit').val();
	 if(changedepartment == "" || changedescription == "" )
	 {
						Swal.fire({
                            icon: 'error',
                            title: 'Empty Field',
                            text: 'Department / Description Is Empty',
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
                url: "process/masterdepartment.php",
                method: 'POST',
                data: {
                    tipe: "changedata",
					myid : changeid,
					mydivision: changedivision,
                    mydepar : changedepartment,
					mydesc : changedescription
                    
                },
                success: function (result) {
					if(result == "sukses")
					{
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
					}
					else{
						Swal.fire({
                            icon: 'error',
                            title: 'Duplicated Category Name',
                            text: 'Duplicate Entry For This Department',
                            confirmButtonColor: '#e00d0d',
                        });
					}
                 
                   
                  
                  
                }
            });
	 }
   }

   function openmodaledit(element){
	// 
	var idelement = element.id.split("-");
	$("#idchange").val(idelement[1]);
	
	var divisi = $("#divisi" + idelement[1]).text();
	var department = $("#department" + idelement[1]).text();
	var desc = $("#description" + idelement[1]).text();
	var selectdivisi = $('#divisionedit option[value='+idelement[2]+']').prop('selected', true);
	
	// alert(idelement[3]);
	// $("#divisiedit").val(divisi);
	$('#departmentedit').val(department);
	$('#descriptionedit').val(desc);
   }


</script>