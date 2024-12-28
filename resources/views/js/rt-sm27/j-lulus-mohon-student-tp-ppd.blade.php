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

		/* Maklumat Tabika Perpaduan */
			$('#lmstpd_state_id').val("{{$tbk_student->state_id}}");
            $('#lmstpd_daerah_id').val("{{$tbk_student->daerah_id}}");
            $('#lmstpd_tabika_id').val("{{$tbk_student->tabika_id}}");

		/* Maklumat Pengesahan Guru */
			$('#lmstpd_status_pengesahan').val("{{$tbk_student->status_pengesahan}}");
			$('#lmstpd_disahkan_note').val("{{$tbk_student->disahkan_note}}");
			
        /* Maklumat Permohonan */
            $('#lmstpd_student_nama').val("{{$tbk_student->student_nama}}");
			$('#lmstpd_student_sijil_lahir').val("{{$tbk_student->student_sijil_lahir}}");
			$('#lmstpd_student_agama_id').val("{{$tbk_student->student_agama_id}}");
			$('#lmstpd_student_kaum_id').val("{{$tbk_student->student_kaum_id}}");
            $('#lmstpd_student_mykid').val("{{$tbk_student->student_mykid}}");
            $('#lmstpd_student_tarikh_lahir').val("{{$tbk_student->student_tarikh_lahir}}");
            $('#lmstpd_student_jantina_id').val("{{$tbk_student->student_jantina_id}}");
            $('#lmstpd_student_kesihatan').val("{{$tbk_student->student_kesihatan}}");
            $('#lmstpd_student_alamat').val("{{$tbk_student->student_alamat}}");
            $('#lmstpd_student_jarak_rumah').val("{{$tbk_student->student_jarak_rumah}}");
            $('#lmstpd_bapa_nama').val("{{$tbk_student->bapa_nama}}");
            $('#lmstpd_bapa_pekerjaan').val("{{$tbk_student->bapa_pekerjaan}}");
            $('#lmstpd_bapa_profession_id').val("{{$tbk_student->bapa_profession_id}}");
            $('#lmstpd_bapa_pendapatan').val("{{$tbk_student->bapa_pendapatan}}");
            $('#lmstpd_bapa_kerakyatan_id').val("{{$tbk_student->bapa_kerakyatan_id}}");
            $('#lmstpd_bapa_jumlah_pendapatan').val("{{$tbk_student->bapa_jumlah_pendapatan}}");
            $('#lmstpd_bapa_ic').val("{{$tbk_student->bapa_ic}}");
            $('#lmstpd_bapa_alamat_office').val("{{$tbk_student->bapa_alamat_office}}");
            $('#lmstpd_bapa_phone_office').val("{{$tbk_student->bapa_phone_office}}");
            $('#lmstpd_bapa_phone').val("{{$tbk_student->bapa_phone}}");
            $('#lmstpd_bapa_phone_rumah').val("{{$tbk_student->bapa_phone_rumah}}");

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm27.senarai_lulus_mohon_student_tp_ppd') }}";
			});

            $('#btn_next').click(function(){
				window.location.href = "{{route('rt-sm27.lulus_mohon_student_tp_ppd_1','')}}"+"/"+"{{$tbk_student->id}}";
			});

	});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop