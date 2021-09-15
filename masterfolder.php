<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$sql = "select f.barcode, f.code as foldercode, f.folder, f.description, lsc.name as sistername, lbranch.branch, lbuilding.description as buildingname, lrack.rackname , lfloor.floor, lroom.room FROM folder f
inner join location_sister_company lsc on lsc.id = f.idsistercompany 
inner join location_branch lbranch on lbranch.idbranch = f.idbranch
inner join location_building lbuilding on lbuilding.id = f.idbuilding
inner join location_floor lfloor on lfloor.id = f.idfloor
inner join location_room lroom on lroom.id = f.idroom
inner join rack lrack on lrack.id = f.idroom";
$res = $conn->query($sql);

?>
        <div class="content-wrapper">
            <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <h4><span class="font-weight-semibold">Master Folder</span></h4> 
                    <div class="page-title d-flex">
                        <div class = "row" style = "width:100%;">
                            <div class = "col-xl-12" >
							<a href="#myModal" data-toggle="modal"> <button class = "btn btn-info" style = "background-color:#26a69a !important;width:120px;"><i class = "icon-add"></i> &nbsp Add Folder</button></a>
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

                                        <th>Code</th>
                                        <th>Barcode</th>
                                        <th>SisterCompany</th>
                                        <th>Branch</th>
                                        <th>Building</th>
                                        <th>Floor</th>
                                        <th>Rooms</th>
                                        <th>Rack</th>    
                                        <th>Folder</th>
                                        <th>Date</th>                            
                                        <th>Description</th>
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
										<td>'.$r['foldercode'].'</td>
										<td>'.$r['barcode'].'</td>
										<td>'.$r['sistername'].'</td>
										<td>'.$r['branch'].'</td>
										<td>'.$r['buildingname'].'</td>
                                        <td>'.$r['floor'].'</td>
                                        <td>'.$r['room'].'</td>
										<td>'.$r['rackname'].'</td>
                                        <td>'.$r['folder'].'</td>
										<td> 02-05-2020</td>
										<td>'.$r['description'].'</td>
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
<div class="modal fade" id="myModal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background-color:#324148;color:white;height:60px;">
						<h5 class="modal-title">Add Folder</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="code">Code</label>
							<input type="text" class="form-control" id="code">
							<br>
							<label for="description">Description</label>
							<input type="text" class="form-control" id="description">
							<br>
							<label for="cars">Building:</label>
							<select id="cars" name="cars" class="form-control">
								<option value="volvo">Area Kantor Utama</option>
								<option value="saab">Area Ruangan Meeting Kantor Utama</option>
							</select>
							<br>
							<label for="cars">Floor:</label>
							<select id="cars" name="cars" class="form-control">
								<option value="volvo">Floor 1</option>
								<option value="saab">Floor 2</option>
								<option value="saab">Floor 3</option>
							</select>
							<br>
							<br>
							<label for="cars">Rooms:</label>
							<select id="cars" name="cars" class="form-control">
								<option value="volvo">Ruangan Meeting</option>
								<option value="saab">Ruangan Penyimpanan</option>
								<option value="saab">Ruangan Diskusi</option>
							</select>
							<br>
							<label for="cars">Rack:</label>
							<select id="cars" name="cars" class="form-control">
								<option value="volvo">Rack A</option>
								<option value="saab">Rack B</option>
								<option value="saab">Rack C</option>
							</select>
							<br>
							<label for="description">Folder</label>
							<input type="text" class="form-control" id="description">
							<br>
							
							<div style = "float:right;margin-bottom:20px;">
							<button type="button" class="btn btn-primary" style = "margin-right:10px;" onclick="">Submit</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		<!-- End Modal -->
</body>

</html>