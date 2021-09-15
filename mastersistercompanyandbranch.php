<?php
require_once 'layout/header.php';
require_once 'layout/footer.php';
require_once 'layout/sidebar.php';
$sessionidsister = $_SESSION['idsister'];
$sqlsister = "select * from location_sister_company where id = '".$sessionidsister."'";
$sqlbranch = "select * from location_branch";

$ressister = $conn->query($sqlsister);
$resbranch = $conn->query($sqlbranch);

$listsister = array();
$listbranch = array();

if($ressister->num_rows>0)
{
	while($r = mysqli_fetch_array($ressister))
	{
		$listsister[] = $r;
	}
}
if($resbranch->num_rows>0)
{
	while($r = mysqli_fetch_array($resbranch))
	{
		$listbranch[] = $r;
	}
}


?>

		<div class="content-wrapper">
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<h4><span class="font-weight-semibold">Setup Sister Company & Branch</span></h4>
					<div class="page-title d-flex">
						<div class="row" style="width:100%;">
							<div class="col-xl-12">
							<a href="#myModal" data-toggle="modal"><button class="btn btn-info" style="background-color:#26a69a !important;width:150px;"><i
										class="icon-add"></i> &nbsp Setup Sister Company & Branch </button></a>
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
										<th>Code</th>
										<th>Sister Company</th>
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
						<h5 class="modal-title">Add Sister & Branch</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
						<div class="form-group">
						<label for="code">Code</label>
    					<input type="text" class="form-control" id="code" disabled>
						<br>
					
							<label for="cars">Sister Company:</label>
							<select id="sister" name="sister" class="form-control">
							<?php 
									for($i = 0 ; $i < count($listsister); $i++)
									{
										echo '<option value="'.$listsister[$i]['id'].'">'.$listsister[$i]['code'].' - '.$listsister[$i]['name'].'</option>';
									}
								?>
							</select>
							<br>
							<label for="cars">Branch:</label>
							<select id="branch" name="branch" class="form-control">
							<?php 
									for($i = 0 ; $i < count($listbranch); $i++)
									{
										echo '<option value="'.$listbranch[$i]['idbranch'].'">'.$listbranch[$i]['code'].' - '.$listbranch[$i]['branch'].'</option>';
									}
								?>
							</select>
							<br>
						<label for="description">Description</label>
    					<input type="text" class="form-control" id="description">

						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick = "adddata()">Submit</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceladd">Close</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="myModaledit">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background-color:#324148;color:white;height:60px;">
						<h5 class="modal-title">Edit Sister & Branch</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
						<form id = "myformedit">
						<div class="form-group">
							<input type = "hidden" id = "idchange">
						<label for="code">Code</label>
    					<input type="text" class="form-control" id="codeedit" disabled>
						<br>
					
							<label for="cars">Sister Company:</label>
							<select id="sisteredit" name="sisteredit" class="form-control">
							<?php 
									for($i = 0 ; $i < count($listsister); $i++)
									{
										echo '<option value="'.$listsister[$i]['id'].'">'.$listsister[$i]['code'].' - '.$listsister[$i]['name'].'</option>';
									}
								?>
							</select>
							<br>
							<label for="cars">Branch:</label>
							<select id="branchedit" name="branchedit" class="form-control">
							<?php 
									for($i = 0 ; $i < count($listbranch); $i++)
									{
										echo '<option value="'.$listbranch[$i]['idbranch'].'">'.$listbranch[$i]['code'].' - '.$listbranch[$i]['branch'].'</option>';
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
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceledit">Cancel</button>
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
            url: 'process/mastersetupsisterbranch.php',
            method: 'POST',
            data: { tipe: "load"  }
        },
         columns: [
            { name: 'Code', searchable: false, className: 'text-center align-middle' },
            { name: 'SisterCompany', searchable: false, className: 'text-center align-middle' },
            { name: 'Branch', className: 'text-center align-middle' },
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

   var globalsister = "";
   var globalbranch = "";
   function openmodaledit(element){

	var idelement = element.id.split("-");
	var idsister = idelement[2];
	var idbranch = idelement[3];

	globalsister = idsister;
	globalbranch = idbranch;

	var code = $("#code" + idelement[1]).text();
	var desc = $("#desc" + idelement[1]).text();

	$('#sisteredit option[value='+idsister+']').prop('selected', true);
	$('#branchedit option[value='+idbranch+']').prop('selected', true);
	$("#sisteredit").trigger('change');
	$("#branchedit").trigger('change');

	// $('#codeedit').val(code);
	$('#descriptionedit').val(desc);
	$("#idchange").val(idelement[1]);
}

function adddata(){
       var mycode = $("#code").val();
       var mysister = $("#sister").val();
       var mybranch = $("#branch").val();
       var mydesc = $("#description").val();
      if(mysister == null || mybranch == null || mycode == ""|| mydesc == "")
      {
                      Swal.fire({
                            icon: 'error',
                            title: 'Empty Field',
                            text: 'Branch / Description tidak boleh kosong',
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
                url: "process/mastersetupsisterbranch.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    code : mycode,
                    sister : mysister,
                    branch : mybranch,
                    desc : mydesc
                    
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
   $("#sister").on('change', function(){
	//    var mytext = this.options.text;
		var branch = document.getElementById("branch");
	   var stringbranch = (branch.options[branch.selectedIndex].text).split(" - ");
	   var sister = document.getElementById("sister");
	   var stringsister = (sister.options[sister.selectedIndex].text).split(" - ");
	   var kodebranch = stringbranch[0];
	   $("#code").val(stringsister[0] + " - " + kodebranch);
   }).trigger('change');

   $("#branch").on('change', function(){
	//    var mytext = this.options.text;
	   var stringbranch = (this.options[this.selectedIndex].text).split(" - ");
	   var sister = document.getElementById("sister");
	   var stringsister = (sister.options[sister.selectedIndex].text).split(" - ");
	   var kodebranch = stringbranch[0];
	   $("#code").val(stringsister[0] + " - " + kodebranch);
   }).trigger('change');
   $("#sisteredit").on('change', function(){
	//    var mytext = this.options.text;
		var branch = document.getElementById("branchedit");
	   var stringbranch = (branch.options[branch.selectedIndex].text).split(" - ");
	   var sister = document.getElementById("sisteredit");
	   var stringsister = (sister.options[sister.selectedIndex].text).split(" - ");
	   var kodebranch = stringbranch[0];
	   $("#codeedit").val(stringsister[0] + " - " + kodebranch);
   }).trigger('change');

   $("#branchedit").on('change', function(){
	//    var mytext = this.options.text;
	   var stringbranch = (this.options[this.selectedIndex].text).split(" - ");
	   var sister = document.getElementById("sisteredit");
	   var stringsister = (sister.options[sister.selectedIndex].text).split(" - ");
	   var kodebranch = stringbranch[0];
	   $("#codeedit").val(stringsister[0] + " - " + kodebranch);
   }).trigger('change');

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
                url: "process/mastersetupsisterbranch.php",
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
	var changecode = $("#codeedit").val();
       var changesister = $("#sisteredit").val();
       var changebranch = $("#branchedit").val();
       var changedesc = $("#descriptionedit").val();
	 if(changecode == "" || changedesc == "" || changesister == null  || changebranch == null  )
	 {
						Swal.fire({
                            icon: 'error',
                            title: 'Empty Field',
                            text: 'Code / Sister Company / Branch / Description Tidak Boleh Kosong',
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
                url: "process/mastersetupsisterbranch.php",
                method: 'POST',
                data: {
                    tipe: "changedata",
					myid : changeid,
					mycode : changecode,
                    mysister : changesister,
					mybranch : changebranch,
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