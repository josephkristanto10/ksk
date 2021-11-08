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
            <h4><span class="font-weight-semibold">Asset's Dispose Transaction </span></h4>
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
                                <th>No. Transaction</th>
                                <th>Action</th>
                            </tr>
                        </thead>

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
                        <label for="cars">Asset Sub Group:</label>
                        <select id="subgroups" name="subgroups" class="form-control">

                        </select>
                        <br>
                        <label for="cars">Asset Category:</label>
                        <select id="categories" name="categories" class="form-control">

                        </select>
                        <br>
                        <b>Asset Choose</b> <a href="#selectasset" onclick="openselectasset(this)"
                            data-toggle="modal" data-backdrop="static" data-keyboard="false">select asset</a>
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
                    <label for="cars" style="font-size:11pt;"><b>Asset Section</b></label><br>
                        <label for="cars">Asset Group:</label>
                        <select id="groupsedit" name="groups" class="form-control">
                            <?php
                                        for($i = 0 ; $i < count($mykategoriasset); $i++)
                                        {                                            
                                                echo '<option value="'.$mykategoriasset[$i]['id'].'">'.$mykategoriasset[$i]['nama'].'</option>';                                       
                                        }
                                ?>
                        </select>
                        <br>
                        <label for="cars">Asset Sub Group:</label>
                        <select id="subgroupsedit" name="subgroups" class="form-control">

                        </select>
                        <br>
                        <label for="cars">Asset Category:</label>
                        <select id="categoriesedit" name="categories" class="form-control">

                        </select>
                        <br>
                        <b>Asset Choose</b> <a href="#selectassetedit" onclick="openselectassetedit(this)"
                            data-toggle="modal" data-backdrop="static" data-keyboard="false">select asset</a>
                        <br><br>
                        <div id="containerpilihasetedit" style="max-height:100px !important;">

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
                url: 'process/master_transaction_dispose.php',
                method: 'POST',
                data: {
                    tipe: "load"
                }
            },
            columns: [
                {
                    name: 'approval',
                    className: 'text-center align-middle'
                },
                {
                    name: 'date',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Transaction',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Action',
                    searchable:false,
                    orderable:false,
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
                var branchroom = $("#branch" + badge[0].id).text();
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
                var company = $("#company"+ badge[0].id).text();
                var contactname = $("#contactname"+ badge[0].id).text();
                card = '<span class = "mi-subdirectory-arrow-right" style = "font-size: 3em;height:100px;float:left;margin-left:10px"></span><div class="card" style = "min-width:250px !important;float:left;margin-left:10px;"><div class="card-header header-elements-inline"><h5 class="card-title">Lend Detail</h5></div>	<div class="card-body" style="text-align:left;"><p>Branch : <b>' +
                        branchroom + ' </b></p> <p>Room : <b>' + room + 
                        ' </b></div></div> 	</div> <div class="card" style = "min-width:250px !important;float:left;margin-left:10px;"><div class="card-header header-elements-inline"><h5 class="card-title"> Company Detail</h5><div class="header-elements"><div class="list-icons"></div></div></div>	<div class="card-body" style="text-align:left;"><p>Company : <b>' +
                        company + ' </b></p> <p>Contact Name : <b>' + contactname+
                        ' </b></p></div>	</div></div><div class="card" style = "min-width:250px !important;float:left;margin-left:10px;"><div class="card-header header-elements-inline"><h5 class="card-title"> Lend Status</h5><div class="header-elements"><div class="list-icons"></div></div></div>	<div class="card-body" style="text-align:left; "><p>Start Date : <b>' +
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
   
        var myselect = arridselectedassetadd;
        if (myselect.length > 0) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_dispose.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    myselected : myselect

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
        else{
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
        $("#relation").on("change", function(){
            var text = $("#relation option:selected").text();
            // alert(text);
            var split = text.split(" - ");
            $("#companypreview").text(split[0]);
            $("#contactnamepreview").text(split[1]);
        }).trigger("change");
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
                            </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="myModal">
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
            <!-- <label for="idgroup" id = "detailcreate">Created By: -</label><br> -->
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
</body>

</html>
<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
    var selected = [];
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
    });


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

        $("a[href='#additionalinfo']").on("click", function () {
            var myid = this.id;
            // alert("test");
            getallanswercustomquestion(myid);

        });
        $("#groups").on("change", function () {
            var myid = this.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_dispose.php",
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
                url: "process/master_transaction_lend_other_branch.php",
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
                url: "process/master_transaction_lend_other_branch.php",
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
        $("#mydepreciation").on("click", function(){
            $("#depreciationtablebody").html("");
            var postingdate = $("#postingdateraw" + myopenid).val();
            var totalmonth = $("#totalmonth"+myopenid).val();
            
            var date1 = new Date(postingdate);
            var date2 = new Date(Date.now());
            var diffYears = date2.getFullYear()-date1.getFullYear();
            var diffMonths = date2.getMonth()-date1.getMonth();
            var diffDays = date2.getDate()-date1.getDate();

            var months = (diffYears*12 + diffMonths);
            var totalprice =  globaltotalpurchaseprice;
            // alert(date1);
            for(var i = 0 ; i < parseInt(totalmonth); i++)
            {
                var month = i+1;
                    totalprice -= globalcostpermonth;
                if((i+1)<=parseInt(months))
                {
                   
                    var mystring = '<tr><td>'+month+'</td><td>Rp '+globalcostpermonth+'</td><td>Rp '+totalprice+'</td><td><b><i style = "font-size:17px; color : #26a69a;font-weight:bold;" class="mi-check"></i><b></td></tr>';
                    $("#depreciationtablebody").append(mystring);
                }
                else{
                    var mystring = '<tr><td>'+month+'</td><td>Rp '+globalcostpermonth+'</td><td>Rp '+totalprice+'</td><td><b><i style = "font-size:17px; color : #ebba34;font-weight:bold;" class="mi-timer"></i><b></td></tr>';
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
        // $("#detailcreate").text("Created By : " + createdby)
        $("#detaildate").text("Transaction Date : " + mydate.getDate() + " " + monthNames[mydate.getMonth()] + " " + mydate.getFullYear());
           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/master_transaction_dispose.php",
                method: 'POST',
                data: {
                    tipe: "getdetailtransaction",
                    idtransaction: myid
                },
                success: function (result) {
                    // alert(result);
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

    var globalroom = "";
    var idbranchroomedit = "";
    var globaliddepartment = "";
    var globalnik = "";
    
    
    function openmodaledits(element) {
      
        var myelement = element.id.split("-");
        var myid = myelement[1];
        idtransaction = myid;
        var idgroup = $("#group_" + myid).val();
      
        var subgroup = $("#subgroup_" + myid).val();
        var category = $("#category_" + myid).val();
        
        //optional
      
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
                tipe: "getassettransactiondispose",
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
            // var myselects = arridselectedassetedit;
            var myselect = arridselectedassetedit;
        
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "process/master_transaction_dispose.php",
                    method: 'POST',
                    data: {
                        tipe: "edit",
                        myselected: myselect,
                        mytransactions : idtransaction

                    },
                    success: function (result) {
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