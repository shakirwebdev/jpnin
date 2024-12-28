<script>
    $(document).ready( function () {
        
    });

    function load_add_perkhidmatan_sejiwa() {
        $('#psk5_perkhidmatan_sejiwa_keperluan').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });
        
    	$('#modal_add_perkhidmatan_sejiwa').modal('show');

    }

</script>