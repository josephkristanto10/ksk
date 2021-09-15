<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$sql = "select k.nohp,k.nik, k.nama, lsc.name as sistername, lbranch.branch, lbuilding.description as buildingname, lfloor.floor, lroom.room, lp.updatedat, depa.department, divi.divisi from logpic lp 
inner join karyawan k on k.nik = lp.iduser
inner join divisi divi on divi.id = lp.iddivisi
inner join department depa on depa.id = lp.iddepartment
inner join location_sister_company lsc on lsc.id = lp.idsistercompany 
inner join location_branch lbranch on lbranch.idbranch = lp.idbranch
inner join location_building lbuilding on lbuilding.id = lp.idbuilding 
inner join location_floor lfloor on lfloor.id = lp.idfloor
inner join location_room lroom on lroom.id = lp.idroom";
$res = $conn->query($sql);
?>

		<div class="content-wrapper">
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<h4><span class="font-weight-semibold">Master PIC</span></h4>
					<div class="page-title d-flex">
						<div class="row" style="width:100%;">
							<div class="col-xl-12">
								<button class="btn btn-info" style="background-color:#26a69a !important;width:150px;"><i
										class="icon-add"></i> &nbsp Add PIC</button>
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
							<table class="table datatable-fixed-left">
								<thead>
									<tr>
										<th>NIK</th>
										<th>Name</th>
										<th>SisterCompany</th>
										<th>Branch</th>
										<th>Building</th>
										<th>Floor</th>
										<th>Rooms</th>
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
										<td>'.$r['sistername'].'</td>
										<td>'.$r['branch'].'</td>
										<td>'.$r['buildingname'].'</td>
										<td>'.$r['floor'].'</td>
										<td>'.$r['room'].'</td>
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