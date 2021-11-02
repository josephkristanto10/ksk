<?php
require 'layout/header.php';
require 'layout/sidebar.php';
require_once 'layout/footer.php';
$sql = "select * from kategori_asset ";
$res = $conn->query($sql);
?>

        <div class="content-wrapper">
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <h4><span class="font-weight-semibold">Master Group</span></h4> 
                    <div class="page-title d-flex">
                        <div class = "row" style = "width:100%;">
                            <div class = "col-xl-12" >
                            <a href="#myModal" data-toggle="modal"><button type="button" style = "background-color:#26a69a !important; color:white; width:200px;" class="btn btn-indigo btn-labeled btn-labeled-left" onclick="cancel()" data-toggle="modal" data-target="#modal_form">
                            <b><i class="icon-plus-circle2"></i></b> Add Group
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
                        <div class="card" style = "padding:15px;">
                            <table id="datatable_serverside" class="table table-hover table-bordered display nowrap w-100">
                                <thead>
                                    <tr class="text-center">
                                    <th>Id</th>
                                        <th>Group</th>
										<th>Assign To</th>
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
						<h5 class="modal-title">Add Group</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
                        <form id = "myform" method = "POST">
						<div class="form-group">
							<label for="code">Group Name</label>
							<input type="text" class="form-control" id="group" >
							<br>
							<label for="description">Description</label>
							<input type="text" class="form-control" id="description">
                            <br> 
								<input type = "checkbox"  onchange="checkchangecategory(this)"> Same as group name<br>
								<br>
							<br>
							<label for="description">Assign To</label>
							<br>
							<input type="checkbox" class = "cb" id="None" name = "assign[]" value = "None" checked>&nbsp None &nbsp
							<input type="checkbox" class = "cb" id="Rooms" name = "assign[]" value = "Rooms">&nbsp Rooms &nbsp
							<input type="checkbox" class = "cb" id="Rack" name = "assign[]" value = "Rack">&nbsp Rack &nbsp
							<input type="checkbox" class = "cb" id="Folder" name = "assign[]" value = "Folder">&nbsp Folder &nbsp
							<br>
							<div style="float:right;margin-bottom:20px;">
								<button type="button" name = "mybutton" class="btn btn-primary" style="margin-right:10px;"
									 onclick = "adddata()">Save</button>
								<button type="button" id= "closemodal" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
						</div>
                            </form>
					</div>

				</div>
			</div>
		</div>
        <div class="modal fade" id="editModal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background-color:#324148;color:white;height:60px;">
						<h5 class="modal-title">Edit Group</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
                        <form id = "myformedit" method = "POST">
						<div class="form-group">
                            <input type = "hidden" id = "idchange">
							<label for="code">Group Name</label>
							<input type="text" class="form-control" id="groupedit" >
							<br>
							<label for="description">Description</label>
							<input type="text" class="form-control" id="descriptionedit">
							<br>
							<label for="description">Assign To</label>
							<br>
							<input type="checkbox" class = "cbedit" id="Noneedit" name = "assign[]" value = "None" checked>&nbsp None &nbsp
							<input type="checkbox" class = "cbedit" id="Roomsedit" name = "assign[]" value = "Rooms">&nbsp Rooms &nbsp
							<input type="checkbox" class = "cbedit" id="Rackedit" name = "assign[]" value = "Rack">&nbsp Rack &nbsp
							<input type="checkbox" class = "cbedit" id="Folderedit" name = "assign[]" value = "Folder">&nbsp Folder &nbsp
							<br>
							<div style="float:right;margin-bottom:20px;">
								<button type="button" name = "mybutton" class="btn btn-primary" style="margin-right:10px;"
									 onclick = "changedata()">Save</button>
								<button type="button" id= "closemodaledit" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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

function success() {
    //   batal();
      $('#datatable_serverside').DataTable().ajax.reload(null, false);
   };

   $(function() {
      loadData();
   });
