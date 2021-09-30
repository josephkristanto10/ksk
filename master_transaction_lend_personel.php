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
$sqltemplate = "select * from template where status = 'Active'";
$restemplate = $conn->query($sqltemplate);
$mytemplate = array();
if($restemplate -> num_rows>0)
{
	while($j = mysqli_fetch_array($restemplate))
	{
		$mytemplate[] = $j;
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
$sqldepartment = "select * from department";
$resdepartment = $conn->query($sqldepartment);
$mydepartment = array();
if($resdepartment -> num_rows>0)
{
	while($j = mysqli_fetch_array($resdepartment))
	{
		$mydepartment[] = $j;
	}
}
$sqlinitial = "select * from initial_condition";
$resinitial  = $conn->query($sqlinitial);
$myinitial = array();
if($resinitial -> num_rows>0)
{
	while($j = mysqli_fetch_array($resinitial))
	{
		$myinitial[] = $j;
	}
}
$sqlconditions = "select * from conditions";
$resconditions  = $conn->query($sqlconditions);
$myconditions = array();
if($resconditions -> num_rows>0)
{
	while($j = mysqli_fetch_array($resconditions))
	{
		$myconditions[] = $j;
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
            <h4><span class="font-weight-semibold">Asset's Lend to Personel </span></h4>
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
                                <th>#</th>
                                <th>Approval</th>
                                <th>Date</th>
                                <th>Transaction</th>
                                <th>Branch Personel</th>
                                <th>No Asset</th>
                                <th>Asset</th>
                                <th>Room</th>
                                <th>Nik</th>
                                <th>Name</th>
                                <th>Start Date</th>
                                <th>Due Date</th>

                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        </tbody>


                        </tbody>

                    </table>
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
                        <label for="cars" style="font-size:11pt;"><b>Personel Section</b></label><br>
                        <label for="cars">Branch:</label>
                        <select id="branchpersonel" name="branchpersonel" class="form-control">
                            <?php
                                        for($i = 0 ; $i < count($mybranch); $i++)
                                        {                                            
                                                echo '<option value="'.$mybranch[$i]['idbranch'].'">'.$mybranch[$i]['branch'].'</option>';                                       
                                        }
                                ?>
                        </select>
                        <br>
                        <label for="cars">Department:</label>
                        <select id="department" name="department" class="form-control">
                            <?php
                                        for($i = 0 ; $i < count($mydepartment); $i++)
                                        {                                            
                                                echo '<option value="'.$mydepartment[$i]['id'].'">'.$mydepartment[$i]['department'].'</option>';                                       
                                        }
                                ?>
                        </select>
                        <br>
                        <label for="cars">User:</label>
                        <select id="user" name="user" class="form-control">

                        </select>
                        <br>
                        <b>Personel Preview</b>
                        <div class="row">

                            <div class="col-md-6">
                                <br>
                                <label>NIK</label>
                                <br>
                                <label id="nikpreview">1123</label>
                            </div>
                            <div class="col-md-6">
                                <br>
                                <label>Name</label>
                                <br>
                                <label id="username">Good</label>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <br>
                                <label>Email</label>
                                <br>
                                <label id="emailpreview">Good</label>
                            </div>
                            <div class="col-md-6">
                                <br>
                                <label>Rank</label>
                                <br>
                                <label id="rankpreview">Good</label>
                            </div>
                        </div>
                        <hr>
                        <label for="cars" style="font-size:11pt;"><b>Asset Section</b></label><br>
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
                        <label for="cars" style="font-size:11pt;"><b>Room Section</b></label><br>
                        <label for="cars">Branch :</label>
                        <select id="branchroom" name="branchroom" class="form-control">
                            <?php
                                        for($i = 0 ; $i < count($mybranch); $i++)
                                        {                                            
                                                echo '<option value="'.$mybranch[$i]['idbranch'].'">'.$mybranch[$i]['branch'].'</option>';                                       
                                        }
                                ?>
                        </select>
                        <br>
                        <label for="cars">Room :</label>
                        <select id="room" name="room" class="form-control">

                        </select>
                        <br>
                        <hr>
                        <label for="cars">Start Date</label>
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-calendar22"></i></span>
                            </span>
                            <input type="text" class="form-control pickadate required" name="mystartdate"
                                id="mystartdate" value="<?php echo date('d-m-Y');?>">

                        </div>

                        <br>

                        <label for="cars">Due Date:</label>
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-calendar22"></i></span>
                            </span>
                            <input type="text" class="form-control pickadate required" name="enddate" id="enddate"
                                value="<?php date_default_timezone_set('Asia/Jakarta');
echo date('d-m-Y');?>">

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
</body>

</html>
<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
    $('#mystartdate').pickadate({
        format: 'dd-mm-yyyy'
    });
    $('#enddate').pickadate({
        format: 'dd-mm-yyyy'
    });
    // $('body').scrollspy({ target: '.sidebar' });
    $("#group").trigger('change');
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
        var dt = $("#datatable_serverside").DataTable({
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
                url: 'process/master_transaction_lend_personel.php',
                method: 'POST',
                data: {
                    tipe: "load"
                }
            },
            columns: [

                {
                    name: '#',
                    className: 'text-center align-middle',
                    class: "details-control"
                },
                {
                    name: 'StatusApproval',
                    className: 'text-center align-middle'
                },
                {
                    name: 'MyDate',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Transaction',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Branch',
                    className: 'text-center align-middle'
                },
                {
                    name: 'No Asset',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Name',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Room',
                    className: 'text-center align-middle'
                },
                {
                    name: 'nik',
                    className: 'text-center align-middle'
                },
                {
                    name: 'NamaKaryawan',
                    className: 'text-center align-middle'
                },
                {
                    name: 'startdate',
                    className: 'text-center align-middle'
                },
                {
                    name: 'duedate',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Status',
                    className: 'text-center align-middle'
                }
            ]
        });

        var detailRows = [];

        $('#datatable_serverside tbody').on('click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt.row(tr);
            var idx = $.inArray(tr.attr('id'), detailRows);

            var badge = tr.find('span.badge');
            //  alert(idtest);
            var icon = tr.find('i');
            if (row.child.isShown()) {
                tr.removeClass('details');
                row.child.hide();

                detailRows.splice(idx, 1);

                tr.removeClass('shown');
                badge.first().removeClass('badge-danger');
                badge.first().addClass('badge-success');
                icon.first().removeClass('icon-minus3');
                icon.first().addClass('icon-plus3');
            } else {
                tr.addClass('details');
                var branchroom = $("#branchroom" + badge[0].id).val();
                var room = $("#room" + badge[0].id).text();
                var nik = $("#nik" + badge[0].id).text();
                var name = $("#namakaryawan" + badge[0].id).text();
                var startdate = $("#startdate" + badge[0].id).text();
                var duedate = $("#duedate" + badge[0].id).text();
                var rank = $("#rank" + badge[0].id).val();
                var email = $("#email" + badge[0].id).val();
                var approval = $("#statusapproval" + badge[0].id).text();
                var status = $("#status" + badge[0].id).text();
                var myapproval = "";
             
                if(approval.toLowerCase().includes("pending"))
                {
                    myapproval = "<span style = 'color:#e37e02'><i class='mi-info'></i> Pending </span>";
                }
                else if(approval.toLowerCase().includes("rejected"))
                {
                    myapproval = "<span style = 'color:#e32702'><i class='mi-cancel'></i>Rejected </span>";
                }
                else if(approval.toLowerCase().includes("accepted"))
                {
                    myapproval = "<span style = 'color:#2aa602'><i class='mi-check-box'></i> Accepted </span>";
                }

                card = '<span class = "mi-subdirectory-arrow-right" style = "font-size: 3em;height:100px;float:left;margin-left:10px"></span><div class="card" style = "min-width:250px !important;float:left;margin-left:10px;"><div class="card-header header-elements-inline"><h5 class="card-title">Lend Detail</h5></div>	<div class="card-body" style="text-align:left;"><p>Branch : <b>' +
                        branchroom + ' </b></p> <p>Room : <b>' + room + 
                        ' </b></div></div> 	</div> <div class="card" style = "min-width:250px !important;float:left;margin-left:10px;"><div class="card-header header-elements-inline"><h5 class="card-title"> Personal Detail</h5><div class="header-elements"><div class="list-icons"></div></div></div>	<div class="card-body" style="text-align:left;"><p>NIK : <b>' +
                        nik + ' </b></p> <p>Employee Name : <b>' + name+
                        ' </b></p> </p> <p>Rank : <b>' + rank +
                        ' </b></p><p>Email : <b>'+email+'</b></p></div>	</div></div><div class="card" style = "min-width:250px !important;float:left;margin-left:10px;"><div class="card-header header-elements-inline"><h5 class="card-title"> Lend Status</h5><div class="header-elements"><div class="list-icons"></div></div></div>	<div class="card-body" style="text-align:left; "><p>Start Date : <b>' +
                        startdate + ' </b></p><p>End Date : <b>' + duedate +
                        ' </b></p><p>Approval : <b>'+myapproval+'</b></p> <p>Status : <b style = "' + "stringcolor" + '"> ' + status +
                        '</b></p></div>	</div>';
                        // <div style = "text-align:left;margin-top:10px;"> <div class = "row"><div style = "float:left;padding:5px;margin-left:20px;"><label for="cars" style="font-size:10pt;"><b>User Section</b></label><br><label>Nik : 11212</label> <br><label>Branch : Surabaya</label><br><label>Email : Email</label><br><label>Rank : Rank</label><br><br><label for="cars" style="font-size:10pt;"></div><div style = "float:left;padding:5px;margin-left:10px;"><label for="cars" style="font-size:10pt;"><b>User Section</b></label><br><label>Nik : 11212</label> <br><label>Branch : Surabaya</label><br><label>Email : Email</label><br><label>Rank : Rank</label><br><br><label for="cars" style="font-size:10pt;"></div><div style = "float:left;padding:5px;;margin-left:10px;"><label for="cars" style="font-size:10pt;"><b>User Section</b></label><br><label>Nik : 11212</label> <br><label>Branch : Surabaya</label><br><label>Email : Email</label><br><label>Rank : Rank</label><br><br><label for="cars" style="font-size:10pt;"></div></div></div>

                row.child(card).show();
                      
                     

                // Add to the 'open' array
                if (idx === -1) {
                    detailRows.push(tr.attr('id'));
                }
                //  detailRows
                tr.addClass('shown');
                badge.first().removeClass('badge-success');
                badge.first().addClass('badge-danger');
                icon.first().removeClass('icon-plus3');
                icon.first().addClass('icon-minus3');
            }
            //  onclickdatarow();
        });

        dt.on('draw', function () {
            $.each(detailRows, function (i, id) {
                $('#' + id + ' td.details-control').trigger('click');
            });
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
        var branchpersonel = $("#branchpersonel").val();
        var department = $('#department').val();
        var user = $('#user').val();
        var group = $('#groups').val();
        var asset = $('#asset').val();
        var branchroom = $('#branchroom').val();
        var room = $('#room').val();
        var startdate = $('#mystartdate').val();
        var enddate = $('#enddate').val();
        if (startdate == "" || enddate == "" || user == null || asset == null) {
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
                url: "process/master_transaction_lend_personel.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    mybranchpersonel: branchpersonel,
                    mydepartment: department,
                    myuser: user,
                    mygroup: group,
                    myasset: asset,
                    mybranchroom: branchroom,
                    myroom: room,
                    mystart: startdate,
                    myend: enddate

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
                            $("#myform").trigger("reset");
                            $("#canceladd").click();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Insert Error',
                            text: 'Error inserting data',
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


        $("#groups").trigger('change');
        $("#groups").on("change", function () {
            var myid = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_lend_personel.php",
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
        $("#branchroom").on("change", function () {
            var myid = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_lend_personel.php",
                method: 'POST',
                data: {
                    tipe: "getroom",
                    idbranch: myid
                },
                success: function (result) {
                    $("#room").html("");
                    $("#room").html(result);

                }

            })
        }).trigger("change");

        $("#branchpersonel").on("change", function () {
            var myvalues = this.value;
            var department = $("#department").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_lend_personel.php",
                method: 'POST',
                data: {
                    tipe: "getuser",
                    idbranch: myvalues,
                    iddepartment: department

                },
                success: function (result) {
                    // alert(result);
                    if (result == "none") {
                        $("#user").html("");

                    } else {
                        $("#user").html("");
                        $("#user").html(result);
                        $("#user").trigger("change");
                    }


                }
            });
        }).trigger("change");
        $("#department").on("change", function () {
            var myvalues = $("#branchpersonel").val();
            var department = $("#department").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_lend_personel.php",
                method: 'POST',
                data: {
                    tipe: "getuser",
                    idbranch: myvalues,
                    iddepartment: department

                },
                success: function (result) {
                    // alert(result);
                    if (result == "none") {
                        $("#user").html("");

                    } else {
                        $("#user").html("");
                        $("#user").html(result);
                        $("#user").trigger("change");
                    }


                }
            });
        }).trigger("change");
        $("#user").on("change", function () {
            var myvalues = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_lend_personel.php",
                method: 'POST',
                data: {
                    tipe: "getdetailuser",
                    iduser: myvalues

                },
                success: function (result) {

                    var myresult = result.split("~~");
                    $("#nikpreview").text(myresult[0]);
                    $("#username").text(myresult[1]);
                    $("#emailpreview").text(myresult[2]);
                    $("#rankpreview").text(myresult[3]);






                }
            });
        }).trigger("change");


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