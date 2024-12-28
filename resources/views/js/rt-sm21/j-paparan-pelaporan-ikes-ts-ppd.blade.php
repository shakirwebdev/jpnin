@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
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
			if("{{$ikes->hasRT}}" == 1){
				$('#ppip_hasRT').attr("checked", "checked");
			}
			$('#ppip_negeri_id').val("{{$ikes->krt_state_id}}");
			$('#ppip_daerah_id').val("{{$ikes->krt_daerah_id}}");
			$('#ppip_krt_profile_id').val("{{$ikes->krt_profile_id}}");

		/* Maklumat Pemohon */
			$('#ppip_user_fullname').val("{{$ikes->nama_permohon}}");
			$('#ppip_user_no_ic').val("{{$ikes->ic_pemohon}}");
			$('#ppip_user_no_phone').val("{{$ikes->phone_pemohon}}");
			$('#ppip_dihantar_alamat').val("{{$ikes->dihantar_alamat}}");

		/* Maklumat Kes Kejadian */
			$('#ppip1_negeri_id').val("{{$ikes->state_id}}");
			$('#ppip_bandar_id').val("{{$ikes->bandar_id}}");
			$('#ppip_ikes_lokasi').val("{{$ikes->ikes_lokasi}}");
			$('#ppip_parlimen_id').val("{{$ikes->parlimen_id}}");
			$('#ppip_pbt_id').val("{{$ikes->pbt_id}}");
			$('#ppip_ikes_tarikh_berlaku').val("{{$ikes->ikes_tarikh_berlaku}}");
			$('#ppip1_daerah_id').val("{{$ikes->daerah_id}}");
			$('#ppip_ikes_kawasan').val("{{$ikes->ikes_kawasan}}");
			$('#ppip_ikes_poskod').val("{{$ikes->ikes_poskod}}");
			$('#ppip_dun_id').val("{{$ikes->dun_id}}");
			$('#ppip_ikes_bpolis').val("{{$ikes->ikes_bpolis}}");
			$('#ppip_peringkat_kes_id').val("{{$ikes->peringkat_id}}");
			$('#ppip_kategori_kes_id').val("{{$ikes->kategori_id}}");
			$('#ppip_kluster_id').val("{{$ikes->kluster_id}}");
			$('#ppip_sub_kluster_id').val("{{$ikes->sub_kluster_id}}");
			$('#ppip_ikes_sumber').val("{{$ikes->ikes_sumber}}");
        
			$('#ppip_ikes_keterangan_kes').summernote({
				height: 200
			});

        	$("#ppip_ikes_keterangan_kes").summernote("disable");

			$('#ppip_ikes_tindakan_awal').summernote({
				height: 200
			});

			$("#ppip_ikes_tindakan_awal").summernote("disable");

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm21.senarai_ts_ikes_ppd') }}";
			});

			$('#btn_next').click(function(){
				window.location.href = "{{route('rt-sm21.paparan_pelaporan_ikes_ts_ppd_1','')}}"+"/"+"{{$ikes->id}}";
			});

	});

	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop