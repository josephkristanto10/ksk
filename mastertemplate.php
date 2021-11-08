<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'layout/footer.php';
$sql = "SELECT * FROM folder_custom where status_field = 'Active'";
$res = $conn->query($sql);
$mycustom = array();
if($res->num_rows>0)
{
    while($r = mysqli_fetch_array($res))
    {
        $mycustom[] = $r;
    }
}

?>
<style>
    #mymodals .modal-dialog {
        -webkit-transform: translate(0, -50%);
        -o-transform: translate(0, -50%);
        transform: translate(0, -50%);
        top: 50%;
        margin: 0 auto;
    }

    /* #mymodals .modal-body {
			height: 10vh !important;
			overflow-y: auto;
		} */
</style>
<div class="content-wrapper">
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <h4><span class="font-weight-semibold">Master Template</span></h4>
            <div class="page-title d-flex">
                <div class="row" style="width:100%;">
                    <div class="col-xl-12">
                        <a href="#myModal" data-toggle="modal"> <button class="btn btn-info"
                                style="background-color:#26a69a !important;width:175px;"><i class="icon-add"></i> &nbsp
                                Add Template</button></a>
                    </div>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div>

    </div>
    <!-- /page header -->


    <!-- Content area -->
    <div class="content">

        <!-- Main charts -->
        <div class="row">
            <div class="col-xl-12">

                <div class="card">


                    <table id="datatable_serverside" class="table table-hover table-bordered display nowrap w-100">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Template</th>
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
                <h5 class="modal-title">Add Template</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>
            <div class="modal-body">
                <form id="myform">
                    <div class="form-group">
                        <label for="description">Template Name : </label>
                        <input type="text" class="form-control" id="template">
                        <br>
                        <label for="description">Custom Field : </label> <a data-toggle="modal" id="addcustomfieldmodal"
                            href="#mymodals" data-backdrop="static" data-keyboard="false"> + Add custom field</a> <br>
                        <div id="listcustomfield">
                            <?php
                            for($i = 0 ; $i< count($mycustom); $i++)
                            {
                                echo '
                                <input type="checkbox" class="customfield" value = '.$mycustom[$i]['id'].'>
                                <label for="custom">'.$mycustom[$i]['name'].'</label><br>';
                            }
                            ?>
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
<div class="modal fade" id="myModaledit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
                <h5 class="modal-title">Edit Template</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>
            <div class="modal-body">
                <form id="myformedit">
                    <div class="form-group">
                        <label for="description">Template Name : </label>
                        <input type="text" class="form-control" id="templateedit">
                        <br>
                        <label for="description">Custom Field : </label> <br>
                        <span class="select2 select2-container select2-container--default select2-container--disabled"
                            dir="ltr" data-select2-id="42" style="width: 100%;"><span class="selection"><span
                                    class="select2-selection select2-selection--multiple" role="combobox"
                                    aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="true">
                                    <ul id = "mycustomlist" class="select2-selection__rendered">
                                        
                                        <!-- <li class="select2-selection__choice" title="Arizona" data-select2-id="46"><span
                                                class="select2-selection__choice__remove"
                                                role="presentation">×</span>Arizona</li>
                                        <li class="select2-selection__choice" title="Idaho" data-select2-id="47"><span
                                                class="select2-selection__choice__remove"
                                                role="presentation">×</span>Idaho</li>
                                        <li class="select2-selection__choice" title="Wyoming" data-select2-id="48"><span
                                                class="select2-selection__choice__remove"
                                                role="presentation">×</span>Wyoming</li>
                                        <li class="select2-search select2-search--inline"><input
                                                class="select2-search__field" type="search" tabindex="0"
                                                autocomplete="off" autocorrect="off" autocapitalize="none"
                                                spellcheck="false" role="searchbox" aria-autocomplete="list"
                                                placeholder="" style="width: 0.75em;" disabled=""></li> -->
                                    </ul>
                                </span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                        <div id="listcustomfieldedit">
                        </div>
                        <br>
                        <div style="float:right;margin-bottom:20px;">
                            <button type="button" class="btn btn-primary" style="margin-right:10px;"
                                onclick="changedata()">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                id="canceledit">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="mymodals">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#324148;color:white;height:60px;">
                <h5 class="modal-title">Add Custom Field</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>
            <div class="modal-body">
                <form id="myform">
                    <div class="form-group">
                        <label for="description">Custom Field : </label>
                        <input type="text" class="form-control" id="customfieldadd">
                        <br>
                        <div style="float:right;margin-bottom:20px;">
                            <button type="button" class="btn btn-primary" style="margin-right:10px;"
                                onclick="adddatacustomfield()">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                id="canceladd">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Modal -->
</body>

</html>
<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
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
                [0, 'desc']
            ],
            ajax: {
                url: 'process/mastertemplate.php',
                method: 'POST',
                data: {
                    tipe: "load"
                }
            },
            columnDefs: [{
                targets: [0],
                visible: false
            }, ],
            columns: [{
                    name: 'Id',
                    className: 'text-center align-middle'
                },
                {
                    name: 'Template',
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
    var globalid = "";
    var globalidtemplate = "";

    function openmodaledit(element) {
        $("#mycustomlist").html("");
        var idelement = element.id.split("-");
        globalidtemplate = idelement[1];
        var template = $("#template" + idelement[1]).text();
        $("#templateedit").val(template);

      $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/mastertemplate.php",
                method: 'POST',
                data: {
                    tipe: "getcustomfieldpertemplate",
                    mytemplateid: globalidtemplate

                },
                success: function (result) {
                    if(result.status == "ok")
                    {
                        var jumlaharray = result.name.length;
                        for(var i = 0 ; i< jumlaharray; i++)
                        {
                            $("#mycustomlist").append('<li class="select2-selection__choice" title="Arizona" data-select2-id="46"><span class="select2-selection__choice__remove" role="presentation">×</span>'+result.name[i]+'</li>');

                        }
                    }
                    else
                    {
                        console.log("no data");
                    }
                    // 

                }
            });
    }

    function changedata() {
        var changeid = globalidtemplate;
        var changetemplate = $("#templateedit").val();
        if (changetemplate == "" ) {
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
                url: "process/mastertemplate.php",
                method: 'POST',
                data: {
                    tipe: "changedata",
                    myid: changeid,
                    mytemplate: changetemplate

                },
                success: function (result) {
                    // alert(result);
                    if (result == "sukses") {
                        success();
                        Swal.fire({
                            title: 'Data Changed',
                            text: 'Data Changed Successfully',
                            icon: 'success',
                            confirmButtonColor: '#53d408',
                            allowOutsideClick: false,
                        }).then((result) => {
                            // $("#myformedit").trigger("reset");
                            $("#canceledit").click();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Duplicated Template',
                            text: 'Duplicate Entry For This Template',
                            confirmButtonColor: '#e00d0d',
                        });
                    }




                }
            });
        }
    }

    function adddata() {
        var template = $("#template").val();

        if (template == "") {
            Swal.fire({
                icon: 'error',
                title: 'Empty Field',
                text: 'Requirement data cannot be empty',
                confirmButtonColor: '#e00d0d',
            });
        } else {
            var selectedcustom = [];
            $("input:checkbox[class=customfield]:checked").each(function () {
                selectedcustom.push($(this).val());
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/mastertemplate.php",
                method: 'POST',
                data: {
                    tipe: "add",
                    mytemplate: template,
                    myselected: selectedcustom

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
                            title: 'Data Exists',
                            text: 'Duplicate Entry For This template',
                            confirmButtonColor: '#e00d0d',
                        });
                    }


                }
            });
        }

    }
    $("#country").on('change', function () {
        //    alert("test");


        //  alert(myoptionid);
        var myid = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/mastercity.php",
            method: 'POST',
            data: {
                tipe: "getprovince",
                idprovince: myid

            },
            success: function (result) {
                // alert(result);
                if (result == "none") {
                    $("#province").html("");
                } else {
                    $("#province").html(result).promise().done(function () {

                        // if(!globalid =="")
                        // {
                        //     $('#subgroupedit').find('option[value="'+globalid+'"]').prop('selected', true);
                        // }
                    });
                }
            }
        });
    }).trigger('change');
    $("#countryedit").on('change', function () {
        //    alert("test");


        //  alert(myoptionid);
        var myid = this.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/mastercity.php",
            method: 'POST',
            data: {
                tipe: "getprovince",
                idprovince: myid

            },
            success: function (result) {
                // alert(result);
                if (result == "none") {
                    $("#provinceedit").html("");
                } else {
                    $("#provinceedit").html(result).promise().done(function () {

                        if (!globalid == "") {
                            $('#provinceedit').find('option[value="' + globalid + '"]')
                                .prop('selected', true);
                        }
                    });
                }
            }
        });
    }).trigger('change');

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
            url: "process/masterdrivingforce.php",
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

    function deleterow(element) {
        var splitid = element.id.split("-");
        var myid = splitid[1];
        Swal.fire({
            title: 'Do you want to delete this template?',
            html: 'You cannot recover this template after delete',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            confirmButtonColor: '#32d419',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "process/delete.php",
                    method: 'POST',
                    data: {
                        tipe: "template",
                        idtemplate: myid

                    },
                    success: function (myresult) {
                        var status = myresult.status;
                        var jumlah = myresult.jumlah;
                        if (status == "ok") {
                            success();
                            Swal.fire({
                                title: 'Deleted Successfully',
                                icon: 'success',
                                confirmButtonText: 'Ok',
                                confirmButtonColor: '#32d419',
                            });
                        } else {


                            Swal.fire({
                                title: 'Delete Failed',
                                icon: 'error',
                                html: 'There is <b>' + jumlah +
                                    "</b> Template is active on list of Asset, please delete it first",
                                confirmButtonText: 'Ok',
                                confirmButtonColor: '#32d419',
                            });
                        }
                    }
                });

            }
        })
    }

    function getcustomfield() {

    }

    function adddatacustomfield() {
        var customfield = $("#customfieldadd").val();

        if (customfield == "") {
            Swal.fire({
                icon: 'error',
                title: 'Empty Field',
                text: 'Requirement data cannot be empty',
                confirmButtonColor: '#e00d0d',
            });
        } else {
            var selectedcustom = [];
            $("input:checkbox[class=customfield]:checked").each(function () {
                selectedcustom.push($(this).val());
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "process/mastercustomfield.php",
                method: 'POST',
                data: {
                    tipe: "addreturn",
                    mycustom: customfield

                },
                success: function (myresult) {
                    //    alert(result);
                    console.log(myresult);
                    if (myresult.status == "sukses") {
                        success();
                        Swal.fire({
                            title: 'Data Saved',
                            text: 'Data Inputted Successfully',
                            icon: 'success',
                            confirmButtonColor: '#53d408',
                            allowOutsideClick: false,
                        }).then((result) => {
                            // $("#myform").trigger("reset");
                            // $("#canceladd").click();
                            var myid = myresult.id;
                            $("#listcustomfield").append(
                                '<input type="checkbox" class="customfield" value = "' + myid +
                                '"><label for="custom"> &nbsp' + customfield + '</label><br>');

                            $('#mymodals').modal('toggle');

                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Exists',
                            text: 'Duplicate Entry For This custom field',
                            confirmButtonColor: '#e00d0d',
                        });
                    }


                }
            });
        }

    }
    $("#addcustomfieldmodal").on('click', function () {

    });
</script>