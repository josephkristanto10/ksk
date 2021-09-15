<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$sql = "SELECT k.nik, k.nama, k.nohp, divi.divisi, depa.department FROM logpicdepartment lpd 
inner join karyawan k on k.nik = lpd.iduser 
inner join location_sister_company lsc on lsc.id = k.idsistercompany 
inner join location_branch lbranch on lbranch.idbranch = k.idbranch 
inner join location_building lbuilding on lbuilding.id = k.idbuilding 
inner join divisi divi on divi.id = k.iddivisi 
inner join department depa on depa.id = k.iddepartment ";
$res = $conn->query($sql);
?>

		<div class="content-wrapper">
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<h4><span class="font-weight-semibold">Master PIC (Department)</span></h4>
					<div class="page-title d-flex">
						<div class="row" style="width:100%;">
							<div class="col-xl-12">
								<button class="btn btn-info" style="background-color:#26a69a !important;width:200px;"><i
										class="icon-add"></i> &nbsp Add PIC Department</button>
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


							<table class="table table-bordered table-hover datatable-highlight">
								<thead>
									<tr>

										<th>NIK</th>
										<th>Name</th>
										<th>Divisi</th>
										<th>Department</th>
										<th>Handphone</th>
										<th class="text-center">Status</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									
								<?php
                                if($res->num_rows>0)
                                {
                                    while($r = mysqli_fetch_array($res))
                                    {
                                        echo
                                        '<tr>
										<td>'.$r['nik'].'</td>
										<td>'.$r['nama'].'</td>
										<td>'.$r['divisi'].'</td>
										<td>'.$r['department'].'</td>
										<td>'.$r['nohp'].'</td>
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
														<a class="dropdown-item"><i class="icon-cross3"></i> Set
															Inactive</a>

													</div>
												</div>
											</div>
										</td>
									</tr>';
                                    }
                                    
                                }
                                else{
                                    
                                }
									
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
</body>

</html>