<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>
    //my custom script
    var senarai_penarikan_diri_config = {
        routes: {
            senarai_penarikan_diri_url: "{{ route('rt-sm18.get_view_permohonan_penarikan_diri','') }}"
        }
    };

    function load_view_penarikan_diri_srs(id) {
        

        $.get(senarai_penarikan_diri_config.routes.senarai_penarikan_diri_url + '/' + id, function (data) {
            
            $('#mvpds_srs_profile_id').val(data.srs_profile_id);
            $('#mvpds_ahli_peronda_id').val(data.ahli_peronda_id);
            $('#mvpds_peronda_ic').val(data.peronda_ic);
            $('#mvpds_peronda_alamat').val(data.peronda_alamat);
            var alasan = (data.alasan_id);
			$("input[name=mvpds_alasan_id][value=" + alasan + "]").prop('checked', true);
            $('#mvpds_penarikan_diri_nyatakan').val(data.penarikan_diri_nyatakan);
            
            $('#modal_view_penarikan_diri_srs').modal('show');
        });
       
    }

	

</script>