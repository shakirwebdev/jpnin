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
            $('#plap5_nama_krt').html("{{$laporan_aktiviti->nama_krt}}");
            $('#plap5_alamat_krt').html("{{$laporan_aktiviti->alamat_krt}}");
            $('#plap5_negeri_krt').html("{{$laporan_aktiviti->negeri_krt}}");
            $('#plap5_parlimen_krt').html("{{$laporan_aktiviti->parlimen_krt}}");
            $('#plap5_pbt_krt').html("{{$laporan_aktiviti->pbt_krt}}");
            $('#plap5_daerah_krt').html("{{$laporan_aktiviti->daerah_krt}}");
            $('#plap5_dun_krt').html("{{$laporan_aktiviti->dun_krt}}");

        /* Maklumat Tempat Aktiviti Perpaduan */
            $('#plap5_state_id').val("{{$laporan_aktiviti->state_id}}");
            $('#plap5_daerah_id').val("{{$laporan_aktiviti->daerah_id}}");
            $('#plap5_aktiviti_tempat').val("{{$laporan_aktiviti->aktiviti_tempat}}");
            var aktiviti_kawasan_DL = "{{$laporan_aktiviti->aktiviti_kawasan_DL}}";
		    $("input[name=plap5_aktiviti_kawasan_DL][value=" + aktiviti_kawasan_DL + "]").prop('checked', true);

        /* Maklumat Status Pengesahan */
            $('#plap5_aktiviti_laporan_id').val("{{$laporan_aktiviti->id}}");

        /* Maklumat Aktiviti Perpaduan */
            $('#plap6_aktiviti_ringkasan_program').html("{{$laporan_aktiviti->aktiviti_ringkasan_program}}");
            $('#plap6_aktiviti_ringkasan_program').summernote({
                height: 200
            });
            $("#plap6_aktiviti_ringkasan_program").summernote("disable");

            if ('{{$laporan_aktiviti->aktiviti_post_mortem}}' == "1") {
                $("input[name=plap6_aktiviti_post_mortem]").prop('checked', true);
            }
            if ('{{$laporan_aktiviti->aktiviti_soal_selidik}}' == "1") {
                $("input[name=plap6_aktiviti_soal_selidik]").prop('checked', true);
            }
            if ('{{$laporan_aktiviti->aktiviti_pemerhatian}}' == "1") {
                $("input[name=plap6_aktiviti_pemerhatian]").prop('checked', true);
            }
            if ('{{$laporan_aktiviti->aktiviti_temubual}}' == "1") {
                $("input[name=plap6_aktiviti_temubual]").prop('checked', true);
            }

            $('#plap6_aktiviti_kekuatan').html("{{$laporan_aktiviti->aktiviti_kekuatan}}");
            $('#plap6_aktiviti_kekuatan').summernote({
                height: 200
            });
            $("#plap6_aktiviti_kekuatan").summernote("disable");

            $('#plap6_aktiviti_keberkesanan').html("{{$laporan_aktiviti->aktiviti_keberkesanan}}");
            $('#plap6_aktiviti_keberkesanan').summernote({
                height: 200
            });
            $("#plap6_aktiviti_keberkesanan").summernote("disable");

            $('#plap6_aktiviti_penambahbaikan').html("{{$laporan_aktiviti->aktiviti_penambahbaikan}}");
            $('#plap6_aktiviti_penambahbaikan').summernote({
                height: 200
            });
            $("#plap6_aktiviti_penambahbaikan").summernote("disable");

            $('#plap5_disahkan_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

        /* Button */
            $('#btn_back').click(function(){
                window.location.href = '{{route('rt-sm6.pengesahan_laporan_aktiviti_ppd_2','')}}'+'/'+'{{$laporan_aktiviti->id}}';
            });

    });

    /* action submit */
	//my custom script
	var pengesahan_laporan_aktiviti_config = {
        routes: {
            pengesahan_laporan_aktiviti_url: "{{ route('rt-sm6.post_pengesahan_laporan_aktiviti') }}",
        }
    };

    $(document).on('submit', '#form_plap5', function(event){    
        event.preventDefault();
        $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
        $('#btn_submit').prop('disabled', true);
        var data = $("#form_plap5").serialize();
        var action = $('#post_pengesahan_laporan_aktiviti').val();
        var btn_text;
        if (action == 'edit') {
            url = pengesahan_laporan_aktiviti_config.routes.pengesahan_laporan_aktiviti_url;
            type = "POST";
            btn_text = 'Hantar Status Pengesahan &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
        } 
        $.ajax({
            url: url,
            type: type,
            data: data,
        }).done(function(response) {        
            $('[name=plap5_disahkan_by]').removeClass("is-invalid");
            $('[name=plap5_disahkan_note]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'plap5_disahkan_by') {
                        $('[name=plap5_disahkan_by]').addClass("is-invalid");
                        $('.error_plap5_disahkan_by').html(error);
                    }

                    if(index == 'plap5_disahkan_note') {
                        $('[name=plap5_disahkan_note]').addClass("is-invalid");
                        $('.error_plap5_disahkan_note').html(error);
                    }

                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
                $('#btn_submit').html(btn_text);
                $('#btn_submit').prop('disabled', false); 
                window.location.href = "{{route('rt-sm6.pengesahan_laporan_aktiviti_ppd')}}";
            }
        });
    });

    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop