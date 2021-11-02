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
                                <th>Room</th>
                                <th>toRoom</th>
                                <th>Remark</th>

                                <th>Lead Time</th>
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
            <div class="modal-body">

                <label for="cars" style="font-size:11pt;"><b>Transaction Section</b></label><br><br>
                <label for="idgroup" id="detailnotransaction">Transaction No : -</label><br>
                <label for="idgroup" id="detaildate">Transaction Date : -</label><br>
                <!-- <label for="idgroup" id = "detailcreate">Created By: -</label><br> -->
                <hr style="border-top: 3px dashed #d4d4d4;">
                <label for="cars" style="font-size:11pt;"><b>Asset Section</b></label><br>
                <label for="idgroup" id="detailqty">Asset Count : 8 pcs</label><br>
                <label for="idgroup">Asset List: </label>
                <br><br>
                <div id="listtransaction">

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
                        <input id="remark" type="text" class="form-control">

                        <br>
                        <br>
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
                        <label for="cars">Asset Category:</label><a href="#selectasset" onclick="openselectasset(this)"
                            data-toggle="modal" data-backdrop="static" data-keyboard="false">select asset</a>
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
<!-- Modal Choose Aset -->
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
                        <label for="cars">Group: &nbsp <b><label id="grouptitleselectasset">-</label></b></label><br>
                        <label for="cars">Sub Group: &nbsp <b><label
                                    id="subgrouptitleselectasset">-</label></b></label><br>
                        <label for="cars">Category: &nbsp <b><label
                                    id="categoriestitleselectasset">-</label></b></label><br>
                        <table id="datatable_asset" class="table table-hover table-bordered display nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No. Asset</th>
                                    <th>Name</th>
                                    <th>Condition</th>
                                    <th>Initial Condition</th>

                                </tr>
                            </thead>
                            </tbody>
                            </tbody>

                        </table>
                        <div style="float:right;margin-bottom:20px;">
                            <button type="button" class="btn btn-primary" id="pilihaset" style="margin-right:10px;"
                                onclick="pilihasset()">Choose</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                id="canceladd">Cancel</button>
                        </div>
                    </div>
                </form>
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
                    <label for="cars">Branch From:</label>
                        <select id="branchfromedit" name="branchfromedit" class="form-control">
                            <?php
                                        for($i = 0 ; $i < count($mybranch); $i++)
                                        {                                            
                                                echo '<option value="'.$mybranch[$i]['idbranch'].'">'.$mybranch[$i]['branch'].'</option>';                                       
                                        }
                                ?>
                        </select>
                        <br>

                        <label for="cars">From Room:</label>
                        <select id="fromroomedit" name="fromroomedit" class="form-control">
                        </select>
                        <br>
                        <label for="cars">Branch To:</label>
                        <select id="branchtoedit" name="branchtoedit" class="form-control">
                            <?php
                                        for($i = 0 ; $i < count($mybranch); $i++)
                                        {                                            
                                                echo '<option value="'.$mybranch[$i]['idbranch'].'">'.$mybranch[$i]['branch'].'</option>';                                       
                                        }
                                ?>
                        </select>
                        <label for="cars">toroom:</label>
                        <select id="toroomedit" name="toroomedit" class="form-control">
                        </select>
                        <br>
                        <label for="cars">Remark :</label>
                        <input id="remarkedit" type="text" class="form-control">
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
                        <label for="cars">Asset Category:</label> <a href="#selectassetedit"
                            onclick="openselectassetedit(this)" data-toggle="modal" data-backdrop="static"
                            data-keyboard="false">select asset</a>
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
                <button type="button" class="btn btn-secondary" style="margin-right:30px;margin-top:10px;"
                    data-dismiss="modal" id="canceledittransaction">Cancel</button>
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
                        <label for="cars">Group: &nbsp <b><label
                                    id="grouptitleselectassetedit">-</label></b></label><br>
                        <label for="cars">Sub Group: &nbsp <b><label
                                    id="subgrouptitleselectassetedit">-</label></b></label><br>
                        <label for="cars">Category: &nbsp <b><label
                                    id="categoriestitleselectassetedit">-</label></b></label><br>
                        <table id="datatable_asset_edit" class="table table-hover table-bordered display nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No. Asset</th>
                                    <th>Name</th>
                                    <th>Condition</th>
                                    <th>Initial Condition</th>

                                </tr>
                            </thead>
                            </tbody>

                            </tbody>

                        </table>
                        <div style="float:right;margin-bottom:20px;">
                            <button type="button" class="btn btn-primary" id="pilihaset" style="margin-right:10px;"
                                onclick="pilihassetedit()">Choose</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                id="canceladd">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- End Modal Choose Asset -->
</body>

</html>
<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>

    // variable pilih asset
    var idtransaction = "";
    var idglobalsubgroupedit = "";
    var idglobalcategoryedit = "";
    var idglobalidtoroomsedit = "";
    var idglobalidfromroomsedit = "";
    var arridselectedassetadd = [];
    var arridselectedassetedit = [];
    // end variable

    var selected = [];
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
                },
                {
                    name: 'action',
                    searchable:false,
                    orderable:false,
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
     
        if (arridselectedassetadd.length > 0) {
            var selectasset = arridselectedassetadd;
            var group = $("#groups").val();
            var branchfrom = $('#branchfrom').val();
            var branchto = $('#branchto').val();
            var fromroom = $('#fromroom').val();
            var toroom = $('#toroom').val();
            var remark = $('#remark').val();
            if (remark == "" || branchfrom == null || branchto == null || fromroom ==
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
                        myselect: selectasset,
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


    $(document).ready(function () {

        // select edit 
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
                    $("#subgroupsedit").html("");
                    $("#subgroupsedit").html(result).promise().done(function () {
                        if (!idglobalsubgroupedit == "") {
                            $('#subgroupsedit').find('option[value="' +
                                idglobalsubgroupedit +
                                '"]').prop('selected', true);
                        }
                    });
                    $("#subgroupsedit").trigger("change");
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
                            $('#categoriesedit').find('option[value="' +
                                idglobalcategoryedit +
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
                url: "process/master_transaction_disp_department.php",
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
        //
        $("#groups").on("change", function () {
            var myid = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_disp_department_branch.php",
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
        $("#subgroups").on("change", function () {
            var myid = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_disp_department_branch.php",
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


        $("#categories").on("change", function () {
            var myid = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_disp_department_branch.php",
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
                url: "process/master_transaction_disp_department_branch.php",
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
                url: "process/master_transaction_disp_department_branch.php",
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
        $("#branchfromedit").on("change", function () {
            var myid = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_disp_department_branch.php",
                method: 'POST',
                data: {
                    tipe: "getroom",
                    idbranch: myid
                },
                success: function (result) {
                    $("#fromroomedit").html("");
                    $("#fromroomedit").append(result).promise().done(function () {
                        if (!globalfromroom == "") {
                       
                            $('#fromroomedit').find('option[value="' + globalfromroom +
                                '"]').prop('selected', true);
                        }

                    });
                    $("#fromroomedit").trigger("change");
        


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
                url: "process/master_transaction_disp_department_branch.php",
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
        $("#branchtoedit").on("change", function () {
            var myid = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_disp_department_branch.php",
                method: 'POST',
                data: {
                    tipe: "getroom",
                    idbranch: myid
                },
                success: function (result) {
                    $("#toroomedit").html("");
                    $("#toroomedit").append(result).promise().done(function () {
                        if (!globaltoroom == "") {
                       
                            $('#toroomedit').find('option[value="' + globaltoroom +
                                '"]').prop('selected', true);
                        }

                    });
                    $("#toroomedit").trigger("change");

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

    function openmodaldetailtransaction(element) {
        var myid = element.id;
        var notransaction = $("#notransaction" + myid).text();
        var datetransaction = $("#mydate" + myid).text();
        var createdby = $("#nama" + myid).text();
        var mydate = new Date(datetransaction);
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        $("#detailnotransaction").text("Transaction No : " + notransaction);
        // $("#detailcreate").text("Created By : " + createdby)
        $("#detaildate").text("Transaction Date : " + mydate.getDate() + " " + monthNames[mydate.getMonth()] + " " +
            mydate.getFullYear());
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/master_transaction_disp_department_branch.php",
            method: 'POST',
            data: {
                tipe: "getdetailtransaction",
                idtransaction: myid
            },
            success: function (result) {
                // alert(result);
                if (result == "") {
                    $("#detailqty").html("Asset Count : 0 pcs");
                    $("#listtransaction").html("");
                    $("#listtransaction").html(result);
                } else {
                    var mysplit = result.split("||");
                    var qty = mysplit[0];
                    var data = mysplit[1];
                    $("#listtransaction").html("");
                    $("#listtransaction").html(data);
                    $("#detailqty").html("Asset Count : " + qty + " pcs");
                }

            }
        });

    }
    $('.sidebar').animate({
        scrollTop: $("#setupfloor").offset().top
    }, 2000);


     // Asset Choose Section
     var asset = null;
    var assetedit = null;
    var chosenasset = null;
    var iddefaultcategories = "";
    $('#selectasset').on('shown.bs.modal', function () {
        var idcategories = $("#categories").val();
        if (iddefaultcategories != idcategories) {
            iddefaultcategories = idcategories;
            loadasset(idcategories);
        }
        asset.columns.adjust();
    });

    function openselectasset() {

        var idcategories = $("#categories").val();
        if (iddefaultcategories != idcategories) {
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
    }

    function openselectassetedit() {

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
        if (iddefaultcategories != idcategories) {
            iddefaultcategories = idcategories;
            loadassetedit(idcategories);
        }
    }

    function loadasset(params) {

        asset = $("#datatable_asset").DataTable({
            processing: true,
            deferRender: true,
            serverSide: true,
            destroy: true,
            scrollX: true,
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
                    tipe: "load",
                    statusmust: "placed",
                    myparam: params
                },

            },
            columns: [{
                    searchable: false,
                    orderable: false,
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
    };

    function loadassetedit(params) {

        assetedit = $("#datatable_asset_edit").DataTable({
            processing: true,
            deferRender: true,
            serverSide: true,
            destroy: true,
            scrollX: true,
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
                    statusmust: "placed",
                    assetexisting: arridselectedassetedit,
                    myparam: params
                },

            },
            columns: [{
                    searchable: false,
                    orderable: false,
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
    };




    function pilihasset() {
        var count = 0;
        var arrselectedasset = [];
        arridselectedassetadd = [];
        $(".checkboxasset").each(function () {
            var checked = this.checked;

            if (checked) {
                var myid = this.id;
                var splitid = myid.split("_");
                var myfixid = splitid[1];
                arridselectedassetadd.push(myfixid);
                var noasset = $("#noasset" + myfixid).text();
                var nameasset = $("#name" + myfixid).text();
                var conditions = $("#conditions" + myfixid).text();
                var initialcondition = $("#initial_condition" + myfixid).text();
                arrselectedasset.push(myfixid + "~~" + noasset + "~~" + nameasset + "~~" + conditions + "~~" +
                    initialcondition);
                count += 1;
            }


        });
        $("#containerpilihaset").html("");
        $("#containerpilihaset").append(
            "<table id = 'tablepilihasset' class = 'table table-hover table-bordered display nowrap w-100'><tr><th>No Asset</th><th>Asset Name</th></tr><tbody>"
            );
        for (var i = 0; i < arrselectedasset.length; i++) {
            var split = arrselectedasset[i].split("~~");
            $("#tablepilihasset").append("<tr><td>" + split[1] + "</td><td>" + split[2] + "</td></tr>");
        }
        $("#containerpilihaset").append("</tbody></table>");
        $("#selectasset").modal("toggle");
    }


    function pilihassetedit() {
        var count = 0;
        var arrselectedasset = [];
        arridselectedassetedit = [];
        $(".checkboxassetedit").each(function () {
            var checked = this.checked;

            if (checked) {
                var myid = this.id;
                var splitid = myid.split("_");
                var myfixid = splitid[1];
                arridselectedassetedit.push(myfixid);
                var noasset = $("#noassetedit" + myfixid).text();
                var nameasset = $("#nameedit" + myfixid).text();
                var conditions = $("#conditionsedit" + myfixid).text();
                var initialcondition = $("#initial_conditionedit" + myfixid).text();
                arrselectedasset.push(myfixid + "~~" + noasset + "~~" + nameasset + "~~" + conditions + "~~" +
                    initialcondition);
                count += 1;
            }


        });

        $("#containerpilihasetedit").html("");
        $("#containerpilihasetedit").append(
            "<table id = 'tablepilihassetedit' class = 'table table-hover table-bordered display nowrap w-100'><tr><th>No Asset</th><th>Asset Name</th></tr><tbody>"
            );
        for (var i = 0; i < arrselectedasset.length; i++) {
            var split = arrselectedasset[i].split("~~");
            $("#tablepilihassetedit").append("<tr><td>" + split[1] + "</td><td>" + split[2] + "</td></tr>");
        }
        $("#containerpilihasetedit").append("</tbody></table>");
        $("#selectassetedit").modal("toggle");
    };

    var globalfromroom = "";
    var globaltoroom = "";
    function openmodaledits(element) {
      
        var myelement = element.id.split("-");
        var myid = myelement[1];
        idtransaction = myid;
        var idgroup = $("#group_" + myid).val();
        var subgroup = $("#subgroup_" + myid).val();
        var category = $("#category_" + myid).val();

        //optional

        var branchfrom_ = $("#branchfrom_" + myid).val();
        var branchto_ = $("#branchto_" + myid).val();
        var fromroom_ = $("#fromroom_" + myid).val();
        var toroom_ = $("#toroom_" + myid).val();
        var remarks = $("#remark"+myid).text();

        globaltoroom = toroom_;
        globalfromroom = fromroom_;
    
        $("#remarkedit").val(remarks);
   
        $('#branchfromedit option[value=' + branchfrom_ + ']').prop('selected', true);
        $('#branchfromedit').trigger("change");

        $('#branchtoedit option[value=' + branchto_ + ']').prop('selected', true);
        $('#branchtoedit').trigger("change");

        // $('#fromroomedit option[value=' + fromroom + ']').prop('selected', true);
        // $('#fromroomedit').trigger("change");

      
        //end optional

        idglobalsubgroupedit = subgroup;
        idglobalcategoryedit = category;
        $('#groupsedit option[value=' + idgroup + ']').prop('selected', true);
        $('#groupsedit').trigger("change");
        asseteditshow();
    };

    function asseteditshow() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/mastergetasset.php",
            method: 'POST',
            data: {
                tipe: "getassettransactiondepartmentbranch",
                myidtransaction: idtransaction

            },
            success: function (result) {
                var jsonparse = JSON.parse(result);
                $("#containerpilihasetedit").html("");
                $("#containerpilihasetedit").html(jsonparse.data.mystring);
                arridselectedassetedit = jsonparse.data.myarray;

            }
        });
    };

    function editdata() {
        if (arridselectedassetedit.length > 0) {
            var myselects = arridselectedassetedit;
            var idtransactions = idtransaction;
            var group = $("#groupsedit").val();
            var branchfrom = $('#branchfromedit').val();
            var branchto = $('#branchtoedit').val();
            var fromroom = $('#fromroomedit').val();
            var toroom = $('#toroomedit').val();
            var remark = $('#remarkedit').val();
            // var branch = $("#branchedit").val();
            // var department = $("#departmentedit").val();
            // var fromroom = $("#fromroomedit").val();
            // var toroom = $("#toroomedit").val();
            var remark = $("#remarkedit").val();
            if (remark == "" || branchfrom == null || branchto == null || fromroom ==
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
                        tipe: "edit",
                        myselect: myselects,
                        mybranchfrom: branchfrom,
                        mybranchto: branchto,
                        myfromroom: fromroom,
                        mytoroom: toroom,
                        myremark: remark,
                        mytransactions : idtransactions

                    },
                    success: function (result) {
                        //    console.log(result);


                        Swal.fire({
                            title: 'Data Saved',
                            text: 'Data Changed Successfully',
                            icon: 'success',
                            confirmButtonColor: '#53d408',
                            allowOutsideClick: false,
                        }).then((result) => {
                            success();
                            // $("#myforms").trigger("reset");
                            $("#canceledittransaction").click();
                        });
                    }



                });
            }

        }
        else {
                Swal.fire({
                    icon: 'error',
                    title: 'No Asset Checked ',
                    text: 'Please choose at least 1 asset to be placed',
                    confirmButtonColor: '#e00d0d',
                });
            }
    }

    // end choose aset 
</script>