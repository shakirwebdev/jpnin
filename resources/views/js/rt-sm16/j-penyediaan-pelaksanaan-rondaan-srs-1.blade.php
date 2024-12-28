@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">  
    
    $(document).ready( function () {
        
    	/* Maklumat Kawasan Krt */
			$('#pprs_nama_krt').html("{{$pelaksanaan_rondaan->nama_krt}}");
			$('#pprs_alamat_krt').html("{{$pelaksanaan_rondaan->alamat_krt}}");
			$('#pprs_negeri_krt').html("{{$pelaksanaan_rondaan->negeri_krt}}");
			$('#pprs_daerah_krt').html("{{$pelaksanaan_rondaan->daerah_krt}}");
			$('#pprs_parlimen_krt').html("{{$pelaksanaan_rondaan->parlimen_krt}}");
			$('#pprs_dun_krt').html("{{$pelaksanaan_rondaan->dun_krt}}");
			$('#pprs_pbt_krt').html("{{$pelaksanaan_rondaan->pbt_krt}}");

        /* Maklumat Pelaksanaan Srs */
            $('#pprs_srs_pelaksanaan_rondaan_id').val("{{$pelaksanaan_rondaan->id}}");
            $('#pprs_srs_profile_id').val("{{$pelaksanaan_rondaan->srs_profile_id}}");
            $('#pprs_pelaksanaan_rondaan_tarikh').val("{{$pelaksanaan_rondaan->pelaksanaan_rondaan_tarikh}}");
            $('#pprs_pelaksanaan_rondaan_kes').val("{{$pelaksanaan_rondaan->pelaksanaan_rondaan_kes}}");

            if($('#pprs_pelaksanaan_rondaan_kes').val() == 'Ada'){
                $("#btn_add").hide();
                $("#btn_next").show();
            } else if($('#pprs_pelaksanaan_rondaan_kes').val() == 'Ada'){
                $("#btn_add").show();
                $("#btn_next").hide();
            }

            url = "{{ route('rt-sm16.get_senarai_ahli_table','') }}"+"/"+"{{$pelaksanaan_rondaan->id}}";

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
                        $checked 	= (full.srs__pelaksanaan_rondaan_ahli_id) ? 'checked' : '';
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

            $('#pprs_pelaksanaan_rondaan_kes').on('change', function() {
                if ($('#pprs_pelaksanaan_rondaan_kes').val() == 'Ada') {
                    $("#btn_add").hide();
                    $("#btn_next").show();
                } else if ($('#pprs_pelaksanaan_rondaan_kes').val() == 'Tiada') {
                    $("#btn_add").show();
                    $("#btn_next").hide();
                }
            });


        /* Button */
            $('#btn_back').click(function(){
                window.location.href = '{{route('rt-sm16.penyediaan_pelaksanaan_rondaan_srs')}}';
            });
        
    });

    function getAhliPeronda(id) {
		//checked
		if ($('#chkp_1' + id).is(':checked')) {
			// alert('checked');
			var pprs_srs_pelaksanaan_rondaan_id = $('#pprs_srs_pelaksanaan_rondaan_id').val();
			url_add_pelaksanaan_rondaan_ahli = "{{ route('rt-sm16.add_pelaksanaan_rondaan_ahli') }}";
			type = "POST";
			$.ajax({
				url: url_add_pelaksanaan_rondaan_ahli,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"pprs_srs_pelaksanaan_rondaan_id": pprs_srs_pelaksanaan_rondaan_id,
						"srs_ahli_peronda_id": id
						}
			});
		}

		//unchecked
		if (!$('#chkp_1' + id).is(':checked')) {
			// alert('unchecked');
			url_delete__pelaksanaan_rondaan_ahli 	= "{{ route('rt-sm16.delete__pelaksanaan_rondaan_ahli','') }}";
			$.ajax({
				type: "GET",
				url: url_delete__pelaksanaan_rondaan_ahli +"/" + id,
			});
			
		}
	}

    

    //my custom script
    var penyediaan_pelaksanaan_rondaan_srs_config = {
        routes: {
            seterusnya_penyediaan_pelaksanaan_rondaan_srs_url: "{{ route('rt-sm16.post_tambah_pelaksanaan_rondaan_1') }}",
            hantar_penyediaan_pelaksanaan_rondaan_srs_url: "{{ route('rt-sm16.post_tambah_pelaksanaan_rondaan_2') }}",
        }
    };

    /* Button Seterusnya */
        $(document).on('click', '#btn_next', function(event){    
            event.preventDefault();
                $('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
                $('#btn_next').prop('disabled', true);
                var data = $("#form_pprs").serialize();
                var action = $('#post_tambah_pelaksanaan_rondaan_1').val();
                var btn_text;
                if (action == 'edit') {
                    url = penyediaan_pelaksanaan_rondaan_srs_config.routes.seterusnya_penyediaan_pelaksanaan_rondaan_srs_url;
                    type = "POST";
                    btn_text = 'Seterusnya&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
                } 
                $.ajax({
                    url: url,
                    type: type,
                    data: data,
                }).done(function(response) {        
                    $('[name=pprs_srs_profile_id]').removeClass("is-invalid");
                    $('[name=pprs_pelaksanaan_rondaan_tarikh]').removeClass("is-invalid");
                    $('[name=pprs_pelaksanaan_rondaan_kes]').removeClass("is-invalid");
                    
                    if(response.errors){
                        $.each(response.errors, function(index, error){
                            if(index == 'pprs_srs_profile_id') {
                                $('[name=pprs_srs_profile_id]').addClass("is-invalid");
                                $('.error_pprs_srs_profile_id').html(error);
                            }

                            if(index == 'pprs_pelaksanaan_rondaan_tarikh') {
                                $('[name=pprs_pelaksanaan_rondaan_tarikh]').addClass("is-invalid");
                                $('.error_pprs_pelaksanaan_rondaan_tarikh').html(error);
                            }

                            if(index == 'pprs_pelaksanaan_rondaan_kes') {
                                $('[name=pprs_pelaksanaan_rondaan_kes]').addClass("is-invalid");
                                $('.error_pprs_pelaksanaan_rondaan_kes').html(error);
                            }

                        });
                        $('#btn_next').html(btn_text);                
                        $('#btn_next').prop('disabled', false);            
                    } else {
                        $('#btn_next').html(btn_text);
                        $('#btn_next').prop('disabled', false); 
                        window.location.href = "{{route('rt-sm16.penyediaan_pelaksanaan_rondaan_srs_2','')}}"+"/"+"{{$pelaksanaan_rondaan->id}}";
                    }
                });
        });

    /* Hantar Pelaksanaan Rondaan SRS */
        $(document).on('submit', '#form_pprs', function(event){    
            event.preventDefault();
            $('#btn_add').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_add').prop('disabled', true);
            var data = $("#form_pprs").serialize();
            var action = $('#post_tambah_pelaksanaan_rondaan_2').val();
            var btn_text;
            if (action == 'edit') {
                url = penyediaan_pelaksanaan_rondaan_srs_config.routes.hantar_penyediaan_pelaksanaan_rondaan_srs_url;
                type = "POST";
                btn_text = 'Hantar Pelaksanaan Rondaan SRS&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=pprs_srs_profile_id]').removeClass("is-invalid");
                $('[name=pprs_pelaksanaan_rondaan_tarikh]').removeClass("is-invalid");
                $('[name=pprs_pelaksanaan_rondaan_kes]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'pprs_srs_profile_id') {
                            $('[name=pprs_srs_profile_id]').addClass("is-invalid");
                            $('.error_pprs_srs_profile_id').html(error);
                        }

                        if(index == 'pprs_pelaksanaan_rondaan_tarikh') {
                            $('[name=pprs_pelaksanaan_rondaan_tarikh]').addClass("is-invalid");
                            $('.error_pprs_pelaksanaan_rondaan_tarikh').html(error);
                        }

                        if(index == 'pprs_pelaksanaan_rondaan_kes') {
                            $('[name=pprs_pelaksanaan_rondaan_kes]').addClass("is-invalid");
                            $('.error_pprs_pelaksanaan_rondaan_kes').html(error);
                        }

                    });
                    $('#btn_add').html(btn_text);                
                    $('#btn_add').prop('disabled', false);            
                } else {
                    $('#btn_add').html(btn_text);
                    $('#btn_add').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm16.penyediaan_pelaksanaan_rondaan_srs')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop