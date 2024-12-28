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
				$('#spmpp_hasRT').attr("checked", "checked");
			}
			$('#spmpp_state_id').val("{{$imuhibbah->krt_state_id}}");
			$('#spmpp_daerah_id').val("{{$imuhibbah->krt_daerah_id}}");
			$('#spmpp_krt_profile_id').val("{{$imuhibbah->krt_profile_id}}");

		/* Maklumat Pemohon */
			$('#spmpp_nama_permohon').val("{{$imuhibbah->nama_permohon}}");
			$('#spmpp_ic_pemohon').val("{{$imuhibbah->ic_pemohon}}");
			$('#spmpp_phone_pemohon').val("{{$imuhibbah->phone_pemohon}}");

        /* Maklumat Status Semakan */
			$('#spmpp_spk_imuhibbah_id').val("{{$imuhibbah->id}}");
			$('#spmpp_disemak_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

			if("{{$imuhibbah->status}}" == 4){
				$('.semak_status_ppd').css("display", "block");
				$('.semak_status_ppn').css("display", "none");
			}

			if("{{$imuhibbah->status}}" == 9){
				$('.semak_status_ppd').css("display", "none");
				$('.semak_status_ppn').css("display", "block");
			}
			
		/* Maklumat Kes */
			$('#spmpp_imuhibbah_tajuk').val("{{$imuhibbah->imuhibbah_tajuk}}");
            $('#spmpp1_state_id').val("{{$imuhibbah->state_id}}");
            $('#spmpp_bandar_id').val("{{$imuhibbah->bandar_id}}");
            $('#spmpp_imuhibbah_lokasi').val("{{$imuhibbah->imuhibbah_lokasi}}");
            $('#spmpp_parlimen_id').val("{{$imuhibbah->parlimen_id}}");
            $('#spmpp_pbt_id').val("{{$imuhibbah->pbt_id}}");
            $('#spmpp1_daerah_id').val("{{$imuhibbah->daerah_id}}");
            $('#spmpp_imuhibbah_kawasan').val("{{$imuhibbah->imuhibbah_kawasan}}");
            $('#spmpp_imuhibbah_poskod').val("{{$imuhibbah->imuhibbah_poskod}}");
            $('#spmpp_dun_id').val("{{$imuhibbah->dun_id}}");
            $('#spmpp_imuhibbah_tarikh_laporan').val("{{$imuhibbah->imuhibbah_tarikh_laporan}}");
            $('#spmpp_imuhibbah_tarikh_j_berlaku').val("{{$imuhibbah->imuhibbah_tarikh_j_berlaku}}");
            $('#spmpp_imuhibbah_laporan').html("{{$imuhibbah->imuhibbah_laporan}}");
            $('#spmpp_imuhibbah_sumber_maklumat').html("{{$imuhibbah->imuhibbah_sumber_maklumat}}");
            $('#spmpp_imuhibbah_pelapor_nama').val("{{$imuhibbah->imuhibbah_pelapor_nama}}");
            $('#spmpp_imuhibbah_pelapor_no').val("{{$imuhibbah->imuhibbah_pelapor_no}}");
            $('#spmpp_imuhibbah_pelapor_jawatan').val("{{$imuhibbah->imuhibbah_pelapor_jawatan}}");
            $('#spmpp_imuhibbah_pelapor_alamat').val("{{$imuhibbah->imuhibbah_pelapor_alamat}}");

            $('#spmpp_imuhibbah_laporan').summernote({
				height: 200
			});
            $("#spmpp_imuhibbah_laporan").summernote("disable");

            $('#spmpp_imuhibbah_sumber_maklumat').summernote({
				height: 200
			});
            $("#spmpp_imuhibbah_sumber_maklumat").summernote("disable");
		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm22.senarai_semakan_permohonan_muhibbah_bpp') }}";
			});
    });

	/* click submit akuan permohonan imuhibbah */
		//my custom script
		var semakan_permohonan_imuhibbah_config = {
			routes: {
				semakan_permohonan_imuhibbah_url: "{{ route('rt-sm22.post_semakan_permohonan_imuhibbah') }}",
			}
		};

        $(document).on('submit', '#form_spmpp', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data = $("#form_spmpp").serialize();
			var action = $('#post_semakan_permohonan_imuhibbah').val();
			var btn_text;
			if (action == 'edit') {
				url = semakan_permohonan_imuhibbah_config.routes.semakan_permohonan_imuhibbah_url;
				type = "POST";
				btn_text = 'Hantar Status Semakan &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=spmpp_imuhibbah_status]').removeClass("is-invalid");
				$('[name=spmpp_disemak_note]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'spmpp_imuhibbah_status') {
							$('[name=spmpp_imuhibbah_status]').addClass("is-invalid");
							$('.error_spmpp_imuhibbah_status').html(error);
						}

						if(index == 'spmpp_disemak_note') {
							$('[name=spmpp_disemak_note]').addClass("is-invalid");
							$('.error_spmpp_disemak_note').html(error);
						}

					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm22.senarai_semakan_permohonan_muhibbah_bpp')}}";
				}
			});
		});
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop