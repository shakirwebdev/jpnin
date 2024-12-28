<script>
    $(document).ready( function () {
        
    });

    

    function load_add_bagunan_tumpang() {
        $('#mabt_tumpang_alamat').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

    	$('#modal_add_bagunan_tumpang').modal('show');

	}

</script>