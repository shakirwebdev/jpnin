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
				$('#apipn_hasRT').attr("checked", "checked");
			}
			$('#apipn_negeri_id').val("{{$ikes->krt_state_id}}");
			$('#apipn_daerah_id').val("{{$ikes->krt_daerah_id}}");
			$('#apipn_krt_profile_id').val("{{$ikes->krt_profile_id}}");

		/* Maklumat Pemohon */
			$('#apipn_user_fullname').val("{{$ikes->nama_permohon}}");
			$('#apipn_user_no_ic').val("{{$ikes->ic_pemohon}}");
			$('#apipn_user_no_phone').val("{{$ikes->phone_pemohon}}");
			$('#apipn_dihantar_alamat').val("{{$ikes->dihantar_alamat}}");

		/* Maklumat Kes Kejadian */
			$('#apipn1_negeri_id').val("{{$ikes->state_id}}");
			$('#apipn_bandar_id').val("{{$ikes->bandar_id}}");
			$('#apipn_ikes_lokasi').val("{{$ikes->ikes_lokasi}}");
			$('#apipn_parlimen_id').val("{{$ikes->parlimen_id}}");
			$('#apipn_pbt_id').val("{{$ikes->pbt_id}}");
			$('#apipn_ikes_tarikh_berlaku').val("{{$ikes->ikes_tarikh_berlaku}}");
			$('#apipn1_daerah_id').val("{{$ikes->daerah_id}}");
			$('#apipn_ikes_kawasan').val("{{$ikes->ikes_kawasan}}");
			$('#apipn_ikes_poskod').val("{{$ikes->ikes_poskod}}");
			$('#apipn_dun_id').val("{{$ikes->dun_id}}");
			$('#apipn_ikes_bpolis').val("{{$ikes->ikes_bpolis}}");
			$('#apipn_peringkat_kes_id').val("{{$ikes->peringkat_id}}");
			$('#apipn_kategori_kes_id').val("{{$ikes->kategori_id}}");
			$('#apipn_sub_kategori_kes_id').val("{{$ikes->sub_kategori_id}}");
			$('#apipn_kluster_id').val("{{$ikes->kluster_id}}");
			$('#apipn_sub_kluster_id').val("{{$ikes->sub_kluster_id}}");
			$('#apipn_ikes_keterangan_kes').html("{{$ikes->ikes_keterangan_kes}}");
			$('#apipn_ikes_tindakan_awal').html("{{$ikes->ikes_tindakan_awal}}");
			$('#apipn_ikes_sumber').val("{{$ikes->ikes_sumber}}");
        
			$('#apipn_ikes_keterangan_kes').summernote({
				height: 200
			});

        	$("#apipn_ikes_keterangan_kes").summernote("disable");

			$('#apipn_ikes_tindakan_awal').summernote({
				height: 200
			});

			$("#apipn_ikes_tindakan_awal").summernote("disable");

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm21.senarai_akuan_permohonan_ikes_ppn') }}";
			});

			$('#btn_next').click(function(){
				window.location.href = "{{route('rt-sm21.akuan_permohonan_ikes_ppn_1','')}}"+"/"+"{{$ikes->id}}";
			});

	});

	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop