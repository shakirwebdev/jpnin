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

</style>
<script type="text/javascript">    
    
	$(document).ready( function () {

		//my custom script
			
			url_table_mediasi		= "{{ route('rt-sm23.get_kes_mediasi_mkp_table','') }}"+"/"+"{{$mkp->id}}";
			url_table_aktiviti		= "{{ route('rt-sm23.get_keaktifan_aktiviti_mkp_table','') }}"+"/"+"{{$mkp->id}}";
            url_table_latihan		= "{{ route('rt-sm23.get_keaktifan_latihan_table_mkp','') }}"+"/"+"{{$mkp->id}}";
            url_table_sumbangan		= "{{ route('rt-sm23.get_keaktifan_sumbangan_mkp_table','') }}"+"/"+"{{$mkp->id}}";
			
        /* Maklumat MKP */
			$('#skmpmk_mkp_nama').val("{{$mkp->mkp_nama}}");
            $('#skmpmk_mkp_no_ic').val("{{$mkp->mkp_no_ic}}");
            $('#skmpmk_mkp_no_phone').val("{{$mkp->mkp_no_phone}}");
			$('#skmpmk_mkp_email').val("{{$mkp->user_email}}");

        /* Maklumat Status Sokongan */
            $('#skmpmk_spk_mkp_keaktifan_id').val("{{$mkp->spk_imediator_id}}");

		/* Maklumat Kriteria Penilaian Keaktifan Mediator */
        
			var senarai_kes_mediasi_table = $('#senarai_kes_mediasi_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_mediasi,
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
					"width": "38%", 
					"mRender": function ( value, type, full )  {
						return full.kluster_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					"mRender": function ( value, type, full )  {
						return full.mediasi_status_kes;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "38%", 
					"mRender": function ( value, type, full )  {
						return full.peringkat_description;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_aktiviti_table = $('#senarai_aktiviti_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_aktiviti,
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
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.aktiviti_nama;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.aktiviti_tarikh;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.aktiviti_tempat;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.aktiviti_jawatan;
					}
				},{          
					"aTargets": [ 5 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.peringkat_description;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

            var senarai_latihan_table = $('#senarai_latihan_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_latihan,
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
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.latihan_nama;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.latihan_tarikh;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.latihan_tempat;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.latihan_penganjur;
					}
				},{          
					"aTargets": [ 5 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.peringkat_description;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

            var senarai_sumbangan_table = $('#senarai_sumbangan_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_sumbangan,
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
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.sumbangan_nama;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.peringkat_description;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
            

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm23.senarai_permohonan_mkp_keaktifan_ppmk') }}";
			});

	});

    /* click submit sokongan permohonan mkp */
		//my custom script
		var sokongan_mkp_keaktifan_ppmk_config = {
			routes: {
				sokongan_mkp_keaktifan_ppmk_url: "{{ route('rt-sm23.post_sokongan_mkp_keaktifan_ppmk') }}",
			}
		};

        $(document).on('submit', '#form_skmpmk', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data = $("#form_skmpmk").serialize();
			var action = $('#post_sokongan_mkp_keaktifan_ppmk').val();
			var btn_text;
			if (action == 'edit') {
				url = sokongan_mkp_keaktifan_ppmk_config.routes.sokongan_mkp_keaktifan_ppmk_url;
				type = "POST";
				btn_text = 'Hantar Status Sokongan&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=skmpmk_mkp_keaktifan_status]').removeClass("is-invalid");
				$('[name=skmpmk_disokong_note]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'skmpmk_mkp_keaktifan_status') {
							$('[name=skmpmk_mkp_keaktifan_status]').addClass("is-invalid");
							$('.error_skmpmk_mkp_keaktifan_status').html(error);
						}

						if(index == 'skmpmk_disokong_note') {
							$('[name=skmpmk_disokong_note]').addClass("is-invalid");
							$('.error_skmpmk_disokong_note').html(error);
						}

					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm23.senarai_permohonan_mkp_keaktifan_ppmk')}}";
				}
			});
		});
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop