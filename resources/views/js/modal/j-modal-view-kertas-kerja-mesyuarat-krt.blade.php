<script>
    //my custom script
    var kertas_kerja_mesyuarat_config = {
        routes: {
            kertas_kerja_mesyuarat_url: "{{ route('rt-sm5.get_view_kertas_kerja_mesyuarat','') }}",
        }
    };

    function load_view_kertas_kerja_mesyuarat_krt(id) {
        $.get(kertas_kerja_mesyuarat_config.routes.kertas_kerja_mesyuarat_url + '/' + id, function (data) {
            $('#mvkkmk_kertas_kerja_perkara').val(data.kertas_kerja_perkara);
            $('#mvkkmk_kertas_kerja_tindakan').val(data.kertas_kerja_tindakan);
			$('#mvkkmk_kertas_kerja_tindakan_siapa').val(data.kertas_kerja_tindakan_siapa);
			$('#mvkkmk_kertas_kerja_dokumen').val(data.kertas_kerja_dokumen);
    	    $('#modal_view_kertas_kerja_mesyuarat_krt').modal('show');
        });
    }

</script>