
@section('page-script')
@include('js.modal.j-modal-view-ahli-sejiwa')
@include('js.modal.j-modal-view-perkhidmatan-sejiwa')
@include('js.modal.j-modal-view-cabaran-sejiwa')
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
            $('#ssk2_nama_krt').html("{{$sejiwa->nama_krt}}");
            $('#ssk2_alamat_krt').html("{{$sejiwa->alamat_krt}}");
            $('#ssk2_negeri_krt').html("{{$sejiwa->negeri_krt}}");
            $('#ssk2_parlimen_krt').html("{{$sejiwa->parlimen_krt}}");
            $('#ssk2_pbt_krt').html("{{$sejiwa->pbt_krt}}");
            $('#ssk2_daerah_krt').html("{{$sejiwa->daerah_krt}}");
            $('#ssk2_dun_krt').html("{{$sejiwa->dun_krt}}");

        /* Maklumat Am Sejiwa */
            $('#ssk2_sejiwa_nama').val("{{$sejiwa->sejiwa_nama}}");
            $('#ssk2_sejiwa_tarikh_ditubuhkan').val("{{$sejiwa->sejiwa_tarikh_ditubuhkan}}");
            $('#ssk2_sejiwa_pusat_operasi').val("{{$sejiwa->sejiwa_pusat_operasi}}");

        /* Maklumat Status Menyemak */
            $('#ssk2_disemak_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
           
        /* Maklumat Ahli Sejiwa */
            url_ahli_sejiwa_table 			= "{{ route('rt-sm10.get_senarai_ahli_sejiwa_table','') }}"+"/"+"{{$sejiwa->id}}";
            
            var senarai_ahli_sejiwa_table = $('#senarai_ahli_sejiwa_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_ahli_sejiwa_table,
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
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.ahli_sejiwa_nama;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.ahli_sejiwa_ic;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.ahli_sejiwa_pekerjaan;
                    }
                },{          
                    "aTargets": [ 4 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_ahli_sejiwa(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        return button_a;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

         /* Maklumat Bidang /  Jenis Fokus Perkhidmatan SeJiwa */
            url_perkhidmatan_sejiwa_table 			= "{{ route('rt-sm10.get_senarai_perkhidmatan_sejiwa_table','') }}"+"/"+"{{$sejiwa->id}}";
            
            var senarai_perkhidmatan_sejiwa_table = $('#senarai_perkhidmatan_sejiwa_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_perkhidmatan_sejiwa_table,
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
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.perkhidmatan_sejiwa_keperluan;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.perkhidmatan_sejiwa_perkhidmatan;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_perkhidmatan_sejiwa(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        return button_a;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

        /* Pegawai Rujukan / Penyelia Sejiwa */
            $('#psk6_sejiwa_pegawai_nama').val("{{$sejiwa->sejiwa_pegawai_nama}}");
            $('#psk6_sejiwa_pegawai_phone').val("{{$sejiwa->sejiwa_pegawai_phone}}");
            $('#psk6_sejiwa_pegawai_jawatan').val("{{$sejiwa->sejiwa_pegawai_jawatan}}");
            $('#psk6_sejiwa_pegawai_emel').val("{{$sejiwa->sejiwa_pegawai_emel}}");

        /* Maklumat Cabaran Dan Cara Menangani */
             url_cabaran_sejiwa_table 			= "{{ route('rt-sm10.get_senarai_cabaran_sejiwa_table','') }}"+"/"+"{{$sejiwa->id}}";
             
             var senarai_cabaran_sejiwa_table = $('#senarai_cabaran_sejiwa_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_cabaran_sejiwa_table,
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
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.cabaran_sejiwa_cabaran;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.cabaran_sejiwa_mengatasi;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_cabaran_sejiwa(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        return button_a;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

            $('#ssk2_sejiwa_id').val("{{$sejiwa->id}}");
        
        /* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{ route('rt-sm10.semakan_sejiwa_krt_1','') }}"+"/"+"{{$sejiwa->id}}";
            });

	});

    /* action submit */
        //my custom script
        var semakan_profil_sejiwa_krt_config = {
            routes: {
                semakan_profil_sejiwa_krt_url: "{{ route('rt-sm10.post_semakan_profile_sejiwa') }}",
            }
        };

        $(document).on('submit', '#form_ssk2', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_ssk2").serialize();
            var action = $('#post_semakan_profile_sejiwa').val();
            var btn_text;
            if (action == 'edit') {
                url = semakan_profil_sejiwa_krt_config.routes.semakan_profil_sejiwa_krt_url;
                type = "POST";
                btn_text = 'Hantar Status Semakan &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=ssk2_status]').removeClass("is-invalid");
                $('[name=ssk2_disemak_note]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'ssk2_status') {
                        $('[name=ssk2_status]').addClass("is-invalid");
                        $('.error_ssk2_status').html(error);
                    }

                    if(index == 'ssk2_disemak_note') {
                        $('[name=ssk2_disemak_note]').addClass("is-invalid");
                        $('.error_ssk2_disemak_note').html(error);
                    }
                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
                $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm10.semakan_sejiwa_krt')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop