<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>
    //my custom script
    var senarai_penarikan_diri_config = {
            routes: {
                senarai_penarikan_diri_url: "{{ route('rt-sm18.get_view_permohonan_penarikan_diri','') }}"
            }
    };

    function load_sah_penarikan_diri_srs(id) {

        $.get(senarai_penarikan_diri_config.routes.senarai_penarikan_diri_url + '/' + id, function (data) {
            $('#mspds_srs_profile_id').val(data.srs_profile_id);
            $('#mspds_ahli_peronda_id').val(data.ahli_peronda_id);
            $('#mspds_peronda_ic').val(data.peronda_ic);
            $('#mspds_peronda_alamat').val(data.peronda_alamat);
            var alasan = (data.alasan_id);
			$("input[name=mspds_alasan_id][value=" + alasan + "]").prop('checked', true);
            $('#mspds_penarikan_diri_nyatakan').val(data.penarikan_diri_nyatakan);
            $('#mspds_penarikan_diri_id').val(data.id);
            $('#mspds_ahli_peronda_srs_id').val(data.ahli_peronda_id);
            
            $('#modal_sah_penarikan_diri_srs').modal('show');
        });

        /* Pengesahan Penarikan Diri */
            //my custom script
            var sah_penarikan_diri_srs_config = {
                routes: {
                    sah_penarikan_diri_srs_url: "{{ route('rt-sm18.post_sahkan_penarikan_diri_srs') }}",
                }
            };

            $(document).on('submit', '#form_mspds', function(event){    
                event.preventDefault();
                $('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
                $('#btn_save').prop('disabled', true);
                var data = $("#form_mspds").serialize();
                var action = $('#post_sahkan_penarikan_diri_srs').val();
                var btn_text;
                if (action == 'edit') {
                    url = sah_penarikan_diri_srs_config.routes.sah_penarikan_diri_srs_url;
                    type = "POST";
                    btn_text = 'Hantar Pengesahan Penarikan Diri&nbsp;&nbsp;<i class="fa fa-send mr-2"></i>';
                }

                $.ajax({
                    url: url,
                    type: type,
                    data: data,
                }).done(function(response) {        
                    $('[name=mspds_penarikan_diri_status]').removeClass("is-invalid");
                    
                    
                    if(response.errors){
                        $.each(response.errors, function(index, error){
                            if(index == 'mspds_penarikan_diri_status') {
                                $('[name=mspds_penarikan_diri_status]').addClass("is-invalid");
                                $('.error_mspds_penarikan_diri_status').html(error);
                            }

                        });
                        $('#btn_save').html(btn_text);                
                        $('#btn_save').prop('disabled', false);            
                    } else {
                        $('#modal_sah_penarikan_diri_srs').modal('hide');
                        swal("Pengesahan Permohonan Penarikan Diri Ahli Srs Ada ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
                        $('#form_mspds').trigger("reset");
                        $('#senarai_penarikan_diri_ahli').DataTable().ajax.reload();
                        $('#btn_save').html(btn_text);                
                        $('#btn_save').prop('disabled', false);
                    }
                });
            });
       
    }

	

</script>