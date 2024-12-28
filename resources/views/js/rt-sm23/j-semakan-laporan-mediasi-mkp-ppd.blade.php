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
			var permohonan_laporan_mediasi_mkp_config = {
				routes: {
					permohonan_laporan_mediasi_mkp_url: "/rt/sm23/semakan-laporan-mediasi-mkp-ppd/{id}"
				}
			};
			url_table_pihak_terlibat		= "{{ route('rt-sm23.get_laporan_mediasi_terlibat_table','') }}"+"/"+"{{$laporan_mediasi->id}}";
			
        /* Maklumat Mediator */
			$('#slmmpd_mkp_nama').val("{{$laporan_mediasi->mkp_nama}}");
			$('#slmmpd_mkp_ic').val("{{$laporan_mediasi->mkp_no_ic}}");
			$('#slmmpd_mkp_no_phone').val("{{$laporan_mediasi->mkp_no_phone}}");

		/* Maklumat Pembantu Mediator */
			$('#slmmpd_mediasi_pembantu_nama').val("{{$laporan_mediasi->mediasi_pembantu_nama}}");
			$('#slmmpd_mediasi_pembantu_ic').val("{{$laporan_mediasi->mediasi_pembantu_ic}}");
			$('#slmmpd_mediasi_pembantu_phone').val("{{$laporan_mediasi->mediasi_pembantu_phone}}");

        /* Maklumat Status Semakan */
            $('#slmmpd_imediator_mediasi_id').val("{{$laporan_mediasi->id}}");

		/* Maklumat Kes Mediasi */
			$('#slmmpd2_mediasi_alamat').on('keyup keypress', function(e) {
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
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
			
            $('#slmmpd_ref_mkp_kategori_id').val("{{$laporan_mediasi->ref_mkp_kategori_id}}");
			$('#slmmpd_mediasi_tarikh').val("{{$laporan_mediasi->mediasi_tarikh}}");
			$('#slmmpd_mediasi_alamat').val("{{$laporan_mediasi->mediasi_alamat}}");
			$('#slmmpd_mediasi_ngo_terlibat').val("{{$laporan_mediasi->mediasi_ngo_terlibat}}");
			$('#slmmpd_mediasi_ringkasan_kes').val("{{$laporan_mediasi->mediasi_ringkasan_kes}}");
			$('#slmmpd_mediasi_status_kes').val("{{$laporan_mediasi->mediasi_status_kes}}");
			if($('#slmmpd_mediasi_status_kes').val() == 'Selesai'){
				$("#mediasi_note_penyelesaian_kes").show();
				$("#mediasi_note_sebab_kes_xberjaya").hide();
			}else if($('#slmmpd_mediasi_status_kes').val() == 'Tidak Selesai'){
				$("#mediasi_note_penyelesaian_kes").hide();
				$("#mediasi_note_sebab_kes_xberjaya").show();
			}
			$('#slmmpd_mediasi_note_penyelesaian_kes').val("{{$laporan_mediasi->mediasi_note_penyelesaian_kes}}");
			$('#slmmpd_mediasi_note_sebab_kes_xberjaya').val("{{$laporan_mediasi->mediasi_note_sebab_kes_xberjaya}}");

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm23.senarai_semakan_laporan_mediasi_ppd') }}";
			});

	});

    /* click submit semakan */
		//my custom script
		var semakan_laporan_mediasi_config = {
			routes: {
				semakan_laporan_mediasi_url: "{{ route('rt-sm23.post_semakan_laporan_mediasi_ppd') }}",
			}
		};

        $(document).on('submit', '#form_slmmpd', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data = $("#form_slmmpd").serialize();
			var action = $('#post_semakan_laporan_mediasi_ppd').val();
			var btn_text;
			if (action == 'edit') {
				url = semakan_laporan_mediasi_config.routes.semakan_laporan_mediasi_url;
				type = "POST";
				btn_text = 'Hantar Status Sokongan&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=slmmpd_status]').removeClass("is-invalid");
				$('[name=slmmpd_disokong_note]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'slmmpd_status') {
							$('[name=slmmpd_status]').addClass("is-invalid");
							$('.error_slmmpd_status').html(error);
						}

						if(index == 'slmmpd_disokong_note') {
							$('[name=slmmpd_disokong_note]').addClass("is-invalid");
							$('.slmmpd_disokong_note').html(error);
						}

					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm23.senarai_semakan_laporan_mediasi_ppd')}}";
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