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
                <h4><span class="font-weight-semibold">Master Supplier</span></h4> 
                    <div class="page-title d-flex">
                        <div class = "row" style = "width:100%;">
                            <div class = "col-xl-12" >
							<a href="#myModal" data-toggle="modal">  <button type="button" style = "background-color:#26a69a !important; color:white; width:150px;" class="btn btn-indigo btn-labeled btn-labeled-left" onclick="cancel()" data-toggle="modal" data-target="#modal_form">
                            <b><i class="icon-plus-circle2"></i></b> Add Supplier
                        </button></a>
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
                                        <th>Company</th>
                                        <th>Description</th>
                                        <th>Address</th>
                                        <th>Country</th>
                                        <th>Province</th>
                                        <th>City</th>
                                        <th>Phone</th>
                                        <th>Contact Name</th>
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
						<h5 class="modal-title">Add Supplier</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
                        <form id= "myform">
						<div class="form-group">
						
                            <label for="description">Company</label>
							<input type="text" class="form-control" id="company">
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
                                for($i = 0 ; $i < count($mycountry); $i++)
                                {
                                    echo '<option value = "'.$mycountry[$i]['id'].'">'.$mycountry[$i]['name'].'</option>';
                                }
                                ?>
                            </select>
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
                            <label for="description">Office Phone</label>
							<input type="text" class="form-control" id="phone">
                            <br>
                            <label for="description">Contact Name</label>
							<input type="text" class="form-control" id="contactname">
                            <br> 
                            <label for="description">Handphone 1</label>
							<input type="text" class="form-control" id="handphone1add">
                            <br>
                            <label for="description">Handphone 2</label>
							<input type="text" class="form-control" id="handphone2add">
                            <br>
                            <label for="description">Email 1</label>
							<input type="text" class="form-control" id="email1add">
                            <br>
                            <label for="description">Email 2</label>
							<input type="text" class="form-control" id="email2add">
                            <br>
                            <label for="description">Remark</label>
							<input type="text" class="form-control" id="remark">
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
						<h5 class="modal-title">Edit Supplier</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
                        <form id= "myformedit">
						<div class="form-group">
                            <input type = "hidden" id = "idchange">
                           
                            <label for="description">Company</label>
							<input type="text" class="form-control" id="companyedit" disabled>
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
                            <label for="description">Office Phone</label>
							<input type="text" class="form-control" id="phoneedit">
                            <br>
                            <label for="description">Contact Name</label>
							<input type="text" class="form-control" id="contactnameedit">
                            <br> 
                            <label for="description">Handphone 1</label>
							<input type="text" class="form-control" id="handphone1edit">
                            <br>
                            <label for="description">Handphone 2</label>
							<input type="text" class="form-control" id="handphone2edit">
                            <br>
                            <label for="description">Email 1</label>
							<input type="text" class="form-control" id="email1edit">
                            <br>
                            <label for="description">Email 2</label>
							<input type="text" class="form-control" id="email2edit">
                            <br>
                            <label for="description">Remark</label>
							<input type="text" class="form-control" id="remarkedit">
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
        <div class="modal fade" id="myModalshow">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background-color:#324148;color:white;height:60px;">
						<h5 class="modal-title" id = "DetailTitle">Additional Info </h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
                        <form >
						<div class="form-group">
                            <label for="description">Contact Name</label>
                            <label for="contactname" id="contactnameshow" class="form-control">-</label>
							<br>
                            <label for="description">Rank</label>
                            <label for="rank" id="rankshow" class="form-control">-</label>
							<br>
                            <label for="description">Department</label>
                            <label for="department" id="departmentshow" class="form-control">-</label>
							<br>
                            <label for="description">Handphone 1</label>
                            <label for="handphone1" id="handphone1" class="form-control">-</label>
							<br>
                            <label for="description">Handphone 1</label>
                            <label for="handphone2" id="handphone2" class="form-control">-</label>
							<br>
                            <label for="description">Email 1</label>
                            <label for="email1" id="email1" class="form-control">-</label>
							<br>
                            <label for="description">Email 2</label>
                            <label for="email2" id="email2" class="form-control">-</label>
							<br>
							<br>
							<div style = "float:right;margin-bottom:20px;">
							
					    	<button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceledit">Close</button>
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
            url: 'process/mastersupplier.php',
            method: 'POST',
            data: { tipe: "load"  }
        },
         columns: [
            { name: 'Company', className: 'text-center align-middle' },
            { name: 'Description', className: 'text-center align-middle' },
            { name: 'Address', className: 'text-center align-middle' },
            { name: 'Country', className: 'text-center align-middle' },
            { name: 'Province', className: 'text-center align-middle' },
            { name: 'City', className: 'text-center align-middle' },
            { name: 'Phone', className: 'text-center align-middle' },
            { name: 'Contact Name', className: 'text-center align-middle' },
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
   var globalcountry = "";
   var globalprovince = "";
   var globalcity = "";

   function openmodaledit(element){
    // $row['id'].'-'.$row['idcountry'].'-'.$row['idprovince'].'-'.$row['idcity'].'-'.$row['idrank'].'-'.
    // $row['iddepartment'].'-'.$row['hp1'].'-'.$row['hp2'].'-'.$row['email1'].'-'.$row['email2']


	var idelement = element.id.split("-");
    var country = idelement[2];
    var province = idelement[3];
    var city = idelement[4];

     globalcountry = country;
     globalprovice = province;
     globalcity = city;

    var rank = idelement[5];
    var department = idelement[6];
    var hp1 = idelement[7];
    var hp2 = idelement[8];
    var email1 = idelement[9];
    var email2 = idelement[10];
    var Company = $("#Company" + idelement[1]).text();
    var Description = $("#Description" + idelement[1]).text();
    var Address = $("#Address" + idelement[1]).text();
    var Phone = $("#Phone" + idelement[1]).text();
    var Contactname = $("#Contactname" + idelement[1]).text();
    var Remark = $("#Remark" + idelement[1]).text();
	$("#companyedit").val(Company);
    $("#descriptionedit").val(Description);
    $("#addressedit").val(Address);
    $("#phoneedit").val(Phone);
    $("#contactnameedit").val(Contactname);
    $("#handphone1edit").val(hp1);
    $("#handphone2edit").val(hp2);
    $("#email1edit").val(email1);
    $("#email2edit").val(email2);
    $("#remarkedit").val(Remark);
    $("#idchange").val(idelement[1]);


    $('#countryedit option[value='+country+']').prop('selected', true);
    $("#countryedit").trigger('change');
   }
   function opendetail(element, mydata){
    // alert(mydata);
	var idelement = element.id.split("|");
    var hp1 = idelement[1];
    var hp2 = idelement[2];
    var email1 = idelement[3];
    var email2 = idelement[4];
    var company= idelement[5];
    var rank= idelement[6];
    var department= idelement[7];
    var contactname= idelement[8];
    $("#handphone1").text(hp1);
    $("#handphone2").text(hp2);
    $("#email1").text(email1);
    $("#email2").text(email2);
    $("#DetailTitle").text("Additional Info " + company);
    $("#contactnameshow").text(contactname);
    $('#rankshow').text(rank)
    $('#departmentshow').text(department)
   }


   function changedata(){
       
	 var changeid = $("#idchange").val();

     var company = $("#companyedit").val();
    var description = $("#descriptionedit").val();
    var address = $("#addressedit").val();
    var country = $("#countryedit").val();
	var province = $("#provinceedit").val();
    var city = $('#cityedit').val();
    var rank = $("#rankedit").val();
	var department = $("#departmentedit").val();
    var phone = $('#phoneedit').val();
    var contactname = $("#contactnameedit").val();
    var hp1 = $("#handphone1edit").val();
    var hp2 = $("#handphone2edit").val();
    var email1 = $("#email1edit").val();
    var email2 = $("#email2edit").val();
    var remark = $("#remarkedit").val();
	 if(company == "" || description == "" || address == "" || description == ""|| 
    phone == "" || contactname == ""|| hp1 == "" || hp2 == ""|| email1 == "" || email2 == "" || remark == ""
    || country == null ||  province == null|| city == null || rank == null || department == null)
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
                url: "process/mastersupplier.php",
                method: 'POST',
                data: {
                    tipe: "changedata",
					myid : changeid,
                    mycompany : company ,
                    mydescription :  description ,
                    myaddress :  address ,
                    mycountry :  country ,
                    myprovince :  province ,
                    mycity :  city ,
                    myrank :  rank ,
                    mydepartment :  department ,
                    myphone :  phone ,
                    mycontactname :  contactname,
                    myhp1 :  hp1 ,
                    myhp2 :  hp2 ,
                    myemail1 :  email1 ,
                    myemail2 :  email2 ,
                    myremark :  remark 
                    
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
                            title: 'Duplicated Condition Name',
                            text: 'Duplicate Entry For This Condition',
                            confirmButtonColor: '#e00d0d',
                        });
					}
                 
                   
                  
                  
                }
            });
	 }
   }
   function adddata(){
    var company = $("#company").val();
    var description = $("#description").val();
    var address = $("#address").val();
    var country = $("#country").val();
	var province = $("#province").val();
    var city = $('#city').val();
    var rank = $("#rank").val();
	var department = $("#department").val();
    var phone = $('#phone').val();
    var contactname = $("#contactname").val();
    var hp1 = $("#handphone1add").val();
    var hp2 = $("#handphone2add").val();
    var email1 = $("#email1add").val();
    var email2 = $("#email2add").val();
    var remark = $("#remark").val();
    if(company == "" || description == "" || address == "" || description == ""|| 
    phone == "" || contactname == ""|| hp1 == "" || hp2 == ""|| email1 == "" || email2 == "" || remark == ""
    || country == null ||  province == null|| city == null || rank == null || department == null)
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
                url: "process/mastersupplier.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    mycompany : company ,
                    mydescription :  description ,
                    myaddress :  address ,
                    mycountry :  country ,
                    myprovince :  province ,
                    mycity :  city ,
                    myrank :  rank ,
                    mydepartment :  department ,
                    myphone :  phone ,
                    mycontactname :  contactname,
                    myhp1 :  hp1 ,
                    myhp2 :  hp2 ,
                    myemail1 :  email1 ,
                    myemail2 :  email2 ,
                    myremark :  remark 
                    
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
                            text: 'Duplicate Entry For This Supplier',
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
                url: "process/mastersupplier.php",
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
                url: "process/supplier.php",
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
                url: "process/mastersupplier.php",
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
                            $('#provinceedit').trigger('change');
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
                url: "process/mastersupplier.php",
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
                url: "process/mastersupplier.php",
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