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
			$('#stpksn_state_id').val("{{$tbk_student->state_id}}");
            $('#stpksn_daerah_id').val("{{$tbk_student->daerah_id}}");
            $('#stpksn_tabika_id').val("{{$tbk_student->tabika_id}}");

        /* Maklumat Permohonan */
            $('#stpksn_student_nama').val("{{$tbk_student->student_nama}}");
			$('#stpksn_student_sijil_lahir').val("{{$tbk_student->student_sijil_lahir}}");
			$('#stpksn_student_agama_id').val("{{$tbk_student->student_agama_id}}");
			$('#stpksn_student_kaum_id').val("{{$tbk_student->student_kaum_id}}");
            $('#stpksn_student_mykid').val("{{$tbk_student->student_mykid}}");
            $('#stpksn_student_tarikh_lahir').val("{{$tbk_student->student_tarikh_lahir}}");
            $('#stpksn_student_jantina_id').val("{{$tbk_student->student_jantina_id}}");
            $('#stpksn_student_kesihatan').val("{{$tbk_student->student_kesihatan}}");
            $('#stpksn_student_alamat').val("{{$tbk_student->student_alamat}}");
            $('#stpksn_student_jarak_rumah').val("{{$tbk_student->student_jarak_rumah}}");
            $('#stpksn_bapa_nama').val("{{$tbk_student->bapa_nama}}");
            $('#stpksn_bapa_pekerjaan').val("{{$tbk_student->bapa_pekerjaan}}");
            $('#stpksn_bapa_profession_id').val("{{$tbk_student->bapa_profession_id}}");
            $('#stpksn_bapa_pendapatan').val("{{$tbk_student->bapa_pendapatan}}");
            $('#stpksn_bapa_kerakyatan_id').val("{{$tbk_student->bapa_kerakyatan_id}}");
            $('#stpksn_bapa_jumlah_pendapatan').val("{{$tbk_student->bapa_jumlah_pendapatan}}");
            $('#stpksn_bapa_ic').val("{{$tbk_student->bapa_ic}}");
            $('#stpksn_bapa_alamat_office').val("{{$tbk_student->bapa_alamat_office}}");
            $('#stpksn_bapa_phone_office').val("{{$tbk_student->bapa_phone_office}}");
            $('#stpksn_bapa_phone').val("{{$tbk_student->bapa_phone}}");
            $('#stpksn_bapa_phone_rumah').val("{{$tbk_student->bapa_phone_rumah}}");

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm27.senarai_student_tp_pksin') }}";
			});

            $('#btn_next').click(function(){
				window.location.href = "{{route('rt-sm27.student_tp_pksin_1','')}}"+"/"+"{{$tbk_student->id}}";
			});

	});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop