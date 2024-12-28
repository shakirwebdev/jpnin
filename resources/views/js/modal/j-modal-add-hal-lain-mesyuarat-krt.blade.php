<script>
    $( document ).ready(function() {
        
      
    });

    function load_add_hal_lain_mesyuarat_krt() {

        $('#mahlmk_hal_lain_tindakan').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

    	$('#modal_add_hal_lain_mesyuarat_krt').modal('show');

	}

</script>