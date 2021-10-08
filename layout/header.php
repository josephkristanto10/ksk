<?php
session_start();
// session_destroy();

require 'connection.php';
$sql = "select * from location_sister_company";
$res = $conn->query($sql);
$listcompany = array();
if($res -> num_rows>0)
{
	while($r = mysqli_fetch_array($res)){
		$listcompany[] = $r;
	}
}
$idlist = $listcompany[0]['id'];
if(isset($_SESSION['idsister']))
{
	$idlist = $_SESSION['idsister'];
}
else{
	$_SESSION['idsister'] = $listcompany[0]['id'];
}
$name = $listcompany[0]['name'];
if(isset($_SESSION['namasister']))
{
	$name = $_SESSION['namasister'];
}
else{
	$_SESSION['namasister'] = $listcompany[0]['name'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

	<?php
if(!isset($_SESSION['iduser']))
{
	?>
	<style>
		body{
			background-color:#115591;
		}
	</style>
	<?php
	echo " ";
	echo"<div style = 'position:absolute;width:100%;height:100%;background-color:#115591;z-index:700'></div>";
	echo "
	<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
	<script>
	Swal.fire({
		icon: 'info',
		title: 'Nexus Admin Area',
		text: 'Please Sign In First',
		allowOutsideClick: false,
		confirmButtonColor: '#3495eb',
	}).then((result) => {
		window.location.replace('index.php');
	});;
	</script>
	";
	die;
}

?>


	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>NEXUS - Integrated System</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
		type="text/css">
	<link href="<?=$url;?>global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
	<link href="<?=$url;?>global_assets/css/icons/material/styles.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- <link href="assets/css/colors.min.css" rel="stylesheet" type="text/css"> -->
	<link rel="shortcut icon" type="image/png" href="<?=$url;?>assets/icon.png" />
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
	<script type="text/javascript" src="<?=$url;?>global_assets/js/plugins/pickers/pickadate/picker.js"></script>
	<script type="text/javascript" src="<?=$url;?>global_assets/js/plugins/pickers/pickadate/picker.time.js"></script>
	<script type="text/javascript" src="<?=$url;?>global_assets/js/plugins/pickers/pickadate/picker.date.js"></script>
	<script src="<?=$url;?>global_assets/js/plugins/pickers/anytime.min.js"></script>
	<script src="<?=$url;?>global_assets/js/demo_pages/picker_date.js"></script>

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

	<script src="<?=$url;?>global_assets/js/plugins/forms/wizards/steps.min.js"></script>
	<script src="<?=$url;?>global_assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script src="<?=$url;?>global_assets/js/demo_pages/form_wizard.js"></script>
	<script src="<?=$url;?>global_assets/js/plugins/forms/validation/validate.min.js"></script>
	<script src="<?=$url;?>global_assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- <script src="<?=$url;?>global_assets/js/plugins/uploaders/dropzone.min.js"></script>
	<script src="<?=$url;?>global_assets/js/demo_pages/uploader_dropzone.js"></script> -->
	<script src="<?=$url;?>global_assets/js/plugins/uploaders/fileinput/plugins/purify.min.js"></script>
	<script src="<?=$url;?>global_assets/js/plugins/uploaders/fileinput/plugins/sortable.min.js"></script>
	<script src="<?=$url;?>global_assets/js/plugins/uploaders/fileinput/fileinput.min.js"></script>
<script src="<?=$url;?>global_assets/js/demo_pages/uploader_bootstrap.js"></script>
<script src="<?=$url;?>global_assets/js/plugins/ui/perfect_scrollbar.min.js"></script>
	<!-- <script src="<?=$url;?>global_assets/js/demo_pages/uploader_plupload.js"></script> -->
	<style>
		th {
			background-color: #324148;
			color: white;
			text-align: center;
		}

		td {
			color: #000000 !important;
			text-align: center;
		}

		#myModal .modal-dialog {
			-webkit-transform: translate(0, -50%);
			-o-transform: translate(0, -50%);
			transform: translate(0, -50%);
			top: 50%;
			margin: 0 auto;
		}

		.dataTables_scrollBody {
			min-height: 120px !important;
		}

		.modal-body {
			height: 60vh !important;
			overflow-y: auto;
		}

		#datatable_serverside_info,
		#datatable_serverside_paginate {
			margin-top: 50px;
		}

		.card {
			padding: 15px;
		}
	</style>
