
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

        /* Maklumat Status Pengesahan */
            $('#pkk_disahkan_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
            
        /* Maklumat Koperasi */
            $('#pkk1_koperasi_nama').val("{{$koperasi->koperasi_nama}}");
            $('#pkk1_koperasi_tarikh_daftar').val("{{$koperasi->koperasi_tarikh_daftar}}");
            $('#pkk1_koperasi_bilangan_ahli_lembaga').val("{{$koperasi->koperasi_bilangan_ahli_lembaga}}");
            $('#pkk1_koperasi_jumlah_anggota').val("{{$koperasi->koperasi_jumlah_anggota}}");
            $("input[name=pkk1_status_koperasi_id][value=" + "{{$koperasi->status_koperasi_id}}" + "]").prop('checked', true);
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
        
        /* Maklumat Menyemak */
            $('#pkk_koperasi_krt_id').val("{{$koperasi->id}}");
        
        /* Button */
        $('#btn_back').click(function(){
			window.location.href = "{{ route('rt-sm10.semakan_koperasi_krt') }}";
		});

	});

    /* action submit */
        //my custom script
        var pengesahan_koperasi_config = {
            routes: {
                pengesahan_koperasi_url: "{{ route('rt-sm10.post_pengesahan_koperasi') }}",
            }
        };

        $(document).on('submit', '#form_pkk', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_pkk").serialize();
            var action = $('#post_pengesahan_koperasi').val();
            var btn_text;
            if (action == 'edit') {
                url = pengesahan_koperasi_config.routes.pengesahan_koperasi_url;
                type = "POST";
                btn_text = 'Hantar Status Pengesahan &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=pkk_status]').removeClass("is-invalid");
                $('[name=pkk_disahkan_note]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'pkk_status') {
                        $('[name=pkk_status]').addClass("is-invalid");
                        $('.error_pkk_status').html(error);
                    }

                    if(index == 'pkk_disahkan_note') {
                        $('[name=pkk_disahkan_note]').addClass("is-invalid");
                        $('.error_pkk_disahkan_note').html(error);
                    }
                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
                $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm10.pengesahan_koperasi_krt')}}";
                }
            });
        });

    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop