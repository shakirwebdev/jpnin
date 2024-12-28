@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">    
    
    $(document).ready( function () {
        
    	/* Maklumat Kawasan Krt */
            $('#spors_daerah').html("{{$ops_rondaan->daerah}}");
            $('#spors_state').html("{{$ops_rondaan->state}}");
            $('#spors_nama_srs').html("{{$ops_rondaan->nama_srs}}");
            $('#spors_nama_krt').html("{{$ops_rondaan->nama_krt}}");
            $('#spors_daerah_1').html("{{$ops_rondaan->daerah}}");
            $('#spors_ops_tarikh_mula_ronda').html("{{$ops_rondaan->ops_tarikh_mula_ronda}}");
            $('#spors_user_fullname').html("{{$ops_rondaan->user_fullname}}");
            $('#spors_direkod_date').html("{{$ops_rondaan->direkod_date}}");

        /* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{route('rt-sm14.paparan_pemakluman_ops_rondaan_ppn')}}";
            });
		
        
    });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop