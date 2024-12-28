<script>
    $( document ).ready(function() {
        
      
    });

    function load_add_kertas_kerja_mesyuarat_krt() {

        $('#makkmk_kertas_kerja_tindakan').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

    	$('#modal_add_kertas_kerja_mesyuarat_krt').modal('show');

	}

</script>