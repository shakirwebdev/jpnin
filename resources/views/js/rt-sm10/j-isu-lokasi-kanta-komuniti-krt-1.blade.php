
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
            url_bil_mengikut_kaum	        = "{{ route('rt-sm10.get_senarai_terlibat_table','') }}"+"/"+"{{$isu_lokasi_kk->id}}";
            url_delete_bil_mengikut_kaum 	= "{{ route('rt-sm10.delete_isu_lokasi_kk_terlibat','') }}";

        /* Maklumat Kawasan Krt */
            $('#ilkk_nama_krt').html("{{$isu_lokasi_kk->nama_krt}}");
            $('#ilkk_alamat_krt').html("{{$isu_lokasi_kk->alamat_krt}}");
            $('#ilkk_negeri_krt').html("{{$isu_lokasi_kk->negeri_krt}}");
            $('#ilkk_parlimen_krt').html("{{$isu_lokasi_kk->parlimen_krt}}");
            $('#ilkk_pbt_krt').html("{{$isu_lokasi_kk->pbt_krt}}");
            $('#ilkk_daerah_krt').html("{{$isu_lokasi_kk->daerah_krt}}");
            $('#ilkk_dun_krt').html("{{$isu_lokasi_kk->dun_krt}}");

        /* Maklumat Koperasi */
            $('#ilkk2_isu_lokasi_kk_id').val("{{$isu_lokasi_kk->id}}");
			$('#ilkk1_isu_lokasi_kanta_komuniti').val("{{$isu_lokasi_kk->isu_lokasi_kanta_komuniti}}");
			$('#ilkk1_isu_bil_terlibat').val("{{$isu_lokasi_kk->isu_bil_terlibat}}");
			$('#ilkk1_isu_kluster').val("{{$isu_lokasi_kk->isu_kluster}}");
			$('#ilkk3_isu_pelaksanan_daerah').val("{{$isu_lokasi_kk->isu_pelaksanan_daerah}}");
			$('#ilkk3_isu_pelaksanan_negeri').val("{{$isu_lokasi_kk->isu_pelaksanan_negeri}}");
			$('#ilkk3_isu_agensi_terlibat').val("{{$isu_lokasi_kk->isu_agensi_terlibat}}");
			if("{{$isu_lokasi_kk->isu_status}}" == ''){

			}else{
				$("input[name=ilkk3_isu_status][value=" + "{{$isu_lokasi_kk->isu_status}}" + "]").prop('checked', true);
			}
			
            var senarai_terlibat_table = $('#senarai_terlibat_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_bil_mengikut_kaum,
				"language": {
					"paginate": {
						"previous": "Sebelumnya",
						"next": "Seterusnya",
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
					"width": "22%", 
					"mRender": function ( value, type, full )  {
						return full.bilangan;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "22%", 
					"mRender": function ( value, type, full )  {
						return full.kaum_description;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "22%", 
					"mRender": function ( value, type, full )  {
						return full.jantina_description;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "22%", 
					"mRender": function ( value, type, full )  {
						return full.umur;
					}
				},{          
					"aTargets": [ 5 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_senarai_terlibat" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

            $('#ilkk3_isu_pelaksanan_daerah').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
			$('#ilkk4_isu_lokasi_kk_id').val("{{$isu_lokasi_kk->id}}");
			
        
        /* Maklumat Note Kemaskini */   
            $('#ilkk_status').val("{{$isu_lokasi_kk->status}}"); 

            if($('#ilkk_status').val() == '5'){
                $("#ilkk_perlu_kemaskini").show();
                $('#ilkk_status_description').html("{{$isu_lokasi_kk->status_desc}}");
                $('#ilkk_disemak_note').html("{{$isu_lokasi_kk->disemak_note}}");
            }

            if($('#ilkk_status').val() == '7'){
                $("#ilkk_perlu_kemaskini").show();
                $('#ilkk_status_description').html("{{$isu_lokasi_kk->status_desc}}");
                $('#ilkk_disahkan_note').html("{{$isu_lokasi_kk->disahkan_note}}");
            }
        
        /* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{ route('rt-sm10.isu_lokasi_kanta_komuniti_krt') }}";
            });

	});

    /* click add bilangan kaum terlibat */
		$(document).on('submit', '#form_ilkk2', function(event){
			var info = $('.error_alert');
			event.preventDefault();

			$('#btn_save_bil_kaum').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save_bil_kaum').prop('disabled', true);

			var data = $("#form_ilkk2").serialize();
			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm10.post_isu_lokasi_kk_terlibat') }}";
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
					$('#btn_save_bil_kaum').html(btn_text);                
					$('#btn_save_bil_kaum').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Bilangan Kaum Yang Terlibat ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_ilkk2').trigger("reset");
					$('#btn_save_bil_kaum').html(btn_text);
					$('#btn_save_bil_kaum').prop('disabled', false);
					$('#senarai_terlibat_table').DataTable().ajax.reload();
				}
			});
		});

    /* click delete bilangan kaum terlibat */
		$('body').on('click', '#delete_senarai_terlibat', function () {
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
						url: url_delete_bil_mengikut_kaum +"/" + delete_id,
						success: function (data) {
							$('#senarai_terlibat_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Bilangan Kaum Yang Terlibat telah dipadam dari pangkalan data", "success");
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

    /* action submit */
        //my custom script
        var submit_isu_lokasi_kanta_komuniti_config = {
            routes: {
                submit_isu_lokasi_kanta_komuniti_url: "{{ route('rt-sm10.post_lapor_isu_lokasi_kanta_komuniti_1') }}",
            }
        };

        $(document).on('submit', '#form_ilkk4', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_ilkk1, #form_ilkk3, #form_ilkk4").serialize();
            var action = $('#post_lapor_isu_lokasi_kanta_komuniti_1').val();
            var btn_text;
            if (action == 'edit') {
                url = submit_isu_lokasi_kanta_komuniti_config.routes.submit_isu_lokasi_kanta_komuniti_url;
                type = "POST";
                btn_text = 'Hantar Lapor Isu Dan Masalah Lokasi Kanta Komuniti &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=ilkk1_isu_lokasi_kanta_komuniti]').removeClass("is-invalid");
                $('[name=ilkk1_isu_bil_terlibat]').removeClass("is-invalid");
                $('[name=ilkk1_isu_kluster]').removeClass("is-invalid");
                $('[name=ilkk3_isu_pelaksanan_daerah]').removeClass("is-invalid");
                $('[name=ilkk3_isu_pelaksanan_negeri]').removeClass("is-invalid");
                $('[name=ilkk3_isu_agensi_terlibat]').removeClass("is-invalid");
                $('[name=ilkk3_isu_status]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'ilkk1_isu_lokasi_kanta_komuniti') {
                        $('[name=ilkk1_isu_lokasi_kanta_komuniti]').addClass("is-invalid");
                        $('.error_ilkk1_isu_lokasi_kanta_komuniti').html(error);
                    }

                    if(index == 'ilkk1_isu_bil_terlibat') {
                        $('[name=ilkk1_isu_bil_terlibat]').addClass("is-invalid");
                        $('.error_ilkk1_isu_bil_terlibat').html(error);
                    }

                    if(index == 'ilkk1_isu_kluster') {
                        $('[name=ilkk1_isu_kluster]').addClass("is-invalid");
                        $('.error_ilkk1_isu_kluster').html(error);
                    }

                    if(index == 'ilkk3_isu_pelaksanan_daerah') {
                        $('[name=ilkk3_isu_pelaksanan_daerah]').addClass("is-invalid");
                        $('.error_ilkk3_isu_pelaksanan_daerah').html(error);
                    }

                    if(index == 'ilkk3_isu_pelaksanan_negeri') {
                        $('[name=ilkk3_isu_pelaksanan_negeri]').addClass("is-invalid");
                        $('.error_ilkk3_isu_pelaksanan_negeri').html(error);
                    }

                    if(index == 'ilkk3_isu_agensi_terlibat') {
                        $('[name=ilkk3_isu_agensi_terlibat]').addClass("is-invalid");
                        $('.error_ilkk3_isu_agensi_terlibat').html(error);
                    }

                    if(index == 'ilkk3_isu_status') {
                        $('[name=ilkk3_isu_status]').addClass("is-invalid");
                        $('.error_ilkk3_isu_status').html(error);
                    }
                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
                $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm10.isu_lokasi_kanta_komuniti_krt')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop