<?php
require 'connection.php';

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
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
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

    <script src="<?=$url;?>global_assets/js/demo_pages/datatables_advanced.js"></script>
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
			height: 65vh;
			overflow-y: auto;
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
		<div class="collapse navbar-collapse" id="navbar-mobile" ">
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
                            <ul class="nav nav-group-sub" data-submenu-title="Basic tables" >
								<li class="nav-item"><a href="masterlocationSisterCompany.php" class="nav-link">Sister Company</a></li>
								<li class="nav-item"><a href="masterlocationBranch.php" class="nav-link ">Branch</a></li>
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
							<a href="#" class="nav-link active"><i class="icon-table2"></i> <span>Location Group</span></a>
							<ul class="nav nav-group-sub" data-submenu-title="Basic tables" style = "display:block;">
							<li class="nav-item"><a href="mastercountry.php" class="nav-link"><i class="icon-width"></i>
								<span>Country</span></a></li>
						<li class="nav-item"><a href="masterprovince.php" class="nav-link"><i class="icon-width"></i>
								<span>Province</span></a></li>
						<li class="nav-item"><a class="nav-link active"><i
									class="icon-width"></i> <span>City</span></a></li>
							</ul>
						</li>

                        <!-- Tables -->
                        <li class="nav-item-header">
                            <div class="text-uppercase font-size-xs line-height-xs">Tables</div> <i class="icon-menu"
                                title="Tables"></i>
                        </li>
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-table2"></i> <span>Basic tables</span></a>
                            <ul class="nav nav-group-sub" data-submenu-title="Basic tables">
                                <li class="nav-item"><a href="table_basic.html" class="nav-link">Basic examples</a></li>
                                <li class="nav-item"><a href="table_sizing.html" class="nav-link">Table sizing</a></li>
                                <li class="nav-item"><a href="table_borders.html" class="nav-link">Table borders</a>
                                </li>
                                <li class="nav-item"><a href="table_styling.html" class="nav-link">Table styling</a>
                                </li>
                                <li class="nav-item"><a href="table_elements.html" class="nav-link">Table elements</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-grid7"></i> <span>Data tables</span></a>
                            <ul class="nav nav-group-sub" data-submenu-title="Data tables">
                                <li class="nav-item"><a href="datatable_basic.html" class="nav-link">Basic
                                        initialization</a></li>
                                <li class="nav-item"><a href="datatable_styling.html" class="nav-link">Basic styling</a>
                                </li>
                                <li class="nav-item"><a href="datatable_advanced.html" class="nav-link">Advanced
                                        examples</a></li>
                                <li class="nav-item"><a href="datatable_sorting.html" class="nav-link">Sorting
                                        options</a></li>
                                <li class="nav-item"><a href="datatable_api.html" class="nav-link">Using API</a></li>
                                <li class="nav-item"><a href="datatable_data_sources.html" class="nav-link">Data
                                        sources</a></li>
                            </ul>
                        </li>
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-alignment-unalign"></i> <span>Data tables
                                    extensions</span></a>
                            <ul class="nav nav-group-sub" data-submenu-title="Data tables extensions">
                                <li class="nav-item"><a href="datatable_extension_reorder.html" class="nav-link">Columns
                                        reorder</a></li>
                                <li class="nav-item"><a href="datatable_extension_row_reorder.html" class="nav-link">Row
                                        reorder</a></li>
                                <li class="nav-item"><a href="datatable_extension_fixed_columns.html"
                                        class="nav-link">Fixed columns</a></li>
                                <li class="nav-item"><a href="datatable_extension_fixed_header.html"
                                        class="nav-link">Fixed header</a></li>
                                <li class="nav-item"><a href="datatable_extension_autofill.html" class="nav-link">Auto
                                        fill</a></li>
                                <li class="nav-item"><a href="datatable_extension_key_table.html" class="nav-link">Key
                                        table</a></li>
                                <li class="nav-item"><a href="datatable_extension_scroller.html"
                                        class="nav-link">Scroller</a></li>
                                <li class="nav-item"><a href="datatable_extension_select.html"
                                        class="nav-link">Select</a></li>
                                <li class="nav-item nav-item-submenu">
                                    <a href="#" class="nav-link">Buttons</a>
                                    <ul class="nav nav-group-sub">
                                        <li class="nav-item"><a href="datatable_extension_buttons_init.html"
                                                class="nav-link">Initialization</a></li>
                                        <li class="nav-item"><a href="datatable_extension_buttons_flash.html"
                                                class="nav-link">Flash buttons</a></li>
                                        <li class="nav-item"><a href="datatable_extension_buttons_print.html"
                                                class="nav-link">Print buttons</a></li>
                                        <li class="nav-item"><a href="datatable_extension_buttons_html5.html"
                                                class="nav-link">HTML5 buttons</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item"><a href="datatable_extension_colvis.html" class="nav-link">Columns
                                        visibility</a></li>
                            </ul>
                        </li>
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-versions"></i> <span>Responsive
                                    tables</span></a>
                            <ul class="nav nav-group-sub" data-submenu-title="Responsive tables">
                                <li class="nav-item"><a href="table_responsive.html" class="nav-link">Responsive basic
                                        tables</a></li>
                                <li class="nav-item"><a href="datatable_responsive.html" class="nav-link">Responsive
                                        data tables</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <h4><span class="font-weight-semibold">Master City</span></h4> 
                    <div class="page-title d-flex">
                        <div class = "row" style = "width:100%;">
                            <div class = "col-xl-12" >
							<a href="#myModal" data-toggle="modal"> <button class = "btn btn-info" style = "background-color:#26a69a !important;width:150px;"><i class = "icon-add"></i> &nbsp Add City</button></a>
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


                        <table class="table table-bordered table-hover datatable-highlight">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Country</th>     
                                        <th>Province</th>
                                        <th>City</th>              
                                        <th>Description</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Jog</td>
                                        <td>Indonesia</td>
                                        <td>Jawa Tengah</td>
                                        <td>Jogja</td>
                                        <td>Silahkan Isikan deskripsi disini</td>
                                        <td><span class="badge badge-success">Active</span></td>
                                        <td class="text-center">
                                            <div class="list-icons">
                                                <div class="dropdown">
                                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                        <i class="icon-menu9"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"><i class="icon-check"></i>
                                                            Set Active</a>
                                                        <a class="dropdown-item"><i
                                                                class="icon-cross3"></i> Set Inactive</a>
                                                   
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ban</td>
                                        <td>Indonesia</td>
                                        <td>Jawa Barat</td>
                                        <td>Bandung</td>
                                        <td>Silahkan Isikan deskripsi disini</td>
                                        <td><span class="badge badge-success">Active</span></td>
                                        <td class="text-center">
                                            <div class="list-icons">
                                                <div class="dropdown">
                                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                        <i class="icon-menu9"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"><i class="icon-check"></i>
                                                            Set Active</a>
                                                        <a class="dropdown-item"><i
                                                                class="icon-cross3"></i> Set Inactive</a>
                                                   
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mal</td>
                                        <td>Indonesia</td>
                                        <td>Jawa Timur</td>
                                        <td>Malang</td>
                                        <td>Silahkan Isikan deskripsi disini</td>
                                        <td><span class="badge badge-success">Active</span></td>
                                        <td class="text-center">
                                            <div class="list-icons">
                                                <div class="dropdown">
                                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                        <i class="icon-menu9"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"><i class="icon-check"></i>
                                                            Set Active</a>
                                                        <a class="dropdown-item"><i
                                                                class="icon-cross3"></i> Set Inactive</a>
                                                   
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sub</td>
                                        <td>Indonesia</td>
                                        <td>Jawa Timur</td>
                                        <td>Surabaya</td>
                                        <td>Silahkan Isikan deskripsi disini</td>
                                        <td><span class="badge badge-success">Active</span></td>
                                        <td class="text-center">
                                            <div class="list-icons">
                                                <div class="dropdown">
                                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                        <i class="icon-menu9"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"><i class="icon-check"></i>
                                                            Set Active</a>
                                                        <a class="dropdown-item"><i
                                                                class="icon-cross3"></i> Set Inactive</a>
                                                   
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                  
                                </tbody>
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
						<h5 class="modal-title">Add City</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="code">Code</label>
							<input type="text" class="form-control" id="code">
							<br>
							<label for="description">City</label>
							<input type="text" class="form-control" id="description">
							<br>
							<label for="description">Description</label>
							<input type="text" class="form-control" id="description">
							<br>
                            <br>
							<label for="cars">Country:</label>
							<select id="cars" name="cars" class="form-control">
								<option value="volvo">Indonesia</option>
								<option value="saab">Malaysia</option>
                                <option value="saab">Thailand</option>
							</select>
							<br>
                            <br>
							<label for="cars">Province:</label>
							<select id="cars" name="cars" class="form-control">
								<option value="volvo">Jawa Timur</option>
								<option value="saab">Jawa Tengah</option>
                                <option value="saab">Jawa Barat</option>
							</select>
							<br>
							<div style = "float:right;margin-bottom:20px;">
							<button type="button" class="btn btn-primary" style = "margin-right:10px;" onclick="">Save</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		<!-- End Modal -->
</body>

</html>