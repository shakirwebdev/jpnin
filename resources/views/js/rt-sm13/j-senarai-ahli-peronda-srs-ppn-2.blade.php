@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {

		/* Maklumat Kawasan Krt */
            $('#apspn1_nama_krt').html("{{$srs_ahli_peronda->nama_krt}}");
            $('#apspn1_alamat_krt').html("{{$srs_ahli_peronda->alamat_krt}}");
            $('#apspn1_negeri_krt').html("{{$srs_ahli_peronda->negeri_krt}}");
            $('#apspn1_parlimen_krt').html("{{$srs_ahli_peronda->daerah_krt}}");
            $('#apspn1_pbt_krt').html("{{$srs_ahli_peronda->parlimen_krt}}");
            $('#apspn1_daerah_krt').html("{{$srs_ahli_peronda->dun_krt}}");
            $('#apspn1_dun_krt').html("{{$srs_ahli_peronda->pbt_krt}}");

        /* Maklumat Status Semakan */
            $('#apspn1_ahli_peronda_id').val("{{$srs_ahli_peronda->id}}");

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
			window.location.href = "{{route('rt-sm13.senarai_ahli_peronda_srs_ppn_1','')}}"+"/"+{{$srs_ahli_peronda->id}};
		});

	});

	function getPekerjaan(id) {
		//checked
		if ($('#chkp_1' + id).is(':checked')) {
			// alert('checked');
			var apspn1_srs_ahli_peronda_id = $('#apspn1_srs_ahli_peronda_id').val();
			url_add_pekerjaan = "{{ route('rt-sm13.add_pekerjaan') }}";
			type = "POST";
			$.ajax({
				url: url_add_pekerjaan,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"apspn1_srs_ahli_peronda_id": apspn1_srs_ahli_peronda_id,
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

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop