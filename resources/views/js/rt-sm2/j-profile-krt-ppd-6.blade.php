@include('js.modal.j-modal-view-jawatankuasa-penaja-rt')
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {

        //my custom script
            url_jawatankuasa_penaja_table 		= "{{ route('rt-sm1.get_jawatankuasa_penaja_table','') }}"+"/"+{{$profile_krt->id}};

        /* Maklumat Am Krt */
            $('#kpk_krt_nama').html("{{$profile_krt->krt_nama}}");
            $('#kpk_krt_alamat').html("{{$profile_krt->krt_alamat}}");
            $('#kpk_tarikh_memohon').html("{{$profile_krt->created_at}}");

		/* Maklumat Asas Kawasan */
            var jawatankuasa_penaja_table = $('#jawatankuasa_penaja_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_jawatankuasa_penaja_table,
                "language": {
                    "paginate": {
                        "previous": "Sebelumnya",
                        "next": "Seterusnya",
                        searchPanes: {
                            emptyPanes: 'There are no panes to display. :/'
                        }
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
                "bSort": false,
                responsive: true,
                "aoColumnDefs":[{          
                    "aTargets": [ 0 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function (data, type, full, meta)  {
                        return  meta.row+1;
                    }
                },{          
                    "aTargets": [ 1 ], 
                    "width": "40%", 
                    "mRender": function ( value, type, full )  {
                        return full.penaja_nama;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "48%", 
                    "mRender": function ( value, type, full )  {
                        return full.penaja_ic;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_jawatankuasa_penaja_rt(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        return button_a;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

		/* Buuton */
            $('#btn_back').click(function(){
                window.location.href = "{{route('rt-sm2.profile_krt_ppd_5','')}}"+"/"+"{{$profile_krt->id}}";
            });

	});
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop