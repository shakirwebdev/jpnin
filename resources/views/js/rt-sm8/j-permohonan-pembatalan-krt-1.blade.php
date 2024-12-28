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
            $('#ppk_nama_krt').html("{{$pembatalan_krt->nama_krt}}");
            $('#ppk_alamat_krt').html("{{$pembatalan_krt->alamat_krt}}");
            $('#ppk_negeri_krt').html("{{$pembatalan_krt->negeri_krt}}");
            $('#ppk_parlimen_krt').html("{{$pembatalan_krt->parlimen_krt}}");
            $('#ppk_pbt_krt').html("{{$pembatalan_krt->pbt_krt}}");
            $('#ppk_daerah_krt').html("{{$pembatalan_krt->daerah_krt}}");
            $('#ppk_dun_krt').html("{{$pembatalan_krt->dun_krt}}");

        /* Maklumat Pemohon */
            $('#ppk_pemohon_name').val("{{$user_profile->pemohon_name}}");
            $('#ppk_pemohon_ic').val("{{$user_profile->pemohon_ic}}");
            $('#ppk_pemohon_address').val("{{$user_profile->pemohon_address}}");

        /* Maklumat Pembatalan Krt */
            $('#ppk4_krt_pembatalan_id').val("{{$pembatalan_krt->id}}");
            $('#ppk_tujuan_pembatalan_id_checked').val("{{$pembatalan_krt->tujuan_pembatalan_id}}");
            
            if($('#ppk_tujuan_pembatalan_id_checked').val() == ''){
                
            }
            if($('#ppk_tujuan_pembatalan_id_checked').val() != ''){
                $("input[name=ppk_tujuan_pembatalan_id][value=" + "{{$pembatalan_krt->tujuan_pembatalan_id}}" + "]").prop('checked', true);
            }

            $('#ppk_nyatakan_tujuan').val("{{$pembatalan_krt->nyatakan_tujuan}}");

            if($('#ppk_nyatakan_tujuan').val() != ''){
                $("#ppk_nyatakan_tujuan").prop("disabled",false);
            }
            
            $('input:radio').click(function() { 
                $("#ppk_nyatakan_tujuan").prop("disabled",true);
                if($(this).hasClass('enable_tb')) {
                    $("#ppk_nyatakan_tujuan").prop("disabled",false);
                    
                }
            });

            $('#ppk2_krt_pembatalan_id').val("{{$pembatalan_krt->id}}");

            url_senarai_minit_meeting_table 	= "{{ route('rt-sm8.get_minit_meeting_pembatalan_krt_table','') }}"+"/"+"{{$pembatalan_krt->id}}";
            url_senarai_minit_meeting_delete  	= "{{ route('rt-sm8.delete_minit_meeting_pembatalan_krt','') }}";

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

            $('#ppk2_keterangan').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

        /* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{route('rt-sm8.permohonan_pembatalan_krt')}}";
            });

        /* Maklumat Note Kemaskini */   
            $('#ppk_status').val("{{$pembatalan_krt->status}}"); 

            if($('#ppk_status').val() == '5'){
                $("#ppk_perlu_kemaskini").show();
                $('#ppk_status_description').html("{{$pembatalan_krt->status_description}}");
                $('#ppk_disemak_note').html("{{$pembatalan_krt->disemak_note}}");
            }

            if($('#ppk_status').val() == '7'){
                $("#ppk_perlu_kemaskini").show();
                $('#ppk_status_description').html("{{$pembatalan_krt->status_description}}");
                $('#ppk_disokong_note').html("{{$pembatalan_krt->disokong_note}}");
            }

            if($('#ppk_status').val() == '8'){
                $("#ppk_perlu_kemaskini").show();
                $('#ppk_status_description').html("{{$pembatalan_krt->status_description}}");
                $('#ppk_diluluskan_note').html("{{$pembatalan_krt->diluluskan_note}}");
            }

	});

    /* click add minit meeting */
        $(document).on('submit', '#form_ppk2', function(event){
            var info = $('.error_alert_ppk2');
            event.preventDefault();

            $('#btn_add').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_add').prop('disabled', true);

            var data = $("#form_ppk2").serialize();
            btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
            url = "{{ route('rt-sm8.post_minit_meeting_pembatalan_krt') }}";
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
                    $('#btn_add').html(btn_text);                
                    $('#btn_add').prop('disabled', false);
                    info.slideDown();
                } else {
                    swal("Senarai Minit Meeting ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
                    $('#form_ppk2').trigger("reset");
                    $('#btn_add').html(btn_text);
                    $('#btn_add').prop('disabled', false);
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

    /* click btn hantar pembatalan krt */
        var hantar_pembatalan_krt_config = {
            routes: {
                hantar_pembatalan_krt_url: "{{ route('rt-sm8.post_create_permohonan_pembatalan_krt_1') }}",
            }
        };

        $(document).on('submit', '#form_ppk4', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data   = $("#form_ppk, #form_ppk4").serialize();
            var action = $('#post_create_permohonan_pembatalan_krt_1').val();
            var btn_text;
            if (action == 'edit') {
                url = hantar_pembatalan_krt_config.routes.hantar_pembatalan_krt_url;
                type = "POST";
                btn_text = 'Hantar Permohonan Pembatalan KRT&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=ppk_tujuan_pembatalan_id]').removeClass("is-invalid");
                $('[name=ppk_nyatakan_tujuan]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'ppk_tujuan_pembatalan_id') {
                            $('[name=ppk_tujuan_pembatalan_id]').addClass("is-invalid");
                            $('.error_ppk_tujuan_pembatalan_id').html(error);
                        }

                        if(index == 'ppk_nyatakan_tujuan') {
                            $('[name=ppk_nyatakan_tujuan]').addClass("is-invalid");
                            $('.error_ppk_nyatakan_tujuan').html(error);
                        }

                    });
                    $('#btn_submit').html(btn_text);                
                    $('#btn_submit').prop('disabled', false);            
                } else {
                    $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm8.permohonan_pembatalan_krt')}}";
                }
            });
        });
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop