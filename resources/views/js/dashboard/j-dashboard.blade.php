@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
    $(document).ready( function () {

		//my custom script
		var senarai_ajk_krt_config = {
			routes: {
				senarai_ajk_krt_url: "dashboard/dashboard"
			}
		};

        alert("{{$role_esepakat->user_id}}");
        
    });
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop