<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>
    //my custom script
    var senarai_add_penarikan_diri_config = {
            routes: {
                senarai_add_penarikan_diri_url: "/rt/sm18/permohonan-penarikan-diri-ahli-srs",
                ahli_peronda:               "{{ route('rt-sm18.get_ahli_peronda','') }}"
            }
    };

    function load_add_penarikan_diri_srs() {

        $("#mapds_srs_profile_id").on( 'change', function () {
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
			$('#mapds_ahli_peronda_id').find('option').remove();
			$('#mapds_ahli_peronda_id').prop("disabled", false);
			if (selectedIndex !== '0') {
				$.ajax({
					type: "GET",
					url: senarai_add_penarikan_diri_config.routes.senarai_add_penarikan_diri_url,
					data: {type: 'get_ahli', value: value},
					success: function (data) {
						$('#mapds_ahli_peronda_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#mapds_ahli_peronda_id')
							.append($('<option>')
							.text(obj.peronda_nama)
							.attr('value', obj.id));
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}
		});

        $("#mapds_ahli_peronda_id").on( 'change', function () {
            var value = $(this).find('option:selected').val();
			$.get(senarai_add_penarikan_diri_config.routes.ahli_peronda + '/' + value, function (data) {
                $('#mapds_peronda_ic').val(data.peronda_ic);
                $('#mapds_peronda_alamat').val(data.peronda_alamat);
            });
		});

        $('input:radio').click(function() { 
            if($(this).hasClass('enable_tb')) {
                $("#mapds_penarikan_diri_nyatakan").prop("disabled",false);
            }
        });
        
        $('#modal_add_penarikan_diri_srs').modal('show');


        /* add Pemakluman_rondaan */
            //my custom script
            var add_penarikan_diri_srs_config = {
                routes: {
                    add_penarikan_diri_srs_url: "{{ route('rt-sm18.add_penarikan_diri_srs') }}",
                }
            };

            $(document).on('submit', '#form_mapds', function(event){    
                event.preventDefault();
                $('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
                $('#btn_save').prop('disabled', true);
                var data = $("#form_mapds").serialize();
                var action = $('#add_penarikan_diri_srs').val();
                var btn_text;
                if (action == 'add') {
                    url = add_penarikan_diri_srs_config.routes.add_penarikan_diri_srs_url;
                    type = "POST";
                    btn_text = 'Hantar Borang Penarikan Diri&nbsp;&nbsp;<i class="fa fa-send mr-2"></i>';
                }

                $.ajax({
                    url: url,
                    type: type,
                    data: data,
                }).done(function(response) {        
                    $('[name=mapds_srs_profile_id]').removeClass("is-invalid");
                    $('[name=mapds_ahli_peronda_id]').removeClass("is-invalid");
                    $('[name=mapds_alasan_id]').removeClass("is-invalid");
                    $('[name=mapds_penarikan_diri_nyatakan]').removeClass("is-invalid");
                    
                    if(response.errors){
                        $.each(response.errors, function(index, error){
                            if(index == 'mapds_srs_profile_id') {
                                $('[name=mapds_srs_profile_id]').addClass("is-invalid");
                                $('.error_mapds_srs_profile_id').html(error);
                            }

                            if(index == 'mapds_ahli_peronda_id') {
                                $('[name=mapds_ahli_peronda_id]').addClass("is-invalid");
                                $('.error_mapds_ahli_peronda_id').html(error);
                            }

                            if(index == 'mapds_alasan_id') {
                                $('[name=mapds_alasan_id]').addClass("is-invalid");
                                $('.error_mapds_alasan_id').html(error);
                            }

                            if(index == 'mapds_penarikan_diri_nyatakan') {
                                $('[name=mapds_penarikan_diri_nyatakan]').addClass("is-invalid");
                                $('.error_mapds_penarikan_diri_nyatakan').html(error);
                            }

                        });
                        $('#btn_save').html(btn_text);                
                        $('#btn_save').prop('disabled', false);            
                    } else {
                        $('#modal_add_penarikan_diri_srs').modal('hide');
                        swal("Maklumat Permohonan Penarikan Diri Ahli Srs Ada ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
                        $('#form_mapds').trigger("reset");
                        $('#senarai_penarikan_diri_ahli').DataTable().ajax.reload();
                        $('#btn_save').html(btn_text);                
                        $('#btn_save').prop('disabled', false);
                    }
                });
            });
    }

	

</script>