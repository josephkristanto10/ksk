<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$sqlrelation = "select * from relation where status = 'Active'";
$resrelation = $conn->query($sqlrelation);
$myrelation = array();
if($resrelation -> num_rows>0)
{
	while($j = mysqli_fetch_array($resrelation))
	{
		$myrelation[] = $j;
	}
}
$sessionidsister = $idlist;
$sqlbranch = "select lbranch.* from location_setup_sister_branch lssb 
              inner join location_branch lbranch on lbranch.idbranch = lssb.idbranch where lssb.idsistercompany = '$sessionidsister'";
$resbranch = $conn->query($sqlbranch);
$mybranch = array();
if($resbranch -> num_rows>0)
{
	while($j = mysqli_fetch_array($resbranch))
	{
		$mybranch[] = $j;
	}
}
$sqlkategoriasset = "select * from kategori_asset";
$reskategoriasset  = $conn->query($sqlkategoriasset);
$mykategoriasset = array();
if($reskategoriasset -> num_rows>0)
{
	while($j = mysqli_fetch_array($reskategoriasset))
	{
		$mykategoriasset[] = $j;
	}
}
$sqlasset = "select asset.id, asset.noasset, asset.name from asset ";
$resasset  = $conn->query($sqlasset);
$myasset = array();
if($resasset -> num_rows>0)
{
	while($j = mysqli_fetch_array($resasset))
	{
		$myasset[] = $j;
	}
}
$sqldepartment = "select * from department";
$resdepartment  = $conn->query($sqldepartment);
$mydepartment = array();
if($resdepartment -> num_rows>0)
{
	while($j = mysqli_fetch_array($resdepartment))
	{
		$mydepartment[] = $j;
	}
}
?>

<head>
    <style>
        #myModalDisplay {
            height: 95vh !important;
        }

        .modal-body {
            width: 100%;
            height: 95vh !important;


        }

        .fileinput-upload-button {
            display: none;
        }

        .nav-tabs>.nav-item>.active {
            background-color: #26a69a !important;
        }
    </style>
</head>
<!-- Main navbar -->


<div class="content-wrapper">
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <h4><span class="font-weight-semibold">Displacement transaction to other department</span></h4>
            <div class="page-title d-flex">
                <div class="row" style="width:100%;">
                    <div class="col-xl-12">
                        <a href="#myModal" data-toggle="modal"><button type="button"
                                style="background-color:#26a69a !important; color:white; width:200px;"
                                class="btn btn-indigo btn-labeled btn-labeled-left" onclick="cancel()"
                                data-toggle="modal" data-target="#modal_form">
                                <b><i class="icon-plus-circle2"></i></b> Add Transaction
                            </button></a>
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

                    <table id="datatable_serverside" class="table table-hover table-bordered display nowrap w-100">
                        <thead>
                            <tr>
                               <th>Approval</th>
                                <th>Date</th>
                                <th>Transaction</th>
                                <th>Branch</th>
                                <th>toBranch</th>
                                <th>No Asset</th>
                                <th>Asset</th>
                                <th>Room</th>
                                <th>toRoom</th>
                                <th>Remark</th>
                               
                                <th>Lead Time</th>

                            </tr>
                        </thead>
                        </tbody>
                       

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="myModals">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
						<h5 class="modal-title">Add Assets</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>

					</div> -->
            <div class="modal-body">
                <div class="card">
                    <!-- <div class="card-header bg-white header-elements-inline">
						<h6 class="card-title"> Asset <?php echo $_SESSION['namasister']; ?></h6>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div> -->
                    <center>
                        <h4><span class="font-weight-semibold">Add Asset Form</span></h4>
                        <h6 style="color:grey;">Please fill any requirement data to add asset</h6>
                    </center>
                    <form class="wizard-form steps-validation" id="myform" method="post" enctype="multipart/form-data"
                        data-fouc>
                        <input type="hidden" name="tipe" value="addassetform">
                        <h6>General</h6>
                        <fieldset>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="noasset">No Asset</label><input type="text"
                                            class="form-control required" name="noasset" id="noasset" />


                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <!-- <label for="noasset">No Asset</label><input type="text" class = "form-control"  name="noasset" id="noasset" /> -->

                                        <label for="name">Name</label><input type="text" class="form-control required"
                                            name="name" id="name" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="idgroup">Group</label>
                                        <select class="form-control required" name="group" id="group"
                                            onchange="searchsubgroup(this)">
                                            <?php
                                                for($i = 0 ; $i < count($myasset); $i++)
                                                {
                                                    echo '<option value = "'.$myasset[$i]['id'].'">'.$myasset[$i]['nama'].'</option>';
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="idinitialcondition">Initial Condition</label>
                                        <select class="form-control" name="initialcondition" id="initialcondition">
                                            <?php
                                            for($i = 0 ; $i < count($myinitial); $i++)
                                            {
                                                echo '<option value = "'.$myinitial[$i]['id'].'">'.$myinitial[$i]['initial_condition'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="idsubgroup">Subgroup</label>
                                        <select class="form-control required" name="subgroup" id="subgroup"
                                            onchange="searchcategory(this)">
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="idcondition">Condition</label>
                                        <select class="form-control required" name="condition" id="condition">
                                            <?php
                                for($i = 0 ; $i < count($myconditions); $i++)
                                {
                                    echo '<option value = "'.$myconditions[$i]['id'].'">'.$myconditions[$i]['name'].'</option>';
                                }
                                ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="idcategory">Category</label>
                                        <select class="form-control required" id="category" name="category">
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </fieldset>

                        <h6>Purchase</h6>
                        <fieldset>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="noasset">No. PO</label>
                                        <input type="text" class="form-control required" name="nopo" id="nopo" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Purchase From:</label>
                                        <select name="relation" data-placeholder="Choose a Country..."
                                            class="form-control form-control-select2 required" data-fouc>
                                            <?php
                                            for($i = 0 ; $i < count($myrelation); $i++)
                                            {
                                                echo '<option value = "'.$myrelation[$i]['id'].'">'.$myrelation[$i]['company'].'</option>';
                                            }
                                        ?>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="noasset">Posting Date</label>
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                            </span>
                                            <input type="text" class="form-control pickadate required"
                                                name="postingdate" id="postingdate" value="<?php date_default_timezone_set('Asia/Jakarta');
echo date('d-m-Y');?>">

                                        </div>
                                        <input type="checkbox" name="statuspostingdate" id="statuspostingdate"
                                            value="yes" style="margin-top:10px;margin-left:10px;"> &nbsp <label>After
                                            15?</label>

                                        <!-- <input type="date" class = "form-control required"  name="postingdate" id="postingdate" /> -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="noasset">Purchase Price</label>
                                        <input type="text" class="form-control required" name="purchaseprice"
                                            id="purchaseprice" value="0" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="noasset">PPN</label>
                                        <!-- <input type="text" class = "form-control required"  name="ppn" id="ppn" /> -->
                                        <select data-placeholder="Choose PPN" name="ppn" id='ppn'
                                            class="form-control form-control-select2 required" onchange="setppn(this)"
                                            data-fouc>
                                            <option value="0">No PPN</option>
                                            <option value="0.1">10%</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="noasset">Total Purchase Price</label>
                                        <input type="text" class="form-control required" name="totalpurchaseprice"
                                            id="totalpurchaseprice" value="0" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="noasset">Economical Life Time</label>
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text">MONTH</span>
                                            </span>
                                            <input type="text" class="form-control required" name="economicallifetime"
                                                value="0" id="economicallifetime"
                                                onkeyup="javascript:return isNumber(event)" />
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="noasset">Cost Per Month</label>
                                        <input type="text" class="form-control required" name="costpermonth"
                                            id="costpermonth" value="0" readonly />
                                    </div>
                                </div>
                            </div>

                        </fieldset>

                        <h6>Waranty Period & Image</h6>
                        <fieldset>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Start : </label>
                                        <input type="text" class="form-control pickadate required" name="startwarranty"
                                            id="startwarranty" value="<?php date_default_timezone_set('Asia/Jakarta');
echo date('d-m-Y');?>">
                                        <!-- <input type="text" name="experience-company" placeholder="Start Warranty" class="form-control" id = "startwarranty"> -->
                                    </div>


                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>End:</label>
                                        <input type="text" class="form-control pickadate required" name="endwarranty"
                                            id="endwarranty" value="<?php date_default_timezone_set('Asia/Jakarta');
echo date('d-m-Y');?>">
                                    </div>


                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <!-- <label class="d-block">Attachment:</label> -->
                                        <!-- <p class="font-weight-semibold">Multiple file upload example:</p> -->

                                        <div class="form-group row">
                                            <label
                                                class="col-lg-2 col-form-label font-weight-semibold">Attachment:</label>
                                            <div class="col-lg-10">
                                                <input type="file" name="myfile[]" class="file-input"
                                                    multiple="multiple" data-fouc>
                                                <span class="form-text text-muted">Automatically convert a file input to
                                                    a bootstrap file input widget by setting its class as
                                                    <code>file-input</code>.</span>
                                            </div>
                                        </div>
                                        <!-- <input type="file" name="resume" class="form-input-styled required" multiple data-fouc> -->
                                        <span class="form-text text-muted">Accepted image only</span>
                                    </div>
                                </div>


                            </div>
                        </fieldset>

                        <h6>Custom</h6>
                        <fieldset>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Template : </label>
                                        <input type="hidden" id="template" name="template">
                                        <b><label id="templatename">-</label></b>
                                    </div>


                                </div>



                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="idcustomquestion" id="idcustomquestion">
                                    <div class="form-group" id="customquestion">

                                    </div>


                                </div>



                            </div>

                        </fieldset>


                    </form>
                </div>

                <!-- <form id = "myform">
						<div class="form-group">
                        <label for="idgroup">Sister Company</label><input type="text" class = "form-control" name="idgroup" id="idgroup" value = "<?php echo $_SESSION['namasister']; ?>" disabled />
                        <br class="clear" /> 
                        <label for="idgroup">Group</label>
                        <select class="form-control" id="group">
                                <?php
                                for($i = 0 ; $i < count($myasset); $i++)
                                {
                                    echo '<option value = "'.$myasset[$i]['id'].'">'.$myasset[$i]['nama'].'</option>';
                                }
                                ?>
                            </select>
                        <br class="clear" /> 
                        <label for="idsubgroup">Subgroup</label>
                        <select class="form-control" id="subgroup">
                            </select>
                        <br class="clear" /> 
                        <label for="idcategory">Category</label>
                        <select class="form-control" id="category">
                            </select>
                        <br class="clear" /> 
                        <label for="idinitialcondition">Initial Condition</label>
                        <select class="form-control" id="initialcondition">
                                <?php
                                for($i = 0 ; $i < count($myinitial); $i++)
                                {
                                    echo '<option value = "'.$myinitial[$i]['id'].'">'.$myinitial[$i]['initial_condition'].'</option>';
                                }
                                ?>
                            </select>
                        <br class="clear" /> 
                        <label for="idcondition">Condition</label>
                        <select class="form-control" id="condition">
                                <?php
                                for($i = 0 ; $i < count($myconditions); $i++)
                                {
                                    echo '<option value = "'.$myconditions[$i]['id'].'">'.$myconditions[$i]['name'].'</option>';
                                }
                                ?>
                            </select>
                        <br class="clear" /> 
                        <label for="noasset">No Asset</label><input type="text" class = "form-control"  name="noasset" id="noasset" />
                        <br class="clear" /> 
                        <label for="name">Name</label><input type="text" class = "form-control"  name="name" id="name" />
                        <br class="clear" />  
                        <br class="clear" /> 
							
						</div>
					</form> -->
            </div>
            <!-- <div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="adddata()">Save</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id = "canceladd">Cancel</button>
					</div> -->
        </div>
    </div>
</div>

<div class="modal fade" id="myModaledit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
                <h5 class="modal-title">Edit Personel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>
            <div class="modal-body">
                <form id="myformedit">
                    <div class="form-group">
                        <input type="hidden" id="idchange">
                        <label for="idgroup">Sister Company</label><input type="text" class="form-control"
                            name="idgroup" id="idgroup" value="<?php echo $_SESSION['namasister']; ?>" disabled />
                        <br class="clear" />
                        <label for="idgroup">Group</label>
                        <select class="form-control" id="groupedit">
                            <?php
                                for($i = 0 ; $i < count($myasset); $i++)
                                {
                                    echo '<option value = "'.$myasset[$i]['id'].'">'.$myasset[$i]['nama'].'</option>';
                                }
                                ?>
                        </select>
                        <br class="clear" />
                        <label for="idsubgroup">Subgroup</label>
                        <select class="form-control" id="subgroupedit">
                        </select>
                        <br class="clear" />
                        <label for="idcategory">Category</label>
                        <select class="form-control" id="categoryedit">
                        </select>
                        <br class="clear" />
                        <label for="idinitialcondition">Initial Condition</label>
                        <select class="form-control" id="initialconditionedit">
                            <?php
                                for($i = 0 ; $i < count($myinitial); $i++)
                                {
                                    echo '<option value = "'.$myinitial[$i]['id'].'">'.$myinitial[$i]['initial_condition'].'</option>';
                                }
                                ?>
                        </select>
                        <br class="clear" />
                        <label for="idcondition">Condition</label>
                        <select class="form-control" id="conditionedit">
                            <?php
                                for($i = 0 ; $i < count($myconditions); $i++)
                                {
                                    echo '<option value = "'.$myconditions[$i]['id'].'">'.$myconditions[$i]['name'].'</option>';
                                }
                                ?>
                        </select>
                        <br class="clear" />
                        <label for="noasset">No Asset</label><input type="text" class="form-control" name="noasset"
                            id="noassetedit" />
                        <br class="clear" />
                        <label for="name">Name</label><input type="text" class="form-control" name="name"
                            id="nameedit" />
                        <br class="clear" />
                        <br class="clear" />


                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="changedata()">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="canceledit">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModalDisplay">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
                <h5 class="modal-title">Asset Display</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>
            <div class="modal-body" style="padding:10px !important;">

                <ul class="nav nav-tabs nav-tabs-solid border-0 nav-justified rounded" id="mynav"
                    style="margin-top:10px;">
                    <li class="nav-item"><a id="myfirst" href="#first" class="nav-link rounded-left active"
                            data-toggle="tab">General</a></li>
                    <li class="nav-item"><a href="#colored-rounded-justified-tab2" class="nav-link"
                            data-toggle="tab">Purchase</a></li>
                    <li class="nav-item"><a id="mydepreciation" href="#depreciation" class="nav-link"
                            data-toggle="tab">Depreciation</a></li>
                    <li class="nav-item"><a href="#colored-rounded-justified-tab3" class="nav-link"
                            data-toggle="tab">Warranty </a></li>
                    <li class="nav-item"><a href="#colored-rounded-justified-tab4" class="nav-link"
                            data-toggle="tab">Image </a></li>
                    <li class="nav-item"><a href="#additionalinfo" class="nav-link" data-toggle="tab">Custom</a></li>

                </ul>

                <div class="tab-content" style="margin-left:10px;">
                    <div class="tab-pane fade show active" id="first">
                        <h4><span class="font-weight-semibold">General Info</span></h4>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="noasset">Asset No.</label>
                                <br>
                                <b> <label for="noasset" id="noassetlabelgeneral">Asset No.</label></b>
                            </div>

                            <div class="col-md-4">
                                <label for="noasset">Asset Name</label>
                                <br>
                                <b> <label for="noasset" id="nameassetlabelgeneral">Asset No.</label></b>
                            </div>
                            <div class="col-md-4">
                                <label for="noasset">Asset Group</label>
                                <br>
                                <b> <label for="noasset" id="groupassetlabelgeneral">Asset No.</label></b>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="noasset">Asset Subgroup</label>
                                <br>
                                <b> <label for="noasset" id="subgroupassetlabelgeneral">Asset No.</label></b>
                            </div>
                            <div class="col-md-4">
                                <label for="noasset">Asset Category</label>
                                <br>
                                <b> <label for="noasset" id="categoryassetlabelgeneral">Asset No.</label></b>
                            </div>
                            <div class="col-md-4">
                                <label for="noasset">Asset Condition</label>
                                <br>
                                <b> <label for="noasset" id="conditionassetlabelgeneral">Asset No.</label></b>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="noasset">Asset Initial Cond</label>
                                <br>
                                <b> <label for="noasset" id="initialassetlabelgeneral">Asset No.</label></b>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="colored-rounded-justified-tab2">
                        <h4><span class="font-weight-semibold">Purchase Info</span></h4>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="noasset">No PO.</label>
                                <br>
                                <b> <label for="noasset" id="nopolabelpurchase">Asset No.</label></b>
                            </div>

                            <div class="col-md-4">
                                <label for="noasset">Purchase Price</label>
                                <br>
                                <b> <label for="noasset" id="purchasepricelabelpurchase">Asset No.</label></b>
                            </div>
                            <div class="col-md-4">
                                <label for="noasset">Posting Date</label>
                                <br>
                                <b> <label for="noasset" id="postingdatelabelpurchase">Asset No.</label></b>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-8">
                                <label for="noasset">Purchase From</label>
                                <br>
                                <b> <label for="noasset" id="purchasefromlabelpurchase">Asset No.</label></b>
                            </div>

                            <div class="col-md-4">
                                <label for="noasset">PPN</label>
                                <br>
                                <b> <label for="noasset" id="ppnlabelpurchase">Asset No.</label></b>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="noasset">Total Purchase Price</label>
                                <br>
                                <b> <label for="noasset" id="totalpurchasepricelabelpurchase">Asset No.</label></b>
                            </div>
                            <div class="col-md-4">
                                <label for="noasset">Economical Life Time</label>
                                <br>
                                <b> <label for="noasset" id="economicallifetimelabelpurchase">Asset No.</label></b>
                            </div>
                            <div class="col-md-4">
                                <label for="noasset">Cost Per Month</label>
                                <br>
                                <b> <label for="noasset" id="costpermonthlabelpurchase">Asset No.</label></b>
                            </div>
                        </div>
                        <br>

                    </div>
                    <div class="tab-pane fade" id="depreciation">
                        <div class="row" style="height:100% !important;margin-right:1px !important; overflow-y:auto;">
                            <div class="col-md-12">
                                <h4><span class="font-weight-semibold">Depreciation Info</span></h4>
                                <table id="mydatatable" class="table table-hover table-bordered display ">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Depreciation</th>
                                            <th>Book Value</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="depreciationtablebody">
                                        <!-- <tr>
                                            <td>1</td>
                                            <td>Rp 1.000.000</td>
                                            <td>Rp 11.000.000</td>
                                            <td><b><i style = "font-size:17px; color : #26a69a;font-weight:bold;" class="mi-check"></i><b></td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Rp 1.000.000</td>
                                            <td>Rp 11.000.000</td>
                                            <td><b><i style = "font-size:17px; color : #ebba34;font-weight:bold;" class="mi-timer"></i><b></td>
                                        
                                        </tr> -->

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="colored-rounded-justified-tab3">
                        <h4><span class="font-weight-semibold">Warranty Info</span></h4>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="noasset">Start Date</label>
                                <br>
                                <b> <label for="noasset" id="startdatelabelwarranty">Asset No.</label></b>
                            </div>
                            <div class="col-md-6">
                                <label for="noasset">End Date</label>
                                <br>
                                <b> <label for="noasset" id="enddatelabelwarranty">Asset No.</label></b>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="colored-rounded-justified-tab4">
                        <h4><span class="font-weight-semibold">Attachment</span></h4>
                        <div id="myattach"></div>
                    </div>
                    <div class="tab-pane fade" id="additionalinfo">
                        <h4><span class="font-weight-semibold">Additional Info</span></h4>
                        <div id="containercustominfo"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
                <h5 class="modal-title">Add Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="myforms">
                    <div class="form-group">
                    
                          <label for="cars">Asset Group:</label>
                        <select id="groups" name="groups" class="form-control">
                            <?php
                                        for($i = 0 ; $i < count($mykategoriasset); $i++)
                                        {                                            
                                                echo '<option value="'.$mykategoriasset[$i]['id'].'">'.$mykategoriasset[$i]['nama'].'</option>';                                       
                                        }
                                ?>
                        </select>
                        <br>
                        <label for="cars">Asset:</label>
                        <select id="asset" name="asset" class="form-control">
                          
                        </select>
                        <br>
                        <b>Asset Preview</b>
                        <div class="row">

                            <div class="col-md-6">
                                <br>
                                <label>No Asset</label>
                                <br>
                                <label id="noassetpreview">1123</label>
                            </div>
                            <div class="col-md-6">
                                <br>
                                <label>Asset</label>
                                <br>
                                <label id="assetpreview">Good</label>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <br>
                                <label>Initial Condition</label>
                                <br>
                                <label id="initialpreview">Good</label>
                            </div>
                            <div class="col-md-6">
                                <br>
                                <label>Condition</label>
                                <br>
                                <label id="conditionpreview">Good</label>
                            </div>
                        </div>
                        <hr>
                        <label for="cars">Branch From:</label>
                        <select id="branchfrom" name="branchfrom" class="form-control">
                            <?php
                                        for($i = 0 ; $i < count($mybranch); $i++)
                                        {                                            
                                                echo '<option value="'.$mybranch[$i]['idbranch'].'">'.$mybranch[$i]['branch'].'</option>';                                       
                                        }
                                ?>
                        </select>
                        <br>
                     
                        <label for="cars">From Room:</label>
                        <select id="fromroom" name="fromroom" class="form-control">
                        </select>
                        <br>
                        <label for="cars">Branch To:</label>
                        <select id="branchto" name="branchto" class="form-control">
                            <?php
                                        for($i = 0 ; $i < count($mybranch); $i++)
                                        {                                            
                                                echo '<option value="'.$mybranch[$i]['idbranch'].'">'.$mybranch[$i]['branch'].'</option>';                                       
                                        }
                                ?>
                        </select>
                        <label for="cars">toroom:</label>
                        <select id="toroom" name="toroom" class="form-control"> 
                        </select>
                        <br>
                        <label for="cars">Remark :</label>
                        <input id= "remark" type = "text" class="form-control"> 
                        
                        <br>
                        <br>
                        <div style="float:right;margin-bottom:20px;">
                            <button type="button" class="btn btn-primary" style="margin-right:10px;"
                                onclick="adddata()">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                id="canceladd">Cancel</button>
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
    // $('body').scrollspy({ target: '.sidebar' });
    $("#group").trigger('change');
    $("#groups").trigger('change');
    var myopenid = "";
    var globaltotalpurchaseprice = 0;
    var globalcostpermonth = 0;

    function openmodaldisplay(element) {
        //general
        myopenid = element.id;
        var myid = element.id;
        var noassetgeneral = $("#noasset" + myid).text();
        var nameassetgeneral = $("#name" + myid).text();
        var groupassetgeneral = $("#group" + myid).text();
        var subgroupassetgeneral = $("#subgroup" + myid).text();
        var categoryassetgeneral = $("#category" + myid).text();
        var conditionassetgeneral = $("#condition" + myid).text();
        var initialassetgeneral = $("#initial" + myid).text();
        $("#noassetlabelgeneral").text(noassetgeneral);
        $("#nameassetlabelgeneral").text(nameassetgeneral);
        $("#groupassetlabelgeneral").text(groupassetgeneral);
        $("#subgroupassetlabelgeneral").text(subgroupassetgeneral);
        $("#categoryassetlabelgeneral").text(categoryassetgeneral);
        $("#conditionassetlabelgeneral").text(conditionassetgeneral);
        $("#initialassetlabelgeneral").text(initialassetgeneral);


        var nopopurchase = $("#nopo" + myid).val();
        var purchasefrompurchase = $("#relation" + myid).val();
        var postingdatepurchase = $("#postingdate" + myid).val();
        // alert(postingdatepurchase);
        var purchasepricepurchase = $("#purchaseprice" + myid).val();
        var ppnpurchase = $("#ppn" + myid).val();
        var totalpurchasepurchase = $("#totalpurchaseprice" + myid).val();
        var economicalpurchase = $("#economical" + myid).val();
        var costpermonthpurchase = $("#costpermonth" + myid).val();

        globaltotalpurchaseprice = parseInt(totalpurchasepurchase);
        globalcostpermonth = parseInt(costpermonthpurchase);

        $("#nopolabelpurchase").text(nopopurchase);
        $("#purchasefromlabelpurchase").text(purchasefrompurchase);
        $("#postingdatelabelpurchase").text(postingdatepurchase);
        $("#purchasepricelabelpurchase").text(purchasepricepurchase);
        $("#ppnlabelpurchase").text(ppnpurchase);
        $("#totalpurchasepricelabelpurchase").text(totalpurchasepurchase);
        $("#economicallifetimelabelpurchase").text(economicalpurchase);
        $("#costpermonthlabelpurchase").text(costpermonthpurchase);

        var startdate = $("#startdate" + myid).val();
        var enddate = $("#enddate" + myid).val();
        $("#startdatelabelwarranty").text(startdate);
        $("#enddatelabelwarranty").text(enddate);


        var myimage = $("#image" + myid).val();

        $("#myattach").html("");
        var spliiterimage = myimage.split(",");

        for (var i = 0; i < spliiterimage.length; i++) {
            $("#myattach").append(
                "<img class = 'myimg' id= 'test' onclick = 'mytoggleenlarge(this)' src = '<?=$url?>assets/attach/" +
                spliiterimage[i] + "' style ='width:100px;height:100px;margin-left:20px;'>");
        }

        $("a[href='#additionalinfo']").attr("id", myid);
        $("#myfirst").click();
        // $('.myimg').on('click', function(){
        //     var animWidth, $this=$(this);
        //     if( $this.hasClass('wide') ){
        //         animWidth=159;
        //         $this.animate({width:'100px'}, "slow");
        //         $('.myimg').removeClass("wide");
        //     }else{
        //         animWidth=593;
        //         // $('.myimg').removeClass("wide");
        //         $this.animate({width:'200px'}, "slow");
        //          $('.myimg').addClass("wide");
        //     }

        //     // alert("test");
        //   });
    }

    function mytoggleenlarge(element) {
        var myclass = element.className;
        // alert(myclass);
        // var animWidth, $this=$(this);
        var str1 = myclass;
        var str2 = "wide";
        var status = "notfound";
        if (str1.indexOf(str2) != -1) {
            status = "found";
        }
        if (status == "found") {
            // alert("akan mengecil");
            // animWidth=159;
            // $(".myimg")..animate({width:'100px'}, "slow")
            $(element).animate({
                width: '100px',
                height: '100px'
            }, "slow");
            $(element).removeClass("wide");
        } else {
            // animWidth=593;
            // $('.myimg').removeClass("wide");
            // alert("akan membesar");
            $(".wide").animate({
                width: '100px',
                height: '100px'
            }, "slow");
            $(element).animate({
                width: '200px',
                height: '200px'
            }, "slow");
            $(element).addClass("wide");
        }

        // alert("test");

    };
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
                url: 'process/master_transaction_disp_department_branch.php',
                method: 'POST',
                data: {
                    tipe: "load"
                }
            },
            columns: [

                {
                    name: 'date',
                    className: 'text-center align-middle'
                },
                {
                    name: 'transaction',
                    className: 'text-center align-middle'
                },
                {
                    name: 'branchfrom',
                    className: 'text-center align-middle'
                },
                {
                    name: 'branchto',
                    className: 'text-center align-middle'
                },
                {
                    name: 'noasset',
                    className: 'text-center align-middle'
                },
                {
                    name: 'asset',
                    className: 'text-center align-middle'
                },
                {
                    name: 'roomfrom',
                    className: 'text-center align-middle'
                },
                {
                    name: 'toroom',
                    className: 'text-center align-middle'
                },
                {
                    name: 'remark',
                    className: 'text-center align-middle'
                },
                {
                    name: 'approval',
                    className: 'text-center align-middle'
                },
                {
                    name: 'leadtime',
                    className: 'text-center align-middle'
                }

            ]
        });
    };

    // Reload table
    function success() {
        $('#datatable_serverside').DataTable().ajax.reload(null, false);
    };

    //setinactive active
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
            url: "process/masterassets.php",
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
    }
    var globalsubgroup = "";
    var globalcategory = "";

    function openmodaledit(element) {
        // click-'.$row['id'].'-'.$row['idgroup'].'-'.$row['idsubgroup'].'-'.$row['idcategory'].'-'.
        // $row['idinitialcondition'].'-'.$row['idcondition'].'"
        var idelement = element.id.split("-");
        var idgroup = idelement[2];
        var idsubgroup = idelement[3];
        var idcategory = idelement[4];
        var idinitialcondition = idelement[5];
        var idcondition = idelement[6];


        globalsubgroup = idsubgroup;
        globalcategory = idcategory;


        var noasset = $("#noasset" + idelement[1]).text();
        var name = $("#name" + idelement[1]).text();
        $("#noassetedit").val(noasset);
        $("#nameedit").val(name);
        $('#groupedit option[value=' + idgroup + ']').prop('selected', true);
        $('#initialconditionedit option[value=' + idinitialcondition + ']').prop('selected', true);
        $('#conditionedit option[value=' + idcondition + ']').prop('selected', true);
        $("#groupedit").trigger('change');
        $("#idchange").val(idelement[1]);
    }

    function searchsubgroup(element) {
        var myid = element.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterassets.php",
            method: 'POST',
            data: {
                tipe: "getsubgroup",
                idgroup: myid

            },
            success: function (result) {
                // alert(result);
                if (result == "none") {
                    $("#subgroup").html("");

                } else {
                    $("#subgroup").html(result).promise().done(function () {


                    });
                }
                $("#subgroup").trigger('change');


            }
        });
    };

    function searchcategory(element) {
        var myid = element.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterassets.php",
            method: 'POST',
            data: {
                tipe: "getcategory",
                idsubgroup: myid

            },
            success: function (result) {
                // alert(result);
                if (result == "none") {
                    $("#category").html("");
                } else {
                    $("#category").html(result).promise().done(function () {});
                }
                $("#category").trigger("change");
            }
        });
    };
    $("#groupedit").on('change', function () {
        var myid = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterassets.php",
            method: 'POST',
            data: {
                tipe: "getsubgroup",
                idgroup: myid

            },
            success: function (result) {
                // alert(result);
                if (result == "none") {
                    $("#subgroupedit").html("");

                } else {
                    $("#subgroupedit").html(result).promise().done(function () {
                        if (!globalsubgroup == "") {
                            // alert(globalid);
                            $('#subgroupedit').find('option[value="' + globalsubgroup +
                                '"]').prop('selected', true);
                        }

                    });
                }
                $("#subgroupedit").trigger('change');


            }
        });
    }).trigger('change');
    $("#subgroupedit").on('change', function () {
        var myid = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterassets.php",
            method: 'POST',
            data: {
                tipe: "getcategory",
                idsubgroup: myid

            },
            success: function (result) {
                // alert(result);
                if (result == "none") {
                    $("#categoryedit").html("");
                } else {
                    $("#categoryedit").html(result).promise().done(function () {
                        if (!globalcategory == "") {
                            // alert(globalid);
                            $('#categoryedit').find('option[value="' + globalcategory +
                                '"]').prop('selected', true);
                        }
                    });
                }
            }
        });
    }).trigger('change');

    function adddata() {
        var group = $("#groups").val();
        var asset = $('#asset').val();
        var branchfrom = $('#branchfrom').val();
        var branchto = $('#branchto').val();
        var fromroom = $('#fromroom').val();
        var toroom = $('#toroom').val();
        var remark = $('#remark').val();
        if (remark == "" || asset == null || branchfrom == null || branchto == null ||  fromroom ==
            null || toroom == null) {
            Swal.fire({
                icon: 'error',
                title: 'Empty Field',
                text: 'Requirement data cannot be empty',
                confirmButtonColor: '#e00d0d',
            });
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_disp_department_branch.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    mygroup: group,
                    myasset: asset,
                    mybranchfrom: branchfrom,
                    mybranchto: branchto,
                    myfromroom: fromroom,
                    mytoroom: toroom,
                    myremark: remark

                },
                success: function (result) {
                    //    alert(result);
                    if (result == "sukses") {
                        success();
                        Swal.fire({
                            title: 'Data Saved',
                            text: 'Data Inputted Successfully',
                            icon: 'success',
                            confirmButtonColor: '#53d408',
                            allowOutsideClick: false,
                        }).then((result) => {
                            $("#myforms").trigger("reset");
                            $("#canceladd").click();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Insert Error ',
                            text: 'Please check your data',
                            confirmButtonColor: '#e00d0d',
                        });
                    }


                }
            });
        }


    }

    function changedata() {
        var changeid = $("#idchange").val();
        var group = $("#groupedit").val();
        var subgroup = $('#subgroupedit').val();
        var category = $('#categoryedit').val();
        var initialcondition = $('#initialconditionedit').val();
        var condition = $('#conditionedit').val();
        var noasset = $('#noassetedit').val();
        var name = $('#nameedit').val();
        if (noasset == "" || name == "" || group == null || subgroup == null || category == null || initialcondition ==
            null || condition == null) {
            Swal.fire({
                icon: 'error',
                title: 'Empty Field',
                text: 'Requirement data cannot be empty',
                confirmButtonColor: '#e00d0d',
            });
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterassets.php",
                method: 'POST',
                data: {
                    tipe: "changedata",
                    myid: changeid,
                    group: group,
                    subgroup: subgroup,
                    category: category,
                    initialcondition: initialcondition,
                    condition: condition,
                    noasset: noasset,
                    name: name

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
                            title: 'Data Exists',
                            text: 'Duplicate Entry For This Assets',
                            confirmButtonColor: '#e00d0d',
                        });
                    }




                }
            });
        }
    }


    function mytemplatechange(element) {
        //    alert("test");
        var myid = element.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterassets.php",
            method: 'POST',
            data: {
                tipe: "getcustomquestion",
                idtemplate: myid

            },
            success: function (result) {
                $("#customquestion").html("");
                if (result == "none") {
                    $("#customquestion").html(
                        "<span style = 'color:grey;'>There is no custom field on this template, Go Ahead</span>"
                    );
                    $("#idcustomquestion").val("");
                } else {
                    var splitresult = result.split("~~");
                    var allquestion = splitresult[1];
                    $("#customquestion").html(allquestion);
                    $("#idcustomquestion").val(splitresult[0]);
                }



            }
        });

    }

    function addassetform() {
        var form = $("#myform"); // You need to use standard javascript object here
        var formData = new FormData(form[0]);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterassets.php",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (result) {
                // alert(result);
                if (result == "sukses") {
                    success();
                    Swal.fire({
                        title: 'Data Saved',
                        text: 'Data Inputted Successfully',
                        icon: 'success',
                        confirmButtonColor: '#53d408',
                        allowOutsideClick: false,
                    }).then((result) => {
                        // $( "#myform" ).steps('reset');
                        $(".first a").click();
                        $(".first").attr("class", "first current");
                        $(".done").attr("class", "disabled");

                        $("#myform").trigger("reset");

                        $('#myModal').modal('toggle');
                    });
                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Data Exists',
                        text: 'Duplicate Entry For This Asset',
                        confirmButtonColor: '#e00d0d',
                    });
                }

            }
        });


    }

    function isNumber(event) {
        // var iKeyCode = (evt.which) ? evt.which : event.keyCode;

        if ((event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode == 8) {
            // alert(event.keyCode);
            // alert(event.keyCode);
            var totalpurchaseprice = $("#totalpurchaseprice").val();
            var economicallifetime = $("#economicallifetime").val();
            // alert(purchaseprice + " -- " + economicallifetime  );
            var costpermonth = parseFloat(totalpurchaseprice) / parseFloat(economicallifetime);
            $("#costpermonth").val(costpermonth);
            return true;

        } else {
            // alert(event.keyCode);
            return false;


        }


    };

    function getallanswercustomquestion(idasset) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/masterassets.php",
            method: 'POST',
            data: {
                tipe: "getallanswer",
                idassets: idasset
            },
            success: function (result) {
                // alert(result);
                if (result == "none") {
                    $("#containercustominfo").html(
                        "<span style = 'color:grey;'>Oops, there is no custom field on this template</span>"
                    );

                } else {
                    $("#containercustominfo").html(result);


                }

            }
        });
    }
    $(document).ready(function () {
        $("#groups").on("change", function(){
            var myid = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_disp_department.php",
                method: 'POST',
                data: {
                    tipe: "getassetlist",
                    idgroup: myid
                },
                success: function (result) {
                   
                    // alert(result);
                    $("#asset").html(result);
                    $("#asset").trigger("change");
                }

            })
        }).trigger("change");
        $("#asset").on("change", function () {
            var myid = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_disp_department.php",
                method: 'POST',
                data: {
                    tipe: "getassetdesc",
                    assetid: myid
                },
                success: function (result) {
                    var mysplittter = result.split("~~");
                    var noasset = mysplittter[0];
                    var name = mysplittter[1];
                    var condition = mysplittter[2];
                    var initialcondition = mysplittter[3];

                    $("#noassetpreview").text(noasset);
                    $("#assetpreview").text(name);
                    $("#conditionpreview").text(condition);
                    $("#initialpreview").text(initialcondition);
                }

            })
        }).trigger("change");
        $("#branchfrom").on("change", function () {
            var myid = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_disp_department.php",
                method: 'POST',
                data: {
                    tipe: "getroom",
                    idbranch: myid
                },
                success: function (result) {
                    $("#fromroom").html("");
                    $("#fromroom").append(result);
                       
                }

            })
        }).trigger("change");
        $("#branchto").on("change", function () {
            var myid = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_disp_department.php",
                method: 'POST',
                data: {
                    tipe: "getroom",
                    idbranch: myid
                },
                success: function (result) {
                    $("#toroom").html("");
                    $("#toroom").append(result);
                       
                }

            })
        }).trigger("change");

        $("a[href='#additionalinfo']").on("click", function () {
            var myid = this.id;
            // alert("test");
            getallanswercustomquestion(myid);

        });
        $("#mydepreciation").on("click", function () {
            $("#depreciationtablebody").html("");
            var postingdate = $("#postingdateraw" + myopenid).val();
            var totalmonth = $("#totalmonth" + myopenid).val();

            var date1 = new Date(postingdate);
            var date2 = new Date(Date.now());
            var diffYears = date2.getFullYear() - date1.getFullYear();
            var diffMonths = date2.getMonth() - date1.getMonth();
            var diffDays = date2.getDate() - date1.getDate();

            var months = (diffYears * 12 + diffMonths);
            var totalprice = globaltotalpurchaseprice;
            // alert(date1);
            for (var i = 0; i < parseInt(totalmonth); i++) {
                var month = i + 1;
                totalprice -= globalcostpermonth;
                if ((i + 1) <= parseInt(months)) {

                    var mystring = '<tr><td>' + month + '</td><td>Rp ' + globalcostpermonth +
                        '</td><td>Rp ' + totalprice +
                        '</td><td><b><i style = "font-size:17px; color : #26a69a;font-weight:bold;" class="mi-check"></i><b></td></tr>';
                    $("#depreciationtablebody").append(mystring);
                } else {
                    var mystring = '<tr><td>' + month + '</td><td>Rp ' + globalcostpermonth +
                        '</td><td>Rp ' + totalprice +
                        '</td><td><b><i style = "font-size:17px; color : #ebba34;font-weight:bold;" class="mi-timer"></i><b></td></tr>';
                    $("#depreciationtablebody").append(mystring);
                }

            }

            // <tr>
            //     <td>1</td>
            //     <td>Rp 1.000.000</td>
            //     <td>Rp 11.000.000</td>
            //     <td><b><i style = "font-size:17px; color : #ebba34;font-weight:bold;" class="mi-timer"></i><b></td>

            // </tr>
        });

        $('#templates').trigger('change');
        $("#myform").off("finished");
        $("#myform").on("finished", function (event, currentIndex) {
            addassetform();
        });

        $('#postingdate').pickadate({
            format: 'dd-mm-yyyy'
        });
        $('#startwarranty').pickadate({
            format: 'dd-mm-yyyy'
        });
        $('#endwarranty').pickadate({
            format: 'dd-mm-yyyy'
        });
        $("#category").on("change", function () {
            var myvalues = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/masterassets.php",
                method: 'POST',
                data: {
                    tipe: "gettemplatecategory",
                    idcategory: myvalues
                },
                success: function (result) {
                    // alert(result);

                    if (result == "another") {
                        $("#containercustominfo").html(
                            "<span style = 'color:red;'>Please choose another category, this category doesnt have template</span>"
                        );

                        $("#template").val("");

                    } else {

                        var mysplittter = result.split("~~~");
                        var nametemplate = mysplittter[1];
                        var idtemplate = mysplittter[0];
                        $("#templatename").text(nametemplate);
                        $("#template").val(idtemplate);
                        if (mysplittter[1] == "none") {
                            $("#containercustominfo").html(
                                "<span style = 'color:grey;'>Oops, there is no custom field on this template</span>"
                            );
                            $("#idcustomquestion").val("");
                        } else {


                            // $("#containercustominfo").html(result);
                            var splitresult = mysplittter[2].split("~~");
                            var allquestion = splitresult[1];
                            $("#customquestion").html(allquestion);
                            $("#idcustomquestion").val(splitresult[0]);

                        }



                    }

                }
            });
        });

        $("#purchaseprice").on('keyup', function (event) {
            // alert(event.keyCode);
            if ((event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode == 8) {

                var myvalue = this.value;
                var myppn = $("#ppn").val();
                if (myppn == "0") {
                    $("#totalpurchaseprice").val(myvalue);
                } else {
                    var total = parseFloat(myvalue) + (parseFloat(myvalue) * myppn);
                    $("#totalpurchaseprice").val(total);
                }
                var month = $("#economicallifetime").val();
                if (!this.value == "") {
                    if (!(month == "0" || month == "")) {
                        var costpermonth = parseFloat(myvalue) / month;
                        $("#costpermonth").val(costpermonth);
                    }
                }


            }
        });
    });

    function setppn(element) {
        var myvalue = element.value;
        var purchaseprice = $("#purchaseprice").val();
        var myppn = $("#ppn").val();
        var month = $("#economicallifetime").val();

        if (myppn == "0") {
            $("#totalpurchaseprice").val(purchaseprice);
        } else {
            var total = parseFloat(purchaseprice) + (parseFloat(purchaseprice) * myppn);
            $("#totalpurchaseprice").val(total);
        }
        if (!(month == "0" || month == "")) {
            var mytotalprice = $("#totalpurchaseprice").val();
            var costpermonth = parseFloat(mytotalprice) / month;
            $("#costpermonth").val(costpermonth);
        }
        // alert(purchaseprice);
    }
</script>