<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$sql = "select * from country";
$sqlrank = "select * from rank";
$sqldepartment = "select * from department";
$res = $conn->query($sql);
$mycountry = array();
if($res->num_rows>0)
{
    while($r = mysqli_fetch_array($res))
    {
        $mycountry[] = $r;
    }
}
$myrank = array();
$resrank =  $conn->query($sqlrank);
if($resrank->num_rows>0)
{
    while($r = mysqli_fetch_array($resrank))
    {
        $myrank[] = $r;
    }
}
$mydept = array();
$resdept =  $conn->query($sqldepartment);
if($resdept->num_rows>0)
{
    while($r = mysqli_fetch_array($resdept))
    {
        $mydept[] = $r;
    }
}

?>

        <div class="content-wrapper">
            <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <h4><span class="font-weight-semibold">Master Relation</span></h4> 
                    <div class="page-title d-flex">
                        <div class = "row" style = "width:100%;">
                            <div class = "col-xl-12" >
							<a href="#myModal" data-toggle="modal"> <button class = "btn btn-info" style = "background-color:#26a69a !important;width:150px;"><i class = "icon-add"></i> &nbsp Add Relation</button></a>
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
                                        <th>Code</th>
                                        <th>Company</th>
                                        <th>Contact Name</th>
                                        <th>Description</th>
                                        <th>Rank</th>
                                        <th>Department</th>
                                        <th>HP1</th>
                                        <th>HP2</th>
                                        <th>Email1</th>
                                        <th>Email2</th>
                                        <th>Address</th>
                                        <th>Country</th>
                                        <th>Province</th>
                                        <th>City</th>
                                        <th>Remark</th>
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
						<h5 class="modal-title">Add Relation</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
                        <form id= "myform">
						<div class="form-group">
					
                        <label for="code">Code</label><input type="text" name="code" id="code" class="form-control"/>
                        <br>
                        <label for="company">Company</label><input type="text" name="company" id="company" class="form-control" />
                        <br class="clear" /> 
                        <label for="contactname">Contactname</label><input type="text" name="contactname" id="contactname" class="form-control"/>
                        <br class="clear" /> 
                        <label for="description">Description</label><input type="text" name="description" id="description" class="form-control"/>
                        <br>
                            <label for="description">Rank</label>
							<select class="form-control" id="rank">
                                <?php
                                for($i = 0 ; $i < count($myrank); $i++)
                                {
                                    echo '<option value = "'.$myrank[$i]['id'].'">'.$myrank[$i]['rank'].'</option>';
                                }
                                ?>
                            </select>
							<br>
                            <label for="description">Department</label>
							<select class="form-control" id="department">
                                <?php
                                for($i = 0 ; $i < count($mydept); $i++)
                                {
                                    echo '<option value = "'.$mydept[$i]['id'].'">'.$mydept[$i]['department'].'</option>';
                                }
                                ?>
                            </select>
							<br>
                        <label for="hp1">Hp1</label><input type="text" name="hp1" id="hp1" class="form-control" />
                        <br class="clear" /> 
                        <label for="hp2">Hp2</label><input type="text" name="hp2" id="hp2" class="form-control"/>
                        <br class="clear" /> 
                        <label for="email1">Email1</label><input type="text" name="email1" id="email1" class="form-control"/>
                        <br class="clear" /> 
                        <label for="email2">Email2</label><input type="text" name="email2" id="email2" class="form-control"/>
                        <br class="clear" /> 
                    
                        <label for="address">Address</label><input type="text" name="address" id="address" class="form-control"/>
                        <br>
                            <label for="description">Country</label>
							<select class="form-control" id="country">
                                <?php
                                for($i = 0 ; $i < count($mycountry); $i++)
                                {
                                    echo '<option value = "'.$mycountry[$i]['id'].'">'.$mycountry[$i]['name'].'</option>';
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
                        
                        <label for="remark">Remark</label><input type="text" name="remark" id="remark" class="form-control" />
                        <br class="clear" /> 
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
						<h5 class="modal-title">Edit Condition</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
                        <form id= "myformedit">
						<div class="form-group">
                            <input type = "hidden" id= "idchange">
                        <label for="code">Code</label><input type="text" name="code" id="codeedit" class="form-control" disabled/>
                        <br>
                        <label for="company">Company</label><input type="text" name="company" id="companyedit" class="form-control" />
                        <br class="clear" /> 
                        <label for="contactname">Contactname</label><input type="text" name="contactname" id="contactnameedit" class="form-control"/>
                        <br class="clear" /> 
                        <label for="description">Description</label><input type="text" name="description" id="descriptionedit" class="form-control"/>
                        <br>
                            <label for="description">Rank</label>
							<select class="form-control" id="rankedit">
                                <?php
                                for($i = 0 ; $i < count($myrank); $i++)
                                {
                                    echo '<option value = "'.$myrank[$i]['id'].'">'.$myrank[$i]['rank'].'</option>';
                                }
                                ?>
                            </select>
							<br>
                            <label for="description">Department</label>
							<select class="form-control" id="departmentedit">
                                <?php
                                for($i = 0 ; $i < count($mydept); $i++)
                                {
                                    echo '<option value = "'.$mydept[$i]['id'].'">'.$mydept[$i]['department'].'</option>';
                                }
                                ?>
                            </select>
							<br>
                        <label for="hp1">Hp1</label><input type="text" name="hp1" id="hp1edit" class="form-control" />
                        <br class="clear" /> 
                        <label for="hp2">Hp2</label><input type="text" name="hp2" id="hp2edit" class="form-control"/>
                        <br class="clear" /> 
                        <label for="email1">Email1</label><input type="text" name="email1" id="email1edit" class="form-control"/>
                        <br class="clear" /> 
                        <label for="email2">Email2</label><input type="text" name="email2" id="email2edit" class="form-control"/>
                        <br class="clear" /> 
                    
                        <label for="address">Address</label><input type="text" name="address" id="addressedit" class="form-control"/>
                        <br>
                            <label for="description">Country</label>
							<select class="form-control" id="countryedit">
                                <?php
                                for($i = 0 ; $i < count($mycountry); $i++)
                                {
                                    echo '<option value = "'.$mycountry[$i]['id'].'">'.$mycountry[$i]['name'].'</option>';
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
                        
                        <label for="remark">Remark</label><input type="text" name="remark" id="remarkedit" class="form-control" />
                        <br class="clear" /> 
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
         order: [[0, 'asc']],
         ajax: { 
            url: 'process/masterrelation.php',
            method: 'POST',
            data: { tipe: "load"  }
        },
         columns: [
            { name: 'Code', className: 'text-center align-middle' },
            { name: 'Company', className: 'text-center align-middle' },
            { name: 'Contact Name', className: 'text-center align-middle' },
            { name: 'Description', className: 'text-center align-middle' },
            { name: 'Rank', className: 'text-center align-middle' },
            { name: 'Department', className: 'text-center align-middle' },
            { name: 'hp1', className: 'text-center align-middle' },
            { name: 'hp2', className: 'text-center align-middle' },
            { name: 'email1', className: 'text-center align-middle' },
            { name: 'email2', className: 'text-center align-middle' },
            { name: 'Address', className: 'text-center align-middle' },
            { name: 'Country', className: 'text-center align-middle' },
            { name: 'Province', className: 'text-center align-middle' },
            { name: 'City', className: 'text-center align-middle' },
            { name: 'Remark', className: 'text-center align-middle' },
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
	var code = $("#code" + idelement[1]).text();
    var company = $("#company" + idelement[1]).text();
    var contactname = $("#contactname" + idelement[1]).text();
    var description = $("#description" + idelement[1]).text();
    var hp1 = $("#hp1" + idelement[1]).text();
    var hp2 = $("#hp2" + idelement[1]).text();
    var email1 = $("#email1" + idelement[1]).text();
    var email2 = $("#email2" + idelement[1]).text();
    var remark = $("#remark" + idelement[1]).text();
    var address = $("#address" + idelement[1]).text();

    var rank =  idelement[5];
    var department = idelement[6];
    var country = idelement[2];
    var province = idelement[3];
    var city = idelement[4]

    globalprovince = province;
    globalcity = city;
    
    $("#codeedit").val(code);
    $("#companyedit").val(company);
    $("#contactnameedit").val(contactname);
    $("#descriptionedit").val(description);
    $("#hp1edit").val(hp1);
    $("#hp2edit").val(hp2);
    $("#email1edit").val(email1);
    $("#email2edit").val(email2);
    $("#remarkedit").val(remark);
    $("#addressedit").val(address);

    $('#rankedit option[value='+rank+']').prop('selected', true);
    $('#departmentedit option[value='+department+']').prop('selected', true);
    $('#countryedit option[value='+country+']').prop('selected', true);
    $("#countryedit").trigger('change');
    $("#idchange").val(idelement[1]);
   }

   function changedata(){
	 var changeid = $("#idchange").val();
     var code = $("#codeedit").val();
    var contactname = $('#contactnameedit').val();
    var description = $("#descriptionedit").val();
    var rank = $('#rankedit').val();
    var department = $("#departmentedit").val();
    var hp1 = $('#hp1edit').val();
    var hp2 = $("#hp2edit").val();
    var email1 = $('#email1edit').val();
    var email2 = $("#email2edit").val();
    var address = $("#addressedit").val();
    var country = $('#countryedit').val();
    var province = $("#provinceedit").val();
    var city = $('#cityedit').val();
    var company = $("#companyedit").val();
    var remark = $('#remarkedit').val();
    if(code == "" || contactname == "" || description == "" || hp1 == ""|| 
    hp2 == "" || email1 == ""|| email2 == "" || address == ""|| company == "" || remark == "" || rank == null
    || department == null ||  country == null|| province == null || city == null)
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
                url: "process/masterrelation.php",
                method: 'POST',
                data: {
                    tipe: "changedata",
					myid : changeid,
                    code : code ,
                    contactname :  contactname ,
                    description :  description ,
                    rank :  rank ,
                    department :  department ,
                    hp1 :  hp1 ,
                    hp2 :  hp2 ,
                    email1 :  email1 ,
                    email2 :  email2 ,
                    address :  address,
                    country :  country ,
                    province :  province ,
                    city :  city ,
                    company :  company ,
                    remark :  remark 
                    
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
                            title: 'Data Exists',
                            text: 'Duplicate Entry For This Relation',
                            confirmButtonColor: '#e00d0d',
                        });
					}
                 
                   
                  
                  
                }
            });
	 }
   }
   function adddata(){
	var code = $("#code").val();
    var contactname = $('#contactname').val();
    var description = $("#description").val();
    var rank = $('#rank').val();
    var department = $("#department").val();
    var hp1 = $('#hp1').val();
    var hp2 = $("#hp2").val();
    var email1 = $('#email1').val();
    var email2 = $("#email2").val();
    var address = $("#address").val();
    var country = $('#country').val();
    var province = $("#province").val();
    var city = $('#city').val();
    var company = $("#company").val();
    var remark = $('#remark').val();

    if(code == "" || contactname == "" || description == "" || hp1 == ""|| 
    hp2 == "" || email1 == ""|| email2 == "" || address == ""|| company == "" || remark == "" || rank == null
    || department == null ||  country == null|| province == null || city == null)
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
                url: "process/masterrelation.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    code : code ,
                    contactname :  contactname ,
                    description :  description ,
                    rank :  rank ,
                    department :  department ,
                    hp1 :  hp1 ,
                    hp2 :  hp2 ,
                    email1 :  email1 ,
                    email2 :  email2 ,
                    address :  address,
                    country :  country ,
                    province :  province ,
                    city :  city ,
                    company :  company ,
                    remark :  remark 
                    
                },
                success: function (result) {
                   alert(result);
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
                            text: 'Duplicate Entry For This Relation',
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
                url: "process/masterrelation.php",
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
   $("#province").on('change', function(){
	   var myid = this.value;
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterrelation.php",
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
                url: "process/masterrelation.php",
                method: 'POST',
                data: {
                    tipe: "getprovince",
                    idcountry : myid
                    
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
                                
                                if(!globalprovince =="")
                                {
                                    $('#provinceedit').find('option[value="'+globalprovince+'"]').prop('selected', true);
                                }
                            }
                            );
                            $("#provinceedit").trigger('change');
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
                url: "process/masterrelation.php",
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
                url: "process/masterrelation.php",
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
</script>