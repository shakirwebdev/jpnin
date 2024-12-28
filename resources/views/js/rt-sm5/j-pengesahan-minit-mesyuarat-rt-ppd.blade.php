@include('js.modal.j-modal-view-kehadiran-mesyuarat-krt')
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">    
    $(document).ready( function () {

		/* Maklumat Kawasan Krt */
		$('#pmmrp_nama_krt').html("{{$pengesahan_minit_mesyuarat->nama_krt}}");
		$('#pmmrp_alamat_krt').html("{{$pengesahan_minit_mesyuarat->alamat_krt}}");
		$('#pmmrp_negeri_krt').html("{{$pengesahan_minit_mesyuarat->negeri_krt}}");
		$('#pmmrp_parlimen_krt').html("{{$pengesahan_minit_mesyuarat->parlimen_krt}}");
		$('#pmmrp_pbt_krt').html("{{$pengesahan_minit_mesyuarat->pbt_krt}}");
		$('#pmmrp_daerah_krt').html("{{$pengesahan_minit_mesyuarat->daerah_krt}}");
		$('#pmmrp_dun_krt').html("{{$pengesahan_minit_mesyuarat->dun_krt}}");

		/* Maklumat Minit Mesyuarat Jawatankuasa */
		$('#pmmrp_mesyuarat_tajuk').val("{{$pengesahan_minit_mesyuarat->mesyuarat_tajuk}}");
		$('#pmmrp_mesyuarat_tarikh').val("{{$pengesahan_minit_mesyuarat->mesyuarat_tarikh}}");
		$('#pmmrp_mesyuarat_masa').val("{{$pengesahan_minit_mesyuarat->mesyuarat_masa}}");
		
		var tmpt;
		tmpt = "{{$pengesahan_minit_mesyuarat->mesyuarat_tempat}}";
		var new_tmpt = tmpt.replace(/&lt;br \/&gt;/g, "\n");
		$('#pmmrp_mesyuarat_tempat').val(new_tmpt);
		
		if("{{$pengesahan_minit_mesyuarat->kehadiran_nama}}" == "")
		{
			$('#pmmrp_pengerusi_mesyuarat').val("");
			$('#pmmrp_catat_mesyuarat').val("");
		}else
		{
			$('#pmmrp_pengerusi_mesyuarat').val("{{$pengesahan_minit_mesyuarat->kehadiran_nama}}"+" ("+"{{$pengesahan_minit_mesyuarat->kehadiran_jawatan}}"+")")
			$('#pmmrp_catat_mesyuarat').val("{{$pengesahan_minit_mesyuarat->nama_pencatat}}"+" ("+"{{$pengesahan_minit_mesyuarat->jawatan_pencatat}}"+")")
		}
			
			
		//$('#pmmrp_mesyuarat_tempat').val("{{$pengesahan_minit_mesyuarat->mesyuarat_tempat}}");
		$('#pmmrp_mesyuarat_perutusan_pengerusi').html("{{$pengesahan_minit_mesyuarat->mesyuarat_perutusan_pengerusi}}");
		$('#pmmrp_mesyuarat_perutusan_pengerusi').summernote({
	        height: 200
	    });
		$("#pmmrp_mesyuarat_perutusan_pengerusi").summernote("disable");
		$('#pmmrp_mesyuarat_yang_lalu').html("{{$pengesahan_minit_mesyuarat->mesyuarat_yang_lalu}}");
		$('#pmmrp_mesyuarat_yang_lalu').summernote({
	        height: 200
	    });
		$("#pmmrp_mesyuarat_yang_lalu").summernote("disable");

	    //my custom script
		url_get_senarai_kehadiran 	= "{{ route('rt-sm5.get_senarai_kehadiran','') }}"+"/"+{{$pengesahan_minit_mesyuarat->id}};

		var senarai_kehadiran_table = $('#senarai_kehadiran_table').DataTable( {
    		processing: true,
			serverSide: true,
			ajax: url_get_senarai_kehadiran,
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
                "width": "44%", 
                "mRender": function ( value, type, full )  {
					return full.kehadiran_nama;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "44%", 
                "mRender": function ( value, type, full )  {
                    return full.kehadiran_ic;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_kehadiran_mesyuarat_krt(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
					return button_a;
                }
            }],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });
		
		url_get_senarai_kehadiran_ajk = "{{ route('rt-sm5.get_senarai_kehadiran_ajk_show','') }}"+"/"+"{{$pengesahan_minit_mesyuarat->id}}";
		
		var senarai_kehadiran_ajk_table = $('#senarai_kehadiran_ajk_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_get_senarai_kehadiran_ajk,
				"language": {
					"paginate": {
							"previous": "",
							"next": "",
					},
					"sSearch": "Carian",
					"sLengthMenu": "",
					"lengthMenu": "",
					"zeroRecords": "Tiada rekod ditemui",
					"info": "",
					"infoEmpty": "",
					"infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
				},
				paging: false,
				pageLength: 30,
				dom: 'rtip',
				"bFilter": true,
				responsive: true,
				"aoColumnDefs":[{
					"aTargets": [ 0 ],
					"width": "5%",
					sClass: 'text-center',
					"mRender": function (data, type, full, meta)  {
						return  meta.row+1;
					}
				},{
					"aTargets": [ 1 ],
					"width": "55%",
					"mRender": function ( value, type, full )  {
						return full.ajk_nama;
					}
				},{
					"aTargets": [ 2 ],
					"width": "20%",
					"mRender": function ( value, type, full )  {
						return full.ajk_jawatan;
					}
				},{
					"aTargets": [ 3 ],
					"width": "10%",
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						if(full.status == 1)
						{
							button_a = '<input type="checkbox" disabled checked class="editor-active" onchange="process_kehadiran_ajk(\'' + full.status + '\',\'' + full.ajk_ic + '\',\'' + full.ajk_nama + '\',\'' + full.mtg_id + '\');">';
						}else
						{
							button_a = '<input type="checkbox" disabled class="editor-active" onchange="process_kehadiran_ajk(\'' + full.status + '\',\'' + full.ajk_ic + '\',\'' + full.ajk_nama + '\',\'' + full.mtg_id + '\');">';
						}
						return button_a;
					}
				},{
					"aTargets": [ 4 ],
					"width": "10%",
					sClass: 'text-center',
					visible: false,
					"mRender": function ( value, type, full )  {
						return full.ajk_jawatan_id;
					}
				}],
				"order": [[ 4, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

		/* Button */
		$('#btn_back').click(function(){
			history.back();
			//window.location.href = '{{route('rt-sm5.pengesahan_minit_mesyuarat_rt')}}';
		});

		$('#btn_next').click(function(){
			window.location.href = "{{ route('rt-sm5.pengesahan_minit_mesyuarat_rt_ppd_1','') }}"+"/"+{{$pengesahan_minit_mesyuarat->id}};
		});

	});
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>

<script src="../assets/bundles/dataTables.bundle.js"></script>
<script src="assets/js/table/datatable.js"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

<!-- <script src="../assets/bundles/summernote.bundle.js"></script>
<script src="assets/js/page/summernote.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="{{ asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
@stop