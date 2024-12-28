
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
            senarai_risiko_url			    = "{{ route('rt-sm10.get_senarai_risiko_kanta_table','') }}"+"/"+"{{$kanta_komuniti->id}}";
           
        /* Maklumat Am Kanta Komuniti */
            $('#skk_state_id').val("{{$kanta_komuniti->state_id}}");
            $('#skk_daerah_id').val("{{$kanta_komuniti->daerah_id}}");
            $('#skk_kanta_nama').val("{{$kanta_komuniti->kanta_nama}}");
            $('#skk_kanta_alamat').val("{{$kanta_komuniti->kanta_alamat}}");

            var kanta_jenis_kediaman_1 = "{{$kanta_komuniti->kanta_jenis_kediaman_1}}";
            if (kanta_jenis_kediaman_1 == "1") {
                $("input[name=skk_kanta_jenis_kediaman_1]").prop('checked', true);
            }

            var kanta_jenis_kediaman_2 = "{{$kanta_komuniti->kanta_jenis_kediaman_2}}";
            if (kanta_jenis_kediaman_2 == "1") {
                $("input[name=skk_kanta_jenis_kediaman_2]").prop('checked', true);
            }

            var kanta_jenis_kediaman_3 = "{{$kanta_komuniti->kanta_jenis_kediaman_3}}";
            if (kanta_jenis_kediaman_3 == "1") {
                $("input[name=skk_kanta_jenis_kediaman_3]").prop('checked', true);
            }

            var kanta_jenis_kediaman_4 = "{{$kanta_komuniti->kanta_jenis_kediaman_4}}";
            if (kanta_jenis_kediaman_4 == "1") {
                $("input[name=skk_kanta_jenis_kediaman_4]").prop('checked', true);
            }

        /* Maklumat Profile Kanta Komuniti */
            var senarai_risiko_table = $('#senarai_risiko_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: senarai_risiko_url,
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
					"width": "45%", 
					"mRender": function ( value, type, full )  {
						return full.risiko_nama_agensi;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "23%", 
					"mRender": function ( value, type, full )  {
						return full.risiko_jenis;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.risiko_isu;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

            $('#skk_kanta_sejarah_lokasi').val("{{$kanta_komuniti->kanta_sejarah_lokasi}}");
            $('#skk_kanta_kelebihan_lokasi').val("{{$kanta_komuniti->kanta_kelebihan_lokasi}}");
            $('#skk_kanta_kemudahan').val("{{$kanta_komuniti->kanta_kemudahan}}");

        /* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{ route('rt-sm10.senarai_kanta_komuniti_hq_1','') }}"+"/"+"{{$kanta_komuniti->id}}";
            });

            $('#btn_next').click(function(){
                window.location.href = "{{ route('rt-sm10.senarai_kanta_komuniti_hq_3','') }}"+"/"+"{{$kanta_komuniti->id}}";
            });
	});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop