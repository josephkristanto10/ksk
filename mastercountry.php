<?php
require 'connection.php';
$sql = "select * from country";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>NEXUS - Integrated System</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
        type="text/css">
    <link href="<?=$url;?>global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
    <link href="<?=$url;?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?=$url;?>assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="<?=$url;?>assets/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="<?=$url;?>assets/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="<?=$url;?>assets/css/colors.min.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" type="image/png" href="assets/logonexus.png" />
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="<?=$url;?>global_assets/js/main/jquery.min.js"></script>
    <script src="<?=$url;?>global_assets/js/main/bootstrap.bundle.min.js"></script>
    <script src="<?=$url;?>global_assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="<?=$url;?>global_assets/js/plugins/visualization/d3/d3.min.js"></script>
    <script src="<?=$url;?>global_assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
    <script src="<?=$url;?>global_assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script src="<?=$url;?>global_assets/js/plugins/ui/moment/moment.min.js"></script>
    <script src="<?=$url;?>global_assets/js/plugins/pickers/daterangepicker.js"></script>

    <script src="assets/js/app.js"></script>
    <script src="<?=$url;?>global_assets/js/demo_pages/dashboard.js"></script>
    <script src="<?=$url;?>global_assets/js/demo_charts/pages/dashboard/light/streamgraph.js"></script>
    <script src="<?=$url;?>global_assets/js/demo_charts/pages/dashboard/light/sparklines.js"></script>
    <script src="<?=$url;?>global_assets/js/demo_charts/pages/dashboard/light/lines.js"></script>
    <script src="<?=$url;?>global_assets/js/demo_charts/pages/dashboard/light/areas.js"></script>
    <script src="<?=$url;?>global_assets/js/demo_charts/pages/dashboard/light/donuts.js"></script>
    <script src="<?=$url;?>global_assets/js/demo_charts/pages/dashboard/light/bars.js"></script>
    <script src="<?=$url;?>global_assets/js/demo_charts/pages/dashboard/light/progress.js"></script>
    <script src="<?=$url;?>global_assets/js/demo_charts/pages/dashboard/light/heatmaps.js"></script>
    <script src="<?=$url;?>global_assets/js/demo_charts/pages/dashboard/light/pies.js"></script>
    <script src="<?=$url;?>global_assets/js/demo_charts/pages/dashboard/light/bullets.js"></script>
    <!-- /theme JS files -->

    <script src="<?=$url;?>global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="<?=$url;?>global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <style>
        th {
            background-color: #324148;
            color: white;
            text-align: center;
        }
        td{
            color:#000000 !important;
            text-align:center;
        }
    	#myModal .modal-dialog {
			-webkit-transform: translate(0, -50%);
			-o-transform: translate(0, -50%);
			transform: translate(0, -50%);
			top: 50%;
			margin: 0 auto;
		}

		/* Important part */
		.modal-dialog {
			overflow-y: initial !important
		}

		.modal-body {
			height: 180px;
			overflow-y: auto;
		}
        #datatable_serverside_info, #datatable_serverside_paginate{
            margin-top:50px;
        }
		.card{
			padding:15px;
		}
    </style>
</head>

<body>

    <!-- Main navbar -->
    <div class="navbar navbar-expand-md navbar-dark">
		<div class="navbar-brand">
			<a href="index.html" class="d-inline-block">
				<img src="<?=$url;?>global_assets/images/logo_light.png" alt="">
			</a>
		</div>

		<div class="d-md-none">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
				<i class="icon-tree5"></i>
			</button>
			<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
				<i class="icon-paragraph-justify3"></i>
			</button>
		</div>

		<div class="collapse navbar-collapse" id="navbar-mobile" >
				<li class="nav-item dropdown dropdown-user" >
					<a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
						<img src="<?=$url;?>assets/logonexus.png" class="rounded-circle mr-2" height="34" alt="">
						<span>Admin</span>
					</a>

					<div class="dropdown-menu dropdown-menu-right">
						<a href="#" class="dropdown-item"><i class="icon-user-plus"></i> My profile</a>
						<a href="#" class="dropdown-item"><i class="icon-coins"></i> My balance</a>
						<a href="#" class="dropdown-item"><i class="icon-comment-discussion"></i> Messages <span class="badge badge-pill bg-blue ml-auto">58</span></a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item"><i class="icon-cog5"></i> Account settings</a>
						<a href="#" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
    <div class="page-content">
        <div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">
            <div class="sidebar-mobile-toggler text-center">
                <a href="#" class="sidebar-mobile-main-toggle">
                    <i class="icon-arrow-left8"></i>
                </a>
                Navigation
                <a href="#" class="sidebar-mobile-expand">
                    <i class="icon-screen-full"></i>
                    <i class="icon-screen-normal"></i>
                </a>
            </div>
            <div class="sidebar-content">
                <div class="card card-sidebar-mobile">
                    <ul class="nav nav-sidebar" data-nav-type="accordion">
                        <li class="nav-item-header">
                            <div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu"
                                title="Main"></i>
                        </li>
                        <li class="nav-item">
                            <a href="index.php" class="nav-link ">
                                <i class="icon-home4"></i>
                                <span>
                                    Dashboard
                                </span>
                            </a>
                        </li>
                       
                        <li class="nav-item-header">
                            <div class="text-uppercase font-size-xs line-height-xs">Master</div> <i class="icon-menu"
                                title="Master"></i>
                        </li>
                        <li class="nav-item nav-item-submenu">
						<li class="nav-item"><a href="../../../RTL/default/full/index.html" class="nav-link"><i
									class="icon-width"></i> <span>Assets</span></a></li>
						</li>
                        <li class="nav-item"><a href="masterholdingcompany.php" class="nav-link"><i
									class="icon-width"></i> <span>Holding Company</span></a></li>
						</li>
						<li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-table2"></i> <span>Asset Group</span></a>
                            <ul class="nav nav-group-sub" data-submenu-title="Basic tables">
							<li class="nav-item"><a href="masterkategoriassets.php" class="nav-link">Group</a></li>
							<li class="nav-item"><a href="mastersubkategoriassets.php" class="nav-link">Sub Group</a></li>
							<li class="nav-item"><a href="mastercategorysubgroup.php" class="nav-link">Category</a></li>
                            </ul>
                        </li>
						<li class="nav-item nav-item-submenu ">
							<a href="#" class="nav-link"><i class="icon-table2"></i> <span>Department</span></a>
							<ul class="nav nav-group-sub" data-submenu-title="Basic tables" >
							<li class="nav-item"><a href="masterdivision.php" class="nav-link"><i
                                    class="icon-width"></i> <span>Division</span></a></li>
                        </li>
                        <li class="nav-item"><a  href="masterdepartment.php" class="nav-link "><i
                                    class="icon-width"></i> <span>Department</span></a></li>
                        </li>
						
							</ul>
						</li>
						<li class="nav-item nav-item-submenu ">
							<a href="#" class="nav-link "><i class="icon-table2"></i> <span>User Asset</span></a>
							<ul class="nav nav-group-sub" data-submenu-title="Basic tables">
							<li class="nav-item"><a href="masterstaff.php" class="nav-link"><i class="icon-width"></i>
								<span>Staff</span></a></li>
						<li class="nav-item"><a href="masterpic.php" class="nav-link"><i class="icon-width"></i>
								<span>PIC</span></a></li>
						<li class="nav-item"><a href="masterpicdepartment.php" class="nav-link"><i
									class="icon-width"></i> <span>PIC (Department)</span></a></li>
							</ul>
                       
						
                        <li class="nav-item nav-item-submenu ">
                            <a href="#" class="nav-link "><i class="icon-table2"></i> <span>Location</span></a>
                            <ul class="nav nav-group-sub" data-submenu-title="Basic tables">
								<li class="nav-item"><a href="masterlocationSisterCompany.php" class="nav-link">Sister Company</a></li>
								<li class="nav-item"><a  href="masterlocationBranch.php" class="nav-link ">Branch</a></li>
								<li class="nav-item"><a href="mastersistercompanyandbranch.php" class="nav-link">Sister Company & Branch</a></li>
                                <li class="nav-item"><a href="masterlocationbuilding.php" class="nav-link ">Building</a></li>
                                <li class="nav-item"><a href="masterlocationfloor.php"  class="nav-link">Floor</a></li>
								<li class="nav-item"><a href="masterlocationSetupfloor.php" class="nav-link">Building & Floor</a></li>
                                <li class="nav-item"><a href="masterlocationrooms.php" class="nav-link">Rooms</a></li>
                                <li class="nav-item"><a href="masterrack.php" class="nav-link ">Rack</a></li>
                                <li class="nav-item"><a href="masterfolder.php" class="nav-link ">Folder</a></li>
                                <li class="nav-item"><a href="masterotherloc.php" class="nav-link">Other Location</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item nav-item-submenu nav-item-open">
							<a href="#" class="nav-link "><i class="icon-table2"></i> <span>Location Group</span></a>
							<ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = "display:block;">
							<li class="nav-item"><a class="nav-link active"><i class="icon-width"></i>
								<span>Country</span></a></li>
						<li class="nav-item"><a href="masterprovince.php" class="nav-link"><i class="icon-width"></i>
								<span>Province</span></a></li>
						<li class="nav-item"><a href="mastercity.php" class="nav-link"><i
									class="icon-width"></i> <span>City</span></a></li>
							</ul>
						</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <h4><span class="font-weight-semibold">Master Country</span></h4> 
                    <div class="page-title d-flex">
                        <div class = "row" style = "width:100%;">
                            <div class = "col-xl-12" >
							<a href="#myModal" data-toggle="modal"> <button class = "btn btn-info" style = "background-color:#26a69a !important;width:150px;"><i class = "icon-add"></i> &nbsp Add Country</button></a>
                            </div>
                        </div>
                        <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card" >
                        <table id = "datatable_serverside" class="table table-hover table-bordered display nowrap w-100">
                                <thead>
                                <tr class="text-center">
                                        <th>Country</th>     
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
						<h5 class="modal-title">Add Country</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
                        <form id = "myform">
						<div class="form-group">
							<label for="description">Country</label>
							<input type="text" class="form-control" id="Country">
							
							<br>
							<div style = "float:right;margin-bottom:20px;">
							<button type="button" class="btn btn-primary" style = "margin-right:10px;" onclick="addcountry()">Save</button>
						    <button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceladd">Cancel</button>
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
						<h5 class="modal-title">Edit Country</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
                        <form id = "myformedit">
						<div class="form-group">
                            <input type = "hidden" id = "idchange">
							<label for="description">Country</label>
							<input type="text" class="form-control" id="Countryedit">
							
							<br>
							<div style = "float:right;margin-bottom:20px;">
							<button type="button" class="btn btn-primary" style = "margin-right:10px;" onclick="changecountry()">Save</button>
						    <button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceledit">Cancel</button>
							</div>
						</div>
                       </form>
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
            url: 'process/mastercountry.php',
            method: 'POST',
            data: { tipe: "load"  }
        },
         columns: [
            { name: 'country', className: 'text-center align-middle' },
            { name: 'status', className: 'text-center align-middle' },
            { name: 'action', searchable: false, orderable: false, className: 'text-center align-middle' }
            
         ]
      });
   };
   function openmodal(element){
    var idelement = element.id.split("-");
    var nama = $("#country" + idelement[1]).text();
     $("#Countryedit").val(nama);
     $("#idchange").val(idelement[1]);
}

function changecountry(){
        var countryedit = $("#Countryedit").val();
        var changeid = $("#idchange").val();
        if(countryedit == "" )
        {
                         Swal.fire({
                            icon: 'error',
                            title: 'Empty Field',
                            text: 'Country tidak boleh kosong',
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
                url: "process/mastercountry.php",
                method: 'POST',
                data: {
                    tipe: "change",
                    mycountry : countryedit,
                    myid: changeid
                    
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
                                $("#myformedit").trigger("reset");
                                $("#canceledit").click();
                            });
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Duplicated Country Name',
                            text: 'Duplicate Entry For This Country',
                            confirmButtonColor: '#e00d0d',
                        });
                    }
                  
                  
                }
            });

        }
    }
   function addcountry() {
            var country = $('#Country').val();
            if(country == "")
            {
                Swal.fire({
                            icon: 'error',
                            title: 'Empty Field',
                            text: 'Country tidak boleh kosong',
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
                url: "process/mastercountry.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    mycountry: country
                    
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
                            text: 'Duplicate Entry For This Country',
                            confirmButtonColor: '#e00d0d',
                        });
                    }
                  
                  
                }
            });
            }
          
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
                url: "process/mastercountry.php",
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