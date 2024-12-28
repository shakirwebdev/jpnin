<script>
    
    function load_add_jawatankuasa_penaja_rt() {

        $('#jpf_penaja_alamat_rumah').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

        $('#jpf_penaja_alamat_pejabat').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

        $('#jpf_penaja_ic').mask('999999999999');

    	$('#modal_add_jawatankuasa_penaja_rt').modal('show');

	}

</script>