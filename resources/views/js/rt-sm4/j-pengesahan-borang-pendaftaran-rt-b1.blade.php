@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {
        
    	/* Maklumat Kawasan Krt */
		$('#pbprb_nama_krt').html("{{$cadangan_ajk_berkepentingan->nama_krt}}");
		$('#pbprb_alamat_krt').html("{{$cadangan_ajk_berkepentingan->alamat_krt}}");
		$('#pbprb_negeri_krt').html("{{$cadangan_ajk_berkepentingan->negeri_krt}}");
		$('#pbprb_parlimen_krt').html("{{$cadangan_ajk_berkepentingan->parlimen_krt}}");
		$('#pbprb_pbt_krt').html("{{$cadangan_ajk_berkepentingan->pbt_krt}}");
		$('#pbprb_daerah_krt').html("{{$cadangan_ajk_berkepentingan->daerah_krt}}");
		$('#pbprb_dun_krt').html("{{$cadangan_ajk_berkepentingan->dun_krt}}");
		
        /* Maklumat Ahli Jawatan Kuasa */
		$('#pbprb_ajk_luar_id').val("{{$cadangan_ajk_berkepentingan->id}}");
        $('#bprb_ajk_luar_nama').val("{{$cadangan_ajk_berkepentingan->ajk_luar_nama}}");
		$('#bprb_ajk_luar_ic').val("{{$cadangan_ajk_berkepentingan->ajk_luar_ic}}");
		$('#bprb_ajk_luar_alamat').val("{{$cadangan_ajk_berkepentingan->ajk_luar_alamat}}");
		if ("{{$cadangan_ajk_berkepentingan->ajk_luar_miliki_perniagaan}}" == "1") {
			$("input[name=bprb_ajk_luar_miliki_perniagaan]").prop('checked', true);
		}
		if ("{{$cadangan_ajk_berkepentingan->ajk_luar_miliki_keluarga}}" == "1") {
			$("input[name=bprb_ajk_luar_miliki_keluarga]").prop('checked', true);
		} 
		if ("{{$cadangan_ajk_berkepentingan->ajk_luar_miliki_pekerjaan}}" == "1") {
			$("input[name=bprb_ajk_luar_miliki_pekerjaan]").prop('checked', true);
		} 
		if ("{{$cadangan_ajk_berkepentingan->ajk_luar_miliki_jawatan}}" == "1") {
			$("input[name=bprb_ajk_luar_miliki_jawatan]").prop('checked', true);
		} 
		if ("{{$cadangan_ajk_berkepentingan->ajk_luar_miliki_kepentingan}}" == "1") {
			$("input[name=bprb_ajk_luar_miliki_kepentingan]").prop('checked', true);
		} 
		$('#bprb_ajk_luar_note').val("{{$cadangan_ajk_berkepentingan->ajk_luar_note}}");

        $('#btn_back').click(function(){
			window.location.href = '{{route('rt-sm4.pengesahan_cadangan_ajk_kepentingan_krt_ppd')}}';
		});
    });

	//my custom script
	var pengesahan_cadangan_ajk_berkepentingan_config = {
        routes: {
            pengesahan_cadangan_ajk_berkepentingan_url: "{{ route('rt-sm4.post_pengesahan_borang_rt_b1') }}",
        }
    };

	$(document).on('submit', '#form_pbprb', function(event){    
        event.preventDefault();
        $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
        $('#btn_submit').prop('disabled', true);
        var data = $("#form_pbprb").serialize();
        var action = $('#post_pengesahan_borang_rt_b1').val();
        var btn_text;
        if (action == 'edit') {
            url = pengesahan_cadangan_ajk_berkepentingan_config.routes.pengesahan_cadangan_ajk_berkepentingan_url;
            type = "POST";
            btn_text = 'Hantar Status Pengesahan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
        } 
		$.ajax({
            url: url,
            type: type,
            data: data,
        }).done(function(response) {        
            $('[name=pbprb_ajk_luar_status]').removeClass("is-invalid");
			$('[name=pbprb_disahkan_note]').removeClass("is-invalid");
            
			if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'pbprb_ajk_luar_status') {
                        $('[name=pbprb_ajk_luar_status]').addClass("is-invalid");
                        $('.error_pbprb_ajk_luar_status').html(error);
                    }

					if(index == 'pbprb_disahkan_note') {
                        $('[name=pbprb_disahkan_note]').addClass("is-invalid");
                        $('.error_pbprb_disahkan_note').html(error);
                    }

                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
				$('#btn_submit').html(btn_text);
                $('#btn_submit').prop('disabled', false); 
				window.location.href = "{{route('rt-sm4.pengesahan_cadangan_ajk_kepentingan_krt_ppd')}}";
            }
        });
    });

   

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop