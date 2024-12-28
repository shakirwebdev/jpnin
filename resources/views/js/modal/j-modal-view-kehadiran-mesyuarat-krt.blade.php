<script>
    //my custom script
    var kehadiran_mesyuarat_config = {
        routes: {
            kehadiran_mesyuarat_url: "{{ route('rt-sm5.get_view_kehadiran_mesyuarat','') }}",
        }
    };

    function load_view_kehadiran_mesyuarat_krt(id) {
        $.get(kehadiran_mesyuarat_config.routes.kehadiran_mesyuarat_url + '/' + id, function (data) {
            $('#mvkmk_kehadiran_nama').val(data.kehadiran_nama);
            $('#mvkmk_kehadiran_ic').val(data.kehadiran_ic);
    	    $('#modal_view_kehadiran_mesyuarat_krt').modal('show');
        });

	}

</script>