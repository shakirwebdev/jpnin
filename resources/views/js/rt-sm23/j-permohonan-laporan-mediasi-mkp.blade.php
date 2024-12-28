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
			var permohonan_laporan_mediasi_mkp_config = {
				routes: {
					permohonan_laporan_mediasi_mkp_url: "/rt/sm23/permohonan-laporan-mediasi-mkp/{id}"
				}
			};
			url_table_pihak_terlibat		= "{{ route('rt-sm23.get_laporan_mediasi_terlibat_table','') }}"+"/"+"{{$laporan_mediasi->id}}";
			url_delete_pihak_terlibat 		= "{{ route('rt-sm23.delete_laporan_mediasi_terlibat','') }}";

		/* Maklumat Mediator */
			$('#plmmkp_mkp_nama').val("{{$laporan_mediasi->mkp_nama}}");
			$('#plmmkp_mkp_ic').val("{{$laporan_mediasi->mkp_pemohon_ic}}");
			$('#plmmkp_mkp_phone').val("{{$laporan_mediasi->mkp_pemohon_no_phone}}");

		/* Maklumat Pembantu Mediator */
			$('#plmmkp1_mediasi_pembantu_ic').mask('999999999999');

			$('#plmmkp1_mediasi_pembantu_nama').val("{{$laporan_mediasi->mediasi_pembantu_nama}}");
			$('#plmmkp1_mediasi_pembantu_ic').val("{{$laporan_mediasi->mediasi_pembantu_ic}}");
			$('#plmmkp1_mediasi_pembantu_phone').val("{{$laporan_mediasi->mediasi_pembantu_phone}}");

		/* Maklumat Kes Mediasi */
			$('#plmmkp2_mediasi_alamat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

			var senarai_pihak_terlibat_table = $('#senarai_pihak_terlibat_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_pihak_terlibat,
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
					"width": "44%", 
					"mRender": function ( value, type, full )  {
						return full.pihak_pertama;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "44%", 
					"mRender": function ( value, type, full )  {
						return full.pihak_kedua;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_pihak_terlibat" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
			$('#pkkmkp3_spk_imediator_mediasi_id').val("{{$laporan_mediasi->id}}");

			$("#plmmkp4_mediasi_status_kes").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				if(value == 'Selesai'){
					$("#mediasi_note_penyelesaian_kes").show();
					$("#mediasi_note_sebab_kes_xberjaya").hide();
				}else if(value == 'Tidak Selesai'){
					$("#mediasi_note_penyelesaian_kes").hide();
					$("#mediasi_note_sebab_kes_xberjaya").show();
				}
			});

			$('#plmmkp4_mediasi_ringkasan_kes').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

			$('#plmmkp4_mediasi_note_penyelesaian_kes').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

			$('#plmmkp4_mediasi_note_sebab_kes_xberjaya').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

			$('#plmmkp5_spk_imediator_mediasi_id').val("{{$laporan_mediasi->id}}");

			$('#plmmkp2_ref_mkp_kategori_id').val("{{$laporan_mediasi->ref_mkp_kategori_id}}");
			$('#plmmkp2_mediasi_tarikh').val("{{$laporan_mediasi->mediasi_tarikh}}");
			$('#plmmkp2_mediasi_alamat').val("{{$laporan_mediasi->mediasi_alamat}}");
			$('#plmmkp4_mediasi_ngo_terlibat').val("{{$laporan_mediasi->mediasi_ngo_terlibat}}");
			$('#plmmkp4_mediasi_ringkasan_kes').val("{{$laporan_mediasi->mediasi_ringkasan_kes}}");
			$('#plmmkp4_peringkat_kes_id').val("{{$laporan_mediasi->peringkat_kes_id}}");
			$('#plmmkp4_mediasi_status_kes').val("{{$laporan_mediasi->mediasi_status_kes}}");
			if($('#plmmkp4_mediasi_status_kes').val() == 'Selesai'){
				$("#mediasi_note_penyelesaian_kes").show();
				$("#mediasi_note_sebab_kes_xberjaya").hide();
			}else if($('#plmmkp4_mediasi_status_kes').val() == 'Tidak Selesai'){
				$("#mediasi_note_penyelesaian_kes").hide();
				$("#mediasi_note_sebab_kes_xberjaya").show();
			}
			$('#plmmkp4_mediasi_note_penyelesaian_kes').val("{{$laporan_mediasi->mediasi_note_penyelesaian_kes}}");
			$('#plmmkp4_mediasi_note_sebab_kes_xberjaya').val("{{$laporan_mediasi->mediasi_note_sebab_kes_xberjaya}}");

		/* Maklumat Note Kemaskini */
			$('#plmmkp_status').val("{{$laporan_mediasi->status}}");

			if($('#plmmkp_status').val() == '5'){
				$("#plmmkp_perlu_kemaskini").show();
				$('#plmmkp_status_description').html("{{$laporan_mediasi->status_description}}");
				$('#plmmkp_disokong_note').html("{{$laporan_mediasi->disokong_note}}");
			}

			if($('#plmmkp_status').val() == '7'){
				$("#plmmkp_perlu_kemaskini").show();
				$('#plmmkp_status_description').html("{{$laporan_mediasi->status_description}}");
				$('#plmmkp_disokong_p_note').html("{{$laporan_mediasi->disokong_p_note}}");
			}

			if($('#plmmkp_status').val() == '9'){
				$("#plmmkp_perlu_kemaskini").show();
				$('#plmmkp_status_description').html("{{$laporan_mediasi->status_description}}");
				$('#plmmkp_disahkan_note').html("{{$laporan_mediasi->disahkan_note}}");
			}

			if($('#plmmkp_status').val() == '11'){
				$("#plmmkp_perlu_kemaskini").show();
				$('#plmmkp_status_description').html("{{$laporan_mediasi->status_description}}");
				$('#plmmkp_disemak_note').html("{{$laporan_mediasi->disemak_note}}");
			}

			if($('#plmmkp_status').val() == '12'){
				$("#plmmkp_perlu_kemaskini").show();
				$('#plmmkp_status_description').html("{{$laporan_mediasi->status_description}}");
				$('#plmmkp_diluluskan_note').html("{{$laporan_mediasi->diluluskan_note}}");
			}

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm23.senarai_permohonan_laporan_mediasi') }}";
			});

	});

	/* click add pihak terlibat */
		$(document).on('submit', '#form_pkkmkp3', function(event){
			var info = $('.error_alert_form_pkkmkp3');
			event.preventDefault();

			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save').prop('disabled', true);

			var data = $("#form_pkkmkp3").serialize();
			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm23.post_add_pihak_terlibat_laporan_mediasi') }}";
			type = "POST";

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {            
				info.hide().find('ul').empty();
				if(response.errors){
					$.each(response.errors, function(index, error){
						info.find('ul').append('<li>'+error+'</li>');
					});
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Kes Pihak Terlibat ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_pkkmkp3').trigger("reset");
					$('#btn_save').html(btn_text);
					$('#btn_save').prop('disabled', false);
					$('#senarai_pihak_terlibat_table').DataTable().ajax.reload();
				}
			});
		});

	/* click delete mediasi */
		$('body').on('click', '#delete_pihak_terlibat', function () {
			var delete_id = $(this).data("id");
			swal({
				title: "Anda pasti?",
				text: "Anda akan memadam rekod ini dari pangkalan data!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#dc3545",
				confirmButtonText: "Ya, sila padam!",
				cancelButtonText: "Tidak",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function (isConfirm) {
				if (isConfirm) {
					$.ajax({
						type: "GET",
						url: url_delete_pihak_terlibat +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_pihak_terlibat_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Pihak Terlibat telah dipadam dari pangkalan data", "success");
						},
						error: function (data) {
							console.log('Error:', data);
						}
					});                    
				} else {
					swal("Tidak", "Proses pemadaman tidak berlaku", "error");
				}
			});
		});

	/* click btn Next */
		var permohonan_laporan_mediasi_config = {
			routes: {
				permohonan_laporan_mediasi_url: "{{ route('rt-sm23.post_permohonan_laporan_mediasi_1') }}",
			}
		};

		$(document).on('submit', '#form_plmmkp5', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data   = $("#form_plmmkp1, #form_plmmkp2, #form_plmmkp4, #form_plmmkp5").serialize();
			var action = $('#post_permohonan_laporan_mediasi_1').val();
			var btn_text;
			if (action == 'edit') {
				url = permohonan_laporan_mediasi_config.routes.permohonan_laporan_mediasi_url;
				type = "POST";
				btn_text = 'Hantar Permohonan Pelaporan Kes Mediasi&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=plmmkp_spk_imediator_id]').removeClass("is-invalid");
				$('[name=plmmkp2_ref_mkp_kategori_id]').removeClass("is-invalid");
				$('[name=plmmkp2_mediasi_tarikh]').removeClass("is-invalid");
				$('[name=plmmkp2_mediasi_alamat]').removeClass("is-invalid");
				$('[name=plmmkp4_mediasi_ringkasan_kes]').removeClass("is-invalid");
				$('[name=plmmkp4_peringkat_kes_id]').removeClass("is-invalid");
				$('[name=plmmkp4_mediasi_status_kes]').removeClass("is-invalid");
				$('[name=plmmkp4_mediasi_note_penyelesaian_kes]').removeClass("is-invalid");
				$('[name=plmmkp4_mediasi_note_sebab_kes_xberjaya]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'plmmkp_spk_imediator_id') {
							$('[name=plmmkp_spk_imediator_id]').addClass("is-invalid");
							$('.error_plmmkp_spk_imediator_id').html(error);
						}

						if(index == 'plmmkp2_ref_mkp_kategori_id') {
							$('[name=plmmkp2_ref_mkp_kategori_id]').addClass("is-invalid");
							$('.error_plmmkp2_ref_mkp_kategori_id').html(error);
						}

						if(index == 'plmmkp2_mediasi_tarikh') {
							$('[name=plmmkp2_mediasi_tarikh]').addClass("is-invalid");
							$('.error_plmmkp2_mediasi_tarikh').html(error);
						}

						if(index == 'plmmkp2_mediasi_alamat') {
							$('[name=plmmkp2_mediasi_alamat]').addClass("is-invalid");
							$('.error_plmmkp2_mediasi_alamat').html(error);
						}

						if(index == 'plmmkp4_mediasi_ringkasan_kes') {
							$('[name=plmmkp4_mediasi_ringkasan_kes]').addClass("is-invalid");
							$('.error_plmmkp4_mediasi_ringkasan_kes').html(error);
						}

						if(index == 'plmmkp4_peringkat_kes_id') {
							$('[name=plmmkp4_peringkat_kes_id]').addClass("is-invalid");
							$('.plmmkp4_peringkat_kes_id').html(error);
						}

						if(index == 'plmmkp4_mediasi_status_kes') {
							$('[name=plmmkp4_mediasi_status_kes]').addClass("is-invalid");
							$('.error_plmmkp4_mediasi_status_kes').html(error);
						}

						if(index == 'plmmkp4_mediasi_note_penyelesaian_kes') {
							$('[name=plmmkp4_mediasi_note_penyelesaian_kes]').addClass("is-invalid");
							$('.error_plmmkp4_mediasi_note_penyelesaian_kes').html(error);
						}

						if(index == 'plmmkp4_mediasi_note_sebab_kes_xberjaya') {
							$('[name=plmmkp4_mediasi_note_sebab_kes_xberjaya]').addClass("is-invalid");
							$('.error_plmmkp4_mediasi_note_sebab_kes_xberjaya').html(error);
						}
					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm23.senarai_permohonan_laporan_mediasi')}}";
				}
			});
		});
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
@stop