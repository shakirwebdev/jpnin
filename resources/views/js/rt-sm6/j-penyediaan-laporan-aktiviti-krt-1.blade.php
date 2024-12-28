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
		var laporan_aktiviti_config = {
			routes: {
				laporan_aktiviti_url: "/rt/sm6/penyediaan-laporan-aktiviti-krt-1/{{$laporan_aktiviti->id}}"
			}
		};

        /* Maklumat Kawasan Krt */
            $('#plak_nama_krt').html("{{$laporan_aktiviti->nama_krt}}");
            $('#plak_alamat_krt').html("{{$laporan_aktiviti->alamat_krt}}");
            $('#plak_negeri_krt').html("{{$laporan_aktiviti->negeri_krt}}");
            $('#plak_parlimen_krt').html("{{$laporan_aktiviti->parlimen_krt}}");
            $('#plak_pbt_krt').html("{{$laporan_aktiviti->pbt_krt}}");
            $('#plak_daerah_krt').html("{{$laporan_aktiviti->daerah_krt}}");
            $('#plak_dun_krt').html("{{$laporan_aktiviti->dun_krt}}");

        /* Maklumat Tempat Aktiviti Perpaduan */
            $('#plak_state_id').val("{{$laporan_aktiviti->state_id}}");
            $("#plak_state_id").on( 'change', function () {
                var value = $(this).find('option:selected').val();
                var selectedIndex = $(this).find('option:selected').index();
                $('#plak_daerah_id').find('option').remove();
                $('#plak_daerah_id').prop("disabled", false);
                    if (selectedIndex !== '0') {
                        $.ajax({
                            type: "GET",
                            url: laporan_aktiviti_config.routes.laporan_aktiviti_url,
                            data: {type: 'get_daerah', value: value},
                            success: function (data) {
                                $('#plak_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                                $.each(data,function(key, obj) 
                                {
                                    $('#plak_daerah_id')
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
            $('#plak_daerah_id').val("{{$laporan_aktiviti->daerah_id}}");
            $('#plak_aktiviti_tempat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
            $('#plak_aktiviti_tempat').val("{{$laporan_aktiviti->aktiviti_tempat}}");
            var aktiviti_kawasan_DL = "{{$laporan_aktiviti->aktiviti_kawasan_DL}}";
            if(aktiviti_kawasan_DL ==! null){
                $("input[name=plak_aktiviti_kawasan_DL][value=" + aktiviti_kawasan_DL + "]").prop('checked', true);
            }
		    
            if ($('#plak_daerah_id').val() !== null){
                $('#plak_daerah_id').prop('disabled', false); 
            }

        /* Maklumat Asas */
            $('#plak1_aktiviti_tajuk').val("{{$laporan_aktiviti->aktiviti_tajuk}}");
            $('#plak1_aktiviti_tarikh').val("{{$laporan_aktiviti->aktiviti_tarikh}}");
            $('#plak1_aktiviti_tarikh_rancang').val("{{$laporan_aktiviti->aktiviti_tarikh_rancang}}");
            $('#plak1_aktiviti_masa').inputmask('hh:mm', { placeholder: '__:__ _m', alias: 'time24', hourFormat: '24' });
            $('#plak1_aktiviti_masa').val("{{$laporan_aktiviti->aktiviti_masa}}");
            $('#plak1_penganjur_id').val("{{$laporan_aktiviti->penganjur_id}}");
            $('#plak1_peringkat_id').val("{{$laporan_aktiviti->peringkat_id}}");
            $("#plak1_agenda_id").on( 'change', function () {
                var value = $(this).find('option:selected').val();
                var selectedIndex = $(this).find('option:selected').index();
                $('#plak1_program_id').find('option').remove();
                $('#plak1_program_id').prop("disabled", false);
                    if (selectedIndex !== '0') {
                        $.ajax({
                            type: "GET",
                            url: laporan_aktiviti_config.routes.laporan_aktiviti_url,
                            data: {type: 'get_program', value: value},
                            success: function (data) {
                                $('#plak1_program_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                                $.each(data,function(key, obj) 
                                {
                                    $('#plak1_program_id')
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
            $('#plak1_agenda_id').val("{{$laporan_aktiviti->agenda_id}}");
            if("{{$laporan_aktiviti->agenda_id}}" !== ''){
                var value = "{{$laporan_aktiviti->agenda_id}}";
                var value_program = "{{$laporan_aktiviti->program_id}}";
                $('#plak1_program_id').prop("disabled", false);
                $.ajax({
                    type: "GET",
                    url: laporan_aktiviti_config.routes.laporan_aktiviti_url,
                    data: {type: 'get_program', value: value},
                    success: function (data) {
                        $('#plak1_program_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#plak1_program_id')
                            .append($('<option>')
                            .text(obj.program_description)
                            .attr('value', obj.id));
                            $('#plak1_program_id').val(value_program);
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }else{
                
            }

            $('#plak1_bidang_id').val("{{$laporan_aktiviti->bidang_id}}");
            $('#plak1_aktiviti_id').val("{{$laporan_aktiviti->aktiviti_id}}");
            $('#plak1_sub_aktiviti_id').val("{{$laporan_aktiviti->sub_aktiviti_id}}");
            $('#plak1_aktiviti_pembelanjaan').val("{{$laporan_aktiviti->aktiviti_pembelanjaan}}");
            $('#plak1_kewangan_id').val("{{$laporan_aktiviti->kewangan_id}}");
            $('#plak1_aktiviti_sasar').val("{{$laporan_aktiviti->aktiviti_sasar}}");
            $('#plak1_aktiviti_perasmi').val("{{$laporan_aktiviti->aktiviti_perasmi}}");
            $('#plak1_aktiviti_laporan_id').val("{{$laporan_aktiviti->id}}");
            
        /* Maklumat Note Kemaskini */
            $('#plak_status').val("{{$laporan_aktiviti->aktiviti_status}}");
            
            if($('#plak_status').val() == '4'){
                $("#plak_perlu_kemaskini").show();
                $('#plak_status_description').html("{{$laporan_aktiviti->status_description}}");
                $('#plak_disahkan_note').html("{{$laporan_aktiviti->disahkan_note}}");
            }

        /* Button */
            $('#btn_back').click(function(){
                window.location.href = '{{route('rt-sm6.penyediaan_laporan_aktiviti_krt')}}';
            });
        
    });

    //my custom script
        var update_laporan_laporan_aktiviti_config = {
            routes: {
                update_laporan_laporan_aktiviti_url: "{{ route('rt-sm6.post_penyediaan_laporan_aktiviti_krt_1') }}",
            }
        };

    /* Button Next */
        $(document).on('submit', '#form_plak1', function(event){    
            event.preventDefault();
            $('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_next').prop('disabled', true);
            var data   = $("#form_plak, #form_plak1").serialize();
            var action = $('#update_penyediaan_laporan_aktiviti').val();
            var btn_text;
            if (action == 'edit') {
                url = update_laporan_laporan_aktiviti_config.routes.update_laporan_laporan_aktiviti_url;
                type = "POST";
                btn_text = 'Seterusnya &nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=plak_state_id]').removeClass("is-invalid");
                $('[name=plak_daerah_id]').removeClass("is-invalid");
                $('[name=plak_aktiviti_tempat]').removeClass("is-invalid");
                $('[name=plak_aktiviti_kawasan_DL]').removeClass("is-invalid");
                $('[name=plak1_aktiviti_tajuk]').removeClass("is-invalid");
                $('[name=plak1_aktiviti_tarikh]').removeClass("is-invalid");
                $('[name=plak1_aktiviti_tarikh_rancang]').removeClass("is-invalid");
                $('[name=plak1_aktiviti_masa]').removeClass("is-invalid");
                $('[name=plak1_penganjur_id]').removeClass("is-invalid");
                $('[name=plak1_peringkat_id]').removeClass("is-invalid");
                $('[name=plak1_agenda_id]').removeClass("is-invalid");
                $('[name=plak1_program_id]').removeClass("is-invalid");
                $('[name=plak1_bidang_id]').removeClass("is-invalid");
                $('[name=plak1_aktiviti_id]').removeClass("is-invalid");
                $('[name=plak1_sub_aktiviti_id]').removeClass("is-invalid");
                $('[name=plak1_aktiviti_pembelanjaan]').removeClass("is-invalid");
                $('[name=plak1_kewangan_id]').removeClass("is-invalid");
                $('[name=plak1_aktiviti_sasar]').removeClass("is-invalid");
                $('[name=plak1_aktiviti_perasmi]').removeClass("is-invalid");

                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'plak_state_id') {
                            $('[name=plak_state_id]').addClass("is-invalid");
                            $('.error_plak_state_id').html(error);
                        }

                        if(index == 'plak_daerah_id') {
                            $('[name=plak_daerah_id]').addClass("is-invalid");
                            $('.error_plak_daerah_id').html(error);
                        }

                        if(index == 'plak_aktiviti_tempat') {
                            $('[name=plak_aktiviti_tempat]').addClass("is-invalid");
                            $('.error_plak_aktiviti_tempat').html(error);
                        }

                        if(index == 'plak1_aktiviti_tajuk') {
                            $('[name=plak1_aktiviti_tajuk]').addClass("is-invalid");
                            $('.error_plak1_aktiviti_tajuk').html(error);
                        }

                        if(index == 'plak1_aktiviti_tarikh') {
                            $('[name=plak1_aktiviti_tarikh]').addClass("is-invalid");
                            $('.error_plak1_aktiviti_tarikh').html(error);
                        }

                        if(index == 'plak1_aktiviti_tarikh_rancang') {
                            $('[name=plak1_aktiviti_tarikh_rancang]').addClass("is-invalid");
                            $('.error_plak1_aktiviti_tarikh_rancang').html(error);
                        }

                        if(index == 'plak1_aktiviti_masa') {
                            $('[name=plak1_aktiviti_masa]').addClass("is-invalid");
                            $('.error_plak1_aktiviti_masa').html(error);
                        }

                        if(index == 'plak1_penganjur_id') {
                            $('[name=plak1_penganjur_id]').addClass("is-invalid");
                            $('.error_plak1_penganjur_id').html(error);
                        }

                        if(index == 'plak1_peringkat_id') {
                            $('[name=plak1_peringkat_id]').addClass("is-invalid");
                            $('.error_plak1_peringkat_id').html(error);
                        }

                        if(index == 'plak1_agenda_id') {
                            $('[name=plak1_agenda_id]').addClass("is-invalid");
                            $('.error_plak1_agenda_id').html(error);
                        }

                        if(index == 'plak1_program_id') {
                            $('[name=plak1_program_id]').addClass("is-invalid");
                            $('.error_plak1_program_id').html(error);
                        }

                        if(index == 'plak1_bidang_id') {
                            $('[name=plak1_bidang_id]').addClass("is-invalid");
                            $('.error_plak1_bidang_id').html(error);
                        }

                        if(index == 'plak1_aktiviti_id') {
                            $('[name=plak1_aktiviti_id]').addClass("is-invalid");
                            $('.error_plak1_aktiviti_id').html(error);
                        }

                        if(index == 'plak1_sub_aktiviti_id') {
                            $('[name=plak1_sub_aktiviti_id]').addClass("is-invalid");
                            $('.error_plak1_sub_aktiviti_id').html(error);
                        }

                        if(index == 'plak1_aktiviti_pembelanjaan') {
                            $('[name=plak1_aktiviti_pembelanjaan]').addClass("is-invalid");
                            $('.error_plak1_aktiviti_pembelanjaan').html(error);
                        }

                        if(index == 'plak1_kewangan_id') {
                            $('[name=plak1_kewangan_id]').addClass("is-invalid");
                            $('.error_plak1_kewangan_id').html(error);
                        }

                        if(index == 'plak1_aktiviti_sasar') {
                            $('[name=plak1_aktiviti_sasar]').addClass("is-invalid");
                            $('.error_plak1_aktiviti_sasar').html(error);
                        }

                        if(index == 'plak1_aktiviti_perasmi') {
                            $('[name=plak1_aktiviti_perasmi]').addClass("is-invalid");
                            $('.error_plak1_aktiviti_perasmi').html(error);
                        }
                    });
                    $('#btn_next').html(btn_text);                
                    $('#btn_next').prop('disabled', false);            
                } else {
                    $('#btn_next').html(btn_text);
                    $('#btn_next').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm6.penyediaan_laporan_aktiviti_krt_2','')}}"+"/"+{{$laporan_aktiviti->id}};
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
@stop