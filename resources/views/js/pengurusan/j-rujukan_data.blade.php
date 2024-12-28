@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    //my custom script
    var rujukan_data_config = {
        routes: {
            daerah_datatable_url: "{{ route('daerah.index') }}",
            daerah_action_url: "/pengurusan/rujukan-data/daerah/",
            daerah_store_url: "{{ route('daerah.store') }}",
            parlimen_datatable_url: "{{ route('parlimen.index') }}",
            parlimen_action_url: "/pengurusan/rujukan-data/parlimen/",
            parlimen_store_url: "{{ route('parlimen.store') }}",
            dun_datatable_url: "{{ route('dun.index') }}",
            dun_action_url: "/pengurusan/rujukan-data/dun/",
            dun_store_url: "{{ route('dun.store') }}",
            pbt_datatable_url: "{{ route('pbt.index') }}",
            pbt_action_url: "/pengurusan/rujukan-data/pbt/",
            pbt_store_url: "{{ route('pbt.store') }}",
            bandar_datatable_url: "{{ route('bandar.index') }}",
            bandar_action_url: "/pengurusan/rujukan-data/bandar/",
            bandar_store_url: "{{ route('bandar.store') }}"
        }
    };

    $(document).ready( function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    <?php
        $js_array = json_encode($daerah); 
        echo "var daerah_array = ". $js_array . ";\n";
    ?>
</script>
<script src="{{ asset('js/ref_daerah.js') }}"></script>
<script src="{{ asset('js/ref_parlimen.js') }}"></script>
<script src="{{ asset('js/ref_dun.js') }}"></script>
<script src="{{ asset('js/ref_pbt.js') }}"></script>
<script src="{{ asset('js/ref_bandar.js') }}"></script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop