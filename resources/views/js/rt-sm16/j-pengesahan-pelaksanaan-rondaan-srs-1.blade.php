@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">  
    
    $(document).ready( function () {
        
    	/* Maklumat Kawasan Krt */
			$('#pprpd_nama_krt').html("{{$pelaksanaan_rondaan->nama_krt}}");
			$('#pprpd_alamat_krt').html("{{$pelaksanaan_rondaan->alamat_krt}}");
			$('#pprpd_negeri_krt').html("{{$pelaksanaan_rondaan->negeri_krt}}");
			$('#pprpd_daerah_krt').html("{{$pelaksanaan_rondaan->daerah_krt}}");
			$('#pprpd_parlimen_krt').html("{{$pelaksanaan_rondaan->parlimen_krt}}");
			$('#pprpd_dun_krt').html("{{$pelaksanaan_rondaan->dun_krt}}");
			$('#pprpd_pbt_krt').html("{{$pelaksanaan_rondaan->pbt_krt}}");

        /* Maklumat Pelaksanaan Srs */
            $('#pprpd_srs_profile_id').val("{{$pelaksanaan_rondaan->srs_profile_id}}");
            $('#pprpd_pelaksanaan_rondaan_tarikh').val("{{$pelaksanaan_rondaan->pelaksanaan_rondaan_tarikh}}");
            url = "{{ route('rt-sm16.get_senarai_ahli_ppd_table','') }}"+"/"+"{{$pelaksanaan_rondaan->id}}";

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
                                    '<input class="custom-control-input" type="checkbox" id="chkp_1' + full.id + '" disabled value="' + full.id + '" onchange="getAhliPeronda(&apos;' + full.id + '&apos;)" ' +
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

            $('#pprpd_pelaksanaan_rondaan_kes').val("{{$pelaksanaan_rondaan->pelaksanaan_rondaan_kes}}");
            $('#pprpd_srs_pelaksanaan_rondaan_id').val("{{$pelaksanaan_rondaan->id}}");
            
            if($('#pprpd_pelaksanaan_rondaan_kes').val() == 'Ada'){
                $("#btn_next_disabled").hide();
                $("#status_pengesahan_1").hide();
                $("#status_pengesahan_2").show();
                $("#btn_next").show();
            } else if($('#pprpd_pelaksanaan_rondaan_kes').val() == 'Tiada'){
                $("#btn_next_disabled").show();
                $("#status_pengesahan_1").show();
                $("#status_pengesahan_2").hide();
                $("#btn_next").hide();
            }


        /* Button */
            $('#btn_back').click(function(){
                window.location.href = '{{route('rt-sm16.pengesahan_pelaksanaan_rondaan_srs')}}';
            });

            $('#btn_next').click(function(){
                window.location.href = '{{route('rt-sm16.pengesahan_pelaksanaan_rondaan_srs_2','')}}'+'/'+'{{$pelaksanaan_rondaan->id}}';
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

    /* action submit */
        //my custom script
        var pengesahan_pelaksanaan_rondaan_srs_config = {
            routes: {
                pengesahan_pelaksanaan_rondaan_srs_url: "{{ route('rt-sm16.post_pengesahan_pelaksanaan_rondaan_srs') }}",
            }
        };

        $(document).on('click', '#btn_submit', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_pprpd").serialize();
            var action = $('#post_pengesahan_pelaksanaan_rondaan_srs').val();
            var btn_text;
            if (action == 'edit') {
                url = pengesahan_pelaksanaan_rondaan_srs_config.routes.pengesahan_pelaksanaan_rondaan_srs_url;
                type = "POST";
                btn_text = 'Hantar Status Pengesahan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=pprpd_pelaksanaan_rondaan_status]').removeClass("is-invalid");
                $('[name=pprpd_disemak_note]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'pprpd_pelaksanaan_rondaan_status') {
                        $('[name=pprpd_pelaksanaan_rondaan_status]').addClass("is-invalid");
                        $('.error_pprpd_pelaksanaan_rondaan_status').html(error);
                    }

                    if(index == 'pprpd_disemak_note') {
                        $('[name=pprpd_disemak_note]').addClass("is-invalid");
                        $('.error_pprpd_disemak_note').html(error);
                    }
                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
                $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm16.pengesahan_pelaksanaan_rondaan_srs')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop