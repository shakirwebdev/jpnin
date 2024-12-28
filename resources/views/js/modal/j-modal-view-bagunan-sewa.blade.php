<script>
    //my custom script
    var bagunan_sewa_config = {
        routes: {
            bagunan_sewa_url: "{{ route('rt-sm2.get_view_bagunan_sewa','') }}",
        }
    };

    function load_view_bagunan_sewa(id) {

        $.get(bagunan_sewa_config.routes.bagunan_sewa_url + '/' + id, function (data) {
            $('#mvbs_jenis_premis_id').val(data.jenis_premis_id);
            $('#mvbs_sewa_alamat').val(data.sewa_alamat);
            var sewa_pengguna_rt = data.sewa_pengguna_rt;
            var sewa_pengguna_srs = data.sewa_pengguna_srs;
            var sewa_pengguna_tabika = data.sewa_pengguna_tabika;
            var sewa_pengguna_taska = data.sewa_pengguna_taska;
            if (sewa_pengguna_rt == "1") {
                $("input[name=mvbs_sewa_pengguna_rt]").prop('checked', true);
            }
            if (sewa_pengguna_srs == "1") {
                $("input[name=mvbs_sewa_pengguna_srs]").prop('checked', true);
            }
            if (sewa_pengguna_tabika == "1") {
                $("input[name=mvbs_sewa_pengguna_tabika]").prop('checked', true);
            }
            if (sewa_pengguna_taska == "1") {
                $("input[name=mvbs_sewa_pengguna_taska]").prop('checked', true);
            }
            $('#mvbs_sewa_isu').val(data.sewa_isu);
            $('#mvbs_sewa_bayaran').val(data.sewa_bayaran);

            $('#modal_view_bagunan_sewa').modal('show');
            
        });

    }

</script>