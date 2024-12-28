@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    //my custom script
    var krt_config = {
        routes: {
            krt_action_url: "/rt/sm6/borang-laporan-aktiviti-perpaduan"
        }
    };

    $(document).ready( function () {
        
    	$('#sumber_kewangan_table').DataTable( {
            processing: true,
            // serverSide: true,
            "language": {
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Seterusnya",
                },
                "sSearch": "Carian",
                "sLengthMenu": "Paparan _MENU_ rekod",
                "lengthMenu": "Paparan _MENU_ rekod setiap laman",
                "zeroRecords": "Tiada rekod ditemui",
                "info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
                "infoEmpty": "",
                "infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
            },
            dom: 'rtip',
            "bFilter": true,
            responsive: true,
            data: dataSetSumberKewangan,
            columns: [
                {bSortable: false, sClass: 'text-center'},
                {bSortable: false},
                {data : null, bSortable: false, sClass: 'text-center',
                    mRender: function (value, type, full) {
                        button_a = '<label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1"><span class="custom-control-label">&nbsp;</span></label>';
                    return button_a;
                    }
                },
            ]
        });
        
    });

    var dataSetSumberKewangan = [ 
        ["1","Jabatan"],
        ["2","Pihak Luar"],
    ];

    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop