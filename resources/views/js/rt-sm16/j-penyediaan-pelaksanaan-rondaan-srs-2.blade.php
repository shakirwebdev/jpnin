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

</style>
<script type="text/javascript">  
    
    $(document).ready( function () {

		//my custom script
        var pelaksanaan_rondaans_config = {
            routes: {
                pelaksanaan_rondaan_url: "/rt/sm16/penyediaan-pelaksanaan-rondaan-srs-2/{{$pelaksanaan_rondaan->id}}"
            }
        };
        
    	/* Maklumat Kawasan Krt */
			$('#pprs2_nama_krt').html("{{$pelaksanaan_rondaan->nama_krt}}");
			$('#pprs2_alamat_krt').html("{{$pelaksanaan_rondaan->alamat_krt}}");
			$('#pprs2_negeri_krt').html("{{$pelaksanaan_rondaan->negeri_krt}}");
			$('#pprs2_daerah_krt').html("{{$pelaksanaan_rondaan->daerah_krt}}");
			$('#pprs2_parlimen_krt').html("{{$pelaksanaan_rondaan->parlimen_krt}}");
			$('#pprs2_dun_krt').html("{{$pelaksanaan_rondaan->dun_krt}}");
			$('#pprs2_pbt_krt').html("{{$pelaksanaan_rondaan->pbt_krt}}");

		/* Maklumat kes */
			$("#pprs2_kategori_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pprs2_jenis_id').find('option').remove();
				$('#pprs2_jenis_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: pelaksanaan_rondaans_config.routes.pelaksanaan_rondaan_url,
						data: {type: 'get_jenis', value: value},
						success: function (data) {
							$('#pprs2_jenis_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pprs2_jenis_id')
								.append($('<option>')
								.text(obj.jenis_description)
								.attr('value', obj.id));
							});
						},
						error: function (data) {
							console.log('Error:', data);
						}
					}); 
				}
			});

			$('#pprs2_kes_keterangan').summernote({
				height: 200
			});

			url_kaum_terlibat      		= "{{ route('rt-sm16.get_kaum_terlibat_table','') }}"+"/"+"{{$pelaksanaan_rondaan->id}}";
			url_delete_kaum_terlibat 	= "{{ route('rt-sm16.delete_kaum_terlibat','') }}";

			var senarai_terlibat_table = $('#senarai_terlibat_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_kaum_terlibat,
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
						return full.kaum_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "29%", 
					"mRender": function ( value, type, full )  {
						return full.terlibat_bilangan;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "29%", 
					"mRender": function ( value, type, full )  {
						return full.jantina_description;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "29%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.terlibat_umur;
					}
				},{          
					"aTargets": [ 5 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_kaum_terlibat" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			$('#pprs3_srs_pelaksanaan_rondaan_id').val("{{$pelaksanaan_rondaan->id}}");

			$('#pprs5_srs_pelaksanaan_rondaan_id').val("{{$pelaksanaan_rondaan->id}}");
       
        /* Button */
			$('#btn_back').click(function(){
                window.location.href = '{{route('rt-sm16.penyediaan_pelaksanaan_rondaan_srs_1','')}}'+'/'+'{{$pelaksanaan_rondaan->id}}';
            });
    });

	/* click add Kaum Terlibat */
	$(document).on('submit', '#form_pprs3', function(event){
		var info = $('.error_form_pprs3');
		event.preventDefault();

		$('#btn_add_kaum_terlibat').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
		$('#btn_add_kaum_terlibat').prop('disabled', true);

		var data = $("#form_pprs3").serialize();
		btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
		url = "{{ route('rt-sm16.post_add_kaum_terlibat') }}";
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
				$('#btn_add_kaum_terlibat').html(btn_text);                
				$('#btn_add_kaum_terlibat').prop('disabled', false);
				info.slideDown();
			} else {
				swal("Bilangan Yang Terlibat Mengikut Kaum ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
				$('#form_pprs3').trigger("reset");
				$('#btn_add_kaum_terlibat').html(btn_text);
				$('#btn_add_kaum_terlibat').prop('disabled', false);
				$('#senarai_terlibat_table').DataTable().ajax.reload();
			}
		});
	});

	/* click delete Kaum Terlibat */
	$('body').on('click', '#delete_kaum_terlibat', function () {
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
					url: url_delete_kaum_terlibat +"/" + delete_id,
					success: function (data) {
						// $('#peranan_form').trigger("reset");
						$('#senarai_terlibat_table').DataTable().ajax.reload();
						swal("Sudah dipadam!", "Rekod Bilangan Yang Terlibat Mengikut Kaum telah dipadam dari pangkalan data", "success");
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
    var submit_pelaksanaan_rondaan_config = {
        routes: {
            submit_pelaksanaan_rondaan_url: "{{ route('rt-sm16.post_tambah_pelaksanaan_rondaan_3') }}",
        }
    };

    /* Button Submit */
    $(document).on('submit', '#form_pprs5', function(event){    
        event.preventDefault();
        $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
        $('#btn_submit').prop('disabled', true);
        var data   = $("#form_pprs2, #form_pprs4, #form_pprs5").serialize();
        var action = $('#post_tambah_pelaksanaan_rondaan_3').val();
        var btn_text;
        if (action == 'edit') {
            url = submit_pelaksanaan_rondaan_config.routes.submit_pelaksanaan_rondaan_url;
            type = "POST";
            btn_text = 'Hantar Pelaksanaan Rondaan SRS&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
        } 
		$.ajax({
            url: url,
            type: type,
            data: data,
        }).done(function(response) {        
            $('[name=pprs2_kategori_id]').removeClass("is-invalid");
            $('[name=pprs2_jenis_id]').removeClass("is-invalid");
			$('[name=pprs2_kes_keterangan]').removeClass("is-invalid");
            $('[name=pprs4_kes_jumlah_org_terlibat]').removeClass("is-invalid");
            $('[name=pprs4_kes_dirujuk_id]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'pprs2_kategori_id') {
                        $('[name=pprs2_kategori_id]').addClass("is-invalid");
                        $('.error_pprs2_kategori_id').html(error);
                    }

                    if(index == 'pprs2_jenis_id') {
                        $('[name=pprs2_jenis_id]').addClass("is-invalid");
                        $('.error_pprs2_jenis_id').html(error);
                    }

					if(index == 'pprs2_kes_keterangan') {
                        $('[name=pprs2_kes_keterangan]').addClass("is-invalid");
                        $('.error_pprs2_kes_keterangan').html(error);
                    }

                    if(index == 'pprs4_kes_jumlah_org_terlibat') {
                        $('[name=pprs4_kes_jumlah_org_terlibat]').addClass("is-invalid");
                        $('.error_pprs4_kes_jumlah_org_terlibat').html(error);
                    }

                    if(index == 'pprs4_kes_dirujuk_id') {
                        $('[name=pprs4_kes_dirujuk_id]').addClass("is-invalid");
                        $('.error_pprs4_kes_dirujuk_id').html(error);
                    }

                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
				$('#btn_submit').html(btn_text);
                $('#btn_submit').prop('disabled', false); 
				window.location.href = "{{route('rt-sm16.penyediaan_pelaksanaan_rondaan_srs')}}";
            }
        });
    });

    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop