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
        
    	$('#pia_keterangan_kes').summernote({
	        height: 200
	    });

		$('#pia_tindakan_kes').summernote({
	        height: 200
	    });

		/* Button */
        $('#btn_back').click(function(){
			window.location.href = "{{ route('rt-sm21.semakan_permohonan_insiden_admin') }}";
		});

		$('#btn_next').click(function(){
			window.location.href = "{{ route('rt-sm21.semakan_permohonan_insiden_admin_2') }}";
		});

	});

	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop