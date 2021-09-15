<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$sql = "select *, c.description as categorydesc from kategori_categorysubgroup c inner join kategori_asset ka on ka.id = c.idgroup inner join kategori_subgroup ks on ks.id = c.idsubgroup ";
$res = $conn->query($sql);
$sqlaset = "select * from kategori_asset";
$resultkategoriaset = $conn->query($sqlaset);
if($resultkategoriaset -> num_rows>0)
{
	while($r = mysqli_fetch_array($resultkategoriaset))
	{
		$row[] = $r;
	}
}
?>


		<div class="content-wrapper">
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<h4><span class="font-weight-semibold">Master Category Sub Group</span></h4>
					<div class="page-title d-flex">
						<div class="row" style="width:100%;">
							<div class="col-xl-12">
								<a href="#myModal" data-toggle="modal">
									<button class="btn btn-info"
										style="background-color:#26a69a !important;width:200px;"><i
											class="icon-add"></i> &nbsp Category Sub Group </button>
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


							<table id="datatable_serverside"
								class="table table-hover table-bordered display nowrap w-100">
								<thead>
									<tr>

										<th>Group</th>
										<th>Sub Group</th>
										<th>Category</th>
										<th>Description</th>
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
						<h5 class="modal-title">Add Category Sub Group</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
						<form id="myform">
							<div class="form-group">
								<label for="code">Category</label>
								<input type="text" class="form-control" id="category">
								<br>

								<label for="cars">Group:</label>
								<select id="group" name="group" class="form-control">
									<?php
										if(count($row)>0)
										{
											for($i = 0 ; $i < count($row) ; $i++)
											{
												echo '<option value="'.$row[$i]['id'].'">'.$row[$i]['nama'].'</option>';
											}
										}
								?>
								</select>
								<br>

								<label for="cars">Sub Group:</label>
								<select id="subgroup" name="subgroup" class="form-control">
								</select>
								<br>
								<label for="description">Description</label>
								<input type="text" class="form-control" id="descriptionadd">

							</div>
						</form>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="adddata()">Save</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal"
							id="canceladd">Cancel</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="myModaledit">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background-color:#324148;color:white;height:60px;">
						<h5 class="modal-title">Edit Category Sub Group</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div>
					<div class="modal-body">
						<form id="myformedit">
							<div class="form-group">
								<input type="hidden" id="idchange">
								<input type="hidden" id="idsubgroup">
								<label for="code">Category</label>
								<input type="text" class="form-control" id="categoryedit">
								<br>

								<label for="cars">Group:</label>
								<select id="groupedit" name="groupedit" class="form-control">
									<?php
										// if($resultkategoriaset->num_rows>0)
										// {
										// 	while($r = mysqli_fetch_array($resultkategoriaset))
										// 	{
										// 		echo '<option value="'.$r['id'].'">'.$r['nama'].'</option>';
										// 	}
											
										// }
										if(count($row)>0)
										{
											for($j = 0 ; $j < count($row) ; $j++)
											{
												echo '<option value="'.$row[$j]['id'].'">'.$row[$j]['nama'].'</option>';
											}
										}
								?>
								</select>
								<br>
								<label for="cars">Sub Group:</label>
								<select id="subgroupedit" name="subgroupedit" class="form-control">
								</select>
								<br>
								<label for="description">Description</label>
								<input type="text" class="form-control" id="descriptionedit">

							</div>
						</form>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="changedata()">Save</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal"
							id="canceledit">Cancel</button>
					</div>
				</div>
			</div>
		</div>
</body>

