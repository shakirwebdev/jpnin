@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">    
    
    $(document).ready( function () {
        
    	/* Maklumat Kawasan Krt */
			$('#pprs_nama_krt').html("{{$perancangan_rondaan->nama_krt}}");
			$('#pprs_alamat_krt').html("{{$perancangan_rondaan->alamat_krt}}");
			$('#pprs_negeri_krt').html("{{$perancangan_rondaan->negeri_krt}}");
			$('#pprs_daerah_krt').html("{{$perancangan_rondaan->daerah_krt}}");
			$('#pprs_parlimen_krt').html("{{$perancangan_rondaan->parlimen_krt}}");
			$('#pprs_dun_krt').html("{{$perancangan_rondaan->dun_krt}}");
			$('#pprs_pbt_krt').html("{{$perancangan_rondaan->pbt_krt}}");

        /* Maklumat Perancangan Srs */
            $('#pprs_srs_perancangan_rondaan_id').val("{{$perancangan_rondaan->id}}");
            $('#pprs_srs_profile_id').val("{{$perancangan_rondaan->srs_profile_id}}");

            url = "{{ route('rt-sm15.get_senarai_ahli','') }}"+"/"+"{{$perancangan_rondaan->id}}";

            var senarai_ahli_table = $('#senarai_ahli_table').DataTable( {
                processing: true,
                serverSide: true,
                "pageLength": 50,
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
                        return full.peronda_nama;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "60%", 
                    "mRender": function ( value, type, full )  {
                        return full.peronda_ic;
                    }
                },{       
                    "aTargets": [ 3 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        $checked 	= (full.srs__perancangan_rondaan_ahli_id) ? 'checked' : '';
                        $button_a 	= '<label class="custom-control custom-checkbox">' +
                                    '<input class="custom-control-input" type="checkbox" id="chkp_1' + full.id + '" value="' + full.id + '" onchange="getAhliPeronda(&apos;' + full.id + '&apos;)" ' +
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

        /* Button */
            $('#btn_back').click(function(){
                window.location.href = '{{route('rt-sm15.penyediaan_perancangan_rondaan_srs')}}';
            });
    });

    function getAhliPeronda(id) {
		//checked
		if ($('#chkp_1' + id).is(':checked')) {
			// alert('checked');
			var pprs_srs_perancangan_rondaan_id = $('#pprs_srs_perancangan_rondaan_id').val();
			url_add_perancangan_rondaan_ahli = "{{ route('rt-sm15.add_perancangan_rondaan_ahli') }}";
			type = "POST";
			$.ajax({
				url: url_add_perancangan_rondaan_ahli,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"pprs_srs_perancangan_rondaan_id": pprs_srs_perancangan_rondaan_id,
						"srs_ahli_peronda_id": id
						}
			});
		}

		//unchecked
		if (!$('#chkp_1' + id).is(':checked')) {
			// alert('unchecked');
			url_delete__perancangan_rondaan_ahli 	= "{{ route('rt-sm15.delete__perancangan_rondaan_ahli','') }}";
			$.ajax({
				type: "GET",
				url: url_delete__perancangan_rondaan_ahli +"/" + id,
			});
			
		}
	}

    //my custom script
	var penyediaan_perancangan_rondaan_srs_config = {
        routes: {
            penyediaan_perancangan_rondaan_srs_url: "{{ route('rt-sm15.post_tambah_perancangan_rondaan_1') }}",
        }
    };

    $(document).on('submit', '#form_pprs', function(event){    
        event.preventDefault();
        $('#btn_add').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
        $('#btn_add').prop('disabled', true);
        var data = $("#form_pprs").serialize();
        var action = $('#post_tambah_perancangan_rondaan_1').val();
        var btn_text;
        if (action == 'edit') {
            url = penyediaan_perancangan_rondaan_srs_config.routes.penyediaan_perancangan_rondaan_srs_url;
            type = "POST";
            btn_text = 'Simpan &nbsp;';
        } 
		$.ajax({
            url: url,
            type: type,
            data: data,
        }).done(function(response) {        
            $('[name=pprs_perancangan_rondaan_tarikh]').removeClass("is-invalid");
			
			if(response.errors){
                $.each(response.errors, function(index, error){
                    
                    if(index == 'pprs_perancangan_rondaan_tarikh') {
                        $('[name=pprs_perancangan_rondaan_tarikh]').addClass("is-invalid");
                        $('.error_pprs_perancangan_rondaan_tarikh').html(error);
                    }

				});
                $('#btn_add').html(btn_text);                
                $('#btn_add').prop('disabled', false);            
            } else {
				$('#btn_add').html(btn_text);
                $('#btn_add').prop('disabled', false); 
				window.location.href = "{{route('rt-sm15.penyediaan_perancangan_rondaan_srs')}}";
            }
        });
    });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop