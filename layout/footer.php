<script>
		function setsister(id, name)
			{
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "process/setsession.php",
                    method: 'POST',
                    data: {
                        idsister: id,
                        namasister : name
                        
                    },
                    success: function (result) {
                            $("#namecompany").text(name);
                            location.reload(); 
                                                 
                    }
                });
			};
        function logout(){
            Swal.fire({
                title: 'Do you want to logout?',
                showCancelButton: true,
                confirmButtonText: 'Logout',
                confirmButtonColor: "#32a852",
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                            $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "process/logout.php",
                            method: 'POST',
                            data: {
                                
                            },
                            success: function (results) {                           
                            
                                Swal.fire({
                                    title: 'Success',
                                    text: "You are logged out!",
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'ok'
                                    }).then((okresult) => {
                                    if (okresult.isConfirmed) {
                                        window.location.replace('index.php');
                                    }
                                 })
                            }
                        });
                   
                } 
            })
            // alert("test");
            // swal.fire({
            //     title: "Are you sure?",
            //     text: "your unsaved changed will lost !",
            //     type: "danger",
            //     showCancelButton: true,
            //     confirmButtonText: "Yes, logout!",
            //     confirmButtonColor: "#32a852",
            //     allowOutsideClick: false,
            //     closeOnConfirm: false
            //     },
            //     function(){
            //         unset($_SESSION['iduser']);
            //         unset($_SESSION['nik']);
            //         unset($_SESSION['username']);
                    
            //     swal("Logout", "please login again to continue", "success");
            //     window.location.replace('index.php');
            // });
          
        }
      
</script>