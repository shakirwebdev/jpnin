
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
            $('#ppek_nama_krt').html("{{$projek_ekonomi->nama_krt}}");
            $('#ppek_alamat_krt').html("{{$projek_ekonomi->alamat_krt}}");
            $('#ppek_negeri_krt').html("{{$projek_ekonomi->negeri_krt}}");
            $('#ppek_parlimen_krt').html("{{$projek_ekonomi->parlimen_krt}}");
            $('#ppek_pbt_krt').html("{{$projek_ekonomi->pbt_krt}}");
            $('#ppek_daerah_krt').html("{{$projek_ekonomi->daerah_krt}}");
            $('#ppek_dun_krt').html("{{$projek_ekonomi->dun_krt}}");

        /* Maklumat Projek Ekonomi RT */
            $('#ppek1_projek_nama').val("{{$projek_ekonomi->projek_nama}}");
            $('#ppek1_projek_penerangan').val("{{$projek_ekonomi->projek_penerangan}}");
            var status_pelaksanaan_projek_id = "{{$projek_ekonomi->status_pelaksanaan_projek_id}}";
            if(status_pelaksanaan_projek_id == ''){
                
            } else {
                $("input[name=ppek1_status_pelaksanaan_projek_id][value=" + "{{$projek_ekonomi->status_pelaksanaan_projek_id}}" + "]").prop('checked', true);
            }

            var sekala_project_semasa_id = "{{$projek_ekonomi->sekala_project_semasa_id}}";
            if(sekala_project_semasa_id == ''){
                
            }else {
                $("input[name=ppek1_sekala_project_semasa_id][value=" + "{{$projek_ekonomi->sekala_project_semasa_id}}" + "]").prop('checked', true);
            }

            var sekala_project_hadapan_id = "{{$projek_ekonomi->sekala_project_hadapan_id}}";
            if(sekala_project_hadapan_id == ''){
                
            }else {
                $("input[name=ppek1_sekala_project_hadapan_id][value=" + "{{$projek_ekonomi->sekala_project_hadapan_id}}" + "]").prop('checked', true);
            }
            
            $('#ppek1_projek_jaringan').val("{{$projek_ekonomi->projek_jaringan}}");
            $('#ppek1_projek_tahun').val("{{$projek_ekonomi->projek_tahun}}");
            $('#ppek1_projek_impak').val("{{$projek_ekonomi->projek_impak}}");

            $('#ppek1_projek_penerangan').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

            $('#ppek1_projek_jaringan').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

            $('#psk2_projek_ekonomi_id').val("{{$projek_ekonomi->id}}");
        
        /* Maklumat Note Kemaskini */   
            $('#ppek_status').val("{{$projek_ekonomi->status}}"); 

            if($('#ppek_status').val() == '5'){
                $("#ppek_perlu_kemaskini").show();
                $('#ppek_status_description').html("{{$projek_ekonomi->status_description}}");
                $('#ppek_disemak_note').html("{{$projek_ekonomi->disemak_note}}");
            }

            if($('#ppek_status').val() == '7'){
                $("#ppek_perlu_kemaskini").show();
                $('#ppek_status_description').html("{{$projek_ekonomi->status_description}}");
                $('#ppek_disahkan_note').html("{{$projek_ekonomi->disahkan_note}}");
            }

        /* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{ route('rt-sm10.permohonan_projek_ekonomi_krt') }}";
            });

	});

    /* Button Submit */

        //my custom script
        var permohonan_projek_ekonomi_config = {
            routes: {
                permohonan_projek_ekonomi_url: "{{ route('rt-sm10.post_permohonan_projek_ekonomi_1') }}",
            }
        };

        $(document).on('submit', '#form_ppek2', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data   = $("#form_ppek1, #form_ppek2").serialize();
            var action = $('#post_permohonan_projek_ekonomi_1').val();
            var btn_text;
            if (action == 'edit') {
                url = permohonan_projek_ekonomi_config.routes.permohonan_projek_ekonomi_url;
                type = "POST";
                btn_text = 'Hantar Permohonan Projek Ekonomi &nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=ppek1_projek_nama]').removeClass("is-invalid");
                $('[name=ppek1_projek_penerangan]').removeClass("is-invalid");
                $('[name=ppek1_status_pelaksanaan_projek_id]').removeClass("is-invalid");
                $('[name=ppek1_sekala_project_semasa_id]').removeClass("is-invalid");
                $('[name=ppek1_sekala_project_hadapan_id]').removeClass("is-invalid");
                $('[name=ppek1_projek_jaringan]').removeClass("is-invalid");
                $('[name=ppek1_projek_tahun]').removeClass("is-invalid");
                $('[name=ppek1_projek_impak]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'ppek1_projek_nama') {
                            $('[name=ppek1_projek_nama]').addClass("is-invalid");
                            $('.error_ppek1_projek_nama').html(error);
                        }

                        if(index == 'ppek1_projek_penerangan') {
                            $('[name=ppek1_projek_penerangan]').addClass("is-invalid");
                            $('.error_ppek1_projek_penerangan').html(error);
                        }

                        if(index == 'ppek1_status_pelaksanaan_projek_id') {
                            $('[name=ppek1_status_pelaksanaan_projek_id]').addClass("is-invalid");
                            $('.error_ppek1_status_pelaksanaan_projek_id').html(error);
                        }

                        if(index == 'ppek1_sekala_project_semasa_id') {
                            $('[name=ppek1_sekala_project_semasa_id]').addClass("is-invalid");
                            $('.error_ppek1_sekala_project_semasa_id').html(error);
                        }

                        if(index == 'ppek1_sekala_project_hadapan_id') {
                            $('[name=ppek1_sekala_project_hadapan_id]').addClass("is-invalid");
                            $('.error_ppek1_sekala_project_hadapan_id').html(error);
                        }

                        if(index == 'ppek1_projek_jaringan') {
                            $('[name=ppek1_projek_jaringan]').addClass("is-invalid");
                            $('.error_ppek1_projek_jaringan').html(error);
                        }

                        if(index == 'ppek1_projek_tahun') {
                            $('[name=ppek1_projek_tahun]').addClass("is-invalid");
                            $('.error_ppek1_projek_tahun').html(error);
                        }

                        if(index == 'ppek1_projek_impak') {
                            $('[name=ppek1_projek_impak]').addClass("is-invalid");
                            $('.error_ppek1_projek_impak').html(error);
                        }

                    });
                    $('#btn_submit').html(btn_text);                
                    $('#btn_submit').prop('disabled', false);            
                } else {
                    $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm10.permohonan_projek_ekonomi_krt')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop