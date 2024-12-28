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
				$('#spmpd_hasRT').attr("checked", "checked");
				
			}
            $('#spmpd_state_id').val("{{$mkp->krt_state_id}}");
			$('#spmpd_daerah_id').val("{{$mkp->krt_daerah_id}}");
			$('#spmpd_krt_profile_id').val("{{$mkp->krt_profile_id}}");

		/* Maklumat Status Sokongan */
			$('#spmpd_disokong_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
			$('#spmpd_spk_imediator_id').val("{{$mkp->id}}");
        /* Maklumat MKP */
			$('#spmpd_mkp_gambar').attr('src', "{{ asset('storage/mkp_profile') }}"+"/"+ "{{$mkp->mkp_file_avatar}}");
            $("#spmpd_mkp_pemohon_nama").val($("<div>").html("{{$mkp->mkp_pemohon_nama}}").text());
            $('#spmpd_mkp_pemohon_tarikh_lahir').val("{{$mkp->mkp_pemohon_tarikh_lahir}}");
            $('#spmpd_mkp_pemohon_daerah_id').val("{{$mkp->mkp_pemohon_daerah_id}}");
            $('#spmpd_mkp_pemohon_dun_id').val("{{$mkp->mkp_pemohon_dun_id}}");
            $('#spmpd_mkp_pemohon_mukim_id').val("{{$mkp->mkp_pemohon_mukim_id}}");
            $('#spmpd_mkp_pemohon_kaum_id').val("{{$mkp->mkp_pemohon_kaum_id}}");
            $('#spmpd_mkp_pemohon_alamat').val("{{$mkp->mkp_pemohon_alamat}}");
            $('#spmpd_mkp_pemohon_no_phone').val("{{$mkp->mkp_pemohon_no_phone}}");
            $('#spmpd_mkp_pemohon_kategori_id').val("{{$mkp->mkp_pemohon_kategori_id}}");
            $('#spmpd_mkp_pemohon_akademik').val("{{$mkp->mkp_pemohon_akademik}}");
            $('#spmpd_mkp_pemohon_ic').val("{{$mkp->mkp_pemohon_ic}}");
            $('#spmpd_mkp_pemohon_state_id').val("{{$mkp->mkp_pemohon_state_id}}");
            $('#spmpd_mkp_pemohon_parlimen_id').val("{{$mkp->mkp_pemohon_parlimen_id}}");
            $('#spmpd_mkp_pemohon_pbt_id').val("{{$mkp->mkp_pemohon_pbt_id}}");
            $('#spmpd_mkp_pemohon_jantina_id').val("{{$mkp->mkp_pemohon_jantina_id}}");
            $('#spmpd_mkp_pemohon_email').val("{{$mkp->mkp_pemohon_email}}");
            $('#spmpd_mkp_pemohon_alamat_p').val("{{$mkp->mkp_pemohon_alamat_p}}");
            $('#spmpd_mkp_pemohon_no_phone_p').val("{{$mkp->mkp_pemohon_no_phone_p}}");
            $('#spmpd_mkp_pemohon_tahap_id').val("{{$mkp->mkp_pemohon_tahap_id}}");
            $('#spmpd_mkp_pemohon_khusus').val("{{$mkp->mkp_pemohon_khusus}}");
			$('#spmpd_mkp_tarikh_dilantik').val("{{$mkp->mkp_tarikh_dilantik}}");

            var senarai_kursus_mkp_table = $('#senarai_kursus_mkp_table').DataTable( {
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
						button_a = '<button type="button" class="btn btn-icon" title="Download Dokumen Kursus" id="download_dokument" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-download"></i></button>';
                            return button_a;
                        
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

        /* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm23.senarai_permohonan_mkp_ppd') }}";
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

    /* click submit sokongan permohonan mkp */
		//my custom script
		var sokongan_permohonan_mkp_ppd_config = {
			routes: {
				sokongan_permohonan_mkp_ppd_url: "{{ route('rt-sm23.post_sokongan_permohonan_mkp_ppd') }}",
			}
		};

        $(document).on('submit', '#form_spmpd', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data = $("#form_spmpd").serialize();
			var action = $('#post_sokongan_permohonan_mkp_ppd').val();
			var btn_text;
			if (action == 'edit') {
				url = sokongan_permohonan_mkp_ppd_config.routes.sokongan_permohonan_mkp_ppd_url;
				type = "POST";
				btn_text = 'Hantar Status Sokongan&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=spmpd_imediator_status]').removeClass("is-invalid");
				$('[name=spmpd_disokong_note]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'spmpd_imediator_status') {
							$('[name=spmpd_imediator_status]').addClass("is-invalid");
							$('.error_spmpd_imediator_status').html(error);
						}

						if(index == 'spmpd_disokong_note') {
							$('[name=spmpd_disokong_note]').addClass("is-invalid");
							$('.error_spmpd_disokong_note').html(error);
						}

					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm23.senarai_permohonan_mkp_ppd')}}";
				}
			});
		});
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop