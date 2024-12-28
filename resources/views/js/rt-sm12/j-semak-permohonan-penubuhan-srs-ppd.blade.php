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
        
		$('#sppsp_daerah').html("{{$surat_penubuhan_srs->daerah}}");
		$('#sppsp_nama_krt').html("{{$surat_penubuhan_srs->nama_krt}}");
		$('#sppsp_nama_pengerusi').html("{{$surat_penubuhan_srs->nama_pengerusi}}");
		$('#sppsp_tarikh_srs_dimohon').html("{{$surat_penubuhan_srs->tarikh_srs_dimohon}}");

		$('#btn_back').click(function(){
			window.location.href = '{{route('rt-sm12.semak_permohonan_penubuhan_srs')}}';
		});

		$('#btn_next').click(function(){
			window.location.href = "{{route('rt-sm12.semak_permohonan_penubuhan_srs_ppd_1','')}}"+"/"+{{$surat_penubuhan_srs->id}};
		});

	});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop