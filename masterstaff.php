<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$sqlsistercompany = "select * from location_sister_company";
$rescompany  = $conn->query($sqlsistercompany);
$arraycompany = array();
if($rescompany -> num_rows>0)
{
	while($r = mysqli_fetch_array($rescompany))
	{
		$arraycompany[] = $r;
	}
}

$sqldivisi = "select * from divisi";
$resdivisi  = $conn->query($sqldivisi);
$arraydivisi = array();
if($resdivisi -> num_rows>0)
{
	while($s = mysqli_fetch_array($resdivisi))
	{
		$arraydivisi[] = $s;
	}
}


$sqlrank = "select * from rank";
$resrank  = $conn->query($sqlrank);
$arrayrank = array();
if($resrank -> num_rows>0)
{
	while($j = mysqli_fetch_array($resrank))
	{
		$arrayrank[] = $j;
	}
}
?>

	<!-- Main navbar -->
	
	
		<div class="content-wrapper">
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<h4><span class="font-weight-semibold">Master Personel</span></h4>
					<div class="page-title d-flex">
						<div class="row" style="width:100%;">
							<div class="col-xl-12">
							<a href="#myModal" data-toggle="modal"><button class="btn btn-info" style="background-color:#26a69a !important;width:140px;"><i
										class="icon-add"></i> &nbsp Add Personel</button></a>
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
										<th>Barcode</th>
										<th>NIK</th>
										<th>Name Employee</th>
										<th>Branch</th>
										<th>Department</th>
										<th>Rank</th>
										<th>Description</th>
										<th>Email</th>
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
						<h5 class="modal-title">Add Personel</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
						<form id = "myform">
						<div class="form-group">
							<label for="code">NIK</label>
							<input type="text" class="form-control" id="nik">
							<br>
							<label for="description">Name</label>
							<input type="text" class="form-control" id="names">
							<br>
							<label for="description">Sister Company</label>
							<select class="form-control" id="SisterCompany">
							<?php
								for($i = 0 ; $i < count($arraycompany) ;$i++)
								{
									echo "<option value = '".$arraycompany[$i]['id']."'>".$arraycompany[$i]['name']."</option>";
								}
							?>
							</select>
							<br>
							<label for="description">Branch</label>
							<select class="form-control" id="Branch">
						
							</select>
							<br>
							<label for="description">Divisi</label>
							<select class="form-control" id="Divisi">
							<?php
								for($i = 0 ; $i < count($arraydivisi) ;$i++)
								{
									echo "<option value = '".$arraydivisi[$i]['id']."'>".$arraydivisi[$i]['divisi']."</option>";
								}
							?>
							</select>
							<br>
							<label for="description">Department</label>
							<select class="form-control" id="Department">

							</select>
							<br>
							<label for="description">Rank</label>
							<select class="form-control" id="Rank">
							<?php
								for($i = 0 ; $i < count($arrayrank) ;$i++)
								{
									echo "<option value = '".$arrayrank[$i]['id']."'>".$arrayrank[$i]['rank']."</option>";
								}
							?>
							</select>
							<br>
							<label for="cars">Email:</label>
							<input type="text" class="form-control" id="Email">
							<br>
							<label for="cars">Description:</label>
							<input type="text" class="form-control" id="Description">
							
							
						</div>
							</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="adddata()">Submit</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceladd">Close</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="myModaledit">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background-color:#324148;color:white;height:60px;">
						<h5 class="modal-title">Edit Personel</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
						<form id = "myformedit">
						<div class="form-group">
							<input type = "hidden" id = "idchange">
							<label for="code">NIK</label>
							<input type="text" class="form-control" id="nikedit">
							<br>
							<label for="description">Name</label>
							<input type="text" class="form-control" id="namesedit">
							<br>
							<label for="description">Sister Company</label>
							<select class="form-control" id="SisterCompanyedit">
							<?php
								for($i = 0 ; $i < count($arraycompany) ;$i++)
								{
									echo "<option value = '".$arraycompany[$i]['id']."'>".$arraycompany[$i]['name']."</option>";
								}
							?>
							</select>
							<br>
							<label for="description">Branch</label>
							<select class="form-control" id="Branchedit">
						
							</select>
							<br>
							<label for="description">Divisi</label>
							<select class="form-control" id="Divisiedit">
							<?php
								for($i = 0 ; $i < count($arraydivisi) ;$i++)
								{
									echo "<option value = '".$arraydivisi[$i]['id']."'>".$arraydivisi[$i]['divisi']."</option>";
								}
							?>
							</select>
							<br>
							<label for="description">Department</label>
							<select class="form-control" id="Departmentedit">

							</select>
							<br>
							<label for="description">Rank</label>
							<select class="form-control" id="Rankedit">
							<?php
								for($i = 0 ; $i < count($arrayrank) ;$i++)
								{
									echo "<option value = '".$arrayrank[$i]['id']."'>".$arrayrank[$i]['rank']."</option>";
								}
							?>
							</select>
							<br>
							<label for="cars">Email:</label>
							<input type="text" class="form-control" id="Emailedit">
							<br>
							<label for="cars">Description:</label>
							<input type="text" class="form-control" id="Descriptionedit">
							
							
						</div>
							</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="changedata()">Save</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceledit">Cancel</button>
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
            url: 'process/masterstaff.php',
            method: 'POST',
            data: { tipe: "load"  }
        },
         columns: [
			{ name: 'Barcode', className: 'text-center align-middle' },
            { name: 'NIK', className: 'text-center align-middle' },
            { name: 'EmployeeName', className: 'text-center align-middle' },
            { name: 'Branch', className: 'text-center align-middle' },
			{ name: 'Department', className: 'text-center align-middle' },
			{ name: 'Rank', className: 'text-center align-middle' },
			{ name: 'Description', className: 'text-center align-middle' },
			{ name: 'Email', className: 'text-center align-middle' },
			{ name: 'Status', className: 'text-center align-middle' },
            { name: 'Action', searchable: false, orderable: false, className: 'text-center align-middle' }
            
         ]
      });
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
                url: "process/masterstaff.php",
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
var idbranchterpilih = "";
var iddepartment = "";
function openmodaledit(element){

	var idelement = element.id.split("-");
	var idsister = idelement[2];
	var idbranch = idelement[3];
	var iddivisi = idelement[4];
	var iddepart = idelement[5];
	var idrank = idelement[6];

	idbranchterpilih = idbranch;
	iddepartement = iddepart;

	var nik = $("#nik" + idelement[1]).text();
	var name = $("#name" + idelement[1]).text();
	var branc = $("#branch" + idelement[1]).text();
	var departement = $("#department" + idelement[1]).text();
	var rank = $("#rank" + idelement[1]).text();
	var email = $("#email" + idelement[1]).text();
	var desc = $("#description" + idelement[1]).text();

	$('#SisterCompanyedit option[value='+idsister+']').prop('selected', true);
	$('#Divisiedit option[value='+iddivisi+']').prop('selected', true);
	$('#Rankedit option[value='+idrank+']').prop('selected', true);
	$("#SisterCompanyedit").trigger('change');
	$("#Divisiedit").trigger('change');

	$('#nikedit').val(nik);
	$('#namesedit').val(name);
    $('#Emailedit').val(email);
	$("#Descriptionedit").val(desc);
	$("#idchange").val(idelement[1]);
   }
