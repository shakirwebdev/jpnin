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
            $('#spk_nama_krt').html("{{$pembatalan_krt->nama_krt}}");
            $('#spk_alamat_krt').html("{{$pembatalan_krt->alamat_krt}}");
            $('#spk_negeri_krt').html("{{$pembatalan_krt->negeri_krt}}");
            $('#spk_parlimen_krt').html("{{$pembatalan_krt->parlimen_krt}}");
            $('#spk_pbt_krt').html("{{$pembatalan_krt->pbt_krt}}");
            $('#spk_daerah_krt').html("{{$pembatalan_krt->daerah_krt}}");
            $('#spk_dun_krt').html("{{$pembatalan_krt->dun_krt}}");

        /* Maklumat Pembatalan Krt */
            $("input[name=spk_tujuan_pembatalan_id][value=" + "{{$pembatalan_krt->tujuan_pembatalan_id}}" + "]").prop('checked', true);
            $('#spk_nyatakan_tujuan').val("{{$pembatalan_krt->nyatakan_tujuan}}");

        /* Maklumat Pembatalan Krt */
            $('#spk_pembatalan_id').val("{{$pembatalan_krt->id}}");
           
            url_senarai_minit_meeting_table 	= "{{ route('rt-sm8.get_minit_meeting_pembatalan_krt_table','') }}"+"/"+"{{$pembatalan_krt->id}}";
            
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
						button_a = '<button type="button" class="btn btn-icon" title="Cetak Minit Mesyuarat JawatanKuasa" target="_blank" onclick="print_minit_mesyuarat(\'' + full.minit_mesyuarat_id + '\');"><i class="fa fa-print"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

            var senarai_maklumat_kewangan_table = $('#senarai_maklumat_kewangan_table').DataTable( {
				processing: true,
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
                data: dataKewangan,
                columns: [
                    {bSortable: false, sClass: 'text-center'},
                    {bSortable: false},
                    {data : null, bSortable: false, sClass: 'text-center',
                        mRender: function (value, type, full) {
                            button_a = '<button type="button" class="btn btn-icon" title="Cetak Maklumat Kewangan" onclick="print_kewangan();"><i class="fa fa-print"></i></button>';
                        return button_a;
                        }
                    },
                ]
			});

			$('#spk_disemak_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
		
		/* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{route('rt-sm8.semakan_pembatalan_krt')}}";
            });

	});

    /* click button print minit meeting */
        function print_minit_mesyuarat(id){
            window.location.href = "{{route('pdf.minit_mesyuarat','')}}"+"/"+id;
        }

    /* Maklumat Kewangan */
        var dataKewangan = [ 
            ["1", "Maklumat Kewangan {{$pembatalan_krt->nama_krt}}",]
        ];

    /* click button print kewangan */
        function print_kewangan(){
            window.location.href = "{{route('pdf.report_kewangan_krt','')}}"+"/"+"{{$pembatalan_krt->krt_profile_id}}";
        }

    /* action submit */
        //my custom script
        var semakan_pembatalan_ket_config = {
            routes: {
                semakan_pembatalan_krt_url: "{{ route('rt-sm8.post_semakan_pembatalan_krt') }}",
            }
        };

        $(document).on('click', '#btn_submit', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_spk").serialize();
            var action = $('#post_semakan_pembatalan_krt').val();
            var btn_text;
            if (action == 'edit') {
                url = semakan_pembatalan_ket_config.routes.semakan_pembatalan_krt_url;
                type = "POST";
                btn_text = 'Hantar Status Semakan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=spk_pembatalan_status]').removeClass("is-invalid");
                $('[name=spk_disemak_note]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'spk_pembatalan_status') {
                        $('[name=spk_pembatalan_status]').addClass("is-invalid");
                        $('.error_spk_pembatalan_status').html(error);
                    }

                    if(index == 'spk_disemak_note') {
                        $('[name=spk_disemak_note]').addClass("is-invalid");
                        $('.error_spk_disemak_note').html(error);
                    }
                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
                $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm8.semakan_pembatalan_krt')}}";
                }
            });
        });
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop