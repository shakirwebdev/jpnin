<script>
    $(document).ready( function () {
        
    });

    

    function load_add_bagunan_sewa() {
        $('#mabs_sewa_alamat').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

        $('#mabs_sewa_isu').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

    	$('#modal_add_bagunan_sewa').modal('show');

	}

</script>