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

        /* Maklumat Kawasan Krt */
            $('#ppap5_nama_krt').html("{{$perancangan_aktiviti->nama_krt}}");
            $('#ppap5_alamat_krt').html("{{$perancangan_aktiviti->alamat_krt}}");
            $('#ppap5_negeri_krt').html("{{$perancangan_aktiviti->negeri_krt}}");
            $('#ppap5_parlimen_krt').html("{{$perancangan_aktiviti->parlimen_krt}}");
            $('#ppap5_pbt_krt').html("{{$perancangan_aktiviti->pbt_krt}}");
            $('#ppap5_daerah_krt').html("{{$perancangan_aktiviti->daerah_krt}}");
            $('#ppap5_dun_krt').html("{{$perancangan_aktiviti->dun_krt}}");

        /* Maklumat Tempat Aktiviti Perpaduan */
            $('#ppap5_state_id').val("{{$perancangan_aktiviti->state_id}}");
            $('#ppap5_daerah_id').val("{{$perancangan_aktiviti->daerah_id}}");
            $('#ppap5_aktiviti_tempat').val("{{$perancangan_aktiviti->aktiviti_tempat}}");
            var aktiviti_kawasan_DL = "{{$perancangan_aktiviti->aktiviti_kawasan_DL}}";
		    $("input[name=ppap5_aktiviti_kawasan_DL][value=" + aktiviti_kawasan_DL + "]").prop('checked', true);

        /* Maklumat Status Pengesahan */
            $('#ppap5_aktiviti_perancangan_id').val("{{$perancangan_aktiviti->id}}");

        /* Maklumat Aktiviti Perpaduan */
            $('#ppap6_aktiviti_ringkasan_program').html("{{$perancangan_aktiviti->aktiviti_ringkasan_program}}");
            $('#ppap6_aktiviti_ringkasan_program').summernote({
                height: 200
            });
            $("#ppap6_aktiviti_ringkasan_program").summernote("disable");

            if ('{{$perancangan_aktiviti->aktiviti_post_mortem}}' == "1") {
                $("input[name=ppap6_aktiviti_post_mortem]").prop('checked', true);
            }
            if ('{{$perancangan_aktiviti->aktiviti_soal_selidik}}' == "1") {
                $("input[name=ppap6_aktiviti_soal_selidik]").prop('checked', true);
            }
            if ('{{$perancangan_aktiviti->aktiviti_pemerhatian}}' == "1") {
                $("input[name=ppap6_aktiviti_pemerhatian]").prop('checked', true);
            }
            if ('{{$perancangan_aktiviti->aktiviti_temubual}}' == "1") {
                $("input[name=ppap6_aktiviti_temubual]").prop('checked', true);
            }

            $('#ppap6_aktiviti_kekuatan').html("{{$perancangan_aktiviti->aktiviti_kekuatan}}");
            $('#ppap6_aktiviti_kekuatan').summernote({
                height: 200
            });
            $("#ppap6_aktiviti_kekuatan").summernote("disable");

            $('#ppap6_aktiviti_keberkesanan').html("{{$perancangan_aktiviti->aktiviti_keberkesanan}}");
            $('#ppap6_aktiviti_keberkesanan').summernote({
                height: 200
            });
            $("#ppap6_aktiviti_keberkesanan").summernote("disable");

            $('#ppap6_aktiviti_penambahbaikan').html("{{$perancangan_aktiviti->aktiviti_penambahbaikan}}");
            $('#ppap6_aktiviti_penambahbaikan').summernote({
                height: 200
            });
            $("#ppap6_aktiviti_penambahbaikan").summernote("disable");

            $('#ppap5_disahkan_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

        /* Button */
            $('#btn_back').click(function(){
                window.location.href = '{{route('rt-sm6.pengesahan_perancangan_aktiviti_ppd_2','')}}'+'/'+'{{$perancangan_aktiviti->id}}';
            });

    });

    /* action submit */
	//my custom script
	var pengesahan_perancangan_aktiviti_config = {
        routes: {
            pengesahan_perancangan_aktiviti_url: "{{ route('rt-sm6.post_pengesahan_perancangan_aktiviti') }}",
        }
    };

    $(document).on('submit', '#form_ppap5', function(event){    
        event.preventDefault();
        $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
        $('#btn_submit').prop('disabled', true);
        var data = $("#form_ppap5").serialize();
        var action = $('#post_pengesahan_perancangan_aktiviti').val();
        var btn_text;
        if (action == 'edit') {
            url = pengesahan_perancangan_aktiviti_config.routes.pengesahan_perancangan_aktiviti_url;
            type = "POST";
            btn_text = 'Hantar Status Pengesahan &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
        } 
        $.ajax({
            url: url,
            type: type,
            data: data,
        }).done(function(response) {        
            $('[name=ppap5_disahkan_by]').removeClass("is-invalid");
            $('[name=ppap5_disahkan_note]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'ppap5_disahkan_by') {
                        $('[name=ppap5_disahkan_by]').addClass("is-invalid");
                        $('.error_ppap5_disahkan_by').html(error);
                    }

                    if(index == 'ppap5_disahkan_note') {
                        $('[name=ppap5_disahkan_note]').addClass("is-invalid");
                        $('.error_ppap5_disahkan_note').html(error);
                    }

                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
                $('#btn_submit').html(btn_text);
                $('#btn_submit').prop('disabled', false); 
                window.location.href = "{{route('rt-sm6.pengesahan_perancangan_aktiviti_ppd')}}";
            }
        });
    });

    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop