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
				$('#ppip_hasRT').attr("checked", "checked");
			}
			$('#ppip_state_id').val("{{$imuhibbah->krt_state_id}}");
			$('#ppip_daerah_id').val("{{$imuhibbah->krt_daerah_id}}");
			$('#ppip_krt_profile_id').val("{{$imuhibbah->krt_profile_id}}");

		/* Maklumat Pemohon */
			$('#ppip_nama_permohon').val("{{$imuhibbah->nama_permohon}}");
			$('#ppip_ic_pemohon').val("{{$imuhibbah->ic_pemohon}}");
			$('#ppip_phone_pemohon').val("{{$imuhibbah->phone_pemohon}}");

        /* Maklumat Status Pengesahan */
			$('#ppip_spk_imuhibbah_id').val("{{$imuhibbah->id}}");
			$('#ppip_disahkan_note').on('keyup keypress', function(e) {
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
			$('#ppip_imuhibbah_tajuk').val("{{$imuhibbah->imuhibbah_tajuk}}");
            $('#ppip1_state_id').val("{{$imuhibbah->state_id}}");
            $('#ppip_bandar_id').val("{{$imuhibbah->bandar_id}}");
            $('#ppip_imuhibbah_lokasi').val("{{$imuhibbah->imuhibbah_lokasi}}");
            $('#ppip_parlimen_id').val("{{$imuhibbah->parlimen_id}}");
            $('#ppip_pbt_id').val("{{$imuhibbah->pbt_id}}");
            $('#ppip1_daerah_id').val("{{$imuhibbah->daerah_id}}");
            $('#ppip_imuhibbah_kawasan').val("{{$imuhibbah->imuhibbah_kawasan}}");
            $('#ppip_imuhibbah_poskod').val("{{$imuhibbah->imuhibbah_poskod}}");
            $('#ppip_dun_id').val("{{$imuhibbah->dun_id}}");
            $('#ppip_imuhibbah_tarikh_laporan').val("{{$imuhibbah->imuhibbah_tarikh_laporan}}");
            $('#ppip_imuhibbah_tarikh_j_berlaku').val("{{$imuhibbah->imuhibbah_tarikh_j_berlaku}}");
            $('#ppip_imuhibbah_laporan').html("{{$imuhibbah->imuhibbah_laporan}}");
            $('#ppip_imuhibbah_sumber_maklumat').html("{{$imuhibbah->imuhibbah_sumber_maklumat}}");
            $('#ppip_imuhibbah_pelapor_nama').val("{{$imuhibbah->imuhibbah_pelapor_nama}}");
            $('#ppip_imuhibbah_pelapor_no').val("{{$imuhibbah->imuhibbah_pelapor_no}}");
            $('#ppip_imuhibbah_pelapor_jawatan').val("{{$imuhibbah->imuhibbah_pelapor_jawatan}}");
            $('#ppip_imuhibbah_pelapor_alamat').val("{{$imuhibbah->imuhibbah_pelapor_alamat}}");

            $('#ppip_imuhibbah_laporan').summernote({
				height: 200
			});
            $("#ppip_imuhibbah_laporan").summernote("disable");

            $('#ppip_imuhibbah_sumber_maklumat').summernote({
				height: 200
			});
            $("#ppip_imuhibbah_sumber_maklumat").summernote("disable");
			
		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm22.senarai_ts_imuhibbah_ppn') }}";
			});
    });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop