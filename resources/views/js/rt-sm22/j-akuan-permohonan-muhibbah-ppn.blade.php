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
				$('#apmpn_hasRT').attr("checked", "checked");
			}
			$('#apmpn_state_id').val("{{$imuhibbah->krt_state_id}}");
			$('#apmpn_daerah_id').val("{{$imuhibbah->krt_daerah_id}}");
			$('#apmpn_krt_profile_id').val("{{$imuhibbah->krt_profile_id}}");

		/* Maklumat Pemohon */
			$('#apmpn_nama_permohon').val("{{$imuhibbah->nama_permohon}}");
			$('#apmpn_ic_pemohon').val("{{$imuhibbah->ic_pemohon}}");
			$('#apmpn_phone_pemohon').val("{{$imuhibbah->phone_pemohon}}");

        /* Maklumat Status Memperakui */
			$('#apmpn_spk_imuhibbah_id').val("{{$imuhibbah->id}}");
			$('#apmpn_diakui_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
			
		/* Maklumat Kes */
			$('#apmpn_imuhibbah_tajuk').val("{{$imuhibbah->imuhibbah_tajuk}}");
            $('#apmpn1_state_id').val("{{$imuhibbah->state_id}}");
            $('#apmpn_bandar_id').val("{{$imuhibbah->bandar_id}}");
            $('#apmpn_imuhibbah_lokasi').val("{{$imuhibbah->imuhibbah_lokasi}}");
            $('#apmpn_parlimen_id').val("{{$imuhibbah->parlimen_id}}");
            $('#apmpn_pbt_id').val("{{$imuhibbah->pbt_id}}");
            $('#apmpn1_daerah_id').val("{{$imuhibbah->daerah_id}}");
            $('#apmpn_imuhibbah_kawasan').val("{{$imuhibbah->imuhibbah_kawasan}}");
            $('#apmpn_imuhibbah_poskod').val("{{$imuhibbah->imuhibbah_poskod}}");
            $('#apmpn_dun_id').val("{{$imuhibbah->dun_id}}");
            $('#apmpn_imuhibbah_tarikh_laporan').val("{{$imuhibbah->imuhibbah_tarikh_laporan}}");
            $('#apmpn_imuhibbah_tarikh_j_berlaku').val("{{$imuhibbah->imuhibbah_tarikh_j_berlaku}}");
            $('#apmpn_imuhibbah_laporan').html("{{$imuhibbah->imuhibbah_laporan}}");
            $('#apmpn_imuhibbah_sumber_maklumat').html("{{$imuhibbah->imuhibbah_sumber_maklumat}}");
            $('#apmpn_imuhibbah_pelapor_nama').val("{{$imuhibbah->imuhibbah_pelapor_nama}}");
            $('#apmpn_imuhibbah_pelapor_no').val("{{$imuhibbah->imuhibbah_pelapor_no}}");
            $('#apmpn_imuhibbah_pelapor_jawatan').val("{{$imuhibbah->imuhibbah_pelapor_jawatan}}");
            $('#apmpn_imuhibbah_pelapor_alamat').val("{{$imuhibbah->imuhibbah_pelapor_alamat}}");

            $('#apmpn_imuhibbah_laporan').summernote({
				height: 200
			});
            $("#apmpn_imuhibbah_laporan").summernote("disable");

            $('#apmpn_imuhibbah_sumber_maklumat').summernote({
				height: 200
			});
            $("#apmpn_imuhibbah_sumber_maklumat").summernote("disable");
		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm22.senarai_akuan_permohonan_muhibbah_ppn') }}";
			});
    });

	/* click submit akuan permohonan imuhibbah */
		//my custom script
		var akui_permohonan_imuhibbah_config = {
			routes: {
				akui_permohonan_imuhibbah_url: "{{ route('rt-sm22.post_akui_permohonan_imuhibbah') }}",
			}
		};

        $(document).on('submit', '#form_apmpn', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data = $("#form_apmpn").serialize();
			var action = $('#post_akui_permohonan_imuhibbah').val();
			var btn_text;
			if (action == 'edit') {
				url = akui_permohonan_imuhibbah_config.routes.akui_permohonan_imuhibbah_url;
				type = "POST";
				btn_text = 'Hantar Status Memperakui &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=apmpn_imuhibbah_status]').removeClass("is-invalid");
				$('[name=apmpn_diakui_note]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'apmpn_imuhibbah_status') {
							$('[name=apmpn_imuhibbah_status]').addClass("is-invalid");
							$('.error_apmpn_imuhibbah_status').html(error);
						}

						if(index == 'apmpn_diakui_note') {
							$('[name=apmpn_diakui_note]').addClass("is-invalid");
							$('.error_apmpn_diakui_note').html(error);
						}

					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm22.senarai_akuan_permohonan_muhibbah_ppn')}}";
				}
			});
		});
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop