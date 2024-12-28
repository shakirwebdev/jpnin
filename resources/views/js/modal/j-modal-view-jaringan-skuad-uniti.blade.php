<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>
    //my custom script
    var senarai_jaringan_config = {
        routes: {
            senarai_jaringan_url: "{{ route('rt-sm10.get_view_jaringan_skuad_uniti','') }}"
        }
    };

    function load_view_jaringan_skuad_uniti(id) {

        $.get(senarai_jaringan_config.routes.senarai_jaringan_url + '/' + id, function (data) {
            
            $('#mvjsu_jaringan_agensi_nama').val(data.jaringan_agensi_nama);
            $('#mvjsu_jaringan_nama_pegawai').val(data.jaringan_nama_pegawai);
            $('#mvjsu_jaringan_no_telefon').val(data.jaringan_no_telefon);
            $('#mvjsu_jaringan_kerjasama').val(data.jaringan_kerjasama);
            
            $('#modal_view_jaringan_skuad_uniti').modal('show');
        });
    	
    }

</script>