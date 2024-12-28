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
    .avatar {
        vertical-align: middle;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        border-color: black;
    }
</style>
<script type="text/javascript">    
    
	$(document).ready( function () {

		/* Maklumat Kawasan Krt */
			$('#pbpe_krt_id').val("{{$krt_ajk->krt_id}}");
            $('#pbpe_krt_nama').html("{{$krt_ajk->krt_nama}}");
            $('#pbpe_krt_alamat').html("{{$krt_ajk->krt_alamat}}");
            $('#pbpe_krt_negeri').html("{{$krt_ajk->krt_negeri}}");
            $('#pbpe_krt_parlimen').html("{{$krt_ajk->krt_parlimen}}");
            $('#pbpe_krt_pbt').html("{{$krt_ajk->krt_pbt}}");
            $('#pbpe_krt_daerah').html("{{$krt_ajk->krt_daerah}}");
            $('#pbpe_krt_dun').html("{{$krt_ajk->krt_dun}}");

		/* Maklumat Pemohonan Ahli KRT */
            $('#pbpe_ajk_krt_id').val("{{$krt_ajk->id}}");
            $('#pbpe_ajk_gambar').attr('src', "{{ asset('storage/ajk_krt') }}"+"/"+ "{{$krt_ajk->file_avatar}}");
			$('#pbpe_ajk_penggal').val("{{$krt_ajk->penggal_mula}}"+"/"+"{{$krt_ajk->penggal_tamat}}");
            $('#pbpe_ajk_nama').val("{{$krt_ajk->ajk_nama}}");
            $('#pbpe_ajk_ic').val("{{$krt_ajk->ajk_ic}}");
            $('#pbpe_ajk_jantina').val("{{$krt_ajk->ajk_jantina}}");
            $('#pbpe_ajk_warganegara').val("{{$krt_ajk->ajk_warganegara}}");
            $('#pbpe_ajk_agama').val("{{$krt_ajk->ajk_agama}}");
            $('#pbpe_ajk_tarikh_lahir').val("{{$krt_ajk->ajk_tarikh_lahir}}");
            $('#pbpe_ajk_k_umur').val("{{$krt_ajk->ajk_kelompok_umur}}");
            $('#pbpe_ajk_kaum').val("{{$krt_ajk->ajk_kaum}}");
            $('#pbpe_ajk_phone').val("{{$krt_ajk->ajk_phone}}");
            $('#pbpe_ajk_alamat').val("{{$krt_ajk->ajk_alamat}}");
            $('#pbpe_ajk_poskod').val("{{$krt_ajk->ajk_poskod}}");
            $('#pbpe_ajk_pendidikan_id').val("{{$krt_ajk->ajk_pendidikan_id}}");
            $('#pbpe_ajk_profession_id').val("{{$krt_ajk->ajk_profession_id}}");
            $('#pbpe_ajk_jawatan_krt_id').val("{{$krt_ajk->ajk_jawatan_krt_id}}");
            $('#pbpe_ajk_tarikh_mula').val("{{$krt_ajk->ajk_tarikh_mula}}");
            $('#pbpe_ajk_tarikh_akhir').val("{{$krt_ajk->ajk_tarikh_akhir}}");
            var ajk_bekepentingan = "{{$krt_ajk->ajk_bekepentingan}}";
            var ajk_bekepentingan_interaksi_1 = "{{$krt_ajk->ajk_bekepentingan_interaksi_1}}";
            var ajk_bekepentingan_interaksi_2 = "{{$krt_ajk->ajk_bekepentingan_interaksi_2}}";
            var ajk_bekepentingan_interaksi_3 = "{{$krt_ajk->ajk_bekepentingan_interaksi_3}}";
            var ajk_bekepentingan_interaksi_4 = "{{$krt_ajk->ajk_bekepentingan_interaksi_4}}";
            var ajk_bekepentingan_interaksi_5 = "{{$krt_ajk->ajk_bekepentingan_interaksi_5}}";
            if (ajk_bekepentingan == "1") {
                $("input[name=pbpe_ajk_bekepentingan]").prop('checked', true);
            }
            if (ajk_bekepentingan_interaksi_1 == "1") {
                $("input[name=pbpe_ajk_bekepentingan_interaksi_1]").prop('checked', true);
            }
            if (ajk_bekepentingan_interaksi_2 == "1") {
                $("input[name=pbpe_ajk_bekepentingan_interaksi_2]").prop('checked', true);
            }
            if (ajk_bekepentingan_interaksi_3 == "1") {
                $("input[name=pbpe_ajk_bekepentingan_interaksi_3]").prop('checked', true);
            }
            if (ajk_bekepentingan_interaksi_4 == "1") {
                $("input[name=pbpe_ajk_bekepentingan_interaksi_4]").prop('checked', true);
            }
            if (ajk_bekepentingan_interaksi_5 == "1") {
                $("input[name=pbpe_ajk_bekepentingan_interaksi_5]").prop('checked', true);
            }
            $('#pbpe_ajk_berkepentingan_keterangan').val("{{$krt_ajk->ajk_berkepentingan_keterangan}}");

            $('#pbpe_disahkan_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
            
        /* Maklumat Pemohonan Ahli KRT */
            $('#btn_back').click(function(){
				history.back();
                //window.location.href = '{{route('rt-sm4.pengesahan_ahli_krt_utama')}}';
            });

	});

	/* Btn Hantar */
        //my custom script
        var pengesahan_ahli_krt_config = {
            routes: {
                pengesahan_ahli_krt_url: "{{ route('rt-sm4.post_pengesahan_ahli_krt') }}",
            }
        };

        $(document).on('submit', '#form_pbpe', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_pbpe").serialize();
            var action = $('#post_pengesahan_ahli_krt').val();
            var btn_text;
            if (action == 'edit') {
                url = pengesahan_ahli_krt_config.routes.pengesahan_ahli_krt_url;
                type = "POST";
                btn_text = 'Hantar Status Semakan &nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=pbpe_ajk_status_form]').removeClass("is-invalid");
                $('[name=pbpe_disahkan_note]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'pbpe_ajk_status_form') {
                            $('[name=pbpe_ajk_status_form]').addClass("is-invalid");
                            $('.error_pbpe_ajk_status_form').html(error);
                        }

                        if(index == 'pbpe_disahkan_note') {
                            $('[name=pbpe_disahkan_note]').addClass("is-invalid");
                            $('.error_pbpe_disahkan_note').html(error);
                        }

                    });
                    $('#btn_submit').html(btn_text);                
                    $('#btn_submit').prop('disabled', false);            
                } else {
                    $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm4.pengesahan_ahli_krt_utama')}}";
                }
            });
        });
	

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop