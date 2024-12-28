@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {

		$('#krt_nama').html("{{$profile_krt->krt_nama}}");
		$('#krt_disemak_by').html("{{$profile_krt->disemak_by}}");
		$('#krt_disemak_date').html("{{$profile_krt->disemak_date}}");
		$('#krt_disahkan_by').html("{{$profile_krt->disahkan_by}}");
		$('#krt_disahkan_date').html("{{$profile_krt->disahkan_date}}");
		$('#krt_disemak_note').html("{{$profile_krt->disemak_note}}");
		$('#krt_disahkan_note').html("{{$profile_krt->disahkan_note}}");
        
    	$('#btn_back').click(function(){
			window.location.href = "{{route('rt-sm1.kelulusan_permohonan_krt_baharu')}}";
		});

		$('#btn_next').click(function(){
			window.location.href = "{{route('rt-sm1.kelulusan_permohonan_krt_hq_1','')}}"+"/"+{{$profile_krt->id}};
		});

	});

    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop