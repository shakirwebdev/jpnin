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

		/* Maklumat Kes Dalam Krt */
			if("{{$imuhibbah->hasRT}}" == 1){
				$('#spmph_hasRT').attr("checked", "checked");
			}
			$('#spmph_state_id').val("{{$imuhibbah->krt_state_id}}");
			$('#spmph_daerah_id').val("{{$imuhibbah->krt_daerah_id}}");
			$('#spmph_krt_profile_id').val("{{$imuhibbah->krt_profile_id}}");

		/* Maklumat Pemohon */
			$('#spmph_nama_permohon').val("{{$imuhibbah->nama_permohon}}");
			$('#spmph_ic_pemohon').val("{{$imuhibbah->ic_pemohon}}");
			$('#spmph_phone_pemohon').val("{{$imuhibbah->phone_pemohon}}");

        /* Maklumat Status Pengesahan */
			$('#spmph_spk_imuhibbah_id').val("{{$imuhibbah->id}}");
			$('#spmph_disahkan_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

			if("{{$imuhibbah->status}}" == 6){
				$('.sahkan_status_ppd').css("display", "block");
				$('.sahkan_status_ppn').css("display", "none");
				$('.sahkan_status_bpp').css("display", "none");
			}

			if("{{$imuhibbah->status}}" == 10){
				$('.sahkan_status_ppd').css("display", "none");
				$('.sahkan_status_ppn').css("display", "block");
				$('.sahkan_status_bpp').css("display", "none");
			}

			if("{{$imuhibbah->status}}" == 13){
				$('.sahkan_status_ppd').css("display", "none");
				$('.sahkan_status_ppn').css("display", "none");
				$('.sahkan_status_bpp').css("display", "block");
			}
			
		/* Maklumat Kes */
			$('#spmph_imuhibbah_tajuk').val("{{$imuhibbah->imuhibbah_tajuk}}");
            $('#spmph1_state_id').val("{{$imuhibbah->state_id}}");
            $('#spmph_bandar_id').val("{{$imuhibbah->bandar_id}}");
            $('#spmph_imuhibbah_lokasi').val("{{$imuhibbah->imuhibbah_lokasi}}");
            $('#spmph_parlimen_id').val("{{$imuhibbah->parlimen_id}}");
            $('#spmph_pbt_id').val("{{$imuhibbah->pbt_id}}");
            $('#spmph1_daerah_id').val("{{$imuhibbah->daerah_id}}");
            $('#spmph_imuhibbah_kawasan').val("{{$imuhibbah->imuhibbah_kawasan}}");
            $('#spmph_imuhibbah_poskod').val("{{$imuhibbah->imuhibbah_poskod}}");
            $('#spmph_dun_id').val("{{$imuhibbah->dun_id}}");
            $('#spmph_imuhibbah_tarikh_laporan').val("{{$imuhibbah->imuhibbah_tarikh_laporan}}");
            $('#spmph_imuhibbah_tarikh_j_berlaku').val("{{$imuhibbah->imuhibbah_tarikh_j_berlaku}}");
            $('#spmph_imuhibbah_laporan').html("{{$imuhibbah->imuhibbah_laporan}}");
            $('#spmph_imuhibbah_sumber_maklumat').html("{{$imuhibbah->imuhibbah_sumber_maklumat}}");
            $('#spmph_imuhibbah_pelapor_nama').val("{{$imuhibbah->imuhibbah_pelapor_nama}}");
            $('#spmph_imuhibbah_pelapor_no').val("{{$imuhibbah->imuhibbah_pelapor_no}}");
            $('#spmph_imuhibbah_pelapor_jawatan').val("{{$imuhibbah->imuhibbah_pelapor_jawatan}}");
            $('#spmph_imuhibbah_pelapor_alamat').val("{{$imuhibbah->imuhibbah_pelapor_alamat}}");

            $('#spmph_imuhibbah_laporan').summernote({
				height: 200
			});
            $("#spmph_imuhibbah_laporan").summernote("disable");

            $('#spmph_imuhibbah_sumber_maklumat').summernote({
				height: 200
			});
            $("#spmph_imuhibbah_sumber_maklumat").summernote("disable");
		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm22.senarai_sahkan_permohonan_muhibbah_p') }}";
			});
    });

	/* click submit akuan permohonan imuhibbah */
		//my custom script
		var sahkan_permohonan_imuhibbah_config = {
			routes: {
				sahkan_permohonan_imuhibbah_url: "{{ route('rt-sm22.post_sahkan_permohonan_imuhibbah') }}",
			}
		};

        $(document).on('submit', '#form_spmph', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data = $("#form_spmph").serialize();
			var action = $('#post_sahkan_permohonan_imuhibbah').val();
			var btn_text;
			if (action == 'edit') {
				url = sahkan_permohonan_imuhibbah_config.routes.sahkan_permohonan_imuhibbah_url;
				type = "POST";
				btn_text = 'Hantar Status Pengesahan&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=spmph_imuhibbah_status]').removeClass("is-invalid");
				$('[name=spmph_disahkan_note]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'spmph_imuhibbah_status') {
							$('[name=spmph_imuhibbah_status]').addClass("is-invalid");
							$('.error_spmph_imuhibbah_status').html(error);
						}

						if(index == 'spmph_disahkan_note') {
							$('[name=spmph_disahkan_note]').addClass("is-invalid");
							$('.error_spmph_disahkan_note').html(error);
						}

					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm22.senarai_sahkan_permohonan_muhibbah_p')}}";
				}
			});
		});
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop