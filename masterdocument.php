<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$idsister = $_SESSION['idsister'];
$sqlbranch = "select lbranch.idbranch, lbranch.branch from location_setup_sister_branch inner join location_branch lbranch on lbranch.idbranch = location_setup_sister_branch.idbranch where location_setup_sister_branch.idsistercompany = '$idsister'";
$resbranch  = $conn->query($sqlbranch);
$mybranch = array();
if($resbranch -> num_rows>0)
{
	while($j = mysqli_fetch_array($resbranch))
	{
		$mybranch[] = $j;
	}
}
$sqldivisi = "select * from divisi";
$resdivisi = $conn->query($sqldivisi);
$mydivisi = array();
if($resdivisi -> num_rows>0)
{
	while($j = mysqli_fetch_array($resdivisi))
	{
		$mydivisi[] = $j;
	}
}

?>

	<!-- Main navbar -->
	
	
		<div class="content-wrapper">
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<h4><span class="font-weight-semibold">Master Document</span></h4>
					<div class="page-title d-flex">
						<div class="row" style="width:100%;">
							<div class="col-xl-12">
							<a href="#myModal" data-toggle="modal"><button class="btn btn-info" style="background-color:#26a69a !important;width:140px;"><i
										class="icon-add"></i> &nbsp Add Document</button></a>
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
										<th>Branch</th>
										<th>Division</th>
                                        <th>Department</th>
										<th>Document</th>
										<th>Document Date</th>
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
						<h5 class="modal-title">Add Document</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
						<form id = "myform">
						<div class="form-group">
                        <label for="idsistercompany">sistercompany</label><input type="text" class = "form-control" name="idsistercompany" id="idsistercompany" value = "<?php echo $_SESSION['namasister'];?>" disabled />
                        <br class="clear" /> 
                        <label for="code">Code</label><input type="text" class = "form-control" name="code" id="code" />
                        <br class="clear" /> 
                        <label for="idbranch">branch</label>
                        <select class="form-control" id="idbranch">
                                <?php
                                for($i = 0 ; $i < count($mybranch); $i++)
                                {
                                    echo '<option value = "'.$mybranch[$i]['idbranch'].'">'.$mybranch[$i]['branch'].'</option>';
                                }
                                ?>
                        </select>
                        <br class="clear" /> 
                        <label for="iddivisi">divisi</label>
                        <select class="form-control" id="iddivisi">
                                <?php
                                for($i = 0 ; $i < count($mydivisi); $i++)
                                {
                                    echo '<option value = "'.$mydivisi[$i]['id'].'">'.$mydivisi[$i]['divisi'].'</option>';
                                }
                                ?>
                        </select>
                        <br class="clear" /> 
                        <label for="iddepartement">departement</label>
                        <select class="form-control" id="iddepartment">
                        </select>
                        <br class="clear" /> 
                        <label for="name">Name</label><input type="text" class = "form-control" name="name" id="name" />
                        <br class="clear" /> 
                        <label for="tanggaldokumen">Tanggaldokumen</label><input type="text" class = "form-control pickadate" name="tanggaldokumen" id="tanggaldokumen" />
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
						<h5 class="modal-title">Edit Document</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
						<form id = "myformedit">
						<div class="form-group">
							<input type = "hidden" id = "idchange">
							<label for="idgroup">Sister Company</label><input type="text" class = "form-control"  value = "<?php echo $_SESSION['namasister']; ?>" disabled />
                        <br class="clear" /> 
                        <label for="code">Code</label><input type="text" class = "form-control" name="code" id="codeedit" />
                        <br class="clear" /> 
                        <label for="idbranch">branch</label>
                        <select class="form-control" id="idbranchedit">
                                <?php
                                for($i = 0 ; $i < count($mybranch); $i++)
                                {
                                    echo '<option value = "'.$mybranch[$i]['idbranch'].'">'.$mybranch[$i]['branch'].'</option>';
                                }
                                ?>
                        </select>
                        <br class="clear" /> 
                        <label for="iddivisi">divisi</label>
                        <select class="form-control" id="iddivisiedit">
                                <?php
                                for($i = 0 ; $i < count($mydivisi); $i++)
                                {
                                    echo '<option value = "'.$mydivisi[$i]['id'].'">'.$mydivisi[$i]['divisi'].'</option>';
                                }
                                ?>
                        </select>
                        <br class="clear" /> 
                        <label for="iddepartement">departement</label>
                        <select class="form-control" id="iddepartmentedit">
                        </select>
                        <br class="clear" /> 
                        <label for="name">Name</label><input type="text" class = "form-control" name="name" id="nameedit" />
                        <br class="clear" /> 
                        <label for="tanggaldokumen">Tanggaldokumen</label><input type="text" class = "form-control pickadate" name="tanggaldokumen" id="tanggaldokumenedit" />
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
      $('#tanggaldokumen').pickadate({
        format: 'yyyy-mm-dd'
      });
      $('#tanggaldokumenedit').pickadate({
        format: 'yyyy-mm-dd'
      });
      
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
            url: 'process/masterdocument.php',
            method: 'POST',
            data: { tipe: "load"  }
        },
         columns: [
			{ name: 'Code', className: 'text-center align-middle' },
            { name: 'Branch', className: 'text-center align-middle' },
            { name: 'Divisi', className: 'text-center align-middle' },
            { name: 'Department', className: 'text-center align-middle' },
			{ name: 'Document', className: 'text-center align-middle' },
			{ name: 'Date', className: 'text-center align-middle' },
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
                url: "process/masterdocument.php",
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
var globaldepartment = "";
function openmodaledit(element){
   

    // $row['id'].'-'.$row['idsistercompany'].'-'.$row['idbranch'].'-'.$row['iddivisi'].'-'.$row['iddepartement']
	var idelement = element.id.split("-");
	var idbranch = idelement[3];
	var iddivisi = idelement[4];
	var iddepartement = idelement[5];
    globaldepartment = iddepartement;
 
    var code = $("#code" + idelement[1]).text();
	var tanggaldokumen = $("#tanggaldokumen" + idelement[1]).text();
	var name = $("#name" + idelement[1]).text();
    $("#codeedit").val(code);
    $("#tanggaldokumenedit").val(tanggaldokumen);
    $("#nameedit").val(name);
	$('#idbranchedit option[value='+idbranch+']').prop('selected', true);
	$('#iddivisiedit option[value='+iddivisi+']').prop('selected', true);
	$("#iddivisiedit").trigger('change');
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
	var code = $("#code").val();
    var idbranch = $('#idbranch').val();
	var iddivisi = $('#iddivisi').val();
	var iddepartement = $('#iddepartment').val();
	var name = $('#name').val();
	var tanggaldokumen = $('#tanggaldokumen').val();
    if(code == "" || name == "" || tanggaldokumen == "" || idbranch == null || iddivisi == null || iddepartement == null)
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
                url: "process/masterdocument.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    code: code,
					idbranch: idbranch,
					iddivisi : iddivisi,
                    iddepartement : iddepartement,
					name : name,
					tanggaldokumen : tanggaldokumen
                    
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
                            text: 'Duplicate Entry For This Document',
                            confirmButtonColor: '#e00d0d',
                        });
                    }
                  
                  
                }
            });
    }

           
}

function changedata(){
    var changeid = $("#idchange").val();
    var codeedit = $("#codeedit").val();
    var branchedit = $('#idbranchedit').val();
	var iddivisiedit = $('#iddivisiedit').val();
	var iddepartmentedit = $('#iddepartmentedit').val();
	var name = $('#nameedit').val();
	var tanggaldokumen = $('#tanggaldokumenedit').val();
    if(codeedit == "" || name == "" || tanggaldokumen == "" || branchedit == null || iddivisiedit == null || iddepartmentedit == null )
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
                url: "process/masterdocument.php",
                method: 'POST',
                data: {

               
                    tipe: "changedata",
					myid : changeid,
                    code: codeedit,
					branch: branchedit,
					divisi : iddivisiedit,
                    department : iddepartmentedit,
					name : name,
					tanggal : tanggaldokumen
                    
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

   $("#iddivisi").on('change', function(){
	   var myid = this.value;
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterdocument.php",
                method: 'POST',
                data: {
                    tipe: "getdepartment",
                    iddivisi : myid
                    
                },
                success: function (result) {
                    if(result == "none")
                    {
						$("#iddepartment").html("");
						
                    }
                    else{
                        $("#iddepartment").html(result).promise().done(function()
						{
							
							});
                    }
                   
                  
                  
                }
            });
   }).trigger('change');
   $("#iddivisiedit").on('change', function(){
	   var myid = this.value;
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterdocument.php",
                method: 'POST',
                data: {
                    tipe: "getdepartment",
                    iddivisi : myid
                    
                },
                success: function (result) {
                    if(result == "none")
                    {
						$("#iddepartmentedit").html("");
						
                    }
                    else{
                        $("#iddepartmentedit").html(result).promise().done(function()
						{
                          
                                if(!globaldepartment=="")
                                {
                                   
                                    $('#iddepartmentedit').find('option[value="'+globaldepartment+'"]').prop('selected', true);
                                }
							});
                    }
                   
                  
                  
                }
            });
   }).trigger('change');

   
</script>