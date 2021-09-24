<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$sql = "select * from kategori_asset";
$res = $conn->query($sql);
$res2 = $conn->query($sql);
?>
		<div class="content-wrapper">
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<h4><span class="font-weight-semibold">Master Sub Group</span></h4>
					<div class="page-title d-flex">
						<div class="row" style="width:100%;">
							<div class="col-xl-12">
							<a href="#myModal" data-toggle="modal"><button type="button" style = "background-color:#26a69a !important; color:white; width:200px;" class="btn btn-indigo btn-labeled btn-labeled-left" onclick="cancel()" data-toggle="modal" data-target="#modal_form">
                            <b><i class="icon-plus-circle2"></i></b> Add Sub Group
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
							<table id = "datatable_serverside" class="table table-hover table-bordered display nowrap w-100">
								<thead>
									<tr>

										<th>Group</th>
										<th>Sub Group</th>
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
						<h5 class="modal-title">Add Sub Group</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
						<form id = "myformadd">
						<div class="form-group">
						<label for="code">Sub Group</label>
    					<input type="text" class="form-control" id="subgroupadd">
						<br>
					
							<label for="cars">Group:</label>
							<select id="groupadd" name="groupadd" class="form-control">
								<?php 
								if($res->num_rows>0)
								{
									while($r = mysqli_fetch_array($res))
									{
										echo '<option value="'.$r['id'].'">'.$r['nama'].'</option>';
									}
								}
								
								?>
							</select>
							
							<br>
						<label for="description">Description</label>
    					<input type="text" class="form-control" id="descriptionadd">

						</div>
							</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick = "adddata()">Save</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceladd">Cancel</button>
					</div>
				</div>
				</div>
		</div>
		<div class="modal fade" id="myModaledit">
				<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background-color:#324148;color:white;height:60px;">
						<h5 class="modal-title">Edit Sub Group</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
						<form id = "myformedit">
						<div class="form-group">
						<input type = "hidden" id = "idchange">
						<label for="code">Sub Group</label>
    					<input type="text" class="form-control" id="subgroupedit">
						<br>
					
							<label for="carss">Group:</label>
							
							<select id="groupedit" name="groupedit" class="form-control">
								<?php 
								if($res2->num_rows>0)
								{
									while($resss = mysqli_fetch_array($res2))
									{
										echo '<option value="'.$resss['id'].'">'.$resss['nama'].'</option>';
									}
								}
								?>
							</select>
							<br>
						<label for="description">Description</label>
    					<input type="text" class="form-control" id="descriptionedit">

						</div>
							</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick = "changedata()">Save</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id = "closemodaledit">Cancel</button>
					</div>
				</div>
				</div>
		</div>
		<!-- End Modal -->
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
            url: 'process/masterkategorisubgroup.php',
            method: 'POST',
            data: { tipe: "load"  }
        },
         columns: [
            { name: 'Group', searchable: false, className: 'text-center align-middle' },
            { name: 'SubGroup', searchable: false, className: 'text-center align-middle' },
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
   function changedata(){
	var myid = $("#idchange").val();
	var group = $("#groupedit").val();
	var subgroup = $("#subgroupedit").val();
	var descriptiongroup = $("#descriptionedit").val();

	$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterkategorisubgroup.php",
                method: 'POST',
                data: {
                    tipe: "change",
                    idchange : myid,
                    descrip : descriptiongroup,
                    mygroup : group,
                    mysubgroup : subgroup
                    
                },
                success: function (result) {
					alert(result);
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
                                $("#closemodaledit").click();
                            });
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Duplicated Sub Group Name',
                            text: 'Duplicate Entry For This Sub Group',
                            confirmButtonColor: '#e00d0d',
                        });
                    }
                   
                  
                  
                }
            });

	
   }
   function openmodaledit(element){
	var idelement = element.id.split("-");
	var namagrup = $("#nama" + idelement[1]).text();
	var subgruop = $("#subgroup" + idelement[1]).text();
	var descgruop = $("#description" + idelement[1]).text();
	var indexselect = $('#groupedit option[value='+idelement[1]+']').prop('selected', true);
	$('#subgroupedit').val(subgruop);
	$('#descriptionedit').val(descgruop);
	$("#idchange").val(idelement[1]);
   }
   // Add Data
   function adddata(){
	var group = $("#groupadd").val();
    var subgroup = $('#subgroupadd').val();
    var description = $('#descriptionadd').val();
           

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterkategorisubgroup.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    descrip: description,
                    mygroup : group,
                    mysubgroup : subgroup
                    
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
                            title: 'Data Exists',
                            text: 'Duplicate Entry For This Group',
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
                url: "process/masterkategorisubgroup.php",
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