<script>
    //my custom script
    var kabin_config = {
        routes: {
            kabin_url: "{{ route('rt-sm2.get_view_kabin_table','') }}",
        }
    };

    function load_view_kabin(id) {

        $.get(kabin_config.routes.kabin_url + '/' + id, function (data) {
            $('#mvksa_kabin_jenis').val(data.kabin_jenis);
            $('#mvksa_kabin_alamat').val(data.kabin_alamat);
            $("input[name=mvksa_kabin_status_tanah_id][value=" + data.kabin_status_tanah_id + "]").prop('checked', true);
            var date_kabin_tarikh_bina = data.kabin_tarikh_bina.split('-');
            var newDate = date_kabin_tarikh_bina[1] + '/' + date_kabin_tarikh_bina[2] + '/' + date_kabin_tarikh_bina[0].slice(-4);
            $('#mvksa_kabin_tarikh_bina').val(newDate);
            $('#mvksa_kabin_kos').val(data.kabin_kos);
            var kabin_pengguna_rt = data.kabin_pengguna_rt;
            var kabin_pengguna_srs = data.kabin_pengguna_srs;
            var kabin_pengguna_tabika = data.kabin_pengguna_tabika;
            var kabin_pengguna_taska = data.kabin_pengguna_taska;
            if (kabin_pengguna_rt == "1") {
                $("input[name=mvksa_kabin_pengguna_rt]").prop('checked', true);
            }
            if (kabin_pengguna_rt == "1") {
                $("input[name=mvksa_kabin_pengguna_srs]").prop('checked', true);
            }
            if (kabin_pengguna_tabika == "1") {
                $("input[name=mvksa_kabin_pengguna_tabika]").prop('checked', true);
            }
            if (kabin_pengguna_taska == "1") {
                $("input[name=mvksa_kabin_pengguna_taska]").prop('checked', true);
            }
            $('#mvksa_kabin_isu').val(data.kabin_isu);
            $('#modal_view_kabin_sedia_ada').modal('show');
            
        });
    }

</script>
<!-- $('#test').prop('checked'); -->