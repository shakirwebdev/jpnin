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

</style>
<script type="text/javascript"> 

	$(document).ready( function () {
        
    	/* Maklumat Kawasan Krt */
            $('#spspn_nama_krt').html("{{$pembatalan_srs->nama_krt}}");
            $('#spspn_alamat_krt').html("{{$pembatalan_srs->alamat_krt}}");
            $('#spspn_negeri_krt').html("{{$pembatalan_srs->negeri_krt}}");
            $('#spspn_parlimen_krt').html("{{$pembatalan_srs->parlimen_krt}}");
            $('#spspn_pbt_krt').html("{{$pembatalan_srs->pbt_krt}}");
            $('#spspn_daerah_krt').html("{{$pembatalan_srs->daerah_krt}}");
            $('#spspn_dun_krt').html("{{$pembatalan_srs->dun_krt}}");

        /* Maklumat Pemohon */
            $('#spspn_pemohon_name').val("{{$pembatalan_srs->direkod_by}}");
            $('#spspn_pemohon_ic').val("{{$pembatalan_srs->direkod_ic}}");
            $('#spspn_pemohon_address').val("{{$pembatalan_srs->direkod_alamat}}");

        /* Maklumat Status Semakan */
            $('#spspn_pembatalan_id').val("{{$pembatalan_srs->id}}");
            $('#spspn_disemak_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

        /* Maklumat Pembatalan Srs */
            $('#spspn_srs_profile_id').val("{{$pembatalan_srs->srs_profile_id}}");
            url_senarai_minit_meeting_table 	= "{{ route('rt-sm19.get_senarai_minit_meeting_pembatalan_table','') }}"+"/"+"{{$pembatalan_srs->id}}";
            
            var senarai_minit_meeting_table = $('#senarai_minit_meeting_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_senarai_minit_meeting_table,
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
					"width": "60%", 
					"mRender": function ( value, type, full )  {
						return full.mesyuarat_title;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					"mRender": function ( value, type, full )  {
						return full.keterangan;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%",
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Cetak Minit Mesyuarat JawatanKuasa" target="_blank" onclick="print_minit_mesyuarat(\'' + full.id + '\');"><i class="fa fa-print"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

        /* Maklumat Error */
            $('#spspn_pembatalan_status').val("{{$pembatalan_srs->pembatalan_status}}");
            $('#spspn_status_description').html("{{$pembatalan_srs->status_description}}");
            $('#spspn_diluluskan_note').html("{{$pembatalan_srs->diluluskan_note}}");

            if($('#spspn_pembatalan_status').val() == '8'){
                $("#spspn_perlu_kemaskini").show();
            }

            $('#btn_back').click(function(){
                window.location.href = "{{route('rt-sm19.semakan_pembatalan_srs_ppd')}}";
            });
        
    });

    /* click button print minit meeting */
        function print_minit_mesyuarat(id){
            window.location.href = "{{route('pdf.minit_mesyuarat','')}}"+"/"+id;
        }

    /* action submit */
        //my custom script
        var pengesahan_pembatalan_srs_config = {
            routes: {
                pengesahan_pembatalan_srs_url: "{{ route('rt-sm19.post_pengesahan_pembatalan_srs') }}",
            }
        };

        $(document).on('click', '#btn_submit', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_spspn").serialize();
            var action = $('#post_pengesahan_pembatalan_srs').val();
            var btn_text;
            if (action == 'edit') {
                url = pengesahan_pembatalan_srs_config.routes.pengesahan_pembatalan_srs_url;
                type = "POST";
                btn_text = 'Hantar Status Pengesahan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=spspn_pembatalan_status]').removeClass("is-invalid");
                $('[name=spspn_disemak_note]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'spspn_pembatalan_status') {
                        $('[name=spspn_pembatalan_status]').addClass("is-invalid");
                        $('.error_spspn_pembatalan_status').html(error);
                    }

                    if(index == 'spspn_disemak_note') {
                        $('[name=spspn_disemak_note]').addClass("is-invalid");
                        $('.error_spspn_disemak_note').html(error);
                    }
                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
                $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm19.pengesahan_pembatalan_srs_ppn')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop