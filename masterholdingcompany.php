<?php
require 'layout/header.php';
require 'layout/sidebar.php';
require_once 'layout/footer.php';
$sql = "select hc.code, hc.description, hc.id, hc.name , hc.address, hc.notelp, hc.modified, hc.created, city.name as cityname, 
		prov.name as provincename, coun.name as countryname 
		FROM holding_company hc inner join city on city.id = hc.idcity 
		inner join province prov on prov.id = hc.idprovince
		inner join country coun on coun.id = hc.idcountry ";
$res = $conn->query($sql);
?>

	
		<div class="content-wrapper">
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<h4><span class="font-weight-semibold">Master Holding Company</span></h4>
					<div class="page-title d-flex">
						<div class="row" style="width:100%;">
							<div class="col-xl-12">
							<a href="#myModal" data-toggle="modal" >
								<button class="btn btn-info" style="background-color:#26a69a !important;width:200px;"><i
										class="icon-add"></i> &nbsp Holding Company </button>
	</a>
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

										<th>Code</th>
										<th>Name</th>
										<th>Description</th>
										<th>Address</th>
										<th>Country</th>
                                        <th>Province</th>
                                        <th>City</th>
                                        <th>No Hp</th>
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
                                        '	<tr>
										<td>'.$r['code'].'</td>
										<td>'.$r['name'].'</td>
										<td>'.$r['description'].'</td>
										<td>'.$r['address'].'</td>
                                        <td>'.$r['countryname'].'</td>
                                        <td>'.$r['provincename'].'</td>
                                        <td>'.$r['cityname'].'</td>
                                        <td>'.$r['notelp'].'</td>
										<td><span class="badge badge-success">Active</span></td>
										<td>
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
			<div class="modal fade" id="myModal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background-color:#324148;color:white;height:60px;">
						<h5 class="modal-title">Add Holding Company</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
						<div class="form-group">
						<label for="code">Code</label>
    					<input type="text" class="form-control" id="code">
						<br>
                        <label for="code">Name</label>
    					<input type="text" class="form-control" id="code">
						<br>
                        <label for="code">No Hp</label>
    					<input type="text" class="form-control" id="code">
						<br>
                        
							<label for="cars">Country</label>
							<select id="cars" name="cars" class="form-control">
								<option value="volvo">Indonesia</option>
                                <option value="volvo">Singapore</option>
							</select>
							<br>
							<label for="cars">Province</label>
							<select id="cars" name="cars" class="form-control">
								<option value="volvo">Jawa Timur</option>
								<option value="saab">Jawa Tengah</option>
								<option value="saab">Jawa Barat</option>
                                <option value="saab">DKI Jakarta</option>
							</select>
							<br>
                            <label for="cars">City</label>
							<select id="cars" name="cars" class="form-control">
								<option value="volvo">Surabaya</option>
								<option value="saab">Malang</option>
								<option value="saab">Jakarta</option>
								<option value="saab">Jogja</option>
							</select>
							<br>
						<label for="description">Description</label>
    					<input type="text" class="form-control" id="description">

						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick = "">Submit</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- End Modal -->

</body>

</html>