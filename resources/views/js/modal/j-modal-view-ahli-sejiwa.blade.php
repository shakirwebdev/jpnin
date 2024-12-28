<script>
    //my custom script
    var ahli_sejiwa_config = {
        routes: {
            ahli_sejiwa_url: "{{ route('rt-sm10.get_view_ahli_sejiwa','') }}"
        }
    };

    function load_view_ahli_sejiwa(id) {

    	$.get(ahli_sejiwa_config.routes.ahli_sejiwa_url + '/' + id, function (data) {
            
            $('#mvas_ahli_sejiwa_nama').val(data.ahli_sejiwa_nama);
            $('#mvas_ahli_sejiwa_ic').val(data.ahli_sejiwa_ic);
            $('#mvas_ahli_sejiwa_pekerjaan').val(data.ahli_sejiwa_pekerjaan);
            $('#mvas_kaum_id').val(data.kaum_id);
            $('#mvas_ahli_sejiwa_jawatan').val(data.ahli_sejiwa_jawatan);
            
            $('#modal_view_ahli_sejiwa').modal('show');
        });

    }

</script>