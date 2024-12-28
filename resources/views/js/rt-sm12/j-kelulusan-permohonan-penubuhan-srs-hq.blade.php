@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {
        
    	$('#kppsh_daerah').html("{{$surat_penubuhan_srs->daerah}}");
		$('#kppsh_nama_krt').html("{{$surat_penubuhan_srs->nama_krt}}");
		$('#kppsh_nama_pengerusi').html("{{$surat_penubuhan_srs->nama_pengerusi}}");
		$('#kppsh_tarikh_srs_dimohon').html("{{$surat_penubuhan_srs->tarikh_srs_dimohon}}");

		$('#btn_back').click(function(){
			window.location.href = '{{route('rt-sm12.kelulusan_permohonan_penubuhan_srs')}}';
		});

		$('#btn_next').click(function(){
			window.location.href = "{{route('rt-sm12.kelulusan_permohonan_penubuhan_srs_hq_1','')}}"+"/"+{{$surat_penubuhan_srs->id}};
		});

	});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop