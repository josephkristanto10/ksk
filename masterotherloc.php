<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$sql = "select * FROM city";
$res = $conn->query($sql);
$listcity = array();
if($res->num_rows>0)
{
	while($r = mysqli_fetch_array($res))
	{
		$listcity[] = $r;
	}
}
?>

		<div class="content-wrapper">
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<h4><span class="font-weight-semibold">Master Other Locations</span></h4>
					<div class="page-title d-flex">
						<div class="row" style="width:100%;">
							<div class="col-xl-12">
							<a href="#myModal" data-toggle="modal"> <button class="btn btn-info" style="background-color:#26a69a !important;width:120px;"><i
										class="icon-add"></i> &nbsp Add Other</button></a>
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
										<th>Location Name</th>
										<th>City</th>
										<th>Desc1</th>
										<th>Desc2</th>
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
						<h5 class="modal-title">Add Other Location</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
                        <form id = "myform">
						<div class="form-group">
							<label for="code">Location Name</label>
							<input type="text" class="form-control" id="name">                            
							<br>
							<label for="description">City</label>
							<select class="form-control" id="city">
								<?php
								for($i = 0 ; $i < count($listcity) ; $i++)
								{
									echo "<option value = '".$listcity[$i]['id']."'>".$listcity[$i]['name']."</option>";
								}
								?>
                            </select>
							<br>
							<label for="description">Description1</label>
							<input type="text" class="form-control" id="description1">
							<br>
							<br>
							<label for="description">Description2</label>
							<input type="text" class="form-control" id="description2">
					
							<br>
                            
							<br>
							
							
							<div style = "float:right;margin-bottom:20px;">
							<button type="button" class="btn btn-primary" style = "margin-right:10px;" onclick="adddata()">Save</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceladd" >Cancel</button>
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
						<h5 class="modal-title">Edit Other Location</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
                        <form id = "myformedit">
						<div class="form-group">
							<input type = "hidden" id = "idchange">
							<label for="code">Location Name</label>
							<input type="text" class="form-control" id="nameedit">                            
							<br>
							<label for="description">City</label>
							<select class="form-control" id="cityedit">
								<?php
								for($i = 0 ; $i < count($listcity) ; $i++)
								{
									echo "<option value = '".$listcity[$i]['id']."'>".$listcity[$i]['name']."</option>";
								}
								?>
                            </select>
							<br>
							<label for="description">Description1</label>
							<input type="text" class="form-control" id="description1edit">
							<br>
							<label for="description">Description2</label>
							<input type="text" class="form-control" id="description2edit">
					
							<br>
                            
							<br>
							
							
							<div style = "float:right;margin-bottom:20px;">
							<button type="button" class="btn btn-primary" style = "margin-right:10px;" onclick="changedata()">Save</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceledit" >Cancel</button>
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
            url: 'process/masterotherloc.php',
            method: 'POST',
            data: { tipe: "load"  }
        },
         columns: [
            { name: 'name', className: 'text-center align-middle' },
            { name: 'city', className: 'text-center align-middle' },
            { name: 'desc1', className: 'text-center align-middle' },
            { name: 'desc2', className: 'text-center align-middle' },
            { name: 'status', searchable: false, className: 'text-center align-middle' },
            { name: 'Action', searchable: false, orderable: false, className: 'text-center align-middle' }
            
         ]
      });
   };

   // Reload table
   function success() {
      $('#datatable_serverside').DataTable().ajax.reload(null, false);
   };
   function openmodaledit(element){

		var idelement = element.id.split("-");
		var idother = idelement[1];
		var idcity = idelement[2];

		var code = $("#locationname" + idelement[1]).text();
		var name = $("#desc1" + idelement[1]).text();
		var description = $("#desc2" + idelement[1]).text();

		$('#cityedit option[value='+idcity+']').prop('selected', true);

		$('#nameedit').val(code);
		$('#description1edit').val(name);
		$('#description2edit').val(description);
		$("#idchange").val(idelement[1]);
	}
   function adddata(){
       var myname = $("#name").val();
       var mycity = $("#city").val();
       var mydesc1 = $("#description1").val();
       var mydesc2 = $("#description2").val();
      if(mycity == null ||  myname == ""|| mydesc1 == ""|| mydesc2 == "")
      {
                      Swal.fire({
                            icon: 'error',
                            title: 'Empty Field',
                            text: ' City / Location Name / Description Cannot Be Empty',
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
                url: "process/masterotherloc.php",
                method: 'POST',
                data: {
				
                    tipe: "add",
                    name : myname,
                    city : mycity,
                    desc1 : mydesc1,
                    desc2 : mydesc2
                    
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
                            text: 'Duplicate Entry For This Code & Name',
                            confirmButtonColor: '#e00d0d',
                        });
                    }
                  
                  
                }
            });

      }
    

   }
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
                url: "process/masterotherloc.php",
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
function changedata(){
	 var changeid = $("#idchange").val();
     var changelocationname = $("#nameedit").val();
	 var changecity = $("#cityedit").val();
	 var changedesc1 = $("#description1edit").val();
	 var changedesc2 = $("#description2edit").val();
	 if(changelocationname == "" ||  changecity == null  || changedesc1 == ""  || changedesc2 == "" )
	 {
						Swal.fire({
                            icon: 'error',
                            title: 'Empty Field',
                            text: 'Location Name / City / Description 1 & 2 Cannot Be Empty',
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
                url: "process/masterotherloc.php",
                method: 'POST',
                data: {

                    tipe: "changedata",
					myid : changeid,
					mylocationname: changelocationname,
                    mycity : changecity,
					mydesc1 : changedesc1,
					mydesc2 : changedesc2
                    
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
                            title: 'Duplicated Employee Data',
                            text: 'Duplicate Entry For Other location',
                            confirmButtonColor: '#e00d0d',
                        });
					}
                 
                   
                  
                  
                }
            });
	 }
   }
   </script>