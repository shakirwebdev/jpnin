@include('js.modal.j-modal-add-gambar-peronda-srs')
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
	.avatar {
        vertical-align: middle;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        border-color: black;
    }
</style>
<script type="text/javascript">    
    
	$(document).ready( function () {

		/* Maklumat Kawasan Krt */
			$('#paps_nama_krt').html("{{$srs_ahli_peronda->nama_krt}}");
			$('#paps_alamat_krt').html("{{$srs_ahli_peronda->alamat_krt}}");
			$('#paps_negeri_krt').html("{{$srs_ahli_peronda->negeri_krt}}");
			$('#paps_daerah_krt').html("{{$srs_ahli_peronda->daerah_krt}}");
			$('#paps_parlimen_krt').html("{{$srs_ahli_peronda->parlimen_krt}}");
			$('#paps_dun_krt').html("{{$srs_ahli_peronda->dun_krt}}");
			$('#paps_pbt_krt').html("{{$srs_ahli_peronda->pbt_krt}}");

		/* Maklumat Pemohonan Ahli Peronda SRS */
			$('#paps_ajk_gambar').attr('src', "{{ asset('storage/ahli_peronda_srs') }}"+"/"+ "{{$srs_ahli_peronda->file_gambar_profile}}");
			$('#paps_srs_profile_id').val("{{$srs_ahli_peronda->srs_profile_id}}");
			$('#paps_peronda_nama').val("{{$srs_ahli_peronda->peronda_nama}}");
			$('#paps_peronda_tarikh_lahir').val("{{$srs_ahli_peronda->peronda_tarikh_lahir}}");
			$('#paps_peronda_kaum').val("{{$srs_ahli_peronda->peronda_kaum}}");
			$('#paps_peronda_jantina').val("{{$srs_ahli_peronda->peronda_jantina}}");
			$('#paps_peronda_warganegara').val("{{$srs_ahli_peronda->peronda_warganegara}}");
			$('#paps_peronda_agama').val("{{$srs_ahli_peronda->peronda_agama}}");
			$('#paps_peronda_ic').val("{{$srs_ahli_peronda->peronda_ic}}");
			$('#paps_peronda_alamat').val("{{$srs_ahli_peronda->peronda_alamat}}");
			$('#paps_peronda_poskod').val("{{$srs_ahli_peronda->peronda_poskod}}");
			$('#paps_peronda_phone').val("{{$srs_ahli_peronda->peronda_phone}}");
			$('#paps_peronda_tarikh_lantikan').val("{{$srs_ahli_peronda->peronda_tarikh_lantikan}}");
			$('#paps_srs_ahli_peronda_id').val("{{$srs_ahli_peronda->id}}");
			$('#paps_peronda_ic').mask('999999999999');
			/*$('#paps_peronda_alamat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
			$('#paps_peronda_alamat').on("paste",function(e) {
                e.preventDefault();
            });*/
			$('#magps_ahli_peronda_id').val("{{$srs_ahli_peronda->id}}");

			url = "{{ route('rt-sm13.get_senarai_pendidikan_table','') }}"+"/"+"{{$srs_ahli_peronda->id}}";
			
			var senarai_pendidikan_table = $('#senarai_pendidikan_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url,
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
					"width": "60%", 
					"mRender": function ( value, type, full )  {
						return full.pendidikan_description;
					}
				},{       
					"aTargets": [ 2 ], 
					"width": "6%", 
					"mRender": function ( value, type, full )  {
						$checked 	= (full.srs_ahli_peronda_pendidikanID) ? 'checked' : '';
						$button_a 	= '<label class="custom-control custom-checkbox">' +
									'<input class="custom-control-input" type="checkbox" id="chkp_1' + full.id + '" value="' + full.id + '" onchange="getPendidikan(&apos;' + full.id + '&apos;)" ' +
									$checked + '>' +
									'<span class="custom-control-label">&nbsp;</span></label>';
						return $button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

		/* Maklumat Note Kemaskini */   
			$('#paps_status').val("{{$srs_ahli_peronda->status}}"); 

			if($('#paps_status').val() == '6'){
				$("#paps_perlu_kemaskini").show();
				$('#paps_status_description').html("{{$srs_ahli_peronda->status_description}}");
				$('#paps_disemak_note').html("{{$srs_ahli_peronda->disemak_note}}");
			}

		/* Button */   
			$('#btn_back').click(function(){
				window.location.href = '{{route('rt-sm13.senarai_pendaftaran_ahli_peronda_srs')}}';
			});

	});

	/* click add gambar ajk */
		var kemaskini_gambar_peronda_config = {
            routes: {
                kemaskini_gambar_peronda_url: "{{ route('post_add_gambar_peronda_srs') }}",
            }
        };

		$(document).on('submit', '#form_magps', function(event){    
            event.preventDefault();
            $('#btn_add').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_add').prop('disabled', true);
            var form_data = new FormData();
			form_data.append("magps_file_gambar_profile",  $("#magps_file_gambar_profile")[0].files[0]);
			form_data.append("magps_ahli_peronda_id", $("#magps_ahli_peronda_id").val() );
			form_data.append("post_add_gambar_peronda_srs", "edit" );
            var action = $('#post_add_gambar_peronda_srs').val();
            var btn_text;
			url = kemaskini_gambar_peronda_config.routes.kemaskini_gambar_peronda_url;
			type = "POST";
			btn_text = '<i class="fa fa-edit mr-2"></i>Kemaskini';
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
            $.ajax({
                url: url,
                type: type,
                data: form_data,
				contentType: false,
            	processData: false,
      			async: false,
            }).done(function(response) {        
                $('[name=magps_file_gambar_profile]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'magps_file_gambar_profile') {
                            $('[name=magps_file_gambar_profile]').addClass("is-invalid");
                            $('.error_magps_file_gambar_profile').html(error);
                        }

                    });
                    $('#btn_add').html(btn_text);                
                    $('#btn_add').prop('disabled', false);            
                } else {
                    $('#btn_add').html(btn_text);
                    $('#btn_add').prop('disabled', false); 
					$('#form_magps').trigger("reset");
                    window.location.href = "{{route('rt-sm13.pendaftaran_ahli_peronda_srs','')}}"+"/"+"{{$srs_ahli_peronda->id}}";
					$('#modal_add_gambar_peronda_srs').modal('hide');
                }
            });
        });

	function getPendidikan(id) {
		//checked
		if ($('#chkp_1' + id).is(':checked')) {
			// alert('checked');
			var paps_srs_ahli_peronda_id = $('#paps_srs_ahli_peronda_id').val();
			url_add_pendidikan = "{{ route('rt-sm13.add_pendidikan') }}";
			type = "POST";
			$.ajax({
				url: url_add_pendidikan,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"paps_srs_ahli_peronda_id": paps_srs_ahli_peronda_id,
						"srs_ahli_peronda_pendidikanID": id
						}
			});
		}

		//unchecked
		if (!$('#chkp_1' + id).is(':checked')) {
			// alert('unchecked');
            var paps_srs_ahli_peronda_id 	= $('#paps_srs_ahli_peronda_id').val();
			url_delete_pendidikan 	= "{{ route('rt-sm13.delete_pendidikan','') }}";
            type = "POST";
			$.ajax({
				url: url_delete_pendidikan,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"paps_srs_ahli_peronda_id": paps_srs_ahli_peronda_id,
						"srs_ahli_peronda_pendidikanID": id
						}
			});
			
		}
	}

	//my custom script
	var daftar_ahli_peronda_srs_config = {
        routes: {
            daftar_ahli_peronda_srs_action_url: "{{ route('rt-sm13.post_pendaftaran_ahli_peronda_srs') }}",
        }
    };

	$(document).on('submit', '#form_paps', function(event){    
        event.preventDefault();
        $('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
        $('#btn_next').prop('disabled', true);
        var data = $("#form_paps").serialize();
        var action = $('#post_pendaftaran_ahli_peronda_srs').val();
        var btn_text;
        if (action == 'edit') {
            url = daftar_ahli_peronda_srs_config.routes.daftar_ahli_peronda_srs_action_url;
            type = "POST";
            btn_text = 'Seterusnya &nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
        } 
		$.ajax({
            url: url,
            type: type,
            data: data,
        }).done(function(response) {        
            $('[name=paps_srs_profile_id]').removeClass("is-invalid");
            $('[name=paps_peronda_nama]').removeClass("is-invalid");
			$('[name=paps_peronda_tarikh_lahir]').removeClass("is-invalid");
			$('[name=paps_peronda_kaum]').removeClass("is-invalid");
			$('[name=paps_peronda_jantina]').removeClass("is-invalid");
			$('[name=paps_peronda_warganegara]').removeClass("is-invalid");
			$('[name=paps_peronda_agama]').removeClass("is-invalid");
			$('[name=paps_peronda_ic]').removeClass("is-invalid");
			$('[name=paps_peronda_alamat]').removeClass("is-invalid");
			$('[name=paps_peronda_poskod]').removeClass("is-invalid");
			$('[name=paps_peronda_phone]').removeClass("is-invalid");
			$('[name=paps_peronda_tarikh_lantikan]').removeClass("is-invalid");
			
			if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'paps_srs_profile_id') {
                        $('[name=paps_srs_profile_id]').addClass("is-invalid");
                        $('.error_paps_srs_profile_id').html(error);
                    }

                    if(index == 'paps_peronda_nama') {
                        $('[name=paps_peronda_nama]').addClass("is-invalid");
                        $('.error_paps_peronda_nama').html(error);
                    }

					if(index == 'paps_peronda_tarikh_lahir') {
                        $('[name=paps_peronda_tarikh_lahir]').addClass("is-invalid");
                        $('.error_paps_peronda_tarikh_lahir').html(error);
                    }

					if(index == 'paps_peronda_kaum') {
                        $('[name=paps_peronda_kaum]').addClass("is-invalid");
                        $('.error_paps_peronda_kaum').html(error);
                    }

					if(index == 'paps_peronda_jantina') {
                        $('[name=paps_peronda_jantina]').addClass("is-invalid");
                        $('.error_paps_peronda_jantina').html(error);
                    }

					if(index == 'paps_peronda_warganegara') {
                        $('[name=paps_peronda_warganegara]').addClass("is-invalid");
                        $('.error_paps_peronda_warganegara').html(error);
                    }

					if(index == 'paps_peronda_agama') {
                        $('[name=paps_peronda_agama]').addClass("is-invalid");
                        $('.error_paps_peronda_agama').html(error);
                    }

					if(index == 'paps_peronda_ic') {
                        $('[name=paps_peronda_ic]').addClass("is-invalid");
                        $('.error_paps_peronda_ic').html(error);
                    }

					if(index == 'paps_peronda_alamat') {
                        $('[name=paps_peronda_alamat]').addClass("is-invalid");
                        $('.error_paps_peronda_alamat').html(error);
                    }

					if(index == 'paps_peronda_poskod') {
                        $('[name=paps_peronda_poskod]').addClass("is-invalid");
                        $('.error_paps_peronda_poskod').html(error);
                    }

					if(index == 'paps_peronda_phone') {
                        $('[name=paps_peronda_phone]').addClass("is-invalid");
                        $('.error_paps_peronda_phone').html(error);
                    }

					if(index == 'paps_peronda_tarikh_lantikan') {
                        $('[name=paps_peronda_tarikh_lantikan]').addClass("is-invalid");
                        $('.error_paps_peronda_tarikh_lantikan').html(error);
                    }

				});
                $('#btn_next').html(btn_text);                
                $('#btn_next').prop('disabled', false);            
            } else {
				$('#btn_next').html(btn_text);
                $('#btn_next').prop('disabled', false); 
				window.location.href = "{{route('rt-sm13.pendaftaran_ahli_peronda_srs_1','')}}"+"/"+"{{$srs_ahli_peronda->id}}";
            }
        });
    });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
@stop