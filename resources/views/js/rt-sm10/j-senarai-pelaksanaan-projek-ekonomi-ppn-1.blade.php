
@section('page-script')
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
            $('#ppespn_nama_krt').html("{{$projek_ekonomi_st->nama_krt}}");
            $('#ppespn_alamat_krt').html("{{$projek_ekonomi_st->alamat_krt}}");
            $('#ppespn_negeri_krt').html("{{$projek_ekonomi_st->negeri_krt}}");
            $('#ppespn_parlimen_krt').html("{{$projek_ekonomi_st->parlimen_krt}}");
            $('#ppespn_pbt_krt').html("{{$projek_ekonomi_st->pbt_krt}}");
            $('#ppespn_daerah_krt').html("{{$projek_ekonomi_st->daerah_krt}}");
            $('#ppespn_dun_krt').html("{{$projek_ekonomi_st->dun_krt}}");

        /* Maklumat Projek */
            $('#ppespn_projek_st_nama').val("{{$projek_ekonomi_st->projek_st_nama}}");
            $('#ppespn_projek_st_kategori').val("{{$projek_ekonomi_st->projek_st_kategori}}");
            $('#ppespn_projek_st_cabaran').val("{{$projek_ekonomi_st->projek_st_cabaran}}");
            $('#ppespn_projek_st_peruntukan_jabatan').val("{{$projek_ekonomi_st->projek_st_peruntukan_jabatan}}");
            $('#ppespn_projek_st_tahun').val("{{$projek_ekonomi_st->projek_st_tahun}}");
            $('#ppespn_projek_st_pendapatan').val("{{$projek_ekonomi_st->projek_st_pendapatan}}");
            $('#ppespn_projek_st_pembelanjaan').val("{{$projek_ekonomi_st->projek_st_pembelanjaan}}");

        /* Maklumat Peserta Projek */
            url_table_peserta      = "{{ route('rt-sm10.get_peserta_table','') }}"+"/"+"{{$projek_ekonomi_st->id}}";
            
            var senarai_peserta_table = $('#senarai_peserta_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_table_peserta,
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
                    "width": "88%", 
                    "mRender": function ( value, type, full )  {
                        return full.nama_peserta;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

            $('#ppespn_pelaksanaan_projek_ekonomi_id').val("{{$projek_ekonomi_st->id}}");

        /* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{ route('rt-sm10.senarai_pelaksanaan_projek_ekonomi_ppn') }}";
            });

	});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop