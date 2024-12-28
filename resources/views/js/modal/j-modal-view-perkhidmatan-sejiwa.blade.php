<script>
    //my custom script
    var perkhidmatan_sejiwa_config = {
        routes: {
            perkhidmatan_sejiwa_url: "{{ route('rt-sm10.get_view_perkhidmatan_sejiwa','') }}"
        }
    };

    function load_view_perkhidmatan_sejiwa(id) {

        $.get(perkhidmatan_sejiwa_config.routes.perkhidmatan_sejiwa_url + '/' + id, function (data) {
            
            $('#mvps_perkhidmatan_sejiwa_keperluan').val(data.perkhidmatan_sejiwa_keperluan);
            $('#mvps_perkhidmatan_sejiwa_perkhidmatan').val(data.perkhidmatan_sejiwa_perkhidmatan);
            $('#mvps_perkhidmatan_sejiwa_kerjasama').val(data.perkhidmatan_sejiwa_kerjasama);
            
            $('#modal_view_perkhidmatan_sejiwa').modal('show');
        });

    	

    }

</script>