
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
    .blink {
        animation: blinker 1.0s linear infinite;
        color: #1c87c9;
        font-weight: bold;
        font-family: sans-serif;
    }
    @keyframes blinker {
        50% {
          opacity: 0;
        }
      }
</style>
<script type="text/javascript">    
    
	$(document).ready( function () {

        /* Maklumat Kawasan Krt */
            $('#ppepn_nama_krt').html("{{$projek_ekonomi->nama_krt}}");
            $('#ppepn_alamat_krt').html("{{$projek_ekonomi->alamat_krt}}");
            $('#ppepn_negeri_krt').html("{{$projek_ekonomi->negeri_krt}}");
            $('#ppepn_parlimen_krt').html("{{$projek_ekonomi->parlimen_krt}}");
            $('#ppepn_pbt_krt').html("{{$projek_ekonomi->pbt_krt}}");
            $('#ppepn_daerah_krt').html("{{$projek_ekonomi->daerah_krt}}");
            $('#ppepn_dun_krt').html("{{$projek_ekonomi->dun_krt}}");

        /* Maklumat Projek Ekonomi RT */
            $('#ppepn_projek_nama').val("{{$projek_ekonomi->projek_nama}}");
            $('#ppepn_projek_penerangan').val("{{$projek_ekonomi->projek_penerangan}}");
            $("input[name=ppepn_status_pelaksanaan_projek_id][value=" + "{{$projek_ekonomi->status_pelaksanaan_projek_id}}" + "]").prop('checked', true);
            $("input[name=ppepn_sekala_project_semasa_id][value=" + "{{$projek_ekonomi->sekala_project_semasa_id}}" + "]").prop('checked', true);
            $("input[name=ppepn_sekala_project_hadapan_id][value=" + "{{$projek_ekonomi->sekala_project_hadapan_id}}" + "]").prop('checked', true);
            $('#ppepn_projek_jaringan').val("{{$projek_ekonomi->projek_jaringan}}");
            $('#ppepn_projek_tahun').val("{{$projek_ekonomi->projek_tahun}}");
            $('#ppepn_projek_impak').val("{{$projek_ekonomi->projek_impak}}");

            $('#ppepn_projek_ekonomi_id').val("{{$projek_ekonomi->id}}");

        /* Button */
        $('#btn_back').click(function(){
			window.location.href = "{{ route('rt-sm10.senarai_projek_ekonomi_krt_ppd') }}";
		});

	});

    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop