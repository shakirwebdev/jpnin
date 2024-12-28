@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {

		$('#krt_nama').html("{{$profile_krt->krt_nama}}");
		$('#created_at').html("{{$profile_krt->created_at}}");
		$('#dihantar_by').html("{{$profile_krt->dihantar_by}}");
		$('#dihantar_date').html("{{$profile_krt->dihantar_date}}");

		$('#btn_back').click(function(){
			window.location.href = "{{route('rt-sm2.profile_krt_ppn')}}";
		});
        
    	$('#btn_next').click(function(){
			window.location.href = "{{route('rt-sm2.profile_krt_ppn_2','')}}"+"/"+"{{$profile_krt->id}}";
		});

	});

    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop