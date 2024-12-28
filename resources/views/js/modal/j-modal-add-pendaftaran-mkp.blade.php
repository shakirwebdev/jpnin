<script>
        var add_pendaftaran_mkp_config = {
            routes: {
                add_pendaftaran_mkp_url: "/rt/sm23/senarai-pra-pendaftaran-mkp-upmk",
                add_pra_pendaftaran_mkp_url: "{{ route('rt-sm23.post_add_pendaftaran_mkp') }}",
                get_data_profile_user_url: "{{ route('rt-sm23.get_profile_user','') }}",
            }
        };

        
       

    function load_add_pendaftran_mkp(id) {
        $("#mapm_state_id").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#mapm_daerah_id').find('option').remove();
            $('#mapm_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: edit_pendaftaran_mkp_config.routes.edit_pendaftaran_mkp_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#mapm_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#mapm_daerah_id')
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

        $('#mapm_no_ic').mask('999999999999');

        $("#mapm_no_ic").on( 'keyup', function () {
            $.get(add_pendaftaran_mkp_config.routes.get_data_profile_user_url + '/' + $("#mapm_no_ic").val(), function (data_user) {
                $('#mapm_user_fullname').val(data_user.user_fullname);
                $('#mapm_no_phone').val(data_user.no_phone);
                $('#mapm_user_email').val(data_user.user_email);
                $('#mapm_user_alamat').val(data_user.user_address);
                $('#mapm_user_id').val(data_user.user_id);
                $('#mapm_email').val(data_user.user_email);
            });
        });

        $('#modal_add_pendaftaran_mkp').modal('show');

        $(document).on('submit', '#form_mapm', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_mapm").serialize();
            var action = $('#post_add_pendaftaran_mkp').val();
            var btn_text;
            if (action == 'add') {
                url = add_pendaftaran_mkp_config.routes.add_pra_pendaftaran_mkp_url;
                type = "POST";
                btn_text = '<i class="fa fa-send"></i>&nbsp;&nbsp;Hantar';
            }

            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=mapm_state_id]').removeClass("is-invalid");
                $('[name=mapm_daerah_id]').removeClass("is-invalid");
                $('[name=mapm_no_ic]').removeClass("is-invalid");
                $('[name=mapm_user_id]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'mapm_state_id') {
                            $('[name=mapm_state_id]').addClass("is-invalid");
                            $('.error_mapm_state_id').html(error);
                        }

                        if(index == 'mapm_daerah_id') {
                            $('[name=mapm_daerah_id]').addClass("is-invalid");
                            $('.error_mapm_daerah_id').html(error);
                        }

                        if(index == 'mapm_no_ic') {
                            $('[name=mapm_no_ic]').addClass("is-invalid");
                            $('.error_mapm_no_ic').html(error);
                        }

                        if(index == 'mapm_user_id') {
                            $('[name=mapm_user_id]').addClass("is-invalid");
                           $('.error_mapm_user_id').html(error);
                        }

                    });
                    $('#btn_submit').html(btn_text);                
                    $('#btn_submit').prop('disabled', false);            
                } else {
                    $('#modal_add_pendaftaran_mkp').modal('hide');
                    swal("Maklumat Pra Pendaftaran ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
                    $('#form_mapm').trigger("reset");
                    $('#senarai_pra_pendaftaran_mkp').DataTable().ajax.reload();
                    $('#btn_submit').html(btn_text);                
                    $('#btn_submit').prop('disabled', false);
                }
            });
        });

	}

</script>