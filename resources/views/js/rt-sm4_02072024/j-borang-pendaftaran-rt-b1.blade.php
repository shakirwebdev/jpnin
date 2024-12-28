@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {
        
    	/* Maklumat Kawasan Krt */
		$('#bprb_nama_krt').html("{{$krt_profile->nama_krt}}");
		$('#bprb_alamat_krt').html("{{$krt_profile->alamat_krt}}");
		$('#bprb_negeri_krt').html("{{$krt_profile->negeri_krt}}");
		$('#bprb_daerah_krt').html("{{$krt_profile->daerah_krt}}");
		$('#bprb_parlimen_krt').html("{{$krt_profile->parlimen_krt}}");
		$('#bprb_dun_krt').html("{{$krt_profile->dun_krt}}");
		$('#bprb_pbt_krt').html("{{$krt_profile->pbt_krt}}");

        /* Maklumat Ahli Jawatan Kuasa */
        $('#bprb_krt_profile_id').val("{{$krt_profile->krt_id}}");

        $('#btn_back').click(function(){
			window.location.href = '{{route('rt-sm4.cadangan_ajk_kepentingan_krt')}}';
		});
    });

    //my custom script
	var daftar_ajk_luar_config = {
        routes: {
            daftar_ajk_luar_url: "{{ route('rt-sm4.post_borang_rt_b1') }}",
        }
    };

    $(document).on('submit', '#form_bprb', function(event){    
        event.preventDefault();
        $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
        $('#btn_submit').prop('disabled', true);
        var data = $("#form_bprb").serialize();
        var action = $('#post_borang_rt_b1').val();
        var btn_text;
        if (action == 'add') {
            url = daftar_ajk_luar_config.routes.daftar_ajk_luar_url;
            type = "POST";
            btn_text = 'Hantar Borang Cadangan AJK Kepentingan Di KRT&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
        } 
		$.ajax({
            url: url,
            type: type,
            data: data,
        }).done(function(response) {        
            $('[name=bprb_ajk_luar_nama]').removeClass("is-invalid");
			$('[name=bprb_ajk_luar_ic]').removeClass("is-invalid");
            $('[name=bprb_ajk_luar_alamat]').removeClass("is-invalid");
			$('[name=bprb_ajk_luar_note]').removeClass("is-invalid");
			
			if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'bprb_ajk_luar_nama') {
                        $('[name=bprb_ajk_luar_nama]').addClass("is-invalid");
                        $('.error_bprb_ajk_luar_nama').html(error);
                    }

					if(index == 'bprb_ajk_luar_ic') {
                        $('[name=bprb_ajk_luar_ic]').addClass("is-invalid");
                        $('.error_bprb_ajk_luar_ic').html(error);
                    }

                    if(index == 'bprb_ajk_luar_alamat') {
                        $('[name=bprb_ajk_luar_alamat]').addClass("is-invalid");
                        $('.error_bprb_ajk_luar_alamat').html(error);
                    }

					if(index == 'bprb_ajk_luar_note') {
                        $('[name=bprb_ajk_luar_note]').addClass("is-invalid");
                        $('.error_bprb_ajk_luar_note').html(error);
                    }

				});
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
				$('#btn_submit').html(btn_text);
                $('#btn_submit').prop('disabled', false); 
				window.location.href = "{{route('rt-sm4.cadangan_ajk_kepentingan_krt')}}";
            }
        });
    });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop