<script>
    //my custom script
    var binaan_config = {
        routes: {
            binaan_url: "{{ route('rt-sm2.get_view_binaan_jambatan','') }}",
        }
    };

    function load_view_binaan_jambatan(id) {

        $.get(binaan_config.routes.binaan_url + '/' + id, function (data) {
            $('#mvbj_binaan_jenis_premis_id').val(data.binaan_jenis_premis_id);
            $('#mvbj_binaan_alamat').val(data.binaan_alamat);
            $("input[name=mvbj_status_tanah_id][value=" + data.status_tanah_id + "]").prop('checked', true);
            $('#mvbj_binaan_kos').val(data.binaan_kos);
            $('#mvbj_binaan_keluasan_tanah').val(data.binaan_keluasan_tanah);
            $('#mvbj_binaan_keluasan_bagunan').val(data.binaan_keluasan_bagunan);
            $('#mvbj_binaan_tarikh_mula_bina').val(data.binaan_tarikh_mula_bina);
            var binaan_pengguna_rt = data.binaan_pengguna_rt;
            var binaan_pengguna_srs = data.binaan_pengguna_srs;
            var binaan_pengguna_tabika = data.binaan_pengguna_tabika;
            var binaan_pengguna_taska = data.binaan_pengguna_taska;
            if (binaan_pengguna_rt == "1") {
                $("input[name=mvbj_binaan_pengguna_rt]").prop('checked', true);
            }
            if (binaan_pengguna_srs == "1") {
                $("input[name=mvbj_binaan_pengguna_srs]").prop('checked', true);
            }
            if (binaan_pengguna_tabika == "1") {
                $("input[name=mvbj_binaan_pengguna_tabika]").prop('checked', true);
            }
            if (binaan_pengguna_taska == "1") {
                $("input[name=mvbj_binaan_pengguna_taska]").prop('checked', true);
            }
            $('#mvbj_binaan_isu').val(data.binaan_isu);
            $('#modal_view_binaan_jambatan').modal('show');
            
        });


	}

</script>