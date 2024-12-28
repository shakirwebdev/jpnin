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
			$('#paps1_nama_krt').html("{{$srs_ahli_peronda->nama_krt}}");
			$('#paps1_alamat_krt').html("{{$srs_ahli_peronda->alamat_krt}}");
			$('#paps1_negeri_krt').html("{{$srs_ahli_peronda->negeri_krt}}");
			$('#paps1_parlimen_krt').html("{{$srs_ahli_peronda->daerah_krt}}");
			$('#paps1_pbt_krt').html("{{$srs_ahli_peronda->parlimen_krt}}");
			$('#paps1_daerah_krt').html("{{$srs_ahli_peronda->dun_krt}}");
			$('#paps1_dun_krt').html("{{$srs_ahli_peronda->pbt_krt}}");

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

			$('#paps2_srs_ahli_peronda_id').val("{{$srs_ahli_peronda->id}}");

		/* Maklumat Note Kemaskini */   
			$('#paps_status').val("{{$srs_ahli_peronda->status}}"); 

			if($('#paps_status').val() == '6'){
				$("#paps_perlu_kemaskini").show();
				$('#paps_status_description').html("{{$srs_ahli_peronda->status_description}}");
				$('#paps_disemak_note').html("{{$srs_ahli_peronda->disemak_note}}");
			}

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{route('rt-sm13.pendaftaran_ahli_peronda_srs','')}}"+"/"+{{$srs_ahli_peronda->id}};
			});

	});

	function getPekerjaan(id) {
		//checked
		if ($('#chkp_1' + id).is(':checked')) {
			// alert('checked');
			var paps1_srs_ahli_peronda_id = $('#paps1_srs_ahli_peronda_id').val();
			url_add_pekerjaan = "{{ route('rt-sm13.add_pekerjaan') }}";
			type = "POST";
			$.ajax({
				url: url_add_pekerjaan,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"paps1_srs_ahli_peronda_id": paps1_srs_ahli_peronda_id,
						"srs_ahli_peronda_pekerjaanID": id
						}
			});
		}

		//unchecked
		if (!$('#chkp_1' + id).is(':checked')) {
			// alert('unchecked');
            var paps1_srs_ahli_peronda_id 	= $('#paps1_srs_ahli_peronda_id').val();
			url_delete_pekerjaan 	= "{{ route('rt-sm13.delete_pekerjaan','') }}";
            type = "POST";
			$.ajax({
				url: url_delete_pekerjaan,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"paps1_srs_ahli_peronda_id": paps1_srs_ahli_peronda_id,
						"srs_ahli_peronda_pekerjaanID": id
						}
			});
			
		}
	}

	//my custom script
	var daftar_ahli_peronda_srs_1_config = {
        routes: {
            daftar_ahli_peronda_srs_1_url: "{{ route('rt-sm13.post_pendaftaran_ahli_peronda_srs_1') }}",
        }
    };

	$(document).on('submit', '#form_paps2', function(event){    
        event.preventDefault();
        $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
        $('#btn_submit').prop('disabled', true);
        var data = $("#form_paps2").serialize();
        var action = $('#post_pendaftaran_ahli_peronda_srs_1').val();
        var btn_text;
        if (action == 'edit') {
            url = daftar_ahli_peronda_srs_1_config.routes.daftar_ahli_peronda_srs_1_url;
            type = "POST";
            btn_text = 'Hantar Pendaftaran Ajli Peronda SRS &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
        } 
		$.ajax({
            url: url,
            type: type,
            data: data,
        }).done(function(response) {        
            
			if(response.errors){
                $.each(response.errors, function(index, error){
                    

				});
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
				$('#btn_submit').html(btn_text);
                $('#btn_submit').prop('disabled', false); 
				window.location.href = "{{route('rt-sm13.senarai_pendaftaran_ahli_peronda_srs')}}";
            }
        });
    });
	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop