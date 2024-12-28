
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

        /* Maklumat Status Pengesahan */
            $('#ppepn_disahkan_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

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
			window.location.href = "{{ route('rt-sm10.permohonan_projek_ekonomi_krt') }}";
		});

	});

    /* action submit */
        //my custom script
        var pengesahan_projek_ekonomi_config = {
            routes: {
                pengesahan_projek_ekonomi_url: "{{ route('rt-sm10.post_pengesahan_projek_ekonomi') }}",
            }
        };

        $(document).on('submit', '#form_ppepn', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_ppepn").serialize();
            var action = $('#post_pengesahan_projek_ekonomi').val();
            var btn_text;
            if (action == 'edit') {
                url = pengesahan_projek_ekonomi_config.routes.pengesahan_projek_ekonomi_url;
                type = "POST";
                btn_text = 'Hantar Status Pengesahan &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=ppepn_status]').removeClass("is-invalid");
                $('[name=ppepn_disahkan_note]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'ppepn_status') {
                        $('[name=ppepn_status]').addClass("is-invalid");
                        $('.error_ppepn_status').html(error);
                    }

                    if(index == 'ppepn_disahkan_note') {
                        $('[name=ppepn_disahkan_note]').addClass("is-invalid");
                        $('.error_ppepn_disahkan_note').html(error);
                    }
                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
                $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm10.pengesahan_projek_ekonomi_krt')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop