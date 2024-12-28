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
			$('#sthq_state_id').val("{{$tbk_student->state_id}}");
            $('#sthq_daerah_id').val("{{$tbk_student->daerah_id}}");
            $('#sthq_tabika_id').val("{{$tbk_student->tabika_id}}");

        /* Maklumat Permohonan */
            $('#sthq_student_nama').val("{{$tbk_student->student_nama}}");
			$('#sthq_student_sijil_lahir').val("{{$tbk_student->student_sijil_lahir}}");
			$('#sthq_student_agama_id').val("{{$tbk_student->student_agama_id}}");
			$('#sthq_student_kaum_id').val("{{$tbk_student->student_kaum_id}}");
            $('#sthq_student_mykid').val("{{$tbk_student->student_mykid}}");
            $('#sthq_student_tarikh_lahir').val("{{$tbk_student->student_tarikh_lahir}}");
            $('#sthq_student_jantina_id').val("{{$tbk_student->student_jantina_id}}");
            $('#sthq_student_kesihatan').val("{{$tbk_student->student_kesihatan}}");
            $('#sthq_student_alamat').val("{{$tbk_student->student_alamat}}");
            $('#sthq_student_jarak_rumah').val("{{$tbk_student->student_jarak_rumah}}");
            $('#sthq_bapa_nama').val("{{$tbk_student->bapa_nama}}");
            $('#sthq_bapa_pekerjaan').val("{{$tbk_student->bapa_pekerjaan}}");
            $('#sthq_bapa_profession_id').val("{{$tbk_student->bapa_profession_id}}");
            $('#sthq_bapa_pendapatan').val("{{$tbk_student->bapa_pendapatan}}");
            $('#sthq_bapa_kerakyatan_id').val("{{$tbk_student->bapa_kerakyatan_id}}");
            $('#sthq_bapa_jumlah_pendapatan').val("{{$tbk_student->bapa_jumlah_pendapatan}}");
            $('#sthq_bapa_ic').val("{{$tbk_student->bapa_ic}}");
            $('#sthq_bapa_alamat_office').val("{{$tbk_student->bapa_alamat_office}}");
            $('#sthq_bapa_phone_office').val("{{$tbk_student->bapa_phone_office}}");
            $('#sthq_bapa_phone').val("{{$tbk_student->bapa_phone}}");
            $('#sthq_bapa_phone_rumah').val("{{$tbk_student->bapa_phone_rumah}}");

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm27.senarai_student_tp_hqtp') }}";
			});

            $('#btn_next').click(function(){
				window.location.href = "{{route('rt-sm27.student_tp_hqtp_1','')}}"+"/"+"{{$tbk_student->id}}";
			});

	});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop