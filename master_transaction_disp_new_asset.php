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

        /* #myModalDetailTransaction .modal-dialog {
			-webkit-transform: translate(0, -50%);
			-o-transform: translate(0, -50%);
			transform: translate(0, -50%);
			top: 50%;
			margin: 0 auto;
		} */
    </style>
</head>
<!-- Main navbar -->


<div class="content-wrapper">
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <h4><span class="font-weight-semibold">Displacement New Asset</span></h4>
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

                    <table id="datatable_serverside"  class="table table-hover table-bordered display nowrap w-100">
                        <thead>
                            <tr>
                                 <th>ID</th>
                                <th>Approval</th>
                                <th>Date</th>
                                <th>Transaction</th>
                                <th>Branch</th>
                                <th>Room</th>
                                <th>Created By</th>
                                <th>Action</th>

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
<div class="modal fade " id="myModalDetailTransaction">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
                <h5 class="modal-title">Transaction Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>
            <div class="modal-body" >

            <label for="cars" style="font-size:11pt;"><b>Transaction Section</b></label><br><br>
            <label for="idgroup" id = "detailnotransaction">Transaction No : -</label><br>
            <label for="idgroup" id = "detaildate">Transaction Date : -</label><br>
            <label for="idgroup" id = "detailcreate">Created By: -</label><br>
            <hr style = "border-top: 3px dashed #d4d4d4;">
            <label for="cars" style="font-size:11pt;"><b>Asset Section</b></label><br>
            <label for="idgroup" id = "detailqty">Asset Count : 8 pcs</label><br>
            <label for="idgroup">Asset List: </label>
            <br><br>
            <div id = "listtransaction">

            </div>

            </div>

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
                        <label for="cars">Branch:</label>
                        <select id="branch" name="branch" class="form-control">
                            <?php
                                        for($i = 0 ; $i < count($mybranch); $i++)
                                        {                                            
                                                echo '<option value="'.$mybranch[$i]['idbranch'].'">'.$mybranch[$i]['branch'].'</option>';                                       
                                        }
                                ?>
                        </select>

                        <br>
                        <label for="cars">Room:</label>
                        <select id="room" name="room" class="form-control">
                        </select>
                        <hr>

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
                        <label for="cars">Asset Sub Group:</label>
                        <select id="subgroups" name="subgroups" class="form-control">

                        </select>
                        <br>
                        <label for="cars">Asset Category:</label> <a href = "#selectasset" onclick = "openselectasset(this)" data-toggle="modal" data-backdrop="static" data-keyboard="false">select asset</a>
                        <select id="categories" name="categories" class="form-control">

                        </select>
                        <br>
                        <b>Asset Choose</b>
                        <br><br>
                        <div id="containerpilihaset" style="max-height:100px !important;">

                        </div>



                        <br>
                        <br>
                        <div style="float:right;margin-bottom:20px;">
                     
                        </div>
                    </div>
                </form>
            </div>
            <div class = "modal-footer" style = "padding-top:20px;">
            <button type="button" class="btn btn-primary" style="margin-right:10px;"
                                onclick="adddata()">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                id="canceladd" style="margin-right:15px;">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModalEditTransactions">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
                <h5 class="modal-title">Edit Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="myforms">
                    <div class="form-group">
                        <label for="cars">Branch:</label>
                        <select id="branchedit" name="branchedit" class="form-control">
                            <?php
                                        for($i = 0 ; $i < count($mybranch); $i++)
                                        {                                            
                                                echo '<option value="'.$mybranch[$i]['idbranch'].'">'.$mybranch[$i]['branch'].'</option>';                                       
                                        }
                                ?>
                        </select>

                        <br>
                        <label for="cars">Room:</label>
                        <select id="roomedit" name="roomedit" class="form-control">
                        </select>
                        <hr>

                        <label for="cars">Asset Group:</label>
                        <select id="groupsedit" name="groupsedit" class="form-control">
                            <?php
                                        for($i = 0 ; $i < count($mykategoriasset); $i++)
                                        {                                            
                                                echo '<option value="'.$mykategoriasset[$i]['id'].'">'.$mykategoriasset[$i]['nama'].'</option>';                                       
                                        }
                                ?>
                        </select>
                        <br>
                        <label for="cars">Asset Sub Group:</label>
                        <select id="subgroupsedit" name="subgroupsedit" class="form-control">

                        </select>
                        <br>
                        <label for="cars">Asset Category:</label> <a href = "#selectassetedit" onclick = "openselectassetedit(this)" data-toggle="modal" data-backdrop="static" data-keyboard="false">select asset</a>
                        <select id="categoriesedit" name="categoriesedit" class="form-control">

                        </select>
                        <br>
                        <b>Asset Choose</b>
                        <br><br>
                        <div id="containerpilihasetedit" style="max-height:100px !important;">

                        </div>



                        <br>
                        <br>
                        <div style="float:right;">
                        
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                         <button type="button" class="btn btn-primary" style="margin-right:10px;margin-top:10px;"
                                onclick="editdata()">Save</button>
                            <button type="button" class="btn btn-secondary" style="margin-right:15px;margin-top:10px;" data-dismiss="modal"
                                id="canceledittransaction">Cancel</button>
                                    </div>

              </div>
    </div>
</div>
<div class="modal fade" id="selectasset">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
                <h5 class="modal-title">Select Asset</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="myforms">
                    <div class="form-group">
                    <label for="cars">Group: &nbsp <b><label id = "grouptitleselectasset">-</label></b></label><br>
                    <label for="cars">Sub Group: &nbsp <b><label id = "subgrouptitleselectasset">-</label></b></label><br>
                    <label for="cars">Category:  &nbsp <b><label id = "categoriestitleselectasset">-</label></b></label><br>
                    <table id="datatable_asset" class="table table-hover table-bordered display nowrap w-100">
                        <thead >
                            <tr>
                                 <th  >#</th>
                                <th>No. Asset</th>
                                <th>Name</th>
                                <th>Condition</th>
                                <th>Initial Condition</th>
                            </tr>
                        </thead>
                        </tbody>
                                    <!-- <tr>
                                        <td><input type = "checkbox" value = "asdsad"></td>
                                        <td>1123</td>
                                        <td>Vas Bunga</td>
                                        <td>Good</td>
                                        <td>Very Good</td>
                                    </tr> -->

                        </tbody>

                    </table>
                        <div style="float:right;margin-bottom:20px;">
                            <button type="button" class="btn btn-primary" id = "pilihaset" style="margin-right:10px;"
                                 onclick = "pilihasset()">Choose</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                id="canceladd">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="selectassetedit">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
                <h5 class="modal-title">Select Asset</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="myforms">
                    <div class="form-group">
                    <label for="cars">Group: &nbsp <b><label id = "grouptitleselectassetedit">-</label></b></label><br>
                    <label for="cars">Sub Group: &nbsp <b><label id = "subgrouptitleselectassetedit">-</label></b></label><br>
                    <label for="cars">Category:  &nbsp <b><label id = "categoriestitleselectassetedit">-</label></b></label><br>
                    <table id="datatable_asset_edit" class="table table-hover table-bordered display nowrap w-100">
                        <thead >
                            <tr>
                                 <th>#</th>
                                <th>No. Asset</th>
                                <th>Name</th>
                                <th>Condition</th>
                                <th>Initial Condition</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        </tbody>

                        </tbody>

                    </table>
                        <div style="float:right;margin-bottom:20px;">
                            <button type="button" class="btn btn-primary" id = "pilihaset" style="margin-right:10px;"
                                 onclick = "pilihassetedit()">Choose</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                id="canceladd">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="myModalEditTransaction">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
                <h5 class="modal-title">Edit Asset</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="myforms">
                    <div class="form-group">
                       

                        <label for="cars">Asset Category:</label> 
               
                        <b><label for="cars" id = "labelassetcategoryedit">-</label></b><br>
                        <hr>
                        <!-- <a href = "#selectasset" onclick = "openselectasset(this)" data-toggle="modal" data-backdrop="static" data-keyboard="false">select asset</a>
                       
                        <br> -->
                        Chosen Asset List
                        <br><br>

                        <table id="datatable_choice_asset" class="table table-hover table-bordered display nowrap w-100">
                        <thead >
                            <tr>
                                 <th>#</th>
                                <th>No. Asset</th>
                                <th>Name</th>

                            </tr>
                        </thead>
                        </tbody>
                                    <!-- <tr>
                                        <td><input type = "checkbox" value = "asdsad"></td>
                                        <td>1123</td>
                                        <td>Vas Bunga</td>
                                        <td>Good</td>
                                        <td>Very Good</td>
                                    </tr> -->

                        </tbody>

                    </table>
                        <div id="containerpilihaset" style="max-height:100px !important;">

                        </div>



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
<script type="text/javascript"
    src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>

var asset = null;
var assetedit = null;
var chosenasset = null;
    $('#selectasset').on('shown.bs.modal', function () {
        var idcategories = $("#categories").val();
        if(iddefaultcategories != idcategories)
        {
            iddefaultcategories = idcategories;
            loadasset(idcategories);
    
        }
   
   asset.columns.adjust();
}); 
$('#selectassetedit').on('shown.bs.modal', function () {
        var idcategories = $("#categories").val();
        if(iddefaultcategories != idcategories)
        {
            iddefaultcategories = idcategories;
            // loadassetedit(idcategories);
    
        }
   
        assetedit.columns.adjust();
}); 
$('#myModalEditTransaction').on('shown.bs.modal', function () {
    
    chosenasset.columns.adjust();
}); 

function loadchoicesasset(idtransac){

    myid = idtransac;
  
    chosenasset = $("#datatable_choice_asset").DataTable({
            processing: true,
            deferRender: true,
            serverSide: true,
            destroy: true,
            scrollX:true,
            responsive: true,
            autoWidth: true,
            iDisplayInLength: 10,
            // scrollX: true,
            
            order: [
                [0, 'asc']
            ],
            ajax: {
                url: 'process/mastergetasset.php',
                method: 'POST',
                data: {
                    tipe: "loadpicked",
                    idtransaction : myid
                }
            },
            initComplete : function(settings, json){
             
                var summarycategory = $("#namecategorysummary").val();
                $("#labelassetcategoryedit").text(summarycategory);


            },
            columns: [{
                    searchable:false,
                    orderable:false,
                    name: '#',
                    className: 'text-center align-middle'
                },
                {
                    name: 'noasset',
                    className: 'text-center align-middle'
                },
                {
                    name: 'asset.name',
                    className: 'text-center align-middle'
                }
                

            ]
        });
}
var idtransaction = "";
var idglobalsubgroupedit = "";
var idglobalcategoryedit = "";
function openmodaledits(element){

// alert("test");
    var myelement = element.id.split("-");
    var myid = myelement[1];
    idtransaction = myid;
    // alert()
    // var idcategory = $("#category_"+myid).val();
    // var idsubgroup = $("#category_"+myid).val();
    var idgroup = $("#group_"+myid).val();
    var subgroup = $("#subgroup_"+myid).val();
    var category = $("#category_"+myid).val();
    idglobalsubgroupedit = subgroup;
    idglobalcategoryedit = category;
    
    $('#groupsedit option[value=' + idgroup + ']').prop('selected', true);
    $('#groupsedit').trigger("change");
    asseteditshow();
};
    var arridselectedassetadd = [];
    function pilihasset(){
        var count = 0;
        var arrselectedasset = [];
      arridselectedassetadd = [];
        $("#datatable_asset tbody input[type='checkbox']").each(function(){
                var checked =  this.checked;
              
                if(checked){
                    var myid = this.id;
                    var splitid = myid.split("_");
                    var myfixid = $(this).closest('td').next('td').find('label').attr('id').split("_");
               
                    arridselectedassetadd.push(myfixid[1]);
                    var noasset = $("#noasset_"+myfixid[1]).text();
                    var nameasset = $("#name_"+myfixid[1]).text();
                    var conditions = $("#conditions_"+myfixid[1]).text();
                    var initialcondition = $("#initial_condition_"+myfixid[1]).text();
               
                    arrselectedasset.push(myfixid[1]+"~~"+noasset + "~~" + nameasset + "~~" + conditions + "~~" + initialcondition);
                    count +=1;
                }
          
                
        });
        $("#containerpilihaset").html("");
        $("#containerpilihaset").append("<table id = 'tablepilihasset' class = 'table table-hover table-bordered display nowrap w-100'><tr><th>No Asset</th><th>Asset Name</th></tr><tbody>");
        for(var i = 0 ; i < arrselectedasset.length; i++)
        {
            var split = arrselectedasset[i].split("~~");
            $("#tablepilihasset").append("<tr><td>"+split[1] + "</td><td>" + split[2] + "</td></tr>");
        }
        $("#containerpilihaset").append("</tbody></table>");
      $("#selectasset").modal("toggle");
    }
    var arridselectedassetedit = [];
    function pilihassetedit(){
        var count = 0;
        var arrselectedasset = [];
      arridselectedassetedit = [];
        $("#datatable_asset_edit tbody input[type='checkbox']").each(function(){
                var checked =  this.checked;
              
                if(checked){
                    var myid = this.id;
                    var splitid = myid.split("_");
                    var myfixid = $(this).closest('td').next('td').find('label').attr('id').split("_");
                    arridselectedassetedit.push(myfixid[1]);
                    var noasset = $("#noassetedit_"+myfixid[1]).text();
                    var nameasset = $("#nameedit_"+myfixid[1]).text();
                    var conditions = $("#conditionsedit_"+myfixid[1]).text();
                    var initialcondition = $("#initial_conditionedit_"+myfixid[1]).text();
                    arrselectedasset.push(myfixid[1]+"~~"+noasset + "~~" + nameasset + "~~" + conditions + "~~" + initialcondition);
                    count +=1;
                }
          
                
        });
       
        $("#containerpilihasetedit").html("");
        $("#containerpilihasetedit").append("<table id = 'tablepilihassetedit' class = 'table table-hover table-bordered display nowrap w-100'><tr><th>No Asset</th><th>Asset Name</th></tr><tbody>");
        for(var i = 0 ; i < arrselectedasset.length; i++)
        {
            var split = arrselectedasset[i].split("~~");
            $("#tablepilihassetedit").append("<tr><td>"+split[1] + "</td><td>" + split[2] + "</td></tr>");
        }
        $("#containerpilihasetedit").append("</tbody></table>");
      $("#selectassetedit").modal("toggle");
    }
    var arrayasset = [];
    // $('body').scrollspy({ target: '.sidebar' });
    $("#group").trigger('change');
    $("#groups").trigger('change');
    var myopenid = "";
    var globaltotalpurchaseprice = 0;
    var globalcostpermonth = 0;
    
    var iddefaultcategories = "";
    function openselectasset(){
        
        var idcategories = $("#categories").val();
        if(iddefaultcategories != idcategories)
        {
            iddefaultcategories = idcategories;
            loadasset(idcategories);
    
        }
     
        var groups = document.getElementById("groups");
        var subgroups = document.getElementById("subgroups");
        var categories = document.getElementById("categories");
        var strgroups = groups.options[groups.selectedIndex].text;
        var strsubgroups = subgroups.options[subgroups.selectedIndex].text;
        var strcategories = categories.options[categories.selectedIndex].text;
        $("#grouptitleselectasset").text(strgroups);
        $("#subgrouptitleselectasset").text(strsubgroups);
        $("#categoriestitleselectasset").text(strcategories);
     
        // var asset = document.getElementById("datatable_asset");
        // console.log(asset);
     

    }
    function openselectassetedit(){
        
        var idcategories = $("#categoriesedit").val();
        var groups = document.getElementById("groupsedit");
        var subgroups = document.getElementById("subgroupsedit");
        var categories = document.getElementById("categoriesedit");
        var strgroups = groups.options[groups.selectedIndex].text;
        var strsubgroups = subgroups.options[subgroups.selectedIndex].text;
        var strcategories = categories.options[categories.selectedIndex].text;

        $("#grouptitleselectassetedit").text(strgroups);
        $("#subgrouptitleselectassetedit").text(strsubgroups);
        $("#categoriestitleselectassetedit").text(strcategories);
        if(iddefaultcategories != idcategories)
        {
            iddefaultcategories = idcategories;
            loadassetedit(idcategories);
        }
    }

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
            $(element).animate({
                width: '100px',
                height: '100px'
            }, "slow");
            $(element).removeClass("wide");
        } else {
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
    function loadasset(params){
        
      asset = $("#datatable_asset").DataTable({
            processing: true,
            deferRender: true,
            serverSide: true,
            destroy: true,
            scrollX:true,
            responsive: true,
            autoWidth: true,
            iDisplayInLength: 10,
            columnDefs: [{
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                }
            }],
            // scrollX: true,
            order: [
                [0, 'asc']
            ],
            ajax: {
                url: 'process/mastergetasset.php',
                method: 'POST',
                data: {
                    tipe: "load",
                    statusmust : "newasset",
                    myparam : params
                },
               
            },
            columns: [{
                    searchable:false,
                    orderable:false,
                    name: '#',
                    className: 'text-center align-middle'
                },
                {
                    name: 'noasset',
                    className: 'text-center align-middle'
                },
                {
                    name: 'name',
                    className: 'text-center align-middle'
                },
                {
                    name: 'conditions',
                    className: 'text-center align-middle'
                },
                {
                    name: 'initial_condition',
                    className: 'text-center align-middle'
                }
                

            ]
        });
      
     
        // assets.columns.adjust();
    };
    function asseteditshow(){
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/mastergetasset.php",
            method: 'POST',
            data: {
                tipe: "getassettransaction",
                myidtransaction: idtransaction

            },
            success: function (result) {
                var jsonparse = JSON.parse(result);
                $("#containerpilihasetedit").html("");
                $("#containerpilihasetedit").html(jsonparse.data.mystring);
                arridselectedassetedit = jsonparse.data.myarray;
                
            }
        });
    }
    function loadassetedit(params){
        
        assetedit = $("#datatable_asset_edit").DataTable({
              processing: true,
              deferRender: true,
              serverSide: true,
              destroy: true,
              scrollX:true,
              responsive: true,
              autoWidth: true,
              iDisplayInLength: 10,
              // scrollX: true,
              order: [
                  [0, 'asc']
              ],
              
              ajax: {
                  url: 'process/mastergetasset.php',
                  method: 'POST',
                  data: {
                      tipe: "loadexisting",
                      statusmust : "newasset",
                      assetexisting: arridselectedassetedit,
                      myparam : params
                  },
                 
              },
              columnDefs: [{
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                },
                'createdCell':  function (td, cellData, rowData, row, col){
            
                    if(rowData[5] === 'True'){
                        this.api().cell(td).checkboxes.select();
                    }
                }
               }],
              columns: [{
                      searchable:false,
                      orderable:false,
                      name: '#',
                      className: 'text-center align-middle'
                  },
                  {
                      name: 'noasset',
                      className: 'text-center align-middle'
                  },
                  {
                      name: 'name',
                      className: 'text-center align-middle'
                  },
                  {
                      name: 'conditions',
                      className: 'text-center align-middle'
                  },
                  {
                      name: 'initial_condition',
                      className: 'text-center align-middle'
                  },
                  {
                      name: 'status',
                      className: 'text-center align-middle'
                  }
                  
  
              ]
          });
        
       
          // assets.columns.adjust();
      };

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
            columnDefs: [{
                targets: [0],
                visible: false
            }, ],
            ajax: {
                url: 'process/master_transaction_disp_new_asset.php',
                method: 'POST',
                data: {
                    tipe: "load"
                }
            },
            columns: [
                {
                    name: 'ID',
                    searchable: false,
                    className: 'text-center align-middle'
                },
                {
                    name: 'approval',
                    className: 'text-center align-middle'
                },
                {
                    name: 'date',
                    className: 'text-center align-middle'
                },
                {
                    name: 'transaction',
                    className: 'text-center align-middle'
                },
                {
                    name: 'branch',
                    className: 'text-center align-middle'
                },
                {
                    name: 'room',
                    className: 'text-center align-middle'
                },
                {
                    name: 'nama',
                    className: 'text-center align-middle'
                },
                {
                    searchable:false,
                    orderable:false,
                    name: 'action',
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
    function editdata(){
        
        if (arridselectedassetedit.length > 0) {
            var selects = arridselectedassetedit;
            var branch = $('#branchedit').val();
            var room = $('#roomedit').val();
            if (branch == null || room == null) {
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
                    url: "process/mastergetasset.php",
                    method: 'POST',
                    data: {
                        tipe: "edit",
                        mytransaction:idtransaction,
                        myselected: selects,
                        myroom: room,
                        mytable: "transaction_displacement_new_asset_log",
                        mybranch: branch

                    },
                    success: function (myresult) {
                        console.log(myresult);
                        // selected = [];
                        //    alert(result);
                        // if (result == "sukses") {
                         
                            Swal.fire({
                                title: 'Data Saved',
                                text: 'Data Inputted Successfully',
                                icon: 'success',
                                confirmButtonColor: '#53d408',
                                allowOutsideClick: false,
                            }).then((result) => {
                                   success();
                                // $("#categories").trigger("change");
                                // $("#myforms").trigger("reset");
                                $("#canceledittransaction").click();

                            });
                        // } else {
                        //     Swal.fire({
                        //         icon: 'error',
                        //         title: 'Insert Error ',
                        //         text: 'Please check your data',
                        //         confirmButtonColor: '#e00d0d',
                        //     });
                        // }


                    }
                });
            }

            //Clear array

        } else {
            Swal.fire({
                icon: 'error',
                title: 'No Asset Checked ',
                text: 'Please choose at least 1 asset to be placed',
                confirmButtonColor: '#e00d0d',
            });
        }

    }
    function adddata() {
     
        if (arridselectedassetadd.length > 0) {
            var selects = arridselectedassetadd;
            var branch = $('#branch').val();
            var room = $('#room').val();
            if (branch == null || room == null) {
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
                    url: "process/master_transaction_disp_new_asset.php",
                    method: 'POST',
                    data: {
                        tipe: "add",
                        myselected: selects,
                        myroom: room,
                        mybranch: branch

                    },
                    success: function (result) {
                        selected = [];
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
                                $("#containerpilihaset").html("");
                                arridselectedassetadd = [];
                                $("#categories").trigger("change");
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

            //Clear array

        } else {
            Swal.fire({
                icon: 'error',
                title: 'No Asset Checked ',
                text: 'Please choose at least 1 asset to be placed',
                confirmButtonColor: '#e00d0d',
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
        $("#groups").on("change", function () {
            var myid = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_disp_new_asset.php",
                method: 'POST',
                data: {
                    tipe: "getsubgroup",
                    idgroup: myid
                },
                success: function (result) {

                    // alert(result);
                    $("#subgroups").html("");
                    $("#subgroups").html(result);
                    $("#subgroups").trigger("change");
                }

            })
        }).trigger("change");
        $("#groupsedit").on("change", function () {
            var myid = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_disp_new_asset.php",
                method: 'POST',
                data: {
                    tipe: "getsubgroup",
                    idgroup: myid
                },
                success: function (result) {
                    // idglobalsubgroupedit = subgroup;
    // idglobalcategoryedit = category;
                    // alert(result);
                   
                    $("#subgroupsedit").html("");
                    $("#subgroupsedit").html(result).promise().done(function () {
                        // alert(idglobalsubgroupedit);
                        if (!idglobalsubgroupedit == "") {
                            // alert(idglobalsubgroupedit);
                            // alert(idglobalsubgroupedit);
                        $('#subgroupsedit').find('option[value="' + idglobalsubgroupedit +
                                '"]').prop('selected', true);
                        }
                     

});
                    $("#subgroupsedit").trigger("change");
                }

            })
        }).trigger("change");
        $("#subgroups").on("change", function () {
            var myid = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_disp_new_asset.php",
                method: 'POST',
                data: {
                    tipe: "getcategory",
                    idsubgroup: myid
                },
                success: function (result) {

                    // alert(result);
                    $("#categories").html("");
                    $("#categories").html(result);
                    $("#categories").trigger("change");
                }

            })
        }).trigger("change");
        $("#subgroupsedit").on("change", function () {
            var myid = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_disp_new_asset.php",
                method: 'POST',
                data: {
                    tipe: "getcategory",
                    idsubgroup: myid
                },
                success: function (result) {

                    // alert(result);

               
                    $("#categoriesedit").html("");
                    $("#categoriesedit").html(result).promise().done(function () {
                        if (!idglobalcategoryedit == "") {
                        $('#categoriesedit').find('option[value="' + idglobalcategoryedit +
                                '"]').prop('selected', true);
                        }
                    });
                    $("#categoriesedit").trigger("change");
                }

            })
        }).trigger("change");


        $("#categories").on("change", function () {
            var myid = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_disp_new_asset.php",
                method: 'POST',
                data: {
                    tipe: "getasset",
                    idcategory: myid
                },
                success: function (result) {
                    selected = [];
                    // alert(result);
                    $("#chooseaset").html("");
                    $("#chooseaset").html(result);
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
        $("#branch").on("change", function () {
            var myid = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_disp_new_asset.php",
                method: 'POST',
                data: {
                    tipe: "getroom",
                    idbranch: myid
                },
                success: function (result) {
                    $("#room").html("");
                    $("#room").append(result);

                }

            })
        }).trigger("change");
        $("#branchedit").on("change", function () {
            var myid = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_disp_new_asset.php",
                method: 'POST',
                data: {
                    tipe: "getroom",
                    idbranch: myid
                },
                success: function (result) {
                    $("#roomedit").html("");
                    $("#roomedit").append(result);

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
    function openmodaldetailtransaction(element){
        var myid = element.id;
        var notransaction = $("#notransaction" + myid).text();
        var datetransaction = $("#mydate" + myid).text();
        var createdby = $("#nama" + myid).text();
        var mydate = new Date(datetransaction);
        const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
        ];
        $("#detailnotransaction").text("Transaction No : " + notransaction);
        $("#detailcreate").text("Created By : " + createdby)
        $("#detaildate").text("Transaction Date : " + mydate.getDate() + " " + monthNames[mydate.getMonth()] + " " + mydate.getFullYear());
           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_disp_new_asset.php",
                method: 'POST',
                data: {
                    tipe: "getdetailtransaction",
                    idtransaction: myid
                },
                success: function (result) {
                    if(result == "")
                    {
                        $("#detailqty").html("Asset Count : 0 pcs");
                        $("#listtransaction").html("");
                        $("#listtransaction").html(result);
                    }
                    else{
                        var mysplit = result.split("||");
                        var qty = mysplit[0];
                        var data = mysplit[1];
                        $("#listtransaction").html("");
                        $("#listtransaction").html(data);
                        $("#detailqty").html("Asset Count : "+qty+" pcs");
                    }
                    
                }
            });

    }
</script>