function adddata(){
    var group = $('#group').val();
            var description = $('#description').val();
            var selected = [];
            $("input:checkbox[class=cb]:checked").each(function(){
                selected.push($(this).val());
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterkategoriassetsprocess.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    descrip: description,
                    mygroup : group,
                    myselect : selected
                    
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
                                $("#closemodal").click();
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
                    // Swal.fire({
                    //             title: 'Data Saved',
                    //             text: 'Data Inputted Successfully',
                    //             icon: 'success',
                    //             confirmButtonColor: '#53d408',
                    //             allowOutsideClick: false,
                    //         }).then((result) => {
                    //             $("#myform").trigger("reset");
                    //             $("#closemodal").click();
                    //         });
                  
                }
            });
}
function loadData() {
      $("#datatable_serverside").DataTable({
         processing: true,
         deferRender: true,
         serverSide: true,
         destroy: true,
         iDisplayInLength: 10,
         scrollX: true,
         order: [[0, 'desc']],
         ajax: { 
            url: 'process/masterkategoriassetsprocess.php',
            method: 'POST',
            data: { tipe: "load"  }
        },
        columnDefs: [
			{ targets: [0], visible: false},
			],
			order: [
				[0, 'desc']
			],
         columns: [
            { name: 'Id', searchable: false, className: 'text-center align-middle' },
            { name: 'nama', searchable: false, className: 'text-center align-middle' },
            { name: 'assignto', searchable: false, className: 'text-center align-middle' },
            { name: 'description', className: 'text-center align-middle' },
            { name: 'status', className: 'text-center align-middle' },
            { name: 'action', searchable: false, orderable: false, className: 'text-center align-middle' }
            
         ]
      });
   };
function openmodal(element){
    var idelement = element.id.split("-");
   var nama = $("#nama" + idelement[1]).text(); 
   var assignto = $("#assignto" + idelement[1]).text().toLowerCase(); 
   var desc = $("#description" + idelement[1]).text(); 
  $("#idchange").val(idelement[1]);
   $("#groupedit").val(nama);
   $("#descriptionedit").val(desc);
   if(assignto.includes("rooms"))
   {
        $("#Noneedit").prop("checked", false);
        $("#Roomsedit").prop("checked", true);
   }
   if(assignto.includes("none"))
   {
        $("#Noneedit").prop("checked", true);
        $("#Roomsedit").prop("checked", false);
        $("#Rackedit").prop("checked", false);
        $("#Folderedit").prop("checked", false);
   }
   if(assignto.includes("folder"))
   {
        $("#Noneedit").prop("checked", false);
        $("#Folderedit").prop("checked", true);
   }
   if(assignto.includes("rack"))
   {
        $("#Noneedit").prop("checked", false);
        $("#Rackedit").prop("checked", true);
   }

}
function changedata(){
          var myid = $("#idchange").val();
          var group = $('#groupedit').val();
            var description = $('#descriptionedit').val();
            var selected = [];
            $("input:checkbox[class=cbedit]:checked").each(function(){
                selected.push($(this).val());
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterkategoriassetsprocess.php",
                method: 'POST',
                data: {
                    tipe: "change",
                    idchange : myid,
                    descrip: description,
                    mygroup : group,
                    myselect : selected
                    
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
                                $("#closemodaledit").click();
                            });
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Duplicated Group Name',
                            text: 'Duplicate Entry For This Group',
                            confirmButtonColor: '#e00d0d',
                        });
                    }
                   
                  
                  
                }
            });
}

$(".cbedit").change(function() {
    if(this.checked) {
        var myvalue = this.value;
		if(myvalue == "None")
		{
			$("input[class=cbedit]").prop('checked', false);
			$(this).prop('checked', true);
		}
		else{
			$("#Noneedit").prop('checked', false);
		}
    }
});
function addkategori() {
            var group = $('#group').val();
            var description = $('#description').val();
            var selected = [];
            $("input:checkbox[class=cb]:checked").each(function(){
                selected.push($(this).val());
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterkategoriassetsprocess.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    descrip: description,
                    mygroup : group,
                    myselect : selected
                    
                },
                success: function (result) {
                    // alert(result);
                    alert(result);
                   
                  
                  
                }
            });
        };

$(".cb").change(function() {
    if(this.checked) {
        var myvalue = this.value;
		if(myvalue == "None")
		{
			$("input[class=cb]").prop('checked', false);
			$(this).prop('checked', true);
		}
		else{
			$("#None").prop('checked', false);
		}
    }
});

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
                url: "process/masterkategoriassetsprocess.php",
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
		var mycategory = $("#group").val();

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