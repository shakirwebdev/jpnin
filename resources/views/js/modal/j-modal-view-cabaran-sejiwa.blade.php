<script>

    //my custom script
    var cabaran_sejiwa_config = {
        routes: {
            cabaran_sejiwa_url: "{{ route('rt-sm10.get_view_cabaran_sejiwa','') }}"
        }
    };

    function load_view_cabaran_sejiwa(id) {

        $.get(cabaran_sejiwa_config.routes.cabaran_sejiwa_url + '/' + id, function (data) {
            
            $('#mvcs_cabaran_sejiwa_cabaran').val(data.cabaran_sejiwa_cabaran);
            $('#mvcs_cabaran_sejiwa_mengatasi').val(data.cabaran_sejiwa_mengatasi);
            
            $('#modal_view_cabaran_sejiwa').modal('show');
        });

    }

</script>