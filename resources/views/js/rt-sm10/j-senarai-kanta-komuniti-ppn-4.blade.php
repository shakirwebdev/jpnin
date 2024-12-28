
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
            senarai_langkah_masalah_url			    = "{{ route('rt-sm10.get_senarai_langkah_masalah_kanta_table','') }}"+"/"+"{{$kanta_komuniti->id}}";
            senarai_pemimpin_url			        = "{{ route('rt-sm10.get_senarai_pemimpin_kanta_table','') }}"+"/"+"{{$kanta_komuniti->id}}";
            delete_pemimpin_url 	                = "{{ route('rt-sm10.delete_pemimpin_kanta','') }}";
            

        /* Maklumat Am Kanta Komuniti */
            $('#pkk_state_id').val("{{$kanta_komuniti->state_id}}");
            $('#pkk_daerah_id').val("{{$kanta_komuniti->daerah_id}}");
            $('#pkk_kanta_nama').val("{{$kanta_komuniti->kanta_nama}}");
            $('#pkk_kanta_alamat').val("{{$kanta_komuniti->kanta_alamat}}");

            var kanta_jenis_kediaman_1 = "{{$kanta_komuniti->kanta_jenis_kediaman_1}}";
            if (kanta_jenis_kediaman_1 == "1") {
                $("input[name=pkk_kanta_jenis_kediaman_1]").prop('checked', true);
            }

            var kanta_jenis_kediaman_2 = "{{$kanta_komuniti->kanta_jenis_kediaman_2}}";
            if (kanta_jenis_kediaman_2 == "1") {
                $("input[name=pkk_kanta_jenis_kediaman_2]").prop('checked', true);
            }

            var kanta_jenis_kediaman_3 = "{{$kanta_komuniti->kanta_jenis_kediaman_3}}";
            if (kanta_jenis_kediaman_3 == "1") {
                $("input[name=pkk_kanta_jenis_kediaman_3]").prop('checked', true);
            }

            var kanta_jenis_kediaman_4 = "{{$kanta_komuniti->kanta_jenis_kediaman_4}}";
            if (kanta_jenis_kediaman_4 == "1") {
                $("input[name=pkk_kanta_jenis_kediaman_4]").prop('checked', true);
            }

        /* Maklumat Profile Kanta Komuniti */
            var senarai_langkah_masalah_table = $('#senarai_langkah_masalah_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: senarai_langkah_masalah_url,
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
					"width": "23%", 
					"mRender": function ( value, type, full )  {
						return full.masalah_tajuk;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.langkah_diambil;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.langkah_pelaksanaan;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "25%", 
					"mRender": function ( value, type, full )  {
						return full.langkah_status;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

            var senarai_pemimpin_table = $('#senarai_pemimpin_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: senarai_pemimpin_url,
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
					"width": "30%", 
					"mRender": function ( value, type, full )  {
						return full.pemimpin_nama;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "58%", 
					"mRender": function ( value, type, full )  {
						return full.pemimpin_catatan;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
                    sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_pemimpin" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

		/* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{ route('rt-sm10.senarai_kanta_komuniti_ppn_3','') }}"+"/"+"{{$kanta_komuniti->id}}";
            });

	});

    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop