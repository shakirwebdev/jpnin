@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<style type="text/css">
    .series-frame {
      /*max-width: 600px;*/
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-sizing: border-box;
      border: 2px solid #113f50;
      /*margin: 30px;*/
      padding: 10px;
    }

</style>
<script type="text/javascript">    
    
    $(document).ready( function () {

        /* Maklumat Kawasan Krt */
            $('#plap2_nama_krt').html("{{$laporan_aktiviti->nama_krt}}");
            $('#plap2_alamat_krt').html("{{$laporan_aktiviti->alamat_krt}}");
            $('#plap2_negeri_krt').html("{{$laporan_aktiviti->negeri_krt}}");
            $('#plap2_parlimen_krt').html("{{$laporan_aktiviti->parlimen_krt}}");
            $('#plap2_pbt_krt').html("{{$laporan_aktiviti->pbt_krt}}");
            $('#plap2_daerah_krt').html("{{$laporan_aktiviti->daerah_krt}}");
            $('#plap2_dun_krt').html("{{$laporan_aktiviti->dun_krt}}");

        /* Maklumat Tempat Aktiviti Perpaduan */
            $('#plap2_state_id').val("{{$laporan_aktiviti->state_id}}");
            $('#plap2_daerah_id').val("{{$laporan_aktiviti->daerah_id}}");
            $('#plap2_aktiviti_tempat').val("{{$laporan_aktiviti->aktiviti_tempat}}");
            var aktiviti_kawasan_DL = "{{$laporan_aktiviti->aktiviti_kawasan_DL}}";
		    $("input[name=plap2_aktiviti_kawasan_DL][value=" + aktiviti_kawasan_DL + "]").prop('checked', true);

        /* Maklumat Penyertaan */
            
            //my custom script
            url_senarai_penyertaan_table      = "{{ route('rt-sm6.get_laporan_penyertaan_table','') }}"+"/"+"{{$laporan_aktiviti->id}}";
            
            var senarai_penyertaan_table      = $('#senarai_penyertaan_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_senarai_penyertaan_table,
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
                    "width": "13%", 
                    "mRender": function ( value, type, full )  {
                        return full.kaum;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "13%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.lelaki;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "29%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.perempuan;
                    }
                },{          
                    "aTargets": [ 4 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_1;
                    }
                },{          
                    "aTargets": [ 5 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_2;
                    }
                },{          
                    "aTargets": [ 6 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_3;
                    }
                },{          
                    "aTargets": [ 7 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_4;
                    }
                },{          
                    "aTargets": [ 8 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_5;
                    }
                },{          
                    "aTargets": [ 9 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_6;
                    }
                },{          
                    "aTargets": [ 10 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_7;
                    }
                },{          
                    "aTargets": [ 11 ], 
                    "width": "13%", 
                    "mRender": function ( value, type, full )  {
                        return full.jumlah;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

        /* Maklumat Rakan Perpaduan */
            
            //my custom script
            url_rakan_perpaduan_table         = "{{ route('rt-sm6.get_laporan_rakan_perpaduan_table','') }}"+"/"+"{{$laporan_aktiviti->id}}";
           
            var senarai_rakan_perpaduan_table = $('#senarai_rakan_perpaduan_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_rakan_perpaduan_table,
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
                    "width": "28%", 
                    "mRender": function ( value, type, full )  {
                        return full.rakan_perpaduan;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "28%", 
                    "mRender": function ( value, type, full )  {
                        return full.bentuk_sumbangan;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "28%",
                    sClass: 'text-center', 
                    "mRender": function ( value, type, full )  {
                        return full.jumlah;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });
        
    	/* Button */
            $('#btn_back').click(function(){
                window.location.href = '{{route('rt-sm6.jana_laporan_aktiviti_krt_1','')}}'+'/'+"{{$laporan_aktiviti->id}}";
            });

            $('#btn_next').click(function(){
                window.location.href = '{{route('rt-sm6.jana_laporan_aktiviti_krt_3','')}}'+'/'+"{{$laporan_aktiviti->id}}";
            });
    });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop