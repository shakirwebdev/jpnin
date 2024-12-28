
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

        /* Maklumat Kawasan Krt */
            $('#pkk_nama_krt').html("{{$koperasi->nama_krt}}");
            $('#pkk_alamat_krt').html("{{$koperasi->alamat_krt}}");
            $('#pkk_negeri_krt').html("{{$koperasi->negeri_krt}}");
            $('#pkk_parlimen_krt').html("{{$koperasi->parlimen_krt}}");
            $('#pkk_pbt_krt').html("{{$koperasi->pbt_krt}}");
            $('#pkk_daerah_krt').html("{{$koperasi->daerah_krt}}");
            $('#pkk_dun_krt').html("{{$koperasi->dun_krt}}");

        /* Maklumat Koperasi */
            $('#pkk1_koperasi_nama').val("{{$koperasi->koperasi_nama}}");
            $('#pkk1_koperasi_tarikh_daftar').val("{{$koperasi->koperasi_tarikh_daftar}}");
            $('#pkk1_koperasi_bilangan_ahli_lembaga').val("{{$koperasi->koperasi_bilangan_ahli_lembaga}}");
            $('#pkk1_koperasi_jumlah_anggota').val("{{$koperasi->koperasi_jumlah_anggota}}");
            if($('#pkk1_status_koperasi_id').val() == null){
                
            }
            if($('#pkk1_status_koperasi_id').val() != null){
                $("input[name=pkk1_status_koperasi_id][value=" + "{{$koperasi->status_koperasi_id}}" + "]").prop('checked', true);
            }
            $('#pkk1_koperasi_pendapatan_semasa').val("{{$koperasi->koperasi_pendapatan_semasa}}");
            $('#pkk1_koperasi_pendapatan_sebelum').val("{{$koperasi->koperasi_pendapatan_sebelum}}");

            url = "{{ route('rt-sm10.get_fungsi_koperasi_table','') }}"+"/"+"{{$koperasi->id}}";

            var fungsi_koperasi_table = $('#fungsi_koperasi_table').DataTable( {
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
                        return full.fungsi_koperasi_description;
                    }
                },{       
                    "aTargets": [ 2 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        $checked 	= (full.krt_koperasi_fungsi_id) ? 'checked' : '';
                        $button_a 	= '<label class="custom-control custom-checkbox">' +
                                    '<input class="custom-control-input" type="checkbox" id="chkp_1' + full.id + '" value="' + full.id + '" onchange="getKoperasiFungsi(&apos;' + full.id + '&apos;)" ' +
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

            url = "{{ route('rt-sm10.get_aktiviti_tambahan_koperasi_table','') }}"+"/"+"{{$koperasi->id}}";

            var aktiviti_tambahan_koperasi_table = $('#aktiviti_tambahan_koperasi_table').DataTable( {
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
                        return full.fungsi_koperasi_description;
                    }
                },{       
                    "aTargets": [ 2 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        $checked 	= (full.krt_koperasi_fungsi_id) ? 'checked' : '';
                        $button_a 	= '<label class="custom-control custom-checkbox">' +
                                    '<input class="custom-control-input" type="checkbox" id="chkp_2' + full.id + '" value="' + full.id + '" onchange="getKoperasiAktivitiTambahan(&apos;' + full.id + '&apos;)" ' +
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

            $('#pkk2_koperasi_krt_id').val("{{$koperasi->id}}");
        
        /* Maklumat Note Kemaskini */   
            $('#pkk_status').val("{{$koperasi->status}}"); 

            if($('#pkk_status').val() == '5'){
                $("#pkk_perlu_kemaskini").show();
                $('#pkk_status_description').html("{{$koperasi->status_description}}");
                $('#pkk_disemak_note').html("{{$koperasi->disemak_note}}");
            }

            if($('#pkk_status').val() == '7'){
                $("#pkk_perlu_kemaskini").show();
                $('#pkk_status_description').html("{{$koperasi->status_description}}");
                $('#pkk_disahkan_note').html("{{$koperasi->disahkan_note}}");
            }
        
        /* Button */
        $('#btn_back').click(function(){
			window.location.href = "{{ route('rt-sm10.permohonan_koperasi_krt') }}";
		});

	});

    function getKoperasiFungsi(id) {
		//checked
		if ($('#chkp_1' + id).is(':checked')) {
			// alert('checked');
			var koperasi_id = "{{$koperasi->id}}";
			url_add_fungsi_koperasi = "{{ route('rt-sm10.post_add_fungsi_koperasi') }}";
			type = "POST";
			$.ajax({
				url: url_add_fungsi_koperasi,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"krt_koperasi_id": koperasi_id,
						"krt_koperasi_fungsi_id": id
						}
			});
		}

		//unchecked
		if (!$('#chkp_1' + id).is(':checked')) {
			// alert('unchecked');
            var koperasi_id = "{{$koperasi->id}}";
			url_delete_fungsi_koperasi 	= "{{ route('rt-sm10.post_delete_fungsi_koperasi','') }}";
            type = "POST";
			$.ajax({
				url: url_delete_fungsi_koperasi,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"krt_koperasi_id": koperasi_id,
						"krt_koperasi_fungsi_id": id
						}
			});
			
		}
	}

    function getKoperasiAktivitiTambahan(id) {
		//checked
		if ($('#chkp_2' + id).is(':checked')) {
			// alert('checked');
			var koperasi_id = "{{$koperasi->id}}";
			url_add_koperasi_aktiviti_tambahan = "{{ route('rt-sm10.post_add_koperasi_aktiviti_tambahan') }}";
			type = "POST";
			$.ajax({
				url: url_add_koperasi_aktiviti_tambahan,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"krt_koperasi_id": koperasi_id,
						"krt_koperasi_fungsi_id": id
						}
			});
		}

		//unchecked
		if (!$('#chkp_2' + id).is(':checked')) {
			// alert('unchecked');
            var koperasi_id = "{{$koperasi->id}}";
			url_delete_koperasi_aktiviti_tambahan 	= "{{ route('rt-sm10.post_delete_koperasi_aktiviti_tambahan','') }}";
            type = "POST";
			$.ajax({
				url: url_delete_koperasi_aktiviti_tambahan,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"krt_koperasi_id": koperasi_id,
						"krt_koperasi_fungsi_id": id
						}
			});
			
		}
	}

    /* Button Submit */

        //my custom script
        var permohonan_koperasi_config = {
            routes: {
                permohonan_koperasi_url: "{{ route('rt-sm10.post_permohonan_koperasi_1') }}",
            }
        };

        $(document).on('submit', '#form_pkk2', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data   = $("#form_pkk1, #form_pkk2").serialize();
            var action = $('#post_permohonan_koperasi_1').val();
            var btn_text;
            if (action == 'edit') {
                url = permohonan_koperasi_config.routes.permohonan_koperasi_url;
                type = "POST";
                btn_text = 'Hantar Permohonan Koperasi&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=pkk1_koperasi_nama]').removeClass("is-invalid");
                $('[name=pkk1_koperasi_tarikh_daftar]').removeClass("is-invalid");
                $('[name=pkk1_koperasi_bilangan_ahli_lembaga]').removeClass("is-invalid");
                $('[name=pkk1_koperasi_jumlah_anggota]').removeClass("is-invalid");
                $('[name=pkk1_status_koperasi_id]').removeClass("is-invalid");
                $('[name=pkk1_koperasi_pendapatan_semasa]').removeClass("is-invalid");
                $('[name=pkk1_koperasi_pendapatan_sebelum]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'pkk1_koperasi_nama') {
                            $('[name=pkk1_koperasi_nama]').addClass("is-invalid");
                            $('.error_pkk1_koperasi_nama').html(error);
                        }

                        if(index == 'pkk1_koperasi_tarikh_daftar') {
                            $('[name=pkk1_koperasi_tarikh_daftar]').addClass("is-invalid");
                            $('.error_pkk1_koperasi_tarikh_daftar').html(error);
                        }

                        if(index == 'pkk1_koperasi_bilangan_ahli_lembaga') {
                            $('[name=pkk1_koperasi_bilangan_ahli_lembaga]').addClass("is-invalid");
                            $('.error_pkk1_koperasi_bilangan_ahli_lembaga').html(error);
                        }

                        if(index == 'pkk1_koperasi_jumlah_anggota') {
                            $('[name=pkk1_koperasi_jumlah_anggota]').addClass("is-invalid");
                            $('.error_pkk1_koperasi_jumlah_anggota').html(error);
                        }

                        if(index == 'pkk1_status_koperasi_id') {
                            $('[name=pkk1_status_koperasi_id]').addClass("is-invalid");
                            $('.error_pkk1_status_koperasi_id').html(error);
                        }

                        if(index == 'pkk1_koperasi_pendapatan_semasa') {
                            $('[name=pkk1_koperasi_pendapatan_semasa]').addClass("is-invalid");
                            $('.error_pkk1_koperasi_pendapatan_semasa').html(error);
                        }

                        if(index == 'pkk1_koperasi_pendapatan_sebelum') {
                            $('[name=pkk1_koperasi_pendapatan_sebelum]').addClass("is-invalid");
                            $('.error_pkk1_koperasi_pendapatan_sebelum').html(error);
                        }

                    });
                    $('#btn_submit').html(btn_text);                
                    $('#btn_submit').prop('disabled', false);            
                } else {
                    $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm10.permohonan_koperasi_krt')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop