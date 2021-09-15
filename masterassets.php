<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$sqlasset = "select * from kategori_asset";
$resasset  = $conn->query($sqlasset);
$myasset = array();
if($resasset -> num_rows>0)
{
	while($j = mysqli_fetch_array($resasset))
	{
		$myasset[] = $j;
	}
}
$sqlinitial = "select * from initial_condition";
$resinitial  = $conn->query($sqlinitial);
$myinitial = array();
if($resinitial -> num_rows>0)
{
	while($j = mysqli_fetch_array($resinitial))
	{
		$myinitial[] = $j;
	}
}
$sqlconditions = "select * from conditions";
$resconditions  = $conn->query($sqlconditions);
$myconditions = array();
if($resconditions -> num_rows>0)
{
	while($j = mysqli_fetch_array($resconditions))
	{
		$myconditions[] = $j;
	}
}
?>

	<!-- Main navbar -->
	
	
		<div class="content-wrapper">
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<h4><span class="font-weight-semibold">Master Assets</span></h4>
					<div class="page-title d-flex">
						<div class="row" style="width:100%;">
							<div class="col-xl-12">
							<a href="#myModal" data-toggle="modal"><button class="btn btn-info" style="background-color:#26a69a !important;width:140px;"><i
										class="icon-add"></i> &nbsp Add Assets</button></a>
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
										<th>SubGroup</th>
										<th>Category</th>
                                        <th>Initial Condition</th>
										<th>Condition</th>
										<th>No Asset</th>
										<th>Name</th>
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
						<h5 class="modal-title">Add Assets</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
						<form id = "myform">
						<div class="form-group">
                        <label for="idgroup">Sister Company</label><input type="text" class = "form-control" name="idgroup" id="idgroup" value = "<?php echo $_SESSION['namasister']; ?>" disabled />
                        <br class="clear" /> 
                        <label for="idgroup">Group</label>
                        <select class="form-control" id="group">
                                <?php
                                for($i = 0 ; $i < count($myasset); $i++)
                                {
                                    echo '<option value = "'.$myasset[$i]['id'].'">'.$myasset[$i]['nama'].'</option>';
                                }
                                ?>
                            </select>
                        <br class="clear" /> 
                        <label for="idsubgroup">Subgroup</label>
                        <select class="form-control" id="subgroup">
                            </select>
                        <br class="clear" /> 
                        <label for="idcategory">Category</label>
                        <select class="form-control" id="category">
                            </select>
                        <br class="clear" /> 
                        <label for="idinitialcondition">Initial Condition</label>
                        <select class="form-control" id="initialcondition">
                                <?php
                                for($i = 0 ; $i < count($myinitial); $i++)
                                {
                                    echo '<option value = "'.$myinitial[$i]['id'].'">'.$myinitial[$i]['initial_condition'].'</option>';
                                }
                                ?>
                            </select>
                        <br class="clear" /> 
                        <label for="idcondition">Condition</label>
                        <select class="form-control" id="condition">
                                <?php
                                for($i = 0 ; $i < count($myconditions); $i++)
                                {
                                    echo '<option value = "'.$myconditions[$i]['id'].'">'.$myconditions[$i]['name'].'</option>';
                                }
                                ?>
                            </select>
                        <br class="clear" /> 
                        <label for="noasset">No Asset</label><input type="text" class = "form-control"  name="noasset" id="noasset" />
                        <br class="clear" /> 
                        <label for="name">Name</label><input type="text" class = "form-control"  name="name" id="name" />
                        <br class="clear" />  
                        <br class="clear" /> 
							
						</div>
							</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="adddata()">Save</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceladd">Cancel</button>
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
							<label for="idgroup">Sister Company</label><input type="text" class = "form-control" name="idgroup" id="idgroup" value = "<?php echo $_SESSION['namasister']; ?>" disabled />
                        <br class="clear" /> 
                        <label for="idgroup">Group</label>
                        <select class="form-control" id="groupedit">
                                <?php
                                for($i = 0 ; $i < count($myasset); $i++)
                                {
                                    echo '<option value = "'.$myasset[$i]['id'].'">'.$myasset[$i]['nama'].'</option>';
                                }
                                ?>
                            </select>
                        <br class="clear" /> 
                        <label for="idsubgroup">Subgroup</label>
                        <select class="form-control" id="subgroupedit">
                            </select>
                        <br class="clear" /> 
                        <label for="idcategory">Category</label>
                        <select class="form-control" id="categoryedit">
                            </select>
                        <br class="clear" /> 
                        <label for="idinitialcondition">Initial Condition</label>
                        <select class="form-control" id="initialconditionedit">
                                <?php
                                for($i = 0 ; $i < count($myinitial); $i++)
                                {
                                    echo '<option value = "'.$myinitial[$i]['id'].'">'.$myinitial[$i]['initial_condition'].'</option>';
                                }
                                ?>
                            </select>
                        <br class="clear" /> 
                        <label for="idcondition">Condition</label>
                        <select class="form-control" id="conditionedit">
                                <?php
                                for($i = 0 ; $i < count($myconditions); $i++)
                                {
                                    echo '<option value = "'.$myconditions[$i]['id'].'">'.$myconditions[$i]['name'].'</option>';
                                }
                                ?>
                            </select>
                        <br class="clear" /> 
                        <label for="noasset">No Asset</label><input type="text" class = "form-control"  name="noasset" id="noassetedit" />
                        <br class="clear" /> 
                        <label for="name">Name</label><input type="text" class = "form-control"  name="name" id="nameedit" />
                        <br class="clear" />  
                        <br class="clear" /> 
							
							
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
            url: 'process/masterassets.php',
            method: 'POST',
            data: { tipe: "load"  }
        },
         columns: [
			{ name: 'Group', className: 'text-center align-middle' },
            { name: 'SubGroup', className: 'text-center align-middle' },
            { name: 'Category', className: 'text-center align-middle' },
            { name: 'No Asset', className: 'text-center align-middle' },
			{ name: 'Name', className: 'text-center align-middle' },
			{ name: 'Initial Condition', className: 'text-center align-middle' },
			{ name: 'Condition', className: 'text-center align-middle' },
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
                url: "process/masterassets.php",
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
var globalsubgroup = "";
var globalcategory = "";
function openmodaledit(element){
    // click-'.$row['id'].'-'.$row['idgroup'].'-'.$row['idsubgroup'].'-'.$row['idcategory'].'-'.
    // $row['idinitialcondition'].'-'.$row['idcondition'].'"
	var idelement = element.id.split("-");
	var idgroup = idelement[2];
	var idsubgroup = idelement[3];
	var idcategory = idelement[4];
	var idinitialcondition = idelement[5];
	var idcondition = idelement[6];
    

    globalsubgroup = idsubgroup;
    globalcategory = idcategory;


	var noasset = $("#noasset" + idelement[1]).text();
	var name = $("#name" + idelement[1]).text();
    $("#noassetedit").val(noasset);
    $("#nameedit").val(name);
	$('#groupedit option[value='+idgroup+']').prop('selected', true);
	$('#initialconditionedit option[value='+idinitialcondition+']').prop('selected', true);
	$('#conditionedit option[value='+idcondition+']').prop('selected', true);
	$("#groupedit").trigger('change');
	$("#idchange").val(idelement[1]);
   }
$("#group").on('change', function(){
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
                    idgroup : myid
                    
                },
                success: function (result) {
					// alert(result);
                    if(result == "none")
                    {
						$("#subgroup").html("");
						
                    }
                    else{
                        $("#subgroup").html(result).promise().done(function()
						{
							
							
							});
                    }
                    $("#subgroup").trigger('change');
                  
                  
                }
            });
   }).trigger('change');
   $("#subgroup").on('change', function(){
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
                    idsubgroup : myid
                    
                },
                success: function (result) {
					// alert(result);
                    if(result == "none")
                    {
						$("#category").html("");
                    }
                    else{
                        $("#category").html(result).promise().done(function()
						{
							});
                    }
                }
            });
   }).trigger('change');
   $("#groupedit").on('change', function(){
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
                    idgroup : myid
                    
                },
                success: function (result) {
					// alert(result);
                    if(result == "none")
                    {
						$("#subgroupedit").html("");
						
                    }
                    else{
                        $("#subgroupedit").html(result).promise().done(function()
						{
                                if(!globalsubgroup =="")
                                {
                                    // alert(globalid);
                                    $('#subgroupedit').find('option[value="'+globalsubgroup+'"]').prop('selected', true);
                                }
							
							});
                    }
                    $("#subgroupedit").trigger('change');
                  
                  
                }
            });
   }).trigger('change');
   $("#subgroupedit").on('change', function(){
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
                    idsubgroup : myid
                    
                },
                success: function (result) {
					// alert(result);
                    if(result == "none")
                    {
						$("#categoryedit").html("");
                    }
                    else{
                        $("#categoryedit").html(result).promise().done(function()
						{
                            if(!globalcategory =="")
                                {
                                    // alert(globalid);
                                    $('#categoryedit').find('option[value="'+globalcategory+'"]').prop('selected', true);
                                }
							});
                    }
                }
            });
   }).trigger('change');

   function adddata(){
	var group = $("#group").val();
    var subgroup = $('#subgroup').val();
	var category = $('#category').val();
	var initialcondition = $('#initialcondition').val();
	var condition = $('#condition').val();
	var noasset = $('#noasset').val();
	var name = $('#name').val();
    if(noasset == "" || name == "" || group == null || subgroup == null || category == null || initialcondition == null || condition == null)
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
                url: "process/masterassets.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    group: group,
					subgroup: subgroup,
					category : category,
                    initialcondition : initialcondition,
					condition : condition,
					noasset : noasset,
					name : name
                    
                },
                success: function (result) {
                //    alert(result);
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
                            text: 'Duplicate Entry For This Asset',
                            confirmButtonColor: '#e00d0d',
                        });
                    }
                  
                  
                }
            });
    }

           
}

function changedata(){
    var changeid = $("#idchange").val();
    var group = $("#groupedit").val();
    var subgroup = $('#subgroupedit').val();
	var category = $('#categoryedit').val();
	var initialcondition = $('#initialconditionedit').val();
	var condition = $('#conditionedit').val();
	var noasset = $('#noassetedit').val();
	var name = $('#nameedit').val();
    if(noasset == "" || name == "" || group == null || subgroup == null || category == null || initialcondition == null || condition == null)
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
                url: "process/masterassets.php",
                method: 'POST',
                data: {
                    tipe: "changedata",
					myid : changeid,
                    group: group,
					subgroup: subgroup,
					category : category,
                    initialcondition : initialcondition,
					condition : condition,
					noasset : noasset,
					name : name
                    
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
                            title: 'Data Exists',
                            text: 'Duplicate Entry For This Assets',
                            confirmButtonColor: '#e00d0d',
                        });
					}
                 
                   
                  
                  
                }
            });
	 }
   }

   
</script>