</head>

<body class = 'custom-scrollbars'>
	<div class="navbar navbar-expand-md navbar-dark" style = "height:60px;">
	
	<div class="navbar navbar-dark bg-dark-100 navbar-static border-0" style="height:55px;margin-top:0px;margin-left:20px;margin-right:20px;">
				<div class="navbar-brand flex-fill wmin-0 text-center">
					<a href="ksk/dashboards.php" class="d-inline-block">
                        <h5 class="sidebar-resize-hide mb-0 text-white text-uppercase font-weight-bold" style="font-size:18.5px;">My Nexus Asset</h5>
                     
					</a>
				</div>
			</div>
		<div class="d-md-none">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
				<i class="icon-tree5"></i>
			</button>
			<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
				<i class="icon-paragraph-justify3"></i>
			</button>
		</div>

		<div class="collapse navbar-collapse" id="navbar-mobile">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
						<i class="icon-paragraph-justify3"></i>
					</a>
				</li>

				<li class="nav-item dropdown">
					<a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
						<i class="icon-git-compare"></i>
						<span class="d-md-none ml-2">Git updates</span>
						<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">9</span>
					</a>

					<div class="dropdown-menu dropdown-content wmin-md-350">
						<div class="dropdown-content-header">
							<span class="font-weight-semibold">Git updates</span>
							<a href="#" class="text-default"><i class="icon-sync"></i></a>
						</div>

						<div class="dropdown-content-body dropdown-scrollable">
							<ul class="media-list">
								<li class="media">
									<div class="mr-3">
										<a href="#"
											class="btn bg-transparent border-primary text-primary rounded-round border-2 btn-icon"><i
												class="icon-git-pull-request"></i></a>
									</div>

									<div class="media-body">
										Drop the IE <a href="#">specific hacks</a> for temporal inputs
										<div class="text-muted font-size-sm">4 minutes ago</div>
									</div>
								</li>

								<li class="media">
									<div class="mr-3">
										<a href="#"
											class="btn bg-transparent border-warning text-warning rounded-round border-2 btn-icon"><i
												class="icon-git-commit"></i></a>
									</div>

									<div class="media-body">
										Add full font overrides for popovers and tooltips
										<div class="text-muted font-size-sm">36 minutes ago</div>
									</div>
								</li>

								<li class="media">
									<div class="mr-3">
										<a href="#"
											class="btn bg-transparent border-info text-info rounded-round border-2 btn-icon"><i
												class="icon-git-branch"></i></a>
									</div>

									<div class="media-body">
										<a href="#">Chris Arney</a> created a new <span
											class="font-weight-semibold">Design</span> branch
										<div class="text-muted font-size-sm">2 hours ago</div>
									</div>
								</li>

								<li class="media">
									<div class="mr-3">
										<a href="#"
											class="btn bg-transparent border-success text-success rounded-round border-2 btn-icon"><i
												class="icon-git-merge"></i></a>
									</div>

									<div class="media-body">
										<a href="#">Eugene Kopyov</a> merged <span
											class="font-weight-semibold">Master</span> and <span
											class="font-weight-semibold">Dev</span> branches
										<div class="text-muted font-size-sm">Dec 18, 18:36</div>
									</div>
								</li>

								<li class="media">
									<div class="mr-3">
										<a href="#"
											class="btn bg-transparent border-primary text-primary rounded-round border-2 btn-icon"><i
												class="icon-git-pull-request"></i></a>
									</div>

									<div class="media-body">
										Have Carousel ignore keyboard events
										<div class="text-muted font-size-sm">Dec 12, 05:46</div>
									</div>
								</li>
							</ul>
						</div>

						<div class="dropdown-content-footer bg-light">
							<a href="#" class="text-grey mr-auto">All updates</a>
							<div>
								<a href="#" class="text-grey" data-popup="tooltip" title="Mark all as read"><i
										class="icon-radio-unchecked"></i></a>
								<a href="#" class="text-grey ml-2" data-popup="tooltip" title="Bug tracker"><i
										class="icon-bug2"></i></a>
							</div>
						</div>
					</div>
				</li>
			</ul>

			<span class="badge bg-success ml-md-3 mr-md-auto">Online</span>

			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<!-- <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
						<i class="icon-people"></i>
						<span class="d-md-none ml-2">Users</span>
					</a> -->
				
					<div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-300">
						<div class="dropdown-content-header">
							<span class="font-weight-semibold">Users online</span>
							<a href="#" class="text-default"><i class="icon-search4 font-size-base"></i></a>
						</div>

						<div class="dropdown-content-body dropdown-scrollable">
							<ul class="media-list">
								<li class="media">
									<div class="mr-3">
										<img src="../../../../global_assets/images/placeholders/placeholder.jpg"
											width="36" height="36" class="rounded-circle" alt="">
									</div>
									<div class="media-body">
										<a href="#" class="media-title font-weight-semibold">Jordana Ansley</a>
										<span class="d-block text-muted font-size-sm">Lead web developer</span>
									</div>
									<div class="ml-3 align-self-center"><span
											class="badge badge-mark border-success"></span></div>
								</li>

								<li class="media">
									<div class="mr-3">
										<img src="../../../../global_assets/images/placeholders/placeholder.jpg"
											width="36" height="36" class="rounded-circle" alt="">
									</div>
									<div class="media-body">
										<a href="#" class="media-title font-weight-semibold">Will Brason</a>
										<span class="d-block text-muted font-size-sm">Marketing manager</span>
									</div>
									<div class="ml-3 align-self-center"><span
											class="badge badge-mark border-danger"></span></div>
								</li>

								<li class="media">
									<div class="mr-3">
										<img src="../../../../global_assets/images/placeholders/placeholder.jpg"
											width="36" height="36" class="rounded-circle" alt="">
									</div>
									<div class="media-body">
										<a href="#" class="media-title font-weight-semibold">Hanna Walden</a>
										<span class="d-block text-muted font-size-sm">Project manager</span>
									</div>
									<div class="ml-3 align-self-center"><span
											class="badge badge-mark border-success"></span></div>
								</li>

								<li class="media">
									<div class="mr-3">
										<img src="../../../../global_assets/images/placeholders/placeholder.jpg"
											width="36" height="36" class="rounded-circle" alt="">
									</div>
									<div class="media-body">
										<a href="#" class="media-title font-weight-semibold">Dori Laperriere</a>
										<span class="d-block text-muted font-size-sm">Business developer</span>
									</div>
									<div class="ml-3 align-self-center"><span
											class="badge badge-mark border-warning-300"></span></div>
								</li>

								<li class="media">
									<div class="mr-3">
										<img src="../../../../global_assets/images/placeholders/placeholder.jpg"
											width="36" height="36" class="rounded-circle" alt="">
									</div>
									<div class="media-body">
										<a href="#" class="media-title font-weight-semibold">Vanessa Aurelius</a>
										<span class="d-block text-muted font-size-sm">UX expert</span>
									</div>
									<div class="ml-3 align-self-center"><span
											class="badge badge-mark border-grey-400"></span></div>
								</li>
							</ul>
						</div>

						<div class="dropdown-content-footer bg-light">
							<a href="#" class="text-grey mr-auto">All users</a>
							<a href="#" class="text-grey"><i class="icon-gear"></i></a>
						</div>
					</div>
				</li>

				<li class="nav-item dropdown">


					<div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
						<div class="dropdown-content-header">
							<span class="font-weight-semibold">Messages</span>
							<a href="#" class="text-default"><i class="icon-compose"></i></a>
						</div>

						<div class="dropdown-content-body dropdown-scrollable">
							<ul class="media-list">
								<li class="media">
									<div class="mr-3 position-relative">
										<img src="../../../../global_assets/images/placeholders/placeholder.jpg"
											width="36" height="36" class="rounded-circle" alt="">
									</div>

									<div class="media-body">
										<div class="media-title">
											<a href="#">
												<span class="font-weight-semibold">James Alexander</span>
												<span class="text-muted float-right font-size-sm">04:58</span>
											</a>
										</div>

										<span class="text-muted">who knows, maybe that would be the best thing for
											me...</span>
									</div>
								</li>

								<li class="media">
									<div class="mr-3 position-relative">
										<img src="../../../../global_assets/images/placeholders/placeholder.jpg"
											width="36" height="36" class="rounded-circle" alt="">
									</div>

									<div class="media-body">
										<div class="media-title">
											<a href="#">
												<span class="font-weight-semibold">Margo Baker</span>
												<span class="text-muted float-right font-size-sm">12:16</span>
											</a>
										</div>

										<span class="text-muted">That was something he was unable to do
											because...</span>
									</div>
								</li>

								<li class="media">
									<div class="mr-3">
										<img src="../../../../global_assets/images/placeholders/placeholder.jpg"
											width="36" height="36" class="rounded-circle" alt="">
									</div>
									<div class="media-body">
										<div class="media-title">
											<a href="#">
												<span class="font-weight-semibold">Jeremy Victorino</span>
												<span class="text-muted float-right font-size-sm">22:48</span>
											</a>
										</div>

										<span class="text-muted">But that would be extremely strained and
											suspicious...</span>
									</div>
								</li>

								<li class="media">
									<div class="mr-3">
										<img src="../../../../global_assets/images/placeholders/placeholder.jpg"
											width="36" height="36" class="rounded-circle" alt="">
									</div>
									<div class="media-body">
										<div class="media-title">
											<a href="#">
												<span class="font-weight-semibold">Beatrix Diaz</span>
												<span class="text-muted float-right font-size-sm">Tue</span>
											</a>
										</div>

										<span class="text-muted">What a strenuous career it is that I've
											chosen...</span>
									</div>
								</li>

								<li class="media">
									<div class="mr-3">
										<img src="../../../../global_assets/images/placeholders/placeholder.jpg"
											width="36" height="36" class="rounded-circle" alt="">
									</div>
									<div class="media-body">
										<div class="media-title">
											<a href="#">
												<span class="font-weight-semibold">Richard Vango</span>
												<span class="text-muted float-right font-size-sm">Mon</span>
											</a>
										</div>

										<span class="text-muted">Other travelling salesmen live a life of
											luxury...</span>
									</div>
								</li>
							</ul>
						</div>

						<div class="dropdown-content-footer justify-content-center p-0">
							<a href="#" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="Load more"><i
									class="icon-menu7 d-block top-0"></i></a>
						</div>
					</div>
				</li>
				<li class="nav-item dropdown dropdown-user">
					<a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle"
						data-toggle="dropdown">
						<img src="<?=$url;?>assets/agency.png" height="28" alt=""> &nbsp &nbsp

						<span id="namecompany"><?= $name?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right">

						<?php
								for($i = 0 ; $i < count($listcompany);$i++) 
								{
								
									echo "<a class='dropdown-item' onclick = setsister('".$listcompany[$i]['id']."','".$listcompany[$i]['name']."')><i class='icon-check'></i>
									".$listcompany[$i]['name']."</a>";
									// echo "<a class='dropdown-item' onclick = setsister('".$listcompany[$i]['id']."-".$listcompany[$i]['name']."')><i class='icon-user-plus' ></i>".$listcompany[$i]['name']."</a>";
								}
							?>

					</div>


				</li>

				<li class="nav-item dropdown dropdown-user">

					<!-- <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle"
						data-toggle="dropdown">
						<img src="../../../../global_assets/images/placeholders/placeholder.jpg"
							class="rounded-circle mr-2" height="34" alt="">
						<span>Victoria</span>
					</a> -->

					<div class="dropdown-menu dropdown-menu-right">
						<a href="#" class="dropdown-item"><i class="icon-user-plus"></i> My profile</a>
						<a href="#" class="dropdown-item"><i class="icon-coins"></i> My balance</a>
						<a href="#" class="dropdown-item"><i class="icon-comment-discussion"></i> Messages <span
								class="badge badge-pill bg-blue ml-auto">58</span></a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item"><i class="icon-cog5"></i> Account settings</a>
						<a href="#" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</div>