$("#SisterCompany").on('change', function(){
	   var myid = this.value;
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterstaff.php",
                method: 'POST',
                data: {
                    tipe: "getbranch",
                    idbranch : myid
                    
                },
                success: function (result) {
					// alert(result);
                    if(result == "none")
                    {
						$("#Branch").html("");
						// $("#subgroupedit").prop("disabled", true);
						
                    }
                    else{
                        $("#Branch").html(result).promise().done(function()
						{
							
							// if(!globalid =="")
							// {
							// 	// alert(globalid);
							// 	$('#subgroupedit').find('option[value="'+globalid+'"]').prop('selected', true);
							// }
							});
                    }
                   
                  
                  
                }
            });
   }).trigger('change');
   $("#SisterCompanyedit").on('change', function(){
	   var myid = this.value;
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterstaff.php",
                method: 'POST',
                data: {
                    tipe: "getbranch",
                    idbranch : myid
                    
                },
                success: function (result) {
					// alert(result);
                    if(result == "none")
                    {
						$("#Branchedit").html("");
						// $("#subgroupedit").prop("disabled", true);
						
                    }
                    else{
                        $("#Branchedit").html(result).promise().done(function()
						{
							
							if(!idbranchterpilih =="")
							{
								// alert(globalid);
								$('#Branchedit').find('option[value="'+idbranchterpilih+'"]').prop('selected', true);
							}
							});
                    }
                   
                  
                  
                }
            });
   }).trigger('change');
   $("#Divisiedit").on('change', function(){
	   var myid = this.value;
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterstaff.php",
                method: 'POST',
                data: {
                    tipe: "getdepartment",
                    iddivisi : myid
                    
                },
                success: function (result) {
                    if(result == "none")
                    {
						$("#Departmentedit").html("");
						
                    }
                    else{
                        $("#Departmentedit").html(result).promise().done(function()
						{
							if(!iddepartment =="")
							{
								// alert(globalid);
								$('#Departmentedit').find('option[value="'+iddepartement+'"]').prop('selected', true);
							}
							});
                    }
                   
                  
                  
                }
            });
   }).trigger('change');
   $("#Divisi").on('change', function(){
	   var myid = this.value;
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterstaff.php",
                method: 'POST',
                data: {
                    tipe: "getdepartment",
                    iddivisi : myid
                    
                },
                success: function (result) {
                    if(result == "none")
                    {
						$("#Department").html("");
						
                    }
                    else{
                        $("#Department").html(result).promise().done(function()
						{
							
							});
                    }
                   
                  
                  
                }
            });
   }).trigger('change');

   function adddata(){
	var nik = $("#nik").val();
    var name = $('#names').val();
	var sister = $('#SisterCompany').val();
	var branch = $('#Branch').val();
	var divisi = $('#Divisi').val();
	var depart = $('#Department').val();
	var rank = $('#Rank').val();
	var email = $('#Email').val();
    var description = $('#Description').val();
    if(nik == "" || name == "" || branch == null || depart == null || rank == null || email == "" || description == "")
    {
                         Swal.fire({
                            icon: 'error',
                            title: 'Empty Field',
                            text: 'Nik / Name / Branch / Department / Rank / Email / Description tidak boleh kosong',
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
                url: "process/masterstaff.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    mynik: nik,
					myname: name,
					mysister : sister,
                    mybranch : branch,
					mydivisi : divisi,
					mydepart : depart,
					myrank : rank,
					myemail : email,
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
                                $("#myform").trigger("reset");
                                $("#canceladd").click();
                            });
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Exists',
                            text: 'Duplicate Entry For This NIK',
                            confirmButtonColor: '#e00d0d',
                        });
                    }
                  
                  
                }
            });
    }

           
}

function changedata(){
	 var changeid = $("#idchange").val();
	 var changenik = $("#nikedit").val();
	 var changenames = $("#namesedit").val();
	 var changesister = $("#SisterCompanyedit").val();
	 var changebranch = $("#Branchedit").val();
	 var changedivisi = $("#Divisiedit").val();
	 var changedepartment = $("#Departmentedit").val();
	 var changerank = $("#Rankedit").val();
	 var changeemail = $("#Emailedit").val();
	 var changedescription = $('#Descriptionedit').val();
	 if(changenik == "" || changenames == "" || changesister == null || changebranch == null || changedivisi == null || 
	 	changedepartment == null || changerank == null || changeemail == "" || changedescription == "" )
	 {
						Swal.fire({
                            icon: 'error',
                            title: 'Empty Field',
                            text: 'Nik / Employee Name / Branch / Department / Rank / Email / Description Tidak Boleh Kosong',
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
                url: "process/masterstaff.php",
                method: 'POST',
                data: {
                    tipe: "changedata",
					myid : changeid,
					mynik: changenik,
                    myname : changenames,
					mysister : changesister,
					mybranch : changebranch,
                    mydivisi : changedivisi,
					mydepart : changedepartment,
					myrank : changerank,
					myemail : changeemail,
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
                            title: 'Duplicated Employee Data',
                            text: 'Duplicate Entry For This Employee Data',
                            confirmButtonColor: '#e00d0d',
                        });
					}
                 
                   
                  
                  
                }
            });
	 }
   }
</script>