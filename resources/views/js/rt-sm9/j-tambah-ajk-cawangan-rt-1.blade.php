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
            $('#tacr_nama_krt').html("{{$ajk_cawangan->nama_krt}}");
            $('#tacr_alamat_krt').html("{{$ajk_cawangan->alamat_krt}}");
            $('#tacr_negeri_krt').html("{{$ajk_cawangan->negeri_krt}}");
            $('#tacr_parlimen_krt').html("{{$ajk_cawangan->parlimen_krt}}");
            $('#tacr_pbt_krt').html("{{$ajk_cawangan->pbt_krt}}");
            $('#tacr_daerah_krt').html("{{$ajk_cawangan->daerah_krt}}");
            $('#tacr_dun_krt').html("{{$ajk_cawangan->dun_krt}}");

        /* Maklumat Asas */
            $('#tacr_cawangan_id').val("{{$ajk_cawangan->cawangan_id}}");
            $('#tacr_1_ajk_nama').val("{{$ajk_cawangan->ajk_nama}}");
            $('#tacr_1_ajk_tarikh_lahir').val("{{$ajk_cawangan->ajk_tarikh_lahir}}");
            $('#tacr_1_jantina_id').val("{{$ajk_cawangan->jantina_id}}");
            $('#tacr_1_kaum_id').val("{{$ajk_cawangan->kaum_id}}");
            $('#tacr_1_ajk_ic').val("{{$ajk_cawangan->ajk_ic}}");
            $('#tacr_1_status_perkahwinan_id').val("{{$ajk_cawangan->status_perkahwinan_id}}");
            $('#tacr_1_ajk_alamat').val("{{$ajk_cawangan->ajk_alamat}}");
            $('#tacr_1_ajk_poskod').val("{{$ajk_cawangan->ajk_poskod}}");
            $('#tacr_1_ajk_phone').val("{{$ajk_cawangan->ajk_phone}}");
            $('#tacr_1_ajk_email').val("{{$ajk_cawangan->ajk_email}}");
            $('#tacr_1_jawatan_cawangan_id').val("{{$ajk_cawangan->jawatan_cawangan_id}}");
            $('#tacr_1_ajk_alamat').on("paste",function(e) {
                e.preventDefault();
            });
            $('#tacr_1_ajk_alamat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
            $('#tacr_1_ajk_ic').mask('999999999999');
            
        /* Maklumat Akademik */
            $('#tacr_2_ajk_cawangan_id').val("{{$ajk_cawangan->id}}");

        //my custom script
            url_add_pendidikan      = "{{ route('rt-sm9.get_pendidikan_table','') }}"+"/"+"{{$ajk_cawangan->id}}";
            url_delete_pendidikan 	= "{{ route('rt-sm9.delete_pendidikans','') }}";

            var senarai_pendidikan_table = $('#senarai_pendidikan_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_add_pendidikan,
                "language": {
                    "paginate": {
                        "previous": "Sebelumnya",
                        "next": "Seterusnya",
                        searchPanes: {
                            emptyPanes: 'There are no panes to display. :/'
                        }
                    },
                    "sSearch": "Carian",
                    "sLengthMenu": "Paparan _MENU_ rekod",
                    "lengthMenu": "Paparan _MENU_ rekod setiap laman",
                    "zeroRecords": "Tiada rekod ditemui",
                    "info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
                    "infoEmpty": "",
                    "infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
                },
                dom: 'rtip',
                "bFilter": true,
                "bSort": false,
                responsive: true,
                "aoColumnDefs":[{          
                    "aTargets": [ 0 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function (data, type, full, meta)  {
                        return  meta.row+1;
                    }
                },{          
                    "aTargets": [ 1 ], 
                    "width": "29%", 
                    "mRender": function ( value, type, full )  {
                        return full.pendidikan_description;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "29%", 
                    "mRender": function ( value, type, full )  {
                        return full.akademik_tahun;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "29%", 
                    "mRender": function ( value, type, full )  {
                        return full.akademik_pencapaian;
                    }
                },{          
                    "aTargets": [ 4 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete-pendidikan" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
                        return button_a;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

        /* Maklumat Note Kemaskini */
            $('#tacr_status').val("{{$ajk_cawangan->ajk_status_form}}");
            
            if($('#tacr_status').val() == '7'){
                $("#tacr_perlu_kemaskini").show();
                $('#tacr_status_description').html("{{$ajk_cawangan->status_description}}");
                $('#tacr_disemak_note').html("{{$ajk_cawangan->disemak_note}}");
            }

            if($('#tacr_status').val() == '8'){
                $("#tacr_perlu_kemaskini").show();
                $('#tacr_status_description').html("{{$ajk_cawangan->status_description}}");
                $('#tacr_diakui_note').html("{{$ajk_cawangan->diakui_note}}");
            }

        /* Button Next */
            $('#tacr_3_ajk_cawangan_id').val("{{$ajk_cawangan->id}}");

    });

    /* click add Pendidikan */
        $(document).on('submit', '#form_tacr_2', function(event){
            var info = $('.error_form_tacr_2');
            event.preventDefault();

            $('#btn-save-pendidikan').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn-save-pendidikan').prop('disabled', true);

            var data = $("#form_tacr_2").serialize();
            btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
            url = "{{ route('rt-sm9.post_pendidikan') }}";
            type = "POST";

            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {            
                info.hide().find('ul').empty();
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        info.find('ul').append('<li>'+error+'</li>');
                    });
                    $('#btn-save-pendidikan').html(btn_text);                
                    $('#btn-save-pendidikan').prop('disabled', false);
                    info.slideDown();
                } else {
                    swal("Pendidikan ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
                    $('#form_tacr_2').trigger("reset");
                    $('#btn-save-pendidikan').html(btn_text);
                    $('#btn-save-pendidikan').prop('disabled', false);
                    $('#senarai_pendidikan_table').DataTable().ajax.reload();
                }
            });
        });

    /* click delete Pendidikan */
        $('body').on('click', '#delete-pendidikan', function () {
            var delete_id = $(this).data("id");
            swal({
                title: "Anda pasti?",
                text: "Anda akan memadam rekod ini dari pangkalan data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                confirmButtonText: "Ya, sila padam!",
                cancelButtonText: "Tidak",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "GET",
                        url: url_delete_pendidikan +"/" + delete_id,
                        success: function (data) {
                            // $('#peranan_form').trigger("reset");
                            $('#senarai_pendidikan_table').DataTable().ajax.reload();
                            swal("Sudah dipadam!", "Rekod peranan telah dipadam dari pangkalan data", "success");
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });                    
                } else {
                    swal("Tidak", "Proses pemadaman tidak berlaku", "error");
                }
            });
        });

    //my custom script
        var tambah_ajk_cawangan_rt_config = {
            routes: {
                tambah_ajk_cawangan_rt_url: "{{ route('rt-sm9.update_ajk_cawangan_rt') }}",
            }
        };

    /* Button Next */
        $(document).on('submit', '#form_tacr_3', function(event){    
            event.preventDefault();
            $('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_next').prop('disabled', true);
            var data   = $("#form_tacr, #form_tacr_1, #form_tacr_3").serialize();
            var action = $('#update_ajk_cawangan_rt').val();
            var btn_text;
            if (action == 'edit') {
                url = tambah_ajk_cawangan_rt_config.routes.tambah_ajk_cawangan_rt_url;
                type = "POST";
                btn_text = 'Seterusnya &nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=tacr_cawangan_id]').removeClass("is-invalid");
                $('[name=tacr_1_ajk_nama]').removeClass("is-invalid");
                $('[name=tacr_1_ajk_tarikh_lahir]').removeClass("is-invalid");
                $('[name=tacr_1_jantina_id]').removeClass("is-invalid");
                $('[name=tacr_1_jantina_id]').removeClass("is-invalid");
                $('[name=tacr_1_kaum_id]').removeClass("is-invalid");
                $('[name=tacr_1_status_perkahwinan_id]').removeClass("is-invalid");
                $('[name=tacr_1_ajk_alamat]').removeClass("is-invalid");
                $('[name=tacr_1_ajk_poskod]').removeClass("is-invalid");
                $('[name=tacr_1_ajk_phone]').removeClass("is-invalid");
                $('[name=tacr_1_ajk_email]').removeClass("is-invalid");
                $('[name=tacr_1_jawatan_cawangan_id]').removeClass("is-invalid");


                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'tacr_cawangan_id') {
                            $('[name=tacr_cawangan_id]').addClass("is-invalid");
                            $('.error_tacr_cawangan_id').html(error);
                        }

                        if(index == 'tacr_1_ajk_nama') {
                            $('[name=tacr_1_ajk_nama]').addClass("is-invalid");
                            $('.error_tacr_1_ajk_nama').html(error);
                        }

                        if(index == 'tacr_1_ajk_tarikh_lahir') {
                            $('[name=tacr_1_ajk_tarikh_lahir]').addClass("is-invalid");
                            $('.error_tacr_1_ajk_tarikh_lahir').html(error);
                        }

                        if(index == 'tacr_1_jantina_id') {
                            $('[name=tacr_1_jantina_id]').addClass("is-invalid");
                            $('.error_tacr_1_jantina_id').html(error);
                        }

                        if(index == 'tacr_1_kaum_id') {
                            $('[name=tacr_1_kaum_id]').addClass("is-invalid");
                            $('.error_tacr_1_kaum_id').html(error);
                        }

                        if(index == 'tacr_1_ajk_ic') {
                            $('[name=tacr_1_ajk_ic]').addClass("is-invalid");
                            $('.error_tacr_1_ajk_ic').html(error);
                        }

                        if(index == 'tacr_1_status_perkahwinan_id') {
                            $('[name=tacr_1_status_perkahwinan_id]').addClass("is-invalid");
                            $('.error_tacr_1_status_perkahwinan_id').html(error);
                        }

                        if(index == 'tacr_1_ajk_alamat') {
                            $('[name=tacr_1_ajk_alamat]').addClass("is-invalid");
                            $('.error_tacr_1_ajk_alamat').html(error);
                        }

                        if(index == 'tacr_1_ajk_poskod') {
                            $('[name=tacr_1_ajk_poskod]').addClass("is-invalid");
                            $('.error_tacr_1_ajk_poskod').html(error);
                        }

                        if(index == 'tacr_1_ajk_phone') {
                            $('[name=tacr_1_ajk_phone]').addClass("is-invalid");
                            $('.error_tacr_1_ajk_phone').html(error);
                        }

                        if(index == 'tacr_1_ajk_email') {
                            $('[name=tacr_1_ajk_email]').addClass("is-invalid");
                            $('.error_tacr_1_ajk_email').html(error);
                        }

                        if(index == 'tacr_1_jawatan_cawangan_id') {
                            $('[name=tacr_1_jawatan_cawangan_id]').addClass("is-invalid");
                            $('.error_tacr_1_jawatan_cawangan_id').html(error);
                        }
                    });
                    $('#btn_next').html(btn_text);                
                    $('#btn_next').prop('disabled', false);            
                } else {
                    $('#btn_next').html(btn_text);
                    $('#btn_next').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm9.tambah_ajk_cawangan_rt_2','')}}"+"/"+{{$ajk_cawangan->id}};
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
@stop