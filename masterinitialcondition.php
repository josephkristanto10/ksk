<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$sql = "select * from country";
$res = $conn->query($sql);
$mycountry = array();
if($res->num_rows>0)
{
    while($r = mysqli_fetch_array($res))
    {
        $mycountry[] = $r;
    }
}

?>
        <div class="content-wrapper">
            <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <h4><span class="font-weight-semibold">Master Initial Condition</span></h4> 
                    <div class="page-title d-flex">
                        <div class = "row" style = "width:100%;">
                            <div class = "col-xl-12" >
							<a href="#myModal" data-toggle="modal"> <button class = "btn btn-info" style = "background-color:#26a69a !important;width:150px;"><i class = "icon-add"></i> &nbsp Add Initial Condition</button></a>
                            </div>
                        </div>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>
              
            </div>
            <!-- /page header -->


            <!-- Content area -->
            <div class="content">

                <!-- Main charts -->
                <div class="row">
                    <div class="col-xl-12">

                        <div class="card">


                        <table id = "datatable_serverside" class="table table-hover table-bordered display nowrap w-100">
                                <thead>
                                    <tr>  
                                    <th>Id</th>
                                        <th>Initial Condition</th>
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
						<h5 class="modal-title">Add Initial Condition</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
                        <form id= "myform">
						<div class="form-group">
                        <input type = "hidden" id = "idchange">
                            <label for="description">Initial Condition</label>
							<input type="text" class="form-control" id="initialcondition">
							<br>
                            <label for="description">Description</label>
							<input type="text" class="form-control" id="description">
                            <br> 
								<input type = "checkbox"  onchange="checkchangecategory(this)"> Same as category name<br>
								<br>
							<br>
							<br>
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
						<h5 class="modal-title">Edit Initial Condition</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
                        <form id= "myformedit">
						<div class="form-group">
                            <input type = "hidden" id = "idchange">
                            <label for="description">Initial Condition</label>
							<input type="text" class="form-control" id="initialconditionedit">
							<br>
                            <label for="description">Description</label>
							<input type="text" class="form-control" id="descriptionedit">
							<br>
							<br>
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
         order: [[0, 'desc']],
         columnDefs: [
			{ targets: [0], visible: false},
			],
         ajax: { 
            url: 'process/masterinitialcondition.php',
            method: 'POST',
            data: { tipe: "load"  }
        },
         columns: [
            { name: 'Id', className: 'text-center align-middle' },
            { name: 'Initial_Condition', className: 'text-center align-middle' },
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
   var globalid = "";

   function openmodaledit(element){
    
	var idelement = element.id.split("-");
	var initial = $("#name" + idelement[1]).text();
	var description = $("#description" + idelement[1]).text();
    $("#initialconditionedit").val(initial);
    $("#descriptionedit").val(description);
	$("#idchange").val(idelement[1]);
    
   }

   function changedata(){
	 var changeid = $("#idchange").val();
	 var changeinitial = $("#initialconditionedit").val();
	 var changedescription = $("#descriptionedit").val();
	 if(changeinitial == "" || changedescription == "" )
	 {
						Swal.fire({
                            icon: 'error',
                            title: 'Empty Field',
                            text: 'Initial Condition / Description cannot be empty',
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
                url: "process/masterinitialcondition.php",
                method: 'POST',
                data: {
                    tipe: "change",
					myid : changeid,
					myinitial: changeinitial,
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
                            title: 'Duplicated This Initial Condition',
                            text: 'Duplicate Entry For This Initial Condition',
                            confirmButtonColor: '#e00d0d',
                        });
					}
                 
                   
                  
                  
                }
            });
	 }
   }
   function adddata(){
	var initialcondition = $("#initialcondition").val();
    var description = $('#description').val();
    if(initialcondition == "" || description == "")
    {
                         Swal.fire({
                            icon: 'error',
                            title: 'Empty Field',
                            text: 'Province / City tidak boleh kosong',
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
                url: "process/masterinitialcondition.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    myinitialcondition: initialcondition,
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
                            text: 'Duplicate Entry For This Initial Condition',
                            confirmButtonColor: '#e00d0d',
                        });
                    }
                  
                  
                }
            });
    }
          
}
$("#country").on('change', function(){
	//    alert("test");

	
	//  alert(myoptionid);
	   var myid = this.value;
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/mastercity.php",
                method: 'POST',
                data: {
                    tipe: "getprovince",
                    idprovince : myid
                    
                },
                success: function (result) {
					// alert(result);
                    if(result == "none")
                    {
						$("#province").html("");
                    }
                    else
                    {
                            $("#province").html(result).promise().done(function()
                            {
                                
                                // if(!globalid =="")
                                // {
                                //     $('#subgroupedit').find('option[value="'+globalid+'"]').prop('selected', true);
                                // }
                            }
                            );
                    }
                }
            });
   }).trigger('change');
   $("#countryedit").on('change', function(){
	//    alert("test");

	
	//  alert(myoptionid);
	   var myid = this.value;
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/mastercity.php",
                method: 'POST',
                data: {
                    tipe: "getprovince",
                    idprovince : myid
                    
                },
                success: function (result) {
					// alert(result);
                    if(result == "none")
                    {
						$("#provinceedit").html("");
                    }
                    else
                    {
                            $("#provinceedit").html(result).promise().done(function()
                            {
                                
                                if(!globalid =="")
                                {
                                    $('#provinceedit').find('option[value="'+globalid+'"]').prop('selected', true);
                                }
                            }
                            );
                    }
                }
            });
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
                url: "process/masterinitialcondition.php",
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
function checkchangecategory(element)
	{
		var mycategory = $("#initialcondition").val();

		var mycheck = element.checked;
		if(mycheck)
		{
			$("#description").val(mycategory);
		}
		else
		{
			$("#description").val("");
		}
		
	}
</script>