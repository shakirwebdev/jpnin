
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

        //my custom script
            url_bil_mengikut_kaum	        = "{{ route('rt-sm10.get_senarai_terlibat_table','') }}"+"/"+"{{$isu_lokasi_kk->id}}";
           
        /* Maklumat Kawasan Krt */
            $('#silkk_nama_krt').html("{{$isu_lokasi_kk->nama_krt}}");
            $('#silkk_alamat_krt').html("{{$isu_lokasi_kk->alamat_krt}}");
            $('#silkk_negeri_krt').html("{{$isu_lokasi_kk->negeri_krt}}");
            $('#silkk_parlimen_krt').html("{{$isu_lokasi_kk->parlimen_krt}}");
            $('#silkk_pbt_krt').html("{{$isu_lokasi_kk->pbt_krt}}");
            $('#silkk_daerah_krt').html("{{$isu_lokasi_kk->daerah_krt}}");
            $('#silkk_dun_krt').html("{{$isu_lokasi_kk->dun_krt}}");
        
        /* Maklumat Semakan */
            $('#silkk1_isu_lokasi_kk_id').val("{{$isu_lokasi_kk->id}}");

        /* Maklumat Koperasi */
            $('#silkk_isu_lokasi_kanta_komuniti').val("{{$isu_lokasi_kk->isu_lokasi_kanta_komuniti}}");
            $('#silkk1_isu_bil_terlibat').val("{{$isu_lokasi_kk->isu_bil_terlibat}}");
            $('#silkk1_isu_kluster').val("{{$isu_lokasi_kk->isu_kluster}}");

            var senarai_terlibat_table = $('#senarai_terlibat_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_bil_mengikut_kaum,
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
					"width": "22%", 
					"mRender": function ( value, type, full )  {
						return full.bilangan;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "22%", 
					"mRender": function ( value, type, full )  {
						return full.kaum_description;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "22%", 
					"mRender": function ( value, type, full )  {
						return full.jantina_description;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "22%", 
					"mRender": function ( value, type, full )  {
						return full.umur;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

            $('#silkk3_isu_pelaksanan_daerah').val("{{$isu_lokasi_kk->isu_pelaksanan_daerah}}");
            $('#silkk3_isu_pelaksanan_negeri').val("{{$isu_lokasi_kk->isu_pelaksanan_negeri}}");
            $('#silkk3_isu_agensi_terlibat').val("{{$isu_lokasi_kk->isu_agensi_terlibat}}");
            $("input[name=silkk3_isu_status][value=" + "{{$isu_lokasi_kk->isu_status}}" + "]").prop('checked', true);
            
        /* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{ route('rt-sm10.analisa_isu_lokasi_kanta_komuniti') }}";
            });

	});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop