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
            $('#plak2_nama_krt').html("{{$laporan_aktiviti->nama_krt}}");
            $('#plak2_alamat_krt').html("{{$laporan_aktiviti->alamat_krt}}");
            $('#plak2_negeri_krt').html("{{$laporan_aktiviti->negeri_krt}}");
            $('#plak2_parlimen_krt').html("{{$laporan_aktiviti->parlimen_krt}}");
            $('#plak2_pbt_krt').html("{{$laporan_aktiviti->pbt_krt}}");
            $('#plak2_daerah_krt').html("{{$laporan_aktiviti->daerah_krt}}");
            $('#plak2_dun_krt').html("{{$laporan_aktiviti->dun_krt}}");

        /* Maklumat Tempat Aktiviti Perpaduan */
            $('#plak2_state_id').val("{{$laporan_aktiviti->state_id}}");
            $('#plak2_daerah_id').val("{{$laporan_aktiviti->daerah_id}}");
            $('#plak2_aktiviti_tempat').val("{{$laporan_aktiviti->aktiviti_tempat}}");
            var aktiviti_kawasan_DL = "{{$laporan_aktiviti->aktiviti_kawasan_DL}}";
		    $("input[name=plak2_aktiviti_kawasan_DL][value=" + aktiviti_kawasan_DL + "]").prop('checked', true);

        /* Maklumat Penyertaan */
            $('#plak3_aktiviti_laporan_id').val("{{$laporan_aktiviti->id}}");

            //my custom script
            url_senarai_penyertaan_table      = "{{ route('rt-sm6.get_laporan_penyertaan_table','') }}"+"/"+"{{$laporan_aktiviti->id}}";
            url_delete_penyertaan 	          = "{{ route('rt-sm6.delete_laporan_penyertaan','') }}";

            var senarai_penyertaan_table = $('#senarai_penyertaan_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_senarai_penyertaan_table,
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
                    "width": "13%", 
                    "mRender": function ( value, type, full )  {
                        return full.kaum;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "13%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.lelaki;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "29%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.perempuan;
                    }
                },{          
                    "aTargets": [ 4 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_1;
                    }
                },{          
                    "aTargets": [ 5 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_2;
                    }
                },{          
                    "aTargets": [ 6 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_3;
                    }
                },{          
                    "aTargets": [ 7 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_4;
                    }
                },{          
                    "aTargets": [ 8 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_5;
                    }
                },{          
                    "aTargets": [ 9 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_6;
                    }
                },{          
                    "aTargets": [ 10 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_7;
                    }
                },{          
                    "aTargets": [ 11 ], 
                    "width": "13%", 
                    "mRender": function ( value, type, full )  {
                        return full.jumlah;
                    }
                },{          
                    "aTargets": [ 12 ], 
                    "width": "6%", 
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_penyertaan" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
                        return button_a;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

        /* Maklumat Rakan Perpaduan */
            $('#plak4_aktiviti_laporan_id').val("{{$laporan_aktiviti->id}}");

            //my custom script
            url_rakan_perpaduan_table      = "{{ route('rt-sm6.get_laporan_rakan_perpaduan_table','') }}"+"/"+"{{$laporan_aktiviti->id}}";
            url_delete_rakan_perpaduan 	   = "{{ route('rt-sm6.delete_laporan_rakan_perpaduan','') }}";

            var senarai_rakan_perpaduan_table = $('#senarai_rakan_perpaduan_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_rakan_perpaduan_table,
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
                    "width": "28%", 
                    "mRender": function ( value, type, full )  {
                        return full.rakan_perpaduan;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "28%", 
                    "mRender": function ( value, type, full )  {
                        return full.bentuk_sumbangan;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "28%",
                    sClass: 'text-center', 
                    "mRender": function ( value, type, full )  {
                        return full.jumlah;
                    }
                },{          
                    "aTargets": [ 4 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_rakan_perpaduan" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
                        return button_a;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

        /* Maklumat Note Kemaskini */
            $('#plak_status').val("{{$laporan_aktiviti->aktiviti_status}}");
            
            if($('#plak_status').val() == '4'){
                $("#plak_perlu_kemaskini").show();
                $('#plak_status_description').html("{{$laporan_aktiviti->status_description}}");
                $('#plak_disahkan_note').html("{{$laporan_aktiviti->disahkan_note}}");
            }
        
    	/* Button */
            $('#btn_back').click(function(){
                window.location.href = '{{route('rt-sm6.penyediaan_laporan_aktiviti_krt_1','')}}'+'/'+"{{$laporan_aktiviti->id}}";
            });

            $('#btn_next').click(function(){
                window.location.href = '{{route('rt-sm6.penyediaan_laporan_aktiviti_krt_3','')}}'+'/'+"{{$laporan_aktiviti->id}}";
            });
    });

    /* click add Penyertaan */
	$(document).on('submit', '#form_plak3', function(event){
		var info = $('.error_form_plak3');
		event.preventDefault();

		$('#btn_save_penyertaan').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
		$('#btn_save_penyertaan').prop('disabled', true);

		var data = $("#form_plak3").serialize();
		btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
		url = "{{ route('rt-sm6.post_laporan_penyertaan') }}";
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
				$('#btn_save_penyertaan').html(btn_text);                
				$('#btn_save_penyertaan').prop('disabled', false);
				info.slideDown();
			} else {
				swal("Penyertaan ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
				$('#form_plak3').trigger("reset");
				$('#btn_save_penyertaan').html(btn_text);
				$('#btn_save_penyertaan').prop('disabled', false);
				$('#senarai_penyertaan_table').DataTable().ajax.reload();
			}
		});
	});

    /* click delete Penyertaan */
	$('body').on('click', '#delete_penyertaan', function () {
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
					url: url_delete_penyertaan +"/" + delete_id,
					success: function (data) {
						// $('#peranan_form').trigger("reset");
						$('#senarai_penyertaan_table').DataTable().ajax.reload();
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

    /* click add Rakan Perpaduan */
	$(document).on('submit', '#form_plak4', function(event){
		var info = $('.error_form_plak4');
		event.preventDefault();

		$('#btn_save_rakan_perpaduan').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
		$('#btn_save_rakan_perpaduan').prop('disabled', true);

		var data = $("#form_plak4").serialize();
		btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
		url = "{{ route('rt-sm6.post_laporan_rakan_perpaduan') }}";
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
				$('#btn_save_rakan_perpaduan').html(btn_text);                
				$('#btn_save_rakan_perpaduan').prop('disabled', false);
				info.slideDown();
			} else {
				swal("Penyertaan ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
				$('#form_plak4').trigger("reset");
				$('#btn_save_rakan_perpaduan').html(btn_text);
				$('#btn_save_rakan_perpaduan').prop('disabled', false);
				$('#senarai_rakan_perpaduan_table').DataTable().ajax.reload();
			}
		});
	});

     /* click delete Rakan Perpaduan */
	$('body').on('click', '#delete_rakan_perpaduan', function () {
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
					url: url_delete_rakan_perpaduan +"/" + delete_id,
					success: function (data) {
						// $('#peranan_form').trigger("reset");
						$('#senarai_rakan_perpaduan_table').DataTable().ajax.reload();
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

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop