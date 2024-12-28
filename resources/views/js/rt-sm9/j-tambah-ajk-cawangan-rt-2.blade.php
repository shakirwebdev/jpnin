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
            $('#tacr_4_nama_krt').html("{{$ajk_cawangan->nama_krt}}");
            $('#tacr_4_alamat_krt').html("{{$ajk_cawangan->alamat_krt}}");
            $('#tacr_4_negeri_krt').html("{{$ajk_cawangan->negeri_krt}}");
            $('#tacr_4_parlimen_krt').html("{{$ajk_cawangan->parlimen_krt}}");
            $('#tacr_4_pbt_krt').html("{{$ajk_cawangan->pbt_krt}}");
            $('#tacr_4_daerah_krt').html("{{$ajk_cawangan->daerah_krt}}");
            $('#tacr_4_dun_krt').html("{{$ajk_cawangan->dun_krt}}");

        /* Maklumat Cawangan RT */
            $('#tacr_4_cawangan_id').val("{{$ajk_cawangan->cawangan_id}}");

        /* Maklumat Kerjaya */
            $('#tacr_8_ajk_cawangan_id').val("{{$ajk_cawangan->id}}");
            $('input:radio').click(function() { 
                $("#tacr_4_ajk_pekerjaan_jawatan").prop("disabled",true);
                $("#tacr_4_ajk_pekerjaan_bidang").prop("disabled",true);
                $("#tacr_4_ajk_pekerjaan_pengalaman").prop("disabled",true);
                if($(this).hasClass('enable_tb')) {
                    $("#tacr_4_ajk_pekerjaan_jawatan").prop("disabled",false);
                    $("#tacr_4_ajk_pekerjaan_bidang").prop("disabled",false);
                    $("#tacr_4_ajk_pekerjaan_pengalaman").prop("disabled",false);
                }
            });
           
            
            if("{{$ajk_cawangan->status_perkejaan_id}}" == ''){
                
            }else{
                $("input[name=tacr_4_status_perkejaan_id][value=" + "{{$ajk_cawangan->status_perkejaan_id}}" + "]").prop('checked', true);
                $("#tacr_4_ajk_pekerjaan_jawatan").prop("disabled",false);
                $("#tacr_4_ajk_pekerjaan_bidang").prop("disabled",false);
                $("#tacr_4_ajk_pekerjaan_pengalaman").prop("disabled",false);
            }

            $('#tacr_4_ajk_pekerjaan_jawatan').val("{{$ajk_cawangan->ajk_pekerjaan_jawatan}}");
            $('#tacr_4_ajk_pekerjaan_bidang').val("{{$ajk_cawangan->ajk_pekerjaan_bidang}}");
            $('#tacr_4_ajk_pekerjaan_pengalaman').val("{{$ajk_cawangan->ajk_pekerjaan_pengalaman}}");
            $('#tacr_4_ajk_pekerjaan_pengalaman').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

        /* Maklumat Pengalaman */
            $('#tacr_6_ajk_cawangan_id').val("{{$ajk_cawangan->id}}");
        
            //my custom script
            url_table_pengalaman      = "{{ route('rt-sm9.get_pengalaman_table','') }}"+"/"+"{{$ajk_cawangan->id}}";
            url_delete_pengalaman 	  = "{{ route('rt-sm9.delete_pengalaman','') }}";

            var senarai_pengalaman_table = $('#senarai_pengalaman_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_table_pengalaman,
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
                    "width": "10%", 
                    "mRender": function ( value, type, full )  {
                        return full.pengalaman_tahun;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "78%", 
                    "mRender": function ( value, type, full )  {
                        return full.pengalaman_program;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete-pengalaman" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
                        return button_a;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

        /* Maklumat Kemahiran & Hobi */
            $('#tacr_4_ajk_kemahiran').val("{{$ajk_cawangan->ajk_kemahiran}}");
            $('#tacr_4_ajk_minat').val("{{$ajk_cawangan->ajk_minat}}");
            $('#tacr_4_ajk_kemahiran').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
            $('#tacr_4_ajk_minat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
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
    });

    /* click add Pengalaman */
        $(document).on('submit', '#form_tacr_6', function(event){
            var info = $('.error_form_tacr_6');
            event.preventDefault();

            $('#btn-save-pengalaman').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn-save-pengalaman').prop('disabled', true);

            var data = $("#form_tacr_6").serialize();
            btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
            url = "{{ route('rt-sm9.post_pengalaman') }}";
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
                    $('#btn-save-pengalaman').html(btn_text);                
                    $('#btn-save-pengalaman').prop('disabled', false);
                    info.slideDown();
                } else {
                    swal("Pengalaman / Penglibatan dalam aktiviti / program kesukarelawanan ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
                    $('#form_tacr_6').trigger("reset");
                    $('#btn-save-pengalaman').html(btn_text);
                    $('#btn-save-pengalaman').prop('disabled', false);
                    $('#senarai_pengalaman_table').DataTable().ajax.reload();
                }
            });
        });

    /* click delete Pengalaman */
        $('body').on('click', '#delete-pengalaman', function () {
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
                        url: url_delete_pengalaman +"/" + delete_id,
                        success: function (data) {
                            // $('#peranan_form').trigger("reset");
                            $('#senarai_pengalaman_table').DataTable().ajax.reload();
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
        var tambah_ajk_cawangan_rt_2_config = {
            routes: {
                tambah_ajk_cawangan_rt_2_url: "{{ route('rt-sm9.update_ajk_cawangan_rt_2') }}",
            }
        };

    /* Button Send */
        $(document).on('submit', '#form_tacr_8', function(event){    
            event.preventDefault();
            $('#btn_send').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_send').prop('disabled', true);
            var data   = $("#form_tacr_5, #form_tacr_7, #form_tacr_8").serialize();
            var action = $('#update_ajk_cawangan_rt_2').val();
            var btn_text;
            if (action == 'edit') {
                url = tambah_ajk_cawangan_rt_2_config.routes.tambah_ajk_cawangan_rt_2_url;
                type = "POST";
                btn_text = 'Hantar Profil AJK Cawangan &nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=tacr_4_status_perkejaan_id]').removeClass("is-invalid");
                $('[name=tacr_4_ajk_pekerjaan_jawatan]').removeClass("is-invalid");
                $('[name=tacr_4_ajk_pekerjaan_bidang]').removeClass("is-invalid");
                $('[name=tacr_4_ajk_pekerjaan_pengalaman]').removeClass("is-invalid");
                $('[name=tacr_4_ajk_kemahiran]').removeClass("is-invalid");
                $('[name=tacr_4_ajk_minat]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'tacr_4_status_perkejaan_id') {
                            $('[name=tacr_4_status_perkejaan_id]').addClass("is-invalid");
                            $('.error_tacr_4_status_perkejaan_id').html(error);
                        }

                        if(index == 'tacr_4_ajk_pekerjaan_jawatan') {
                            $('[name=tacr_4_ajk_pekerjaan_jawatan]').addClass("is-invalid");
                            $('.error_tacr_4_ajk_pekerjaan_jawatan').html(error);
                        }

                        if(index == 'tacr_4_ajk_pekerjaan_bidang') {
                            $('[name=tacr_4_ajk_pekerjaan_bidang]').addClass("is-invalid");
                            $('.error_tacr_4_ajk_pekerjaan_bidang').html(error);
                        }

                        if(index == 'tacr_4_ajk_pekerjaan_pengalaman') {
                            $('[name=tacr_4_ajk_pekerjaan_pengalaman]').addClass("is-invalid");
                            $('.error_tacr_4_ajk_pekerjaan_pengalaman').html(error);
                        }

                        if(index == 'tacr_4_ajk_kemahiran') {
                            $('[name=tacr_4_ajk_kemahiran]').addClass("is-invalid");
                            $('.error_tacr_4_ajk_kemahiran').html(error);
                        }

                        if(index == 'tacr_4_ajk_minat') {
                            $('[name=tacr_4_ajk_minat]').addClass("is-invalid");
                            $('.error_tacr_4_ajk_minat').html(error);
                        }

                        if(index == 'tacr_1_ajk_alamat') {
                            $('[name=tacr_1_ajk_alamat]').addClass("is-invalid");
                            $('.error_tacr_1_ajk_alamat').html(error);
                        }

                    });
                    $('#btn_send').html(btn_text);                
                    $('#btn_send').prop('disabled', false);            
                } else {
                    $('#btn_send').html(btn_text);
                    $('#btn_send').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm9.tambah_ajk_cawangan_rt')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop