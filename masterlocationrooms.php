<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$sessionidsister = $_SESSION['idsister'];
$sql = "select lssb.idsetupsisterbranch, lssb.code, lsc.name as sistername, lbranch.branch from location_setup_sister_branch lssb 
		inner join location_sister_company lsc on lsc.id = lssb.idsistercompany 
		inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch where lsc.id = '$sessionidsister'";
$res = $conn->query($sql);
$listlocation = array();
if($res -> num_rows>0)
{
	while($r = mysqli_fetch_array($res))
	{
		$listlocation[] = $r;
	}
}
$sqlbuilding = ""
?>

		<div class="content-wrapper">
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<h4><span class="font-weight-semibold">Master Locations Rooms</span></h4>
					<div class="page-title d-flex">
						<div class="row" style="width:100%;">
							<div class="col-xl-12">
								<a href="#myModal" data-toggle="modal"><button type="button" style = "background-color:#26a69a !important; color:white; width:150px;" class="btn btn-indigo btn-labeled btn-labeled-left" onclick="cancel()" data-toggle="modal" data-target="#modal_form">
                            <b><i class="icon-plus-circle2"></i></b> Add Rooms
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


							<table id="datatable_serverside"
								class="table table-hover table-bordered display nowrap w-100">
								<thead>
									<tr>
										<th>Code</th>
										<th>Branch</th>
										<th>Building</th>
										<th>Floor</th>
										<th>Rooms</th>
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
						<h5 class="modal-title">Add Location Rooms</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
						<form id = "myform">
						<div class="form-group">
							<label for="code">Code</label>
							<input type="text" class="form-control" id="code">
							<br>

							<label for="cars">Location:</label>
							<select id="location" name="location" class="form-control">
								<?php
									for($i = 0; $i < count($listlocation); $i++)
									{
										echo "<option value = '".$listlocation[$i]['idsetupsisterbranch']."'>".Ucfirst($listlocation[$i]['sistername'])." - ".Ucfirst($listlocation[$i]['branch'])."</option>";
									}
							?>
							</select>
							<br>
							<label for="cars">Building:</label>
							<select id="building" name="building" class="form-control">

							</select>
							<br>
							<label for="cars">Floor:</label>
							<select id="floor" name="floor" class="form-control">
								<?php
                                
                                for($i = 0 ; $i < count($listfloor); $i++)
                                {
                                    echo '<option value="'.$listfloor[$i]['id'].'">'.$listfloor[$i]['floor'].'</option>';
                                }

                            ?>
							</select>
							<br>
							<label for="description">Rooms</label>
							<input type="text" class="form-control" id="rooms">
							<br>
							<label for="description">Description</label>
							<input type="text" class="form-control" id="description">
							<br>
						</div>
							</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="adddata()">Save</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceladd">Close</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="myModaledit">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background-color:#324148;color:white;height:60px;">
						<h5 class="modal-title">Edit Location Rooms</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
						<form id = "myformedit">
						<div class="form-group">
							<input type = "hidden" id = "idchange">
							<label for="code">Code</label>
							<input type="text" class="form-control" id="codeedit">
							<br>

							<label for="cars">Location:</label>
							<select id="locationedit" name="locationedit" class="form-control">
								<?php
									for($i = 0; $i < count($listlocation); $i++)
									{
										echo "<option value = '".$listlocation[$i]['idsetupsisterbranch']."'>".Ucfirst($listlocation[$i]['sistername'])." - ".Ucfirst($listlocation[$i]['branch'])."</option>";
									}
							?>
							</select>
							<br>
							<label for="cars">Building:</label>
							<select id="buildingedit" name="buildingedit" class="form-control">

							</select>
							<br>
							<label for="cars">Floor:</label>
							<select id="flooredit" name="flooredit" class="form-control">
								<?php
                                
                                for($i = 0 ; $i < count($listfloor); $i++)
                                {
                                    echo '<option value="'.$listfloor[$i]['id'].'">'.$listfloor[$i]['floor'].'</option>';
                                }

                            ?>
							</select>
							<br>
							<label for="description">Rooms</label>
							<input type="text" class="form-control" id="roomsedit">
							<br>
							<label for="description">Description</label>
							<input type="text" class="form-control" id="descriptionedit">
							<br>
						</div>
							</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="changedata()">Save</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceledit">Close</button>
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
				url: 'process/masterrooms.php',
				method: 'POST',
				data: {
					tipe: "load"
				}
			},
			columns: [
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

	// Reload table
	function success() {
		$('#datatable_serverside').DataTable().ajax.reload(null, false);
	};

	var globalsister = "";
	var globalbuilding = "";
	var globalfloor = "";

	function openmodaledit(element){

	var idelement = element.id.split("-");
	// var idsetup = idelement[2];
	var idbuilding = idelement[2];
	var idfloor = idelement[3];

	// globalsister = idsetup;
	globalbuilding = idbuilding;
	globalfloor = idfloor;

	var code = $("#code" + idelement[1]).text();
	var room = $("#room" + idelement[1]).text();
	var desc = $("#description" + idelement[1]).text();
		alert(room);
	// $('#locationedit option[value='+idsetup+']').prop('selected', true);
	// $('#locationedit').trigger('change');

	$('#codeedit').val(code);
	$("#roomsedit").val(room);
	$('#descriptionedit').val(desc);
	$("#idchange").val(idelement[1]);
	}

	function adddata(){
       var mycode = $("#code").val();
       var mylocation = $("#location").val();
	   var mybuilding = $("#building").val();
       var myfloor = $("#floor").val();
       var myrooms = $("#rooms").val();
	   var mydesc = $("#description").val();
      if(myfloor == null || mybuilding == null || mylocation == null || mycode == "" || myrooms == ""|| mydesc == "")
      {
				Swal.fire({
						icon: 'error',
						title: 'Empty Field',
						text: 'Requirement data cannot be empty',
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
                url: "process/masterrooms.php",
                method: 'POST',
                data: {

				
                    tipe: "add",
                    code : mycode,
                    location : mylocation,
                    building : mybuilding,
					floor : myfloor,
					rooms : myrooms,
                    desc : mydesc
                    
                },
                success: function (result) {
					// alert(result);
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
                            text: 'Duplicate Entry For This Rooms',
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
			url: "process/masterrooms.php",
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
	$("#location").on('change', function(){
	   var myid = this.value;
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterrooms.php",
                method: 'POST',
                data: {
                    tipe: "getbuilding",
                    idsetup : myid
                    
                },
                success: function (result) {
                    if(result == "none")
                    {
						$("#building").html("");
						
                    }
                    else{
                        $("#building").html(result).promise().done(function()
						{
							
							});
                    }
					$("#building").trigger('change');
                }
            });
   }).trigger('change');
   $("#building").on('change', function(){
	   var mysister = $("#location").val();
	   var myid = this.value;
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterrooms.php",
                method: 'POST',
                data: {
                    tipe: "getfloor",
                    idbuilding : myid,
                    idsister : mysister
                },
                success: function (result) {
                    if(result == "none")
                    {
						$("#floor").html("");
						
                    }
                    else{
                        $("#floor").html(result).promise().done(function()
						{

							});
                    }
					$("#floor").trigger('change');
                }
            });
   }).trigger('change');
   $("#locationedit").on('change', function(){
	   var myid = this.value;
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterrooms.php",
                method: 'POST',
                data: {
                    tipe: "getbuilding",
                    idsetup : myid
                    
                },
                success: function (result) {
                    if(result == "none")
                    {
						$("#buildingedit").html("");
						
                    }
                    else{
                        $("#buildingedit").html(result).promise().done(function()
						{
								if(!globalbuilding =="")
								{
									$('#buildingedit').find('option[value="'+globalbuilding+'"]').prop('selected', true);
								}
							});
                    }
					$("#buildingedit").trigger('change');
                }
            });
   }).trigger('change');
   $("#buildingedit").on('change', function(){
	   var mysister = $("#locationedit").val();
	   var myid = this.value;
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterrooms.php",
                method: 'POST',
                data: {
                    tipe: "getfloor",
                    idbuilding : myid,
                    idsister : mysister
                },
                success: function (result) {
                    if(result == "none")
                    {
						$("#flooredit").html("");
						
                    }
                    else{
                        $("#flooredit").html(result).promise().done(function()
						{
							if(!globalfloor =="")
								{
									$('#flooredit').find('option[value="'+globalfloor+'"]').prop('selected', true);
								}
						
							});
                    }
					$("#flooredit").trigger('change');
                }
            });
   }).trigger('change');

   function changedata(){
	var changeid = $("#idchange").val();
	var changecode = $("#codeedit").val();
	var changelocation = $("#locationedit").val();
       var changebuilding = $("#buildingedit").val();
	   var changefloor = $("#flooredit").val();
	   var changerooms = $("#roomsedit").val();
       var changedesc = $("#descriptionedit").val();
	 if(changecode == "" || changelocation == null || changebuilding == null || changefloor == null  || changerooms == ""
	 || changedesc == ""  )
	 {
					Swal.fire({
                        icon: 'error',
                        title: 'Empty Field',
                        text: 'Requirement data cannot be empty',
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
                url: "process/masterrooms.php",
                method: 'POST',
                data: {

                    tipe: "changedata",
					myid : changeid,
					mycode : changecode,
                    mylocation : changelocation,
					mybuilding : changebuilding,
					myfloor : changefloor,
					myrooms : changerooms,
					mydesc : changedesc
                    
                },
                success: function (result) {
					// alert(result);
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