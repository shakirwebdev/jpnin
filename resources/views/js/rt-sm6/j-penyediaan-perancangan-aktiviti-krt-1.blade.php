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

        //my custom script
		var perancangan_aktiviti_config = {
			routes: {
				perancangan_aktiviti_url: "/rt/sm6/penyediaan-perancangan-aktiviti-krt-1/{{$perancangan_aktiviti->id}}"
			}
		};

        /* Maklumat Kawasan Krt */
            $('#ppak_nama_krt').html("{{$perancangan_aktiviti->nama_krt}}");
            $('#ppak_alamat_krt').html("{{$perancangan_aktiviti->alamat_krt}}");
            $('#ppak_negeri_krt').html("{{$perancangan_aktiviti->negeri_krt}}");
            $('#ppak_parlimen_krt').html("{{$perancangan_aktiviti->parlimen_krt}}");
            $('#ppak_pbt_krt').html("{{$perancangan_aktiviti->pbt_krt}}");
            $('#ppak_daerah_krt').html("{{$perancangan_aktiviti->daerah_krt}}");
            $('#ppak_dun_krt').html("{{$perancangan_aktiviti->dun_krt}}");

        /* Maklumat Tempat Aktiviti Perpaduan */
            $("#ppak_state_id").on( 'change', function () {
                var value = $(this).find('option:selected').val();
                var selectedIndex = $(this).find('option:selected').index();
                $('#ppak_daerah_id').find('option').remove();
                $('#ppak_daerah_id').prop("disabled", false);
                    if (selectedIndex !== '0') {
                        $.ajax({
                            type: "GET",
                            url: perancangan_aktiviti_config.routes.perancangan_aktiviti_url,
                            data: {type: 'get_daerah', value: value},
                            success: function (data) {
                                $('#ppak_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                                $.each(data,function(key, obj) 
                                {
                                    $('#ppak_daerah_id')
                                    .append($('<option>')
                                    .text(obj.daerah_description)
                                    .attr('value', obj.daerah_id));
                                });
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        }); 
                    }
            });

            $('#ppak_state_id').val("{{$perancangan_aktiviti->state_id}}");
            
            if("{{$perancangan_aktiviti->state_id}}" !== ''){
                var value = "{{$perancangan_aktiviti->state_id}}";
                var value_daerah = "{{$perancangan_aktiviti->daerah_id}}";
                $('#ppak_daerah_id').prop("disabled", false);
                $.ajax({
                    type: "GET",
                    url: perancangan_aktiviti_config.routes.perancangan_aktiviti_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#ppak_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#ppak_daerah_id')
                            .append($('<option>')
                            .text(obj.daerah_description)
                            .attr('value', obj.daerah_id));
                            $('#ppak_daerah_id').val(value_daerah);
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }else{
                
            }

            $('#ppak_aktiviti_tempat').val("{{$perancangan_aktiviti->aktiviti_tempat}}");
            var aktiviti_kawasan_DL = "{{$perancangan_aktiviti->aktiviti_kawasan_DL}}";
		    
            if(aktiviti_kawasan_DL ==! null){
                $("input[name=ppak_aktiviti_kawasan_DL][value=" + aktiviti_kawasan_DL + "]").prop('checked', true);
            }

            $('#ppak_aktiviti_tempat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
            
        /* Maklumat Asas */
            $('#ppak1_aktiviti_tajuk').val("{{$perancangan_aktiviti->aktiviti_tajuk}}");
            $('#ppak1_aktiviti_tarikh').val("{{$perancangan_aktiviti->aktiviti_tarikh}}");
            $('#ppak1_aktiviti_tarikh_rancang').val("{{$perancangan_aktiviti->aktiviti_tarikh_rancang}}");
            $('#ppak1_aktiviti_masa').inputmask('hh:mm', { placeholder: '__:__ _m', alias: 'time24', hourFormat: '24' });
            $('#ppak1_aktiviti_masa').val("{{$perancangan_aktiviti->aktiviti_masa}}");
            $('#ppak1_penganjur_id').val("{{$perancangan_aktiviti->penganjur_id}}");
            $('#ppak1_peringkat_id').val("{{$perancangan_aktiviti->peringkat_id}}");

            $("#ppak1_agenda_id").on( 'change', function () {
                var value = $(this).find('option:selected').val();
                var selectedIndex = $(this).find('option:selected').index();
                $('#ppak1_program_id').find('option').remove();
                $('#ppak1_program_id').prop("disabled", false);
                    if (selectedIndex !== '0') {
                        $.ajax({
                            type: "GET",
                            url: perancangan_aktiviti_config.routes.perancangan_aktiviti_url,
                            data: {type: 'get_program', value: value},
                            success: function (data) {
                                $('#ppak1_program_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                                $.each(data,function(key, obj) 
                                {
                                    $('#ppak1_program_id')
                                    .append($('<option>')
                                    .text(obj.program_description)
                                    .attr('value', obj.id));
                                });
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        }); 
                    }
            });

            $('#ppak1_agenda_id').val("{{$perancangan_aktiviti->agenda_id}}");

            if("{{$perancangan_aktiviti->agenda_id}}" !== ''){
                var value = "{{$perancangan_aktiviti->agenda_id}}";
                var value_program = "{{$perancangan_aktiviti->program_id}}";
                $('#ppak1_program_id').prop("disabled", false);
                $.ajax({
                    type: "GET",
                    url: perancangan_aktiviti_config.routes.perancangan_aktiviti_url,
                    data: {type: 'get_program', value: value},
                    success: function (data) {
                        $('#ppak1_program_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#ppak1_program_id')
                            .append($('<option>')
                            .text(obj.program_description)
                            .attr('value', obj.id));
                            $('#ppak1_program_id').val(value_program);
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }else{
                
            }

            $('#ppak1_bidang_id').val("{{$perancangan_aktiviti->bidang_id}}");
            $('#ppak1_aktiviti_id').val("{{$perancangan_aktiviti->aktiviti_id}}");
            $('#ppak1_sub_aktiviti_id').val("{{$perancangan_aktiviti->sub_aktiviti_id}}");
            $('#ppak1_aktiviti_pembelanjaan').val("{{$perancangan_aktiviti->aktiviti_pembelanjaan}}");
            $('#ppak1_kewangan_id').val("{{$perancangan_aktiviti->kewangan_id}}");
            $('#ppak1_aktiviti_sasar').val("{{$perancangan_aktiviti->aktiviti_sasar}}");
            $('#ppak1_aktiviti_perasmi').val("{{$perancangan_aktiviti->aktiviti_perasmi}}");
            $('#ppak1_aktiviti_perancangan_id').val("{{$perancangan_aktiviti->id}}");

        /* Maklumat Note Kemaskini */
            $('#ppak_status').val("{{$perancangan_aktiviti->aktiviti_status}}");
            
            if($('#ppak_status').val() == '4'){
                $("#ppak_perlu_kemaskini").show();
                $('#ppak_status_description').html("{{$perancangan_aktiviti->status_description}}");
                $('#ppak_disahkan_note').html("{{$perancangan_aktiviti->disahkan_note}}");
            }

        /* Button */
            $('#btn_back').click(function(){
                window.location.href = '{{route('rt-sm6.penyediaan_perancangan_aktiviti_krt')}}';
            });
        
    });

    //my custom script
    var update_penyediaan_perancangan_aktiviti_config = {
        routes: {
            update_penyediaan_perancangan_aktiviti_url: "{{ route('rt-sm6.post_penyediaan_perancangan_aktiviti_krt_1') }}",
        }
    };

    /* Button Next */
    $(document).on('submit', '#form_ppak1', function(event){    
        event.preventDefault();
        $('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
        $('#btn_next').prop('disabled', true);
        var data   = $("#form_ppak, #form_ppak1").serialize();
        var action = $('#update_penyediaan_perancangan_aktiviti').val();
        var btn_text;
        if (action == 'edit') {
            url = update_penyediaan_perancangan_aktiviti_config.routes.update_penyediaan_perancangan_aktiviti_url;
            type = "POST";
            btn_text = 'Seterusnya &nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
        } 
		$.ajax({
            url: url,
            type: type,
            data: data,
        }).done(function(response) {        
            $('[name=ppak_state_id]').removeClass("is-invalid");
            $('[name=ppak_daerah_id]').removeClass("is-invalid");
			$('[name=ppak_aktiviti_tempat]').removeClass("is-invalid");
            $('[name=ppak_aktiviti_kawasan_DL]').removeClass("is-invalid");
            $('[name=ppak1_aktiviti_tajuk]').removeClass("is-invalid");
            $('[name=ppak1_aktiviti_tarikh]').removeClass("is-invalid");
            $('[name=ppak1_aktiviti_tarikh_rancang]').removeClass("is-invalid");
            $('[name=ppak1_aktiviti_masa]').removeClass("is-invalid");
            $('[name=ppak1_penganjur_id]').removeClass("is-invalid");
            $('[name=ppak1_peringkat_id]').removeClass("is-invalid");
            $('[name=ppak1_agenda_id]').removeClass("is-invalid");
            $('[name=ppak1_program_id]').removeClass("is-invalid");
            $('[name=ppak1_bidang_id]').removeClass("is-invalid");
            $('[name=ppak1_aktiviti_id]').removeClass("is-invalid");
            $('[name=ppak1_sub_aktiviti_id]').removeClass("is-invalid");
            $('[name=ppak1_aktiviti_pembelanjaan]').removeClass("is-invalid");
            $('[name=ppak1_kewangan_id]').removeClass("is-invalid");
            $('[name=ppak1_aktiviti_sasar]').removeClass("is-invalid");
            $('[name=ppak1_aktiviti_perasmi]').removeClass("is-invalid");

            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'ppak_state_id') {
                        $('[name=ppak_state_id]').addClass("is-invalid");
                        $('.error_ppak_state_id').html(error);
                    }

                    if(index == 'ppak_daerah_id') {
                        $('[name=ppak_daerah_id]').addClass("is-invalid");
                        $('.error_ppak_daerah_id').html(error);
                    }

					if(index == 'ppak_aktiviti_tempat') {
                        $('[name=ppak_aktiviti_tempat]').addClass("is-invalid");
                        $('.error_ppak_aktiviti_tempat').html(error);
                    }

                    if(index == 'ppak1_aktiviti_tajuk') {
                        $('[name=ppak1_aktiviti_tajuk]').addClass("is-invalid");
                        $('.error_ppak1_aktiviti_tajuk').html(error);
                    }

                    if(index == 'ppak1_aktiviti_tarikh') {
                        $('[name=ppak1_aktiviti_tarikh]').addClass("is-invalid");
                        $('.error_ppak1_aktiviti_tarikh').html(error);
                    }

                    if(index == 'ppak1_aktiviti_tarikh_rancang') {
                        $('[name=ppak1_aktiviti_tarikh_rancang]').addClass("is-invalid");
                        $('.error_ppak1_aktiviti_tarikh_rancang').html(error);
                    }

                    if(index == 'ppak1_aktiviti_masa') {
                        $('[name=ppak1_aktiviti_masa]').addClass("is-invalid");
                        $('.error_ppak1_aktiviti_masa').html(error);
                    }

                    if(index == 'ppak1_penganjur_id') {
                        $('[name=ppak1_penganjur_id]').addClass("is-invalid");
                        $('.error_ppak1_penganjur_id').html(error);
                    }

                    if(index == 'ppak1_peringkat_id') {
                        $('[name=ppak1_peringkat_id]').addClass("is-invalid");
                        $('.error_ppak1_peringkat_id').html(error);
                    }

                    if(index == 'ppak1_agenda_id') {
                        $('[name=ppak1_agenda_id]').addClass("is-invalid");
                        $('.error_ppak1_agenda_id').html(error);
                    }

                    if(index == 'ppak1_program_id') {
                        $('[name=ppak1_program_id]').addClass("is-invalid");
                        $('.error_ppak1_program_id').html(error);
                    }

                    if(index == 'ppak1_bidang_id') {
                        $('[name=ppak1_bidang_id]').addClass("is-invalid");
                        $('.error_ppak1_bidang_id').html(error);
                    }

                    if(index == 'ppak1_aktiviti_id') {
                        $('[name=ppak1_aktiviti_id]').addClass("is-invalid");
                        $('.error_ppak1_aktiviti_id').html(error);
                    }

                    if(index == 'ppak1_sub_aktiviti_id') {
                        $('[name=ppak1_sub_aktiviti_id]').addClass("is-invalid");
                        $('.error_ppak1_sub_aktiviti_id').html(error);
                    }

                    if(index == 'ppak1_aktiviti_pembelanjaan') {
                        $('[name=ppak1_aktiviti_pembelanjaan]').addClass("is-invalid");
                        $('.error_ppak1_aktiviti_pembelanjaan').html(error);
                    }

                    if(index == 'ppak1_kewangan_id') {
                        $('[name=ppak1_kewangan_id]').addClass("is-invalid");
                        $('.error_ppak1_kewangan_id').html(error);
                    }

                    if(index == 'ppak1_aktiviti_sasar') {
                        $('[name=ppak1_aktiviti_sasar]').addClass("is-invalid");
                        $('.error_ppak1_aktiviti_sasar').html(error);
                    }

                    if(index == 'ppak1_aktiviti_perasmi') {
                        $('[name=ppak1_aktiviti_perasmi]').addClass("is-invalid");
                        $('.error_ppak1_aktiviti_perasmi').html(error);
                    }
                });
                $('#btn_next').html(btn_text);                
                $('#btn_next').prop('disabled', false);            
            } else {
				$('#btn_next').html(btn_text);
                $('#btn_next').prop('disabled', false); 
				window.location.href = "{{route('rt-sm6.penyediaan_perancangan_aktiviti_krt_2','')}}"+"/"+{{$perancangan_aktiviti->id}};
            }
        });
    });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
@stop