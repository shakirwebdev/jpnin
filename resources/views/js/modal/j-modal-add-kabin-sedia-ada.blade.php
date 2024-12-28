<script>
    $( document ).ready(function() {
    
        

        
      
    });

    function load_add_kabin() {

        $('#maksa_kabin_alamat').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

        $('#maksa_kabin_isu').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

        $("#maksa_kabin_jenis").change(function(){
			if( $(this).val() == 3) {
                $('#maksa_kabin_sumbangan_lain').prop( "disabled", false );
            } else {       
                $('#maksa_kabin_sumbangan_lain').prop( "disabled", true );
            }
		});

        $('#modal_add_kabin_sedia_ada').modal('show');

	}

</script>