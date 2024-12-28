@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
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

	//my custom script
	var penubuhan_srs_config = {
        routes: {
            srs_profile_action_url: "{{ route('rt-sm12.update_kemaskini_srs_profile') }}",
			
        }
    };
    
	$(document).ready( function () {

	/* Maklumat Kawasan Krt */
		$('#pps_nama_krt').html("{{$srs_profile->nama_krt}}");
		$('#pps_alamat_krt').html("{{$srs_profile->alamat_krt}}");
		$('#pps_negeri_krt').html("{{$srs_profile->negeri_krt}}");
		$('#pps_parlimen_krt').html("{{$srs_profile->parlimen_krt}}");
		$('#pps_pbt_krt').html("{{$srs_profile->pbt_krt}}");
		$('#pps_daerah_krt').html("{{$srs_profile->daerah_krt}}");
		$('#pps_dun_krt').html("{{$srs_profile->dun_krt}}");

	/* Maklumat Pemohon */
		$('#pps_pemohon_name').val("{{$user_profile->pemohon_name}}");
		$('#pps_pemohon_ic').val("{{$user_profile->pemohon_ic}}");
		$('#pps_pemohon_address').val("{{$user_profile->pemohon_address}}");

	/* Maklumat Asas */
		$('#pps1_srs_id').val("{{$srs_profile->id}}");
		$('#pps1_srs_name').val("{{$srs_profile->srs_name}}");
		$('#pps1_srs_peronda_total').val("{{$srs_profile->srs_peronda_total}}");
		var srs_kawalan = "{{$srs_profile->srs_kawalan}}";
		if(srs_kawalan ==! null){
			$("input[name=pps1_srs_kawalan][value=" + srs_kawalan + "]").prop('checked', true);
		}

		$('#pps2_peronda_kad').mask('999999999999');
	
	/* Maklumat Peronda */
		$('#pps2_srs_profile_id').val("{{$srs_profile->id}}");

		//my custom script
		url_senarai_peronda 			= "{{ route('rt-sm12.get_senarai_peronda_table','') }}"+"/"+"{{$srs_profile->id}}";
		url_delete_senarai_peronda  	= "{{ route('rt-sm12.delete_peronda','') }}";

		var senarai_peronda_table = $('#senarai_peronda_table').DataTable( {
    		processing: true,
			serverSide: true,
			ajax: url_senarai_peronda,
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
			rowCallback: function(nRow, aData, index) {
                var info = senarai_peronda_table.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
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
                    return full.peronda_nama;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "28%", 
                "mRender": function ( value, type, full )  {
                    return full.peronda_kad;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "6%",
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete-peronda" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
					return button_a;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });

	/* Maklumat Note Kemaskini */
		$('#pps_status').val("{{$srs_profile->srs_status}}");
            
		if($('#pps_status').val() == '6'){
			$("#pps_perlu_kemaskini").show();
			$('#pps_status_description').html("{{$srs_profile->status_description}}");
			$('#pps_disemak_note').html("{{$srs_profile->disemak_note}}");
		}

            

	/* Button */
		$('#btn_back').click(function(){
			window.location.href = "{{route('rt-sm12.senarai_srs')}}";
		});
		
	});

	/* click add peronda */
		$(document).on('submit', '#form_pps2', function(event){
			var info = $('.error_alert_pps2');
			event.preventDefault();

			$('#btn_add_peronda').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_add_peronda').prop('disabled', true);

			var data = $("#form_pps2").serialize();
			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm12.post_peronda') }}";
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
					$('#btn_add_peronda').html(btn_text);                
					$('#btn_add_peronda').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Senarai Peronda ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_pps2').trigger("reset");
					$('#btn_add_peronda').html(btn_text);
					$('#btn_add_peronda').prop('disabled', false);
					$('#senarai_peronda_table').DataTable().ajax.reload();
				}
			});
		});
		
	/* click delete peronda */
		$('body').on('click', '#delete-peronda', function () {
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
						url: url_delete_senarai_peronda +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_peronda_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod peronda telah dipadam dari pangkalan data", "success");
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

	/* click btn Seterusnya */
		$(document).on('submit', '#form_pps3', function(event){    
			event.preventDefault();
			$('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_next').prop('disabled', true);
			var data = $("#form_pps1").serialize();
			var action = $('#update_kemaskini_srs_profile').val();
			var btn_text;
			if (action == 'edit') {
				url = penubuhan_srs_config.routes.srs_profile_action_url;
				type = "POST";
				btn_text = 'Seterusnya &nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=pps1_srs_name]').removeClass("is-invalid");
				$('[name=pps1_srs_peronda_total]').removeClass("is-invalid");
				$('[name=pps1_srs_kawalan]').removeClass("is-invalid");


				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'pps1_srs_name') {
							$('[name=pps1_srs_name]').addClass("is-invalid");
							$('.error_pps1_srs_name').html(error);
						}

						if(index == 'pps1_srs_peronda_total') {
							$('[name=pps1_srs_peronda_total]').addClass("is-invalid");
							$('.error_pps1_srs_peronda_total').html(error);
						}

						if(index == 'pps1_srs_kawalan') {
							$('[name=pps1_srs_kawalan]').addClass("is-invalid");
							$('.error_pps1_srs_kawalan').html(error);
						}
					});
					$('#btn_next').html(btn_text);                
					$('#btn_next').prop('disabled', false);            
				} else {
					$('#btn_next').html(btn_text);
					$('#btn_next').prop('disabled', false); 
					window.location.href = "{{route('rt-sm12.permohonan_penubuhan_srs_1','')}}"+"/"+{{$srs_profile->id}};
				}
			});
		});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
@stop