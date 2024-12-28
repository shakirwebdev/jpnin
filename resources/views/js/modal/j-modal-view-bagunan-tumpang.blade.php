<script>
    //my custom script
    var bagunan_tumpang_config = {
        routes: {
            bagunan_tumpang_url: "{{ route('rt-sm2.get_view_bagunan_tumpang','') }}",
        }
    };

    function load_view_bagunan_tumpang(id) {

        $.get(bagunan_tumpang_config.routes.bagunan_tumpang_url + '/' + id, function (data) {
            $('#mvbt_tumpang_jenis_premis_id').val(data.tumpang_jenis_premis_id);
            $('#mvbt_tumpang_alamat').val(data.tumpang_alamat);
            var tumpang_pengguna_rt = data.tumpang_pengguna_rt;
            var tumpang_pengguna_srs = data.tumpang_pengguna_srs;
            var tumpang_pengguna_tabika = data.tumpang_pengguna_tabika;
            var tumpang_pengguna_taska = data.tumpang_pengguna_taska;
            if (tumpang_pengguna_rt == "1") {
                $("input[name=mvbt_tumpang_pengguna_rt]").prop('checked', true);
            }
            if (tumpang_pengguna_srs == "1") {
                $("input[name=mvbt_tumpang_pengguna_srs]").prop('checked', true);
            }
            if (tumpang_pengguna_tabika == "1") {
                $("input[name=mvbt_tumpang_pengguna_tabika]").prop('checked', true);
            }
            if (tumpang_pengguna_taska == "1") {
                $("input[name=mvbt_tumpang_pengguna_taska]").prop('checked', true);
            }
            $("input[name=mvbt_tumpang_status_tanah_id][value=" + data.tumpang_status_tanah_id + "]").prop('checked', true);

            $('#modal_view_bagunan_tumpang').modal('show');
            
        });

    }

</script>