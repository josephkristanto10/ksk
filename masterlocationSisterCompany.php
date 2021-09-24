<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$country = array();
$holding = array();
$sql = "select * from country";
$sqlholding = "select * from holding_company";
$resholding = $conn->query($sqlholding);
$res = $conn->query($sql);
if($res->num_rows>0)
{
    while($r = mysqli_fetch_array($res))
    {
        $country[] = $r;
    }
}
if($resholding->num_rows>0)
{
    while($r = mysqli_fetch_array($resholding))
    {
        $holding[] = $r;
    }
}
?>

        <div class="content-wrapper">
            <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <h4><span class="font-weight-semibold">Master Sister Company</span></h4> 
                    <div class="page-title d-flex">
                        <div class = "row" style = "width:100%;">
                            <div class = "col-xl-12" >
							<a href="#myModal" data-toggle="modal">  <button type="button" style = "background-color:#26a69a !important; color:white; width:200px;" class="btn btn-indigo btn-labeled btn-labeled-left" onclick="cancel()" data-toggle="modal" data-target="#modal_form">
                            <b><i class="icon-plus-circle2"></i></b> Add Sister Company
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
                                        <th>Name</th>
                                        <th>Desc</th>
                                        <th>Address</th>
                                        <th>Country</th>
                                        <th>Province</th>    
                                        <th>City</th>                            
                                        <th>No HP</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
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
						<h5 class="modal-title">Add Sister Company</h5>
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
                            <label for="description">Holding Company</label>
							<select class="form-control" id="holding">
                                <?php
                                for($i = 0 ; $i < count($holding); $i++)
                                {
                                    echo '<option value = "'.$holding[$i]['id'].'">'.$holding[$i]['name'].'</option>';
                                }
                                ?>
                            </select>
							<br>
							<label for="description">Name</label>
							<input type="text" class="form-control" id="name">
							<br>
							<label for="description">Description</label>
							<input type="text" class="form-control" id="description">
							<br>
							<label for="description">Address</label>
							<input type="text" class="form-control" id="address">
							<br>
                            <label for="description">Country</label>
							<select class="form-control" id="country">
                                <?php
                                for($i = 0 ; $i < count($country); $i++)
                                {
                                    echo '<option value = "'.$country[$i]['id'].'">'.$country[$i]['name'].'</option>';
                                }
                                ?>
                            </select>
							<br>
							<label for="description">Province</label>
                            <select class="form-control" id="province">
                            </select>
							<br>
							<label for="description">City</label>
							<select class="form-control" id="city">
                            </select>
							<br>
							
							<label for="description">Telp</label>
							<input type="text" class="form-control" id="telp">
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
						<h5 class="modal-title">Edit Sister Company</h5>
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
                            <label for="description">Holding Company</label>
							<select class="form-control" id="holdingedit">
                                <?php
                                for($i = 0 ; $i < count($holding); $i++)
                                {
                                    echo '<option value = "'.$holding[$i]['id'].'">'.$holding[$i]['name'].'</option>';
                                }
                                ?>
                            </select>
							<br>
							<label for="description">Name</label>
							<input type="text" class="form-control" id="nameedit">
							<br>
							<label for="description">Description</label>
							<input type="text" class="form-control" id="descriptionedit">
							<br>
							<label for="description">Address</label>
							<input type="text" class="form-control" id="addressedit">
							<br>
                            <label for="description">Country</label>
							<select class="form-control" id="countryedit">
                                <?php
                                for($i = 0 ; $i < count($country); $i++)
                                {
                                    echo '<option value = "'.$country[$i]['id'].'">'.$country[$i]['name'].'</option>';
                                }
                                ?>
                            </select>
							<br>
							<label for="description">Province</label>
                            <select class="form-control" id="provinceedit">
                            </select>
							<br>
							<label for="description">City</label>
							<select class="form-control" id="cityedit">
                            </select>
							<br>
							
							<label for="description">Telp</label>
							<input type="text" class="form-control" id="telpedit">
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
            url: 'process/mastersistercompany.php',
            method: 'POST',
            data: { tipe: "load"  }
        },
         columns: [
            { name: 'Code', searchable: false, className: 'text-center align-middle' },
            { name: 'Name', searchable: false, className: 'text-center align-middle' },
            { name: 'Desc', searchable: false, className: 'text-center align-middle' },
            { name: 'Address', className: 'text-center align-middle' },
            { name: 'Country', searchable: false, className: 'text-center align-middle' },
            { name: 'Province', className: 'text-center align-middle' },
            { name: 'City', searchable: false, className: 'text-center align-middle' },
            { name: 'No HP', className: 'text-center align-middle' },
            { name: 'Status', className: 'text-center align-middle' },
            { name: 'Action', searchable: false, orderable: false, className: 'text-center align-middle' }
            
         ]
      });
   };

   // Reload table
   function success() {
      $('#datatable_serverside').DataTable().ajax.reload(null, false);
   };
   var globalprovince = "";
   var globalcity = "";
   function openmodaledit(element){

    var idelement = element.id.split("-");
    var idcountry = idelement[2];
    var idprovince = idelement[3];
    var idcity = idelement[4];
    var idholding = idelement[5];

    globalprovince = idprovince;
    globalcity = idcity;

    var code = $("#code" + idelement[1]).text();
    var name = $("#name" + idelement[1]).text();
    var description = $("#desc" + idelement[1]).text();
    var address = $("#address" + idelement[1]).text();
    var telp = $("#telp" + idelement[1]).text();

    $('#countryedit option[value='+idcountry+']').prop('selected', true);
    $('#holdingedit option[value='+idholding+']').prop('selected', true);
    $("#countryedit").trigger('change');

    $('#codeedit').val(code);
    $('#nameedit').val(name);
    $('#descriptionedit').val(description);
    $('#addressedit').val(address);
    $("#telpedit").val(telp);
    $("#idchange").val(idelement[1]);
    }

   function adddata(){
       var mycode = $("#code").val();
       var myname = $("#name").val();
       var mydesc = $("#description").val();
       var myaddre = $("#address").val();
       var mycountry = $("#country").val();
       var myprovince = $("#province").val();
       var mycity = $("#city").val();
       var mytelp = $("#telp").val();
       var myholding = $("#holding").val();
      if(myprovince == null || mycity == null || mycode == ""|| myname == ""|| mydesc == ""|| myaddre == ""|| mytelp == "")
      {
                      Swal.fire({
                            icon: 'error',
                            title: 'Empty Field',
                            text: 'Province / City / Code / Nama / Description / Address/ Telp tidak boleh kosong',
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
                url: "process/mastersistercompany.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    code : mycode,
                    name : myname,
                    desc : mydesc,
                    address : myaddre,
                    country : mycountry,
                    province : myprovince,
                    city : mycity,
                    holding : myholding,
                    telp : mytelp
                    
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

   $("#country").on('change', function(){
	   var myid = this.value;
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/mastersistercompany.php",
                method: 'POST',
                data: {
                    tipe: "getprovince",
                    idcountry : myid
                    
                },
                success: function (result) {
                  
                    if(result == "none")
                    {
						$("#province").html("");
						$("#province").trigger('change');
                    }
                    else{
                        $("#province").html(result).promise().done(function()
						{
							  $("#province").trigger('change');
							});
                    }
                   
                  
                  
                }
            });
   }).trigger('change');
   $("#countryedit").on('change', function(){
	   var myid = this.value;
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/mastersistercompany.php",
                method: 'POST',
                data: {
                    tipe: "getprovince",
                    idcountry : myid
                    
                },
                success: function (result) {
                  
                    if(result == "none")
                    {
						$("#provinceedit").html("");
						$("#provinceedit").trigger('change');
                    }
                    else{
                        $("#provinceedit").html(result).promise().done(function()
						{
                            if(!globalprovince =="")
							{
								// alert(globalid);
								$('#provinceedit').find('option[value="'+globalprovince+'"]').prop('selected', true);
							}
							  $("#provinceedit").trigger('change');
							});
                    }
                   
                  
                  
                }
            });
   }).trigger('change');
   $("#province").on('change', function(){
	   var myid = this.value;
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/mastersistercompany.php",
                method: 'POST',
                data: {
                    tipe: "getcity",
                    idprovince : myid
                    
                },
                success: function (result) {
                    if(result == "none")
                    {
						$("#city").html("");
						
                    }
                    else{
                        $("#city").html(result).promise().done(function()
						{
							
							});
                    }
                   
                  
                  
                }
            });
   }).trigger('change');
   $("#provinceedit").on('change', function(){
	   var myid = this.value;
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/mastersistercompany.php",
                method: 'POST',
                data: {
                    tipe: "getcity",
                    idprovince : myid
                    
                },
                success: function (result) {
                    if(result == "none")
                    {
						$("#cityedit").html("");
						
                    }
                    else{
                        $("#cityedit").html(result).promise().done(function()
						{
							
                            if(!globalcity =="")
							{
								// alert(globalid);
								$('#cityedit').find('option[value="'+globalcity+'"]').prop('selected', true);
							}
							});
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
                url: "process/mastersistercompany.php",
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
	 var changename = $("#nameedit").val();
	 var changeholding = $("#holdingedit").val();
	 var changedesc = $("#descriptionedit").val();
	 var changeaddress = $("#addressedit").val();
	 var changecountry = $("#countryedit").val();
	 var changeprovince = $("#provinceedit").val();
	 var changecity = $("#cityedit").val();
	 var changetelp = $("#telpedit").val();
	 if(changecode == "" || changename == "" || changecountry == null 
     || changeholding == null  || changeprovince == null || 
     changecity == null || changetelp == "null" || changedesc == "" || changeaddress == "" )
	 {
						Swal.fire({
                            icon: 'error',
                            title: 'Empty Field',
                            text: 'Code / Name / Address / Country / Province / City / Telp / Description Tidak Boleh Kosong',
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
                url: "process/mastersistercompany.php",
                method: 'POST',
                data: {
                    tipe: "changedata",
					myid : changeid,
					mycode: changecode,
                    myname : changename,
					myholding : changeholding,
					mydesc : changedesc,
                    myaddress : changeaddress,
					mycountry : changecountry,
					myprovince : changeprovince,
					mycity : changecity,
					mytelp : changetelp
                    
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