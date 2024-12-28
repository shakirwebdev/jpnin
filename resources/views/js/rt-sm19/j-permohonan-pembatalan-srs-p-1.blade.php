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
            $('#ppsp_nama_krt').html("{{$pembatalan_srs->nama_krt}}");
            $('#ppsp_alamat_krt').html("{{$pembatalan_srs->alamat_krt}}");
            $('#ppsp_negeri_krt').html("{{$pembatalan_srs->negeri_krt}}");
            $('#ppsp_parlimen_krt').html("{{$pembatalan_srs->parlimen_krt}}");
            $('#ppsp_pbt_krt').html("{{$pembatalan_srs->pbt_krt}}");
            $('#ppsp_daerah_krt').html("{{$pembatalan_srs->daerah_krt}}");
            $('#ppsp_dun_krt').html("{{$pembatalan_srs->dun_krt}}");

        /* Maklumat Pemohon */
            $('#ppsp_pemohon_name').val("{{$user_profile->pemohon_name}}");
            $('#ppsp_pemohon_ic').val("{{$user_profile->pemohon_ic}}");
            $('#ppsp_pemohon_address').val("{{$user_profile->pemohon_address}}");


        /* Maklumat Pembatalan Srs */
            $('#ppsp_srs_profile_id').val("{{$pembatalan_srs->srs_profile_id}}");
            $('#ppsp2_pembatalan_srs_id').val("{{$pembatalan_srs->id}}");
            url_senarai_minit_meeting_table 	= "{{ route('rt-sm19.get_senarai_minit_meeting_pembatalan_table','') }}"+"/"+"{{$pembatalan_srs->id}}";
            url_senarai_minit_meeting_delete  	= "{{ route('rt-sm19.delete_senarai_minit_meeting_pembatalan','') }}";

            var senarai_minit_meeting_table = $('#senarai_minit_meeting_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_senarai_minit_meeting_table,
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
					"width": "60%", 
					"mRender": function ( value, type, full )  {
						return full.mesyuarat_title;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					"mRender": function ( value, type, full )  {
						return full.keterangan;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%",
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Cetak Minit Mesyuarat JawatanKuasa" target="_blank" onclick="print_minit_mesyuarat(\'' + full.minit_mesyuarat_id + '\');"><i class="fa fa-print"></i></button>';
						button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_minit_meeting" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a + button_b;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

            $('#ppsp3_pembatalan_srs_id').val("{{$pembatalan_srs->id}}");

            $('#ppsp2_minit_mesyuarat_id').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
			$('#ppsp2_minit_mesyuarat_id').on("paste",function(e) {
                e.preventDefault();
            });

            $('#btn_back').click(function(){
                window.location.href = "{{route('rt-sm19.permohonan_pembatalan_srs_p')}}";
            });

        /* Maklumat Error */
            $('#ppsp_pembatalan_status').val("{{$pembatalan_srs->pembatalan_status}}");
            $('#ppsp_status_description').html("{{$pembatalan_srs->status_description}}");
            $('#ppsp_disemak_note').html("{{$pembatalan_srs->disemak_note}}");

            if($('#ppsp_pembatalan_status').val() == '5'){
                $("#ppsp_perlu_kemaskini").show();
            }
        
    });

    /* click add minit meeting */
        $(document).on('submit', '#form_ppsp2', function(event){
            var info = $('.error_alert_ppsp2');
            event.preventDefault();

            $('#btn_add_minit_meeting_pembatalan').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_add_minit_meeting_pembatalan').prop('disabled', true);

            var data = $("#form_ppsp2").serialize();
            btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
            url = "{{ route('rt-sm19.post_minit_meeting_pembatalan_srs') }}";
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
                    $('#btn_add_minit_meeting_pembatalan').html(btn_text);                
                    $('#btn_add_minit_meeting_pembatalan').prop('disabled', false);
                    info.slideDown();
                } else {
                    swal("Senarai Minit Meeting ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
                    $('#form_pps7').trigger("reset");
                    $('#btn_add_minit_meeting_pembatalan').html(btn_text);
                    $('#btn_add_minit_meeting_pembatalan').prop('disabled', false);
                    $('#senarai_minit_meeting_table').DataTable().ajax.reload();
                }
            });
        });

    /* click button print minit meeting */
        function print_minit_mesyuarat(id){
            window.location.href = "{{route('pdf.minit_mesyuarat','')}}"+"/"+id;
        }

    /* click delete minit meeting */
        $('body').on('click', '#delete_minit_meeting', function () {
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
                        url: url_senarai_minit_meeting_delete +"/" + delete_id,
                        success: function (data) {
                            // $('#peranan_form').trigger("reset");
                            $('#senarai_minit_meeting_table').DataTable().ajax.reload();
                            swal("Sudah dipadam!", "Rekod telah dipadam dari pangkalan data", "success");
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

    /* click btn hantar pembatalan srs */

        var hantar_pembatalan_srs_config = {
            routes: {
                hantar_pembatalan_srs_url: "{{ route('rt-sm19.post_create_permohonan_pembatalan_srs_1') }}",
            }
        };

        $(document).on('submit', '#form_ppsp3', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data   = $("#form_ppsp, #form_ppsp3").serialize();
            var action = $('#post_create_permohonan_pembatalan_srs_1').val();
            var btn_text;
            if (action == 'edit') {
                url = hantar_pembatalan_srs_config.routes.hantar_pembatalan_srs_url;
                type = "POST";
                btn_text = 'Hantar Permohonan Pembatalan SRS&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=ppsp_srs_profile_id]').removeClass("is-invalid");
            
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'ppsp_srs_profile_id') {
                            $('[name=ppsp_srs_profile_id]').addClass("is-invalid");
                            $('.error_ppsp_srs_profile_id').html(error);
                        }

                    });
                    $('#btn_submit').html(btn_text);                
                    $('#btn_submit').prop('disabled', false);            
                } else {
                    $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm19.permohonan_pembatalan_srs_p')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop