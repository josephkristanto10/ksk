<?php
require 'connection.php';
?>
<html>

<head>
    <title></title>
    <link href="externalcss/loginform.css" rel="stylesheet" type="text/css">
    <script src="sweetalert2.all.min.js"></script>
    <script src="<?=$url;?>js/jquery-3.6.0.js"></script>
</head>

<body>
    <section>
        <!-- <span ></span> -->
        <img src="<?=$url?>assets/logonexus.png" style="width:60px;height:60px;margin-top:25px;">
        <h1 style="color:white">Admin Login</h1>
        <form id="myform" action="">
            <input type="text" placeholder="Username">
            <input type="password" placeholder="Password" />
        </form>
        <button id = "mybuttonlogin" style="font-weight:bold;" onclick="login()">LOGIN</button>
    </section>
</body>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    function login() {
        jQuery.ajax({
            url: "process/login.php",
            method: 'post',
            data: {
                // _token: "{{ csrf_token() }}",
                // username: user,
                // password: pass,
            },
            success: function (result) {
                Swal.fire({
                    title: 'User Matched',
                    text: 'Welcome to admin page',
                    icon: 'success',
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Go to admin dashboard'
                }).then((result) => {
                    window.location.href = "index.php";
                });
                // alert(result);
                // if (result == "none") {
                //     Swal.fire({
                //         type: 'error',
                //         title: 'User Not Found',
                //         text: 'User not found on our database, please use other account',
                //     })

                // } else {
                //     if (result == "admin") {

                //         Swal.fire({
                //             title: 'User Found',
                //             text: 'you can proceed to admin page',
                //             type: 'success',
                //             allowOutsideClick: false,
                //             confirmButtonColor: '#3085d6',
                //             confirmButtonText: 'Go to admin page'
                //         }).then((result) => {
                //             window.location.href = "{{route('todashboardadmin')}}";
                //         });
                //     } else if (result == "user") {
                //       Swal.fire({
                //             title: 'User Found',
                //             text: 'you can proceed to user page',
                //             type: 'success',
                //             allowOutsideClick: false,
                //             confirmButtonColor: '#3085d6',
                //             confirmButtonText: 'Go to user page'
                //         }).then((result) => {

                //             window.location.href = "{{route('dashboarduser')}}";
                //         });
                //     }

                // }


            }
        });
    }
</script>

</html>