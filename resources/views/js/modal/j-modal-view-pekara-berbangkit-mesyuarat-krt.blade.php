<script>
    //my custom script
    var pekara_berbangkit_mesyuarat_config = {
        routes: {
            pekara_berbangkit_mesyuarat_url: "{{ route('rt-sm5.get_view_pekara_berbangkit_mesyuarat','') }}",
        }
    };

    function load_view_pekara_berbangkit_mesyuarat_krt(id) {
        $.get(pekara_berbangkit_mesyuarat_config.routes.pekara_berbangkit_mesyuarat_url + '/' + id, function (data) {
            $('#mvpbmk_berbangkit_perkara').val(data.berbangkit_perkara);
            $('#mvpbmk_berbangkit_tindakan').val(data.berbangkit_tindakan);
			$('#mvpbmk_berbangkit_tindakan_siapa').val(data.berbangkit_tindakan_siapa);
    	    $('#modal_view_pekara_berbangkit_mesyuarat_krt').modal('show');
        });

	}

</script>