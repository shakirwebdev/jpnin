@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {
		
        $('#krt_nama').html("{{$profile_krt->krt_nama}}");
		$('#disemak_by').html("{{$profile_krt->disemak_by}}");
		$('#disemak_date').html("{{$profile_krt->disemak_date}}");
		$('#disemak_note').html("{{$profile_krt->disemak_note}}");
		
		$('#btn_next').click(function(){
			window.location.href = "{{route('rt-sm1.pengesahan_permohonan_krt_ppn_1','')}}"+"/"+{{$profile_krt->id}};
		});

		$('#btn_back').click(function(){
			window.location.href = "{{route('rt-sm1.pengesahan_permohonan_krt_baharu')}}";
		});

	});

    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop