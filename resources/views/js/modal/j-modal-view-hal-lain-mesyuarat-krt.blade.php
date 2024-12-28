<script>
    //my custom script
    var hal_lain_mesyuarat_config = {
        routes: {
            hal_lain_mesyuarat_url: "{{ route('rt-sm5.get_view_hal_lain_mesyuarat','') }}",
        }
    };

    function load_view_hal_lain_mesyuarat_krt(id) {
        $.get(hal_lain_mesyuarat_config.routes.hal_lain_mesyuarat_url + '/' + id, function (data) {
            $('#mvhlmk_hal_lain_perkara').val(data.hal_lain_perkara);
            $('#mvhlmk_hal_lain_tindakan').val(data.hal_lain_tindakan);
			$('#mvhlmk_hal_lain_tindakan_siapa').val(data.hal_lain_tindakan_siapa);
    	    $('#modal_view_hal_lain_mesyuarat_krt').modal('show');
        });
    }

</script>