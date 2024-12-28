@include('js.modal.j-modal-view-pekara-berbangkit-mesyuarat-krt')
@include('js.modal.j-modal-view-kertas-kerja-mesyuarat-krt')
@include('js.modal.j-modal-view-hal-lain-mesyuarat-krt')
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    $(document).ready( function () {

		//my custom script
            url_get_senarai_perkara_berbangkit 			= "{{ route('rt-sm5.get_senarai_perkara_berbangkit','') }}"+"/"+"{{$pengesahan_minit_mesyuarat->id}}";
            url_get_senarai_kertas_kerja 				= "{{ route('rt-sm5.get_senarai_kertas_kerja','') }}"+"/"+"{{$pengesahan_minit_mesyuarat->id}}";
            url_get_senarai_hal_lain 					= "{{ route('rt-sm5.get_senarai_hal_lain','') }}"+"/"+"{{$pengesahan_minit_mesyuarat->id}}";

		/* Maklumat Kawasan Krt */
            $('#pmmrp_1_nama_krt').html("{{$pengesahan_minit_mesyuarat->nama_krt}}");
            $('#pmmrp_1_alamat_krt').html("{{$pengesahan_minit_mesyuarat->alamat_krt}}");
            $('#pmmrp_1_negeri_krt').html("{{$pengesahan_minit_mesyuarat->negeri_krt}}");
            $('#pmmrp_1_parlimen_krt').html("{{$pengesahan_minit_mesyuarat->parlimen_krt}}");
            $('#pmmrp_1_pbt_krt').html("{{$pengesahan_minit_mesyuarat->pbt_krt}}");
            $('#pmmrp_1_daerah_krt').html("{{$pengesahan_minit_mesyuarat->daerah_krt}}");
            $('#pmmrp_1_dun_krt').html("{{$pengesahan_minit_mesyuarat->dun_krt}}");

		/* Maklumat Minit Mesyuarat Jawatankuasa */
            $('#pmmrp_1_minit_mesyuarat_id').val("{{$pengesahan_minit_mesyuarat->id}}");
            $('#pmmrp_1_mesyuarat_penyata_kewangan').html("{{$pengesahan_minit_mesyuarat->mesyuarat_penyata_kewangan}}");
            $('#pmmrp_1_mesyuarat_penyata_kewangan').summernote({
                height: 200
            });
            $("#pmmrp_1_mesyuarat_penyata_kewangan").summernote("disable");
	    
            var senarai_perkara_berbangkit_table = $('#senarai_perkara_berbangkit_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_get_senarai_perkara_berbangkit,
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
                    "width": "44%", 
                    "mRender": function ( value, type, full )  {
                        return full.berbangkit_perkara;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "44%", 
                    "mRender": function ( value, type, full )  {
                        return full.berbangkit_tindakan;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_pekara_berbangkit_mesyuarat_krt(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        return button_a;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

            var senarai_kertas_kerja_table = $('#senarai_kertas_kerja_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_get_senarai_kertas_kerja,
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
                    "width": "44%", 
                    "mRender": function ( value, type, full )  {
                        return full.kertas_kerja_perkara;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "44%", 
                    "mRender": function ( value, type, full )  {
                        return full.kertas_kerja_tindakan;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_kertas_kerja_mesyuarat_krt(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        return button_a;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

            var senarai_hal_lain_table = $('#senarai_hal_lain_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_get_senarai_hal_lain,
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
                    "width": "44%", 
                    "mRender": function ( value, type, full )  {
                        return full.hal_lain_perkara;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "44%", 
                    "mRender": function ( value, type, full )  {
                        return full.hal_lain_tindakan;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_hal_lain_mesyuarat_krt(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        return button_a;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

            $('#pmmrp_1_mesyuarat_penutup').html("{{$pengesahan_minit_mesyuarat->mesyuarat_penutup}}");
            $('#pmmrp_1_mesyuarat_penutup').summernote({
                height: 200
            });
            $("#pmmrp_1_mesyuarat_penutup").summernote("disable");

            $('#pmmrp_1_disemak_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

		/* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{ route('rt-sm5.pengesahan_minit_mesyuarat_rt_ppd','') }}"+"/"+{{$pengesahan_minit_mesyuarat->id}};
            });
    });

	/* action submit */
        //my custom script
        var pengesahan_minit_mesyuarat_config = {
            routes: {
                pengesahan_minit_mesyuarat_url: "{{ route('rt-sm5.post_pengesahan_minit_mesyuarat') }}",
            }
        };

        $(document).on('submit', '#form_pmmrtp_1', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_pmmrtp_1").serialize();
            var action = $('#post_pengesahan_minit_mesyuarat').val();
            var btn_text;
            if (action == 'edit') {
                url = pengesahan_minit_mesyuarat_config.routes.pengesahan_minit_mesyuarat_url;
                type = "POST";
                btn_text = 'Hantar Pengesahan Minit Mesyuarat&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=pmmrp_1_mesyuarat_status]').removeClass("is-invalid");
                $('[name=pmmrp_1_disemak_note]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'pmmrp_1_mesyuarat_status') {
                            $('[name=pmmrp_1_mesyuarat_status]').addClass("is-invalid");
                            $('.error_pmmrp_1_mesyuarat_status').html(error);
                        }

                        if(index == 'pmmrp_1_disemak_note') {
                            $('[name=pmmrp_1_disemak_note]').addClass("is-invalid");
                            $('.error_pmmrp_1_disemak_note').html(error);
                        }

                    });
                    $('#btn_submit').html(btn_text);                
                    $('#btn_submit').prop('disabled', false);            
                } else {
                    $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm5.pengesahan_minit_mesyuarat_rt')}}";
                }
            });
        });
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>

<script src="../assets/bundles/dataTables.bundle.js"></script>
<script src="assets/js/table/datatable.js"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

<!-- <script src="../assets/bundles/summernote.bundle.js"></script>
<script src="assets/js/page/summernote.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="{{ asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
@stop