@include('js.modal.j-modal-edit-gambar-peronda-srs')
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<style>
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
			$('#aps_nama_krt').html("{{$srs_ahli_peronda->nama_krt}}");
			$('#aps_alamat_krt').html("{{$srs_ahli_peronda->alamat_krt}}");
			$('#aps_negeri_krt').html("{{$srs_ahli_peronda->negeri_krt}}");
			$('#aps_daerah_krt').html("{{$srs_ahli_peronda->daerah_krt}}");
			$('#aps_parlimen_krt').html("{{$srs_ahli_peronda->parlimen_krt}}");
			$('#aps_dun_krt').html("{{$srs_ahli_peronda->dun_krt}}");
			$('#aps_pbt_krt').html("{{$srs_ahli_peronda->pbt_krt}}");

		/* Maklumat Pemohonan Ahli Peronda SRS */
			$('#kak_ajk_gambar').attr('src', "{{ asset('storage/ahli_peronda_srs') }}"+"/"+ "{{$srs_ahli_peronda->file_gambar_profile}}");
			$('#aps_srs_profile_id').val("{{$srs_ahli_peronda->srs_profile_id}}");
			$('#aps_peronda_nama').val("{{$srs_ahli_peronda->peronda_nama}}");
			$('#aps_peronda_tarikh_lahir').val("{{$srs_ahli_peronda->peronda_tarikh_lahir}}");
			$('#aps_peronda_kaum').val("{{$srs_ahli_peronda->peronda_kaum}}");
			$('#aps_peronda_jantina').val("{{$srs_ahli_peronda->peronda_jantina}}");
			$('#aps_peronda_warganegara').val("{{$srs_ahli_peronda->peronda_warganegara}}");
			$('#aps_peronda_agama').val("{{$srs_ahli_peronda->peronda_agama}}");
			$('#aps_peronda_ic').val("{{$srs_ahli_peronda->peronda_ic}}");
			$('#aps_peronda_alamat').val("{{$srs_ahli_peronda->peronda_alamat}}");
			$('#aps_peronda_poskod').val("{{$srs_ahli_peronda->peronda_poskod}}");
			$('#aps_peronda_phone').val("{{$srs_ahli_peronda->peronda_phone}}");
			$('#aps_peronda_tarikh_lantikan').val("{{$srs_ahli_peronda->peronda_tarikh_lantikan}}");
			$('#aps_srs_ahli_peronda_id').val("{{$srs_ahli_peronda->id}}");
			$('#aps_peronda_alamat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
			$('#aps_peronda_alamat').on("paste",function(e) {
                e.preventDefault();
            });

			url = "{{ route('rt-sm13.get_senarai_pendidikan_table','') }}"+"/"+"{{$srs_ahli_peronda->id}}";
			
			var senarai_pendidikan_srs_table = $('#senarai_pendidikan_srs_table').DataTable( {
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
					sClass: 'text-center',
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

		/* Edit Gambar */
			$('#megps_ahli_peronda_id').val("{{$srs_ahli_peronda->id}}");

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = '{{route('rt-sm13.senarai_pendaftaran_ahli_peronda_srs')}}';
			});

	});

	/* click add gambar ajk */
		var kemaskini_gambar_peronda_config = {
            routes: {
                kemaskini_gambar_peronda_url: "{{ route('post_edit_gambar_peronda_srs') }}",
            }
        };

		$(document).on('submit', '#form_megps', function(event){    
            event.preventDefault();
            $('#btn_edit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_edit').prop('disabled', true);
            var form_data = new FormData();
			form_data.append("megps_file_gambar_profile",  $("#megps_file_gambar_profile")[0].files[0]);
			form_data.append("megps_ahli_peronda_id", $("#megps_ahli_peronda_id").val() );
			form_data.append("post_edit_gambar_peronda_srs", "edit" );
            var action = $('#post_edit_gambar_peronda_srs').val();
            var btn_text;
            if (action == 'edit') {
                url = kemaskini_gambar_peronda_config.routes.kemaskini_gambar_peronda_url;
                type = "POST";
                btn_text = '<i class="fa fa-edit mr-2"></i>Kemaskini';
            } 
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
                $('[name=megps_file_gambar_profile]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'megps_file_gambar_profile') {
                            $('[name=megps_file_gambar_profile]').addClass("is-invalid");
                            $('.error_megps_file_gambar_profile').html(error);
                        }

                    });
                    $('#btn_edit').html(btn_text);                
                    $('#btn_edit').prop('disabled', false);            
                } else {
                    $('#btn_edit').html(btn_text);
                    $('#btn_edit').prop('disabled', false); 
					$('#form_megps').trigger("reset");
                    window.location.href = "{{route('rt-sm13.ahli_peronda_srs','')}}"+"/"+"{{$srs_ahli_peronda->id}}";
					$('#modal_edit_gambar_peronda_srs').modal('hide');
                }
            });
        });

	/* button tindakan Pendidikan */

		function getPendidikan(id) {
			//checked
			if ($('#chkp_1' + id).is(':checked')) {
				// alert('checked');
				var aps_srs_ahli_peronda_id = $('#aps_srs_ahli_peronda_id').val();
				url_add_pendidikan_srs = "{{ route('rt-sm13.add_pendidikan_srs') }}";
				type = "POST";
				$.ajax({
					url: url_add_pendidikan_srs,
					type: type,
					data: {
							"_token": "{{ csrf_token() }}",
							"aps_srs_ahli_peronda_id": aps_srs_ahli_peronda_id,
							"srs_ahli_peronda_pendidikanID": id
							}
				});
			}

			//unchecked
			if (!$('#chkp_1' + id).is(':checked')) {
				// alert('unchecked');
				url_delete_pendidikan_srs 	= "{{ route('rt-sm13.delete_pendidikan_srs','') }}";
				$.ajax({
					type: "GET",
					url: url_delete_pendidikan_srs +"/" + id,
				});
				
			}
		}

		//my custom script
		var update_ahli_peronda_srs_config = {
			routes: {
				update_ahli_peronda_srs_action_url: "{{ route('rt-sm13.post_ahli_peronda_srs') }}",
			}
		};

		$(document).on('submit', '#form_aps', function(event){    
			event.preventDefault();
			$('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_next').prop('disabled', true);
			var data = $("#form_aps").serialize();
			var action = $('#post_ahli_peronda_srs').val();
			var btn_text;
			url = update_ahli_peronda_srs_config.routes.update_ahli_peronda_srs_action_url;
				type = "POST";
				btn_text = 'Seterusnya &nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=aps_peronda_kaum]').removeClass("is-invalid");
				$('[name=aps_peronda_jantina]').removeClass("is-invalid");
				$('[name=aps_peronda_warganegara]').removeClass("is-invalid");
				$('[name=aps_peronda_agama]').removeClass("is-invalid");
				$('[name=aps_peronda_alamat]').removeClass("is-invalid");
				$('[name=aps_peronda_poskod]').removeClass("is-invalid");
				$('[name=aps_peronda_phone]').removeClass("is-invalid");
				$('[name=aps_peronda_tarikh_lantikan]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'aps_peronda_kaum') {
							$('[name=aps_peronda_kaum]').addClass("is-invalid");
							$('.error_aps_peronda_kaum').html(error);
						}

						if(index == 'aps_peronda_jantina') {
							$('[name=aps_peronda_jantina]').addClass("is-invalid");
							$('.error_aps_peronda_jantina').html(error);
						}

						if(index == 'aps_peronda_warganegara') {
							$('[name=aps_peronda_warganegara]').addClass("is-invalid");
							$('.error_aps_peronda_warganegara').html(error);
						}

						if(index == 'aps_peronda_agama') {
							$('[name=aps_peronda_agama]').addClass("is-invalid");
							$('.error_aps_peronda_agama').html(error);
						}

						if(index == 'aps_peronda_alamat') {
							$('[name=aps_peronda_alamat]').addClass("is-invalid");
							$('.error_aps_peronda_alamat').html(error);
						}

						if(index == 'aps_peronda_poskod') {
							$('[name=aps_peronda_poskod]').addClass("is-invalid");
							$('.error_aps_peronda_poskod').html(error);
						}

						if(index == 'aps_peronda_phone') {
							$('[name=aps_peronda_phone]').addClass("is-invalid");
							$('.error_aps_peronda_phone').html(error);
						}

						if(index == 'aps_peronda_tarikh_lantikan') {
							$('[name=aps_peronda_tarikh_lantikan]').addClass("is-invalid");
							$('.error_aps_peronda_tarikh_lantikan').html(error);
						}

					});
					$('#btn_next').html(btn_text);                
					$('#btn_next').prop('disabled', false);            
				} else {
					$('#btn_next').html(btn_text);
					$('#btn_next').prop('disabled', false); 
					window.location.href = "{{route('rt-sm13.ahli_peronda_srs_1','')}}"+"/"+"{{$srs_ahli_peronda->id}}";
				}
			});
		});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop