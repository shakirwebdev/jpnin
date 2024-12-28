<script>
    //my custom script
    var ops_rondaan_config = {
        routes: {
            ops_rondaan_url: "{{ route('rt-sm14.get_view_pemakluman_ops_rondaan_srs','') }}",
        }
    };

    function load_view_pemakluman_operasi_rondaan(id) {

        $.get(ops_rondaan_config.routes.ops_rondaan_url + '/' + id, function (data) {
            $('#mvpor_srs_profile_id').val(data.srs_profile_id);
            $('#mvpor_ops_tarikh_mula_ronda').val(data.ops_tarikh_mula_ronda);
            $('#mvpor_ops_tarikh_surat').val(data.ops_tarikh_surat);
            
            $('#modal_view_pemakluman_operasi_rondaan').modal('show');
            
        });

    }

</script>