</html>
<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
	var flag = false;
	//   $("#subgroup").prop("disabled", "true");
	$(function () {
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
			order: [
				[0, 'asc']
			],
			ajax: {
				url: 'process/masterkategoricategorysubgroup.php',
				method: 'POST',
				data: {
					tipe: "load"
				}
			},
			columns: [{
					name: 'Group',
					searchable: false,
					className: 'text-center align-middle'
				},
				{
					name: 'SubGroup',
					className: 'text-center align-middle'
				},
				{
					name: 'Category',
					className: 'text-center align-middle'
				},
				{
					name: 'Description',
					className: 'text-center align-middle'
				},
				{
					name: 'Status',
					className: 'text-center align-middle'
				},
				{
					name: 'Action',
					searchable: false,
					orderable: false,
					className: 'text-center align-middle'
				}

			]
		});
	};

	// Reload table
	function success() {
		$('#datatable_serverside').DataTable().ajax.reload(null, false);
	};

	function setstatus(setactionto) {
		var elements = setactionto.split("-");
		var myid = elements[0];
		var mystat = elements[1];
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url: "process/masterkategoricategorysubgroup.php",
			method: 'POST',
			data: {
				tipe: "setstatus",
				myidchange: myid,
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
	};
	var globalid = "";

	function openmodaledit(element) {
		// 
		var idelement = element.id.split("-");
		$("#idchange").val(idelement[1]);

		var namagrup = $("#nama" + idelement[1]).text();
		var subgruop = $("#subgroup" + idelement[1]).text();
		globalid = idelement[3];
		var category = $("#category" + idelement[1]).text();
		var descgruop = $("#description" + idelement[1]).text();
		var selectgroup = $('#groupedit option[value=' + idelement[2] + ']').prop('selected', true);

		// alert(idelement[3]);
		$("#groupedit").trigger('change');
		$('#categoryedit').val(category);
		$('#descriptionedit').val(descgruop);
	}


	function changedata() {
		var changeid = $("#idchange").val();
		var changecategory = $("#categoryedit").val();
		var changegroup = $("#groupedit").val();
		var changesubgroup = $("#subgroupedit").val();
		var changedescription = $('#descriptionedit').val();
		if (changecategory == "" || changesubgroup == null || changedescription == "") {
			Swal.fire({
				icon: 'error',
				title: 'Empty Field',
				text: 'Group / Subgroup / Category / Description Is Empy',
				confirmButtonColor: '#e00d0d',
			});
		} else {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: "process/masterkategoricategorysubgroup.php",
				method: 'POST',
				data: {
					tipe: "changedata",
					myid: changeid,
					mycategory: changecategory,
					mygroup: changegroup,
					mysubgroup: changesubgroup,
					mydesc: changedescription

				},
				success: function (result) {
					if (result == "sukses") {
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
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Duplicated Category Name',
							text: 'Duplicate Entry For This Group, Sub Group, Category',
							confirmButtonColor: '#e00d0d',
						});
					}




				}
			});
		}
	}

	function adddata() {
		var mycat = $("#category").val();
		var mygroup = $("#group").val();
		var mysubgroup = $("#subgroup").val();
		var mydesc = $("#descriptionadd").val();
		if (mycat == "" || mysubgroup == null) {
			Swal.fire({
				icon: 'error',
				title: 'Empty Field',
				text: 'Group / Category Is Empy',
				confirmButtonColor: '#e00d0d',
			});
		} else {

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: "process/masterkategoricategorysubgroup.php",
				method: 'POST',
				data: {
					tipe: "addcategory",
					mycategory: mycat,
					group: mygroup,
					sub: mysubgroup,
					desc: mydesc

				},
				success: function (result) {
					if (result == "sukses") {
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
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Duplicated Category Name',
							text: 'Duplicate Entry For This Group, Sub Group, Category',
							confirmButtonColor: '#e00d0d',
						});
					}




				}
			});

		}
	}
	//    function changegroupedit(myid)
	$("#groupedit").on('change', function () {
		var myid = this.value;
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url: "process/masterkategoricategorysubgroup.php",
			method: 'POST',
			data: {
				tipe: "getsubgroup",
				idgroup: myid

			},
			success: function (result) {
				// alert(result);
				if (result == "none") {
					$("#subgroupedit").html("");
					// $("#subgroupedit").prop("disabled", true);

				} else {
					$("#subgroupedit").html(result).promise().done(function () {

						if (!globalid == "") {
							// alert(globalid);
							$('#subgroupedit').find('option[value="' + globalid + '"]').prop(
								'selected', true);
						}
					});
				}



			}
		});
	}).trigger('change');
	$("#group").on('change', function () {
		var myid = this.value;
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url: "process/masterkategoricategorysubgroup.php",
			method: 'POST',
			data: {
				tipe: "getsubgroup",
				idgroup: myid

			},
			success: function (result) {
				// alert(result);
				if (result == "none") {
					$("#subgroup").html("");
					$("#subgroup").prop("disabled", true);
				} else {
					$("#subgroup").html(result);
					$('#subgroup').removeAttr('disabled')
				}



			}
		});
	}).trigger('change');
</script>