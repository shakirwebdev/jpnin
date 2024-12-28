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

		//my custom script
			
            url_senarai_kursus_mkp 	= "{{ route('rt-sm23.get_senarai_kursus_mkp_table','') }}"+"/"+"{{$mkp->id}}";

		/* Maklumat Kes Dalam Krt */
            if("{{$mkp->hasRT}}" == 1){
				$('#spmupmkn_hasRT').attr("checked", "checked");
				
			}
            $('#spmupmkn_state_id').val("{{$mkp->mkp_pemohon_state_id}}");
			$('#spmupmkn_daerah_id').val("{{$mkp->mkp_pemohon_daerah_id}}");
			$('#spmupmkn_krt_profile_id').val("{{$mkp->krt_profile_id}}");

		/* Maklumat Status Sokongan */
			$('#spmupmkn_disemak_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
			$('#spmupmkn_spk_imediator_id').val("{{$mkp->id}}");
        /* Maklumat MKP */
			$('#spmupmkn_mkp_gambar').attr('src', "{{ asset('storage/mkp_profile') }}"+"/"+ "{{$mkp->mkp_file_avatar}}");
            $('#spmupmkn_mkp_pemohon_nama').val("{{$mkp->mkp_pemohon_nama}}");
            $('#spmupmkn_mkp_pemohon_tarikh_lahir').val("{{$mkp->mkp_pemohon_tarikh_lahir}}");
            $('#spmupmkn_mkp_pemohon_daerah_id').val("{{$mkp->mkp_pemohon_daerah_id}}");
            $('#spmupmkn_mkp_pemohon_dun_id').val("{{$mkp->mkp_pemohon_dun_id}}");
            $('#spmupmkn_mkp_pemohon_mukim_id').val("{{$mkp->mkp_pemohon_mukim_id}}");
            $('#spmupmkn_mkp_pemohon_kaum_id').val("{{$mkp->mkp_pemohon_kaum_id}}");
            $('#spmupmkn_mkp_pemohon_alamat').val("{{$mkp->mkp_pemohon_alamat}}");
            $('#spmupmkn_mkp_pemohon_no_phone').val("{{$mkp->mkp_pemohon_no_phone}}");
            $('#spmupmkn_mkp_pemohon_kategori_id').val("{{$mkp->mkp_pemohon_kategori_id}}");
            $('#spmupmkn_mkp_pemohon_akademik').val("{{$mkp->mkp_pemohon_akademik}}");
            $('#spmupmkn_mkp_pemohon_ic').val("{{$mkp->mkp_pemohon_ic}}");
            $('#spmupmkn_mkp_pemohon_state_id').val("{{$mkp->mkp_pemohon_state_id}}");
            $('#spmupmkn_mkp_pemohon_parlimen_id').val("{{$mkp->mkp_pemohon_parlimen_id}}");
            $('#spmupmkn_mkp_pemohon_pbt_id').val("{{$mkp->mkp_pemohon_pbt_id}}");
            $('#spmupmkn_mkp_pemohon_jantina_id').val("{{$mkp->mkp_pemohon_jantina_id}}");
            $('#spmupmkn_mkp_pemohon_email').val("{{$mkp->mkp_pemohon_email}}");
            $('#spmupmkn_mkp_pemohon_alamat_p').val("{{$mkp->mkp_pemohon_alamat_p}}");
            $('#spmupmkn_mkp_pemohon_no_phone_p').val("{{$mkp->mkp_pemohon_no_phone_p}}");
            $('#spmupmkn_mkp_pemohon_tahap_id').val("{{$mkp->mkp_pemohon_tahap_id}}");
            $('#spmupmkn_mkp_pemohon_khusus').val("{{$mkp->mkp_pemohon_khusus}}");
            $('#spmupmkn_mkp_tarikh_dilantik').val("{{$mkp->mkp_tarikh_dilantik}}");

        /* Maklumat Kursus Yang Dihadiri */
			var senarai_kursus_table = $('#senarai_kursus_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_senarai_kursus_mkp,
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
					"width": "16%", 
					"mRender": function ( value, type, full )  {
						return full.kursus_nama;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "16%",
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.kursus_description;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "16%",
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.peringkat_description;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "16%",
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.kursus_penganjur;
					}
				},{          
					"aTargets": [ 5 ], 
					"width": "16%",
					"mRender": function ( value, type, full )  {
						return full.file_dokument;
					}
				},{          
					"aTargets": [ 6 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
                        if (full.status_pelanjutan == null || full.status_pelanjutan == 2 || full.status_pelanjutan == 5 || full.status_pelanjutan == 7 || full.status_pelanjutan == 9 || full.status_pelanjutan == 11 || full.status_pelanjutan == 13 || full.status_pelanjutan == 14) {
                            button_a = '<button type="button" class="btn btn-icon" title="Download Dokumen Kursus" id="download_dokument" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-download"></i></button>';
                            button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_maklumat_kursus" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
                            return button_a + '|' + button_b;
                        } else {
                            button_a = '<button type="button" class="btn btn-icon" title="Download Dokumen Kursus" id="download_dokument" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-download"></i></button>';
                            return button_a;
                        }
                        
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

        /* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm23.senarai_semakan_pelanjutan_mkp_upmk') }}";
			});
    });

	/* click download dokumen kursus */
		var download_dokument_config = {
			routes: {
				download_dokumen_kursus_url: "{{ route('rt-sm23.get_download_dokument_kursus','') }}",
			}
		};

        $('body').on('click', '#download_dokument', function () {
			var download_id = $(this).data("id");
			$.get(download_dokument_config.routes.download_dokumen_kursus_url + '/' + download_id, function (data) {
				let link = document.createElement("a");
				link.download = data.file_dokument;
				link.href = "{{ asset('storage/mkp_dokument_kursus') }}"+"/"+ data.file_dokument ;
				link.click();
			});
		});

    /* click submit sokongan pelanjutan mkp */
		//my custom script
		var semakan_pelanjutan_mkp_upmk_config = {
			routes: {
				semakan_pelanjutan_mkp_upmk_url: "{{ route('rt-sm23.post_semakan_pelanjutan_mkp_upmk') }}",
			}
		};

        $(document).on('submit', '#form_spmupmkn', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data = $("#form_spmupmkn").serialize();
			var action = $('#post_semakan_pelanjutan_mkp_upmk').val();
			var btn_text;
			if (action == 'edit') {
				url = semakan_pelanjutan_mkp_upmk_config.routes.semakan_pelanjutan_mkp_upmk_url;
				type = "POST";
				btn_text = 'Hantar Status Semakan&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=spmupmkn_imediator_status]').removeClass("is-invalid");
				$('[name=spmupmkn_disemak_note]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'spmupmkn_imediator_status') {
							$('[name=spmupmkn_imediator_status]').addClass("is-invalid");
							$('.error_spmupmkn_imediator_status').html(error);
						}

						if(index == 'spmupmkn_disemak_note') {
							$('[name=spmupmkn_disemak_note]').addClass("is-invalid");
							$('.error_spmupmkn_disemak_note').html(error);
						}

					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm23.senarai_semakan_pelanjutan_mkp_upmk')}}";
				}
			});
		});
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop