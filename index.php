<?php
session_start();
require 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
    <title>NEXUS Asset - Integrated System</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
        type="text/css">

    <link href="<?=$url;?>global_assets/css/icons/material/styles.min.css" rel="stylesheet" type="text/css">
    <link href="<?=$url;?>global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
    <link href="<?=$url;?>assets/css/layoutduplicate.min.css" rel="stylesheet" type="text/css">
    <link href="<?=$url;?>assets/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="<?=$url;?>assets/css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- <link href="<?=$url;?>template/assets/css/all.min.css" rel="stylesheet"> -->

    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="<?=$url;?>global_assets/js/main/jquery.min.js"></script>
    <script src="<?=$url;?>global_assets/js/main/bootstrap.bundle.min.js"></script>
    <script src="<?=$url;?>global_assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->



    <script src="<?=$url;?>assets/js/app.js"></script>
    <link href="<?=$url;?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?=$url;?>assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" type="image/png" href="<?=$url;?>assets/icon.png" />
</head>

<body
    style="background:url('<?=$url;?>assets/bgloginbluecompressed.jpg'); background-position:center; background-repeat:no-repeat; background-size:cover;">
    <div class="page-content">
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content d-flex justify-content-center align-items-center">
                    <form class="login-form" action="" method="POST">

                        <div class="card mb-0" style="border-radius:7px !important;   box-shadow: 1px 2px 3px #888888;">
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <img src="<?=$url;?>assets/icon.png" width="200" class="img-fluid mb-1 mt-1">
                                    <h5 class="mb-0">Nexus Asset Management</h5>
                                    <!-- <h5 class="mb-0">Login to your account</h5> -->
                                    <span class="d-block text-muted">Enter your username and password here</span>
                                </div>

                                <!-- <div class="alert bg-danger text-white alert-styled-left alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                        <span class="font-weight-semibold">{{ session('success') }}</span>
                                    </div>
                               
                                    <div class="alert bg-danger text-white alert-styled-left alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                                        <span class="font-weight-semibold">{{ session('failed') }}</span>
                                    </div> -->

                                <div class="form-group form-group-feedback form-group-feedback-left">
                                    <input type="text" class="form-control" name="username" id="username"
                                        placeholder="Username" required>
                                    <div class="form-control-feedback">
                                        <i class="icon-user text-muted"></i>
                                    </div>
                                </div>
                                <div class="form-group form-group-feedback form-group-feedback-left">
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Password" required>
                                    <div class="form-control-feedback">
                                        <i class="icon-lock2 text-muted"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-block" onclick = "login()">Sign in</button>
                                </div>
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
    function login() {
        var username = $("#username").val();
        var pass = $("#password").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "process/login.php",
            method: 'POST',
            data: {

                tipe: "checklogin",
                myusername: username,
                mypassword: pass

            },
            success: function (result) {
                // alert(result);
                if (result == "ok") {
                    Swal.fire({
                        title: 'User Matched',
                        text: 'Welcome',
                        icon: 'success',
                        confirmButtonColor: '#53d408',
                        allowOutsideClick: false,
                    }).then((result) => {
                        window.location.replace("dashboard.php");
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'User not found',
                        text: 'User doesnt exists',
                        confirmButtonColor: '#e00d0d',
                    });
                }


            }
        });
    }
</script>