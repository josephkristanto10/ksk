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
      
</script>