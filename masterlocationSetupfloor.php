<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$sessionidsister = $_SESSION['idsister'];
$sqlbuilding = "select * from location_building";
$sqlfloor = "select * from location_floor";
$sql = "select lssb.idsetupsisterbranch, lssb.code, lsc.name as sistername, lbranch.branch from location_setup_sister_branch lssb 
		inner join location_sister_company lsc on lsc.id = lssb.idsistercompany 
		inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch where lsc.id = '".$sessionidsister."'";

$listlocation = array();
$listbuilding = array();
$listfloor = array();
$resbuilding = $conn->query($sqlbuilding);
$resfloor = $conn->query($sqlfloor);
$res = $conn->query($sql);
if($res -> num_rows>0)
{
	while($r = mysqli_fetch_array($res))
	{
		$listlocation[] = $r;
	}
}
if($resbuilding->num_rows>0)
{
    while($result = mysqli_fetch_array($resbuilding))
    {
        $listbuilding[] = $result;
    }
}
if($resfloor->num_rows>0)
{
    while($result = mysqli_fetch_array($resfloor))
        {
            $listfloor[] = $result;
        }
}

?>

        <div class="content-wrapper">
            <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <h4><span class="font-weight-semibold">Master Setup Building & Floor</span></h4> 
                    <div class="page-title d-flex">
                        <div class = "row" style = "width:100%;">
                            <div class = "col-xl-12" >
							<a href="#myModal" data-toggle="modal"> <button type="button" style = "background-color:#26a69a !important; color:white; width:200px;" class="btn btn-indigo btn-labeled btn-labeled-left" onclick="cancel()" data-toggle="modal" data-target="#modal_form">
                            <b><i class="icon-plus-circle2"></i></b> Setup Building & Floor
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
                                        <th>Code</th>
                                        <th>Branch</th>
                                        <th>Building Name</th>
                                        <th>Floor</th>       
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
						<h5 class="modal-title">Add Setup Building & Floor</h5>
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
                            <br><br>
							<div style = "float:right;margin-bottom:20px;">
							<button type="button" class="btn btn-primary" style = "margin-right:10px;" onclick="adddata()">Save</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceladd">Cancel</button>
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
						<h5 class="modal-title">Edit Setup Building & Floor</h5>
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
                            <br><br>
							<div style = "float:right;margin-bottom:20px;">
							<button type="button" class="btn btn-primary" style = "margin-right:10px;" onclick="changedata()">Save</button>
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
            url: 'process/mastersetupfloor.php',
            method: 'POST',
            data: { tipe: "load"  }
        },
         columns: [
            { name: 'Code',  className: 'text-center align-middle' },
            { name: 'Location',  className: 'text-center align-middle' },
            { name: 'Building Name', className: 'text-center align-middle' },
            { name: 'Floor', className: 'text-center align-middle' },
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
                url: "process/mastersetupfloor.php",
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

function adddata(){
       var mycode = $("#code").val();
    //    var mylocation = $("#location").val();
       var mybuilding = $("#building").val();
       var myfloor = $("#floor").val();
      if( mybuilding == null || myfloor == null || mycode == "")
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
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                }
            });
            $.ajax({
                url: "process/mastersetupfloor.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    code : mycode,
                    building : mybuilding,
                    floor : myfloor
                },
                success: function (result) {
                if(result == "ok")
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
                        text: 'Duplicate Entry For This Setup',
                        confirmButtonColor: '#e00d0d',
                    });
                }
              
              
            }
            });
      }
   }
   var globalbuilding  = "";
   var globalfloor = "";
   function openmodaledit(element){

    var idelement = element.id.split("-");
    // var idsetupsister = idelement[2];
    var idbuilding = idelement[3];
    var idfloor = idelement[4];

    globalbuilding = idbuilding;
    globalfloor = idfloor;
    
    var code = $("#code" + idelement[1]).text();
    // var name = $("#name" + idelement[1]).text();
    // var description = $("#floor" + idelement[1]).text();
    // alert(idsetupsister);
    // $('#locationedit option[value='+idsetupsister+']').prop('selected', true);
    // $("#locationedit").trigger('change');

    $('#codeedit').val(code);
   
    $("#idchange").val(idelement[1]);
}
   $("#location").on('change', function(){
	   var myid = this.value;
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/mastersetupfloor.php",
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
							
                            // if(!globalcity =="")
							// {
							// 	// alert(globalid);
							// 	$('#cityedit').find('option[value="'+globalcity+'"]').prop('selected', true);
							// }
							});
                    }
                    // $("#building").trigger("change");
                   
                  
                  
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
                url: "process/mastersetupfloor.php",
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
                   
                  
                  
                }
            });
   }).trigger('change');

   function changedata(){
	 var changeid = $("#idchange").val();
     var changecode = $("#codeedit").val();
	 var changelocation = $("#locationedit").val();
	 var changebuilding = $("#buildingedit").val();
	 var changefloor = $("#flooredit").val();
	 if(changecode == "" ||  changelocation == null 
     || changebuilding == null  || changefloor == null )
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
                url: "process/mastersetupfloor.php",
                method: 'POST',
                data: {
                    tipe: "changedata",
					myid : changeid,
					mycode: changecode,
                    mylocation : changelocation,
					mybuilding : changebuilding,
					myfloor : changefloor
                    
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
