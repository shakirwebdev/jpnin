
@section('page-script')
@include('js.modal.j-modal-view-ahli-sejiwa')
@include('js.modal.j-modal-view-perkhidmatan-sejiwa')
@include('js.modal.j-modal-view-cabaran-sejiwa')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
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
    .blink {
        animation: blinker 1.0s linear infinite;
        color: #1c87c9;
        font-weight: bold;
        font-family: sans-serif;
    }
    @keyframes blinker {
        50% {
          opacity: 0;
        }
      }
</style>
<script type="text/javascript">    
    
	$(document).ready( function () {

        /* Maklumat Kawasan Krt */
            $('#ask2_nama_krt').html("{{$sejiwa->nama_krt}}");
            $('#ask2_alamat_krt').html("{{$sejiwa->alamat_krt}}");
            $('#ask2_negeri_krt').html("{{$sejiwa->negeri_krt}}");
            $('#ask2_parlimen_krt').html("{{$sejiwa->parlimen_krt}}");
            $('#ask2_pbt_krt').html("{{$sejiwa->pbt_krt}}");
            $('#ask2_daerah_krt').html("{{$sejiwa->daerah_krt}}");
            $('#ask2_dun_krt').html("{{$sejiwa->dun_krt}}");

        /* Maklumat Am Sejiwa */
            $('#ask2_sejiwa_nama').val("{{$sejiwa->sejiwa_nama}}");
            $('#ask2_sejiwa_tarikh_ditubuhkan').val("{{$sejiwa->sejiwa_tarikh_ditubuhkan}}");
            $('#ask2_sejiwa_pusat_operasi').val("{{$sejiwa->sejiwa_pusat_operasi}}");
           
        /* Maklumat Ahli Sejiwa */
            url_ahli_sejiwa_table 			= "{{ route('rt-sm10.get_senarai_ahli_sejiwa_table','') }}"+"/"+"{{$sejiwa->id}}";
            
            var senarai_ahli_sejiwa_table = $('#senarai_ahli_sejiwa_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_ahli_sejiwa_table,
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
                "aoColumnDefs":[{          
                    "aTargets": [ 0 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function (data, type, full, meta)  {
                        return  meta.row+1;
                    }
                },{          
                    "aTargets": [ 1 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.ahli_sejiwa_nama;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.ahli_sejiwa_ic;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.ahli_sejiwa_pekerjaan;
                    }
                },{          
                    "aTargets": [ 4 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_ahli_sejiwa(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        return button_a;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

         /* Maklumat Bidang /  Jenis Fokus Perkhidmatan SeJiwa */
            url_perkhidmatan_sejiwa_table 			= "{{ route('rt-sm10.get_senarai_perkhidmatan_sejiwa_table','') }}"+"/"+"{{$sejiwa->id}}";
            
            var senarai_perkhidmatan_sejiwa_table = $('#senarai_perkhidmatan_sejiwa_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_perkhidmatan_sejiwa_table,
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
                "aoColumnDefs":[{          
                    "aTargets": [ 0 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function (data, type, full, meta)  {
                        return  meta.row+1;
                    }
                },{          
                    "aTargets": [ 1 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.perkhidmatan_sejiwa_keperluan;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.perkhidmatan_sejiwa_perkhidmatan;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_perkhidmatan_sejiwa(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        return button_a;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

        /* Pegawai Rujukan / Penyelia Sejiwa */
            $('#psk6_sejiwa_pegawai_nama').val("{{$sejiwa->sejiwa_pegawai_nama}}");
            $('#psk6_sejiwa_pegawai_phone').val("{{$sejiwa->sejiwa_pegawai_phone}}");
            $('#psk6_sejiwa_pegawai_jawatan').val("{{$sejiwa->sejiwa_pegawai_jawatan}}");
            $('#psk6_sejiwa_pegawai_emel').val("{{$sejiwa->sejiwa_pegawai_emel}}");

        /* Maklumat Cabaran Dan Cara Menangani */
             url_cabaran_sejiwa_table 			= "{{ route('rt-sm10.get_senarai_cabaran_sejiwa_table','') }}"+"/"+"{{$sejiwa->id}}";
             
             var senarai_cabaran_sejiwa_table = $('#senarai_cabaran_sejiwa_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_cabaran_sejiwa_table,
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
                "aoColumnDefs":[{          
                    "aTargets": [ 0 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function (data, type, full, meta)  {
                        return  meta.row+1;
                    }
                },{          
                    "aTargets": [ 1 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.cabaran_sejiwa_cabaran;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.cabaran_sejiwa_mengatasi;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_cabaran_sejiwa(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        return button_a;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

            $('#ask2_sejiwa_id').val("{{$sejiwa->id}}");
        
        /* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{ route('rt-sm10.senarai_sejiwa_krt_1','') }}"+"/"+"{{$sejiwa->id}}";
            });

	});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop