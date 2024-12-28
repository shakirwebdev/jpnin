<script>
    $(document).ready( function () {
        
    });

    

    function load_add_binaan_jambatan() {
        $('#mabj_binaan_alamat').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

        $('#mabj_binaan_isu').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });
        
    	$('#modal_add_binaan_jambatan').modal('show');

	}

</script>