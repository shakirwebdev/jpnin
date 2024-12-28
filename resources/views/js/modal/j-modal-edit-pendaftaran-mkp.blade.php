<script>
        var edit_pendaftaran_mkp_config = {
            routes: {
                edit_pendaftaran_mkp_url: "/rt/sm23/senarai-pra-pendaftaran-mkp-upmk",
                get_data_pendaftaran_mkp_url: "{{ route('rt-sm23.get_pra_pendaftaran_mkp','') }}",
                kemaskini_pendaftaran_mkp_url: "{{ route('rt-sm23.post_edit_pendaftaran_mkp') }}",
            }
        };

    function load_edit_pendaftran_mkp(id) {
        
        $("#mepm_state_id").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#mepm_daerah_id').find('option').remove();
            $('#mepm_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: edit_pendaftaran_mkp_config.routes.edit_pendaftaran_mkp_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#mepm_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#mepm_daerah_id')
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

        $.get(edit_pendaftaran_mkp_config.routes.get_data_pendaftaran_mkp_url + '/' + id, function (data_mkp) {
            $('#mepm_state_id').val(data_mkp.state_id);
            
            if(data_mkp.daerah_id !== ''){
				$('#mepm_daerah_id').attr('disabled', false);
				var value = data_mkp.state_id;
				$.ajax({
					type: "GET",
					url: edit_pendaftaran_mkp_config.routes.edit_pendaftaran_mkp_url,
					data: {type: 'get_daerah', value: value},
					success: function (data) {
						$('#mepm_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#mepm_daerah_id')
							.append($('<option>')
							.text(obj.daerah_description)
							.attr('value', obj.daerah_id));
							$('#mepm_daerah_id').val(data_mkp.daerah_id);
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}else{
				$('#mepm_daerah_id').attr('disabled', true);
			}

            $('#mepm_user_fullname').val(data_mkp.user_fullname);
            $('#mepm_no_ic').val(data_mkp.no_ic);
            $('#mepm_no_phone').val(data_mkp.no_phone);
            $('#mepm_user_email').val(data_mkp.user_email);
            $('#mepm_status_id').val(data_mkp.user_status);
            $('#user_profile_id').val(id);

            $('#modal_edit_pendaftaran_mkp').modal('show');
        });

        $(document).on('submit', '#form_mepm', function(event){    
            event.preventDefault();
            $('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_save').prop('disabled', true);
            var data = $("#form_mepm").serialize();
            var action = $('#post_edit_pendaftaran_mkp').val();
            var btn_text;
            url = edit_pendaftaran_mkp_config.routes.kemaskini_pendaftaran_mkp_url;
                type = "POST";
                btn_text = '<i class="fa fa-save"></i> Simpan';

            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=mepm_state_id]').removeClass("is-invalid");
                $('[name=mepm_daerah_id]').removeClass("is-invalid");
                $('[name=mepm_user_fullname]').removeClass("is-invalid");
                $('[name=mepm_no_phone]').removeClass("is-invalid");
                $('[name=mepm_user_email]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'mepm_state_id') {
                            $('[name=mepm_state_id]').addClass("is-invalid");
                            $('.error_mepm_state_id').html(error);
                        }

                        if(index == 'mepm_daerah_id') {
                            $('[name=mepm_daerah_id]').addClass("is-invalid");
                            $('.error_mepm_daerah_id').html(error);
                        }

                        if(index == 'mepm_user_fullname') {
                            $('[name=mepm_user_fullname]').addClass("is-invalid");
                            $('.error_mepm_user_fullname').html(error);
                        }
                        
                        if(index == 'mepm_no_phone') {
                            $('[name=mepm_no_phone]').addClass("is-invalid");
                            $('.error_mepm_no_phone').html(error);
                        }

                        if(index == 'mepm_user_email') {
                            $('[name=mepm_user_email]').addClass("is-invalid");
                            $('.error_mepm_user_email').html(error);
                        }
                        
                    });
                    $('#btn_save').html(btn_text);                
                    $('#btn_save').prop('disabled', false);            
                } else {
                    $('#form_mepm').trigger("reset");
                    $('#modal_edit_pendaftaran_mkp').modal('hide');
                    $('#btn_save').html("Simpan");
                    $('#btn_save').prop('disabled', false);
                    $('#senarai_pra_pendaftaran_mkp').DataTable().ajax.reload();
                }
            });
        });

	}

</script>