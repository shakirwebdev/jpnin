@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {

		/* Maklumat Kawasan Krt */
            $('#spapsp1_nama_krt').html("{{$srs_ahli_peronda->nama_krt}}");
            $('#spapsp1_alamat_krt').html("{{$srs_ahli_peronda->alamat_krt}}");
            $('#spapsp1_negeri_krt').html("{{$srs_ahli_peronda->negeri_krt}}");
            $('#spapsp1_parlimen_krt').html("{{$srs_ahli_peronda->daerah_krt}}");
            $('#spapsp1_pbt_krt').html("{{$srs_ahli_peronda->parlimen_krt}}");
            $('#spapsp1_daerah_krt').html("{{$srs_ahli_peronda->dun_krt}}");
            $('#spapsp1_dun_krt').html("{{$srs_ahli_peronda->pbt_krt}}");

        /* Maklumat Status Semakan */
            $('#spapsp1_ahli_peronda_id').val("{{$srs_ahli_peronda->id}}");

		/* Maklumat Pemohonan Ahli Peronda SRS */
            $('#paps1_srs_ahli_peronda_id').val("{{$srs_ahli_peronda->id}}");

		    url = "{{ route('rt-sm13.get_senarai_pekerjaan_table','') }}"+"/"+"{{$srs_ahli_peronda->id}}";
		
            var senarai_pekerjaan_table = $('#senarai_pekerjaan_table').DataTable( {
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
                rowCallback: function(nRow, aData, index) {
                    var info = senarai_pekerjaan_table.page.info();
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
                        return full.profession_description;
                    }
                },{       
                    "aTargets": [ 2 ], 
                    "width": "6%", 
                    "mRender": function ( value, type, full )  {
                        $checked 	= (full.srs_ahli_peronda_pekerjaanID) ? 'checked' : '';
                        $button_a 	= '<label class="custom-control custom-checkbox">' +
                                    '<input class="custom-control-input" type="checkbox" id="chkp_1' + full.id + '" value="' + full.id + '" onchange="getPekerjaan(&apos;' + full.id + '&apos;)" ' +
                                    $checked + ' disabled>' +
                                    '<span class="custom-control-label">&nbsp;</span></label>';
                        return $button_a;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

		

		$('#btn_back').click(function(){
			window.location.href = "{{route('rt-sm13.semak_pendaftaran_ahli_peronda_srs_ppd_1','')}}"+"/"+{{$srs_ahli_peronda->id}};
		});

	});

	function getPekerjaan(id) {
		//checked
		if ($('#chkp_1' + id).is(':checked')) {
			// alert('checked');
			var spapsp1_srs_ahli_peronda_id = $('#spapsp1_srs_ahli_peronda_id').val();
			url_add_pekerjaan = "{{ route('rt-sm13.add_pekerjaan') }}";
			type = "POST";
			$.ajax({
				url: url_add_pekerjaan,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"spapsp1_srs_ahli_peronda_id": spapsp1_srs_ahli_peronda_id,
						"srs_ahli_peronda_pekerjaanID": id
						}
			});
		}

		//unchecked
		if (!$('#chkp_1' + id).is(':checked')) {
			// alert('unchecked');
			url_delete_pekerjaan 	= "{{ route('rt-sm13.delete_pekerjaan','') }}";
			$.ajax({
				type: "GET",
				url: url_delete_pekerjaan +"/" + id,
			});
			
		}
	}

    /* click button Hantar */
        //my custom script
        var semak_pendaftaran_ahli_peronda_config = {
            routes: {
                semak_pendaftaran_ahli_peronda_url: "{{ route('rt-sm13.post_semak_pendaftaran_ahli_peronda') }}",
            }
        };

        $(document).on('submit', '#form_spapsp1', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_spapsp1").serialize();
            var action = $('#post_semak_pendaftaran_ahli_peronda').val();
            var btn_text;
            if (action == 'edit') {
                url = semak_pendaftaran_ahli_peronda_config.routes.semak_pendaftaran_ahli_peronda_url;
                type = "POST";
                btn_text = 'Hantar Status Semakan &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=spapsp1_peronda_status]').removeClass("is-invalid");
                $('[name=spapsp1_disemak_note]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'spapsp1_peronda_status') {
                            $('[name=spapsp1_peronda_status]').addClass("is-invalid");
                            $('.error_spapsp1_peronda_status').html(error);
                        }

                        if(index == 'spapsp1_disemak_note') {
                            $('[name=spapsp1_disemak_note]').addClass("is-invalid");
                            $('.error_spapsp1_disemak_note').html(error);
                        }

                    });
                    $('#btn_submit').html(btn_text);                
                    $('#btn_submit').prop('disabled', false);            
                } else {
                    $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm13.semak_pendaftaran_ahli_peronda_srs_ppd')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop