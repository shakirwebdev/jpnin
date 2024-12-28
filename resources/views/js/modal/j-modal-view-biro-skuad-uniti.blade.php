<script>

    //my custom script
    var senarai_biro_uniti_config = {
        routes: {
            senarai_biro_uniti_url: "{{ route('rt-sm10.get_view_biro_skuad_uniti','') }}"
        }
    };

    function load_view_biro_skuad_uniti(id) {

        $.get(senarai_biro_uniti_config.routes.senarai_biro_uniti_url + '/' + id, function (data) {
            
            $('#mvbsu_biro_nama').val(data.biro_nama);
            $('#mvbsu_biro_nama_penuh').val(data.biro_nama_penuh);
            $('#mvbsu_biro_ic').val(data.biro_ic);
            $('#mvbsu_biro_phone').val(data.biro_phone);
            $('#mvbsu_biro_emel').val(data.biro_emel);
            $('#mvbsu_biro_pekerjaan').val(data.biro_pekerjaan);
            
            $('#modal_view_biro_skuad_uniti').modal('show');
        });

    }

</script>