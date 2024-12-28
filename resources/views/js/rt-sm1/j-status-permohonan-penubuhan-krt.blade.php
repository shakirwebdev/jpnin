@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    //my custom script
    var krt_config = {
        routes: {
            krt_action_url: "/rt/sm1/status-permohonan-penubuhan-krt"
        }
    };

    $(document).ready( function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table_permohonan = $('#permohonan_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {url: krt_config.routes.krt_action_url},
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
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return 'RT'+full.state_id+full.daerah_id+full.id;
                }
            },{			
                "aTargets": [ 2 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.krt_name;
                }
            },{			
                "aTargets": [ 3 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    txtstatus = '';
                    if (full.status == '1') {
                        txtstatus = '<div align="left"><a href="#" data-toggle="tooltip" data-placement="top" title="'+full.rt_application_status+'"><font color="red"><i class="fe fe-edit-3"></i></font></a></div>';
                    } else if (full.status == '2') {
                        txtstatus = '<div align="left"><a href="#" data-toggle="tooltip" data-placement="top" title="'+full.rt_application_status+'"><font color="green"><i class="icon-check"></i></font> '+full.rt_application_status+'</a></div>';
                    } else {
                        txtstatus = 'Unknown';
                    }
                    return txtstatus;
                }
            },{			
                "aTargets": [ 4 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.created_at;
                }
            },{			
                "aTargets": [ 5 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    if (full.krt_status == '1') {
                        text = 'Lulus';
                        return text;
                    }  else if (full.krt_status == '2') {
                        text = 'Kemaskini Profil KRT';
                        return text;
                    }  else if (full.krt_status == '3') {
                        text = 'Memohon KRT';
                        return text;
                    }  else if (full.krt_status == '4') {
                        text = 'Disemak Oleh PPD';
                        return text;
                    }  else if (full.krt_status == '5') {
                        text = 'Perlu Kemaskini';
                        return text;
                    }  else if (full.krt_status == '6') {
                        text = 'Disahkan Oleh PPN';
                        return text;
                    }  else if (full.krt_status == '7') {
                        text = 'Perlu Kemaskini';
                        return text;
                    }  else if (full.krt_status == '8') {
                        text = 'Perlu Kemaskini';
                        return text;
                    }  else {
                        text = 'Dibatalkan';
                        return text;
                    }
                }
            },{
                "aTargets": [ 6 ], 
                "width": "8%", 
                "sClass": "text-center", 
                "mRender": function ( value, type, full )  {
                    if (full.krt_status == '2') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Permohonan Profail Penubuhan Krt" id="edit-jpnin" onclick="kemaskini_profile_krt(\'' + full.krt_id + '\');"><i class="fa fa-edit"></i></button>';
                        return button_a;
                    }  else if (full.krt_status == '5') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Permohonan Profail Penubuhan Krt" id="edit-jpnin" onclick="kemaskini_profile_krt(\'' + full.krt_id + '\');"><i class="fa fa-edit"></i></button>';
                        return button_a;
                    }  else if (full.krt_status == '7') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Permohonan Profail Penubuhan Krt" id="edit-jpnin" onclick="kemaskini_profile_krt(\'' + full.krt_id + '\');"><i class="fa fa-edit"></i></button>';
                        return button_a;
                    }  else if (full.krt_status == '8') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Permohonan Profail Penubuhan Krt" id="edit-jpnin" onclick="kemaskini_profile_krt(\'' + full.krt_id + '\');"><i class="fa fa-edit"></i></button>';
                        return button_a;
                    }  else {
                        button_b = '';
                        return button_b;
                    }
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        $('#myInputTextField_Permohonan').keyup(function(){
            table_bandar.search( $(this).val() ).draw();
        });
    });

    function kemaskini_profile_krt(krt_id){
        window.location.href = "{{ route('rt-sm1.kemaskini_profil_krt','') }}"+"/"+krt_id;
    }
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop