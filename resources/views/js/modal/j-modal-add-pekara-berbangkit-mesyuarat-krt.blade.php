<script>
    $( document ).ready(function() {
        
      
    });

    function load_add_pekara_berbangkit_mesyuarat_krt() {

        $('#mapbmk_berbangkit_tindakan').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

    	$('#modal_add_pekara_berbangkit_mesyuarat_krt').modal('show');

	}

</script>