<script>
    //my custom script
    var cadangan_pembinaan_prt1_config = {
        routes: {
            cadangan_pembinaan_prt1_url: "{{ route('rt-sm2.get_view_cadangan_pembinaan_table','') }}",
        }
    };

    function load_view_cadangan_pembinaan_prt(id) {

        $.get(cadangan_pembinaan_prt1_config.routes.cadangan_pembinaan_prt1_url + '/' + id, function (data) {
            $("input[name=mvcpp_prt_jenis_premis][value=" + data.prt_jenis_premis + "]").prop('checked', true);
            $('#mvcpp_prt_status_tanah_terkini').val(data.prt_status_tanah_terkini);
            $('#mvcpp_prt_keluasan').val(data.prt_keluasan);
            $('#mvcpp_prt_status_kelulusan_tanah_kabin').val(data.prt_status_kelulusan_tanah_kabin);
            $('#mvcpp_prt_cadangan_tahun').val(data.prt_cadangan_tahun);
            $('#modal_view_cadangan_pembinaan_prt').modal('show');
        });
    }

</script>