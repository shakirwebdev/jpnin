@include('js.modal.j-modal-view-biro-skuad-uniti')
@include('js.modal.j-modal-view-jaringan-skuad-uniti')
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

</style>
<script type="text/javascript">    
    
	$(document).ready( function () {

        /* Maklumat Kawasan Krt */
            $('#spsupn_nama_krt').html("{{$skuad_uniti->nama_krt}}");
            $('#spsupn_alamat_krt').html("{{$skuad_uniti->alamat_krt}}");
            $('#spsupn_negeri_krt').html("{{$skuad_uniti->negeri_krt}}");
            $('#spsupn_parlimen_krt').html("{{$skuad_uniti->parlimen_krt}}");
            $('#spsupn_pbt_krt').html("{{$skuad_uniti->pbt_krt}}");
            $('#spsupn_daerah_krt').html("{{$skuad_uniti->daerah_krt}}");
            $('#spsupn_dun_krt').html("{{$skuad_uniti->dun_krt}}");

        /* Maklumat Am Kawasan Krt */
            $('#spsupn_skuad_nama').val("{{$skuad_uniti->skuad_nama}}");
            $('#spsupn_skuad_tarikh_ditubuhkan').val("{{$skuad_uniti->skuad_tarikh_ditubuhkan}}");
            $('#spsupn_skuad_skop_perkhidmatan').val("{{$skuad_uniti->skuad_skop_perkhidmatan}}");

        /* Maklumat Status Menyemak */
            $('#spsuk_disemak_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

        /* Maklumat Ketua Skuad Uniti */
            $('#spsupn_skuad_nama_ketua').val("{{$skuad_uniti->skuad_nama_ketua}}");
            $('#spsupn_skuad_phone_ketua').val("{{$skuad_uniti->skuad_phone_ketua}}");
            $('#spsupn_skuad_email_ketua').val("{{$skuad_uniti->skuad_email_ketua}}");
            $('#spsupn_skuad_ic_ketua').val("{{$skuad_uniti->skuad_ic_ketua}}");
            $('#spsupn_skuad_alamat_ketua').val("{{$skuad_uniti->skuad_alamat_ketua}}");
            $('#spsupn_skuad_pekerjaan_ketua').val("{{$skuad_uniti->skuad_pekerjaan_ketua}}");

        /* Maklumat Setiausaha Skuad Uniti */
            $('#spsupn_skuad_nama_setiausaha').val("{{$skuad_uniti->skuad_nama_setiausaha}}");
            $('#spsupn_skuad_phone_setiausaha').val("{{$skuad_uniti->skuad_phone_setiausaha}}");
            $('#spsupn_skuad_email_setiausaha').val("{{$skuad_uniti->skuad_email_setiausaha}}");
            $('#spsupn_skuad_ic_setiausaha').val("{{$skuad_uniti->skuad_ic_setiausaha}}");
            $('#spsupn_skuad_alamat_setiausaha').val("{{$skuad_uniti->skuad_alamat_setiausaha}}");
            $('#spsupn_skuad_pekerjaan_setiausaha').val("{{$skuad_uniti->skuad_pekerjaan_setiausaha}}");

        /* Maklumat Biro Skuad Uniti */

            //my custom script
		    url_senarai_biro_table 			= "{{ route('rt-sm10.get_senarai_biro_table','') }}"+"/"+"{{$skuad_uniti->id}}";
            url_delete_biro 				= "{{ route('rt-sm10.delete_biro','') }}";
        
            var senarai_biro_table = $('#senarai_biro_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_senarai_biro_table,
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
                        return full.biro_nama;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.biro_nama_penuh;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.biro_ic;
                    }
                },{          
                    "aTargets": [ 4 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_biro_skuad_uniti(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        return button_a ;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

        /* Maklumat Jaringan Kerjasama Strategik */

            //my custom script
		    url_senarai_jaringan_table 			= "{{ route('rt-sm10.get_senarai_jaringan_table','') }}"+"/"+"{{$skuad_uniti->id}}";
            url_delete_jaringan 				= "{{ route('rt-sm10.delete_jaringan','') }}";

            var senarai_jaringan_table = $('#senarai_jaringan_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_senarai_jaringan_table,
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
                        return full.jaringan_agensi_nama;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.jaringan_nama_pegawai;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.jaringan_no_telefon;
                    }
                },{          
                    "aTargets": [ 4 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_jaringan_skuad_uniti(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        return button_a;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

        /* Maklumat Profile Skuad Uniti */
            $('#spsuk_skuad_uniti_id').val("{{$skuad_uniti->id}}");

        /* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{ route('rt-sm10.semakan_profil_skuad_uniti_krt') }}";
            });

	});

    /* action submit */
        //my custom script
        var semakan_profil_skuad_uniti_krt_config = {
            routes: {
                semakan_profil_skuad_uniti_krt_url: "{{ route('rt-sm10.post_semakan_profile_skuad_uniti') }}",
            }
        };

        $(document).on('submit', '#form_spsuk', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_spsuk").serialize();
            var action = $('#post_semakan_profile_skuad_uniti').val();
            var btn_text;
            if (action == 'edit') {
                url = semakan_profil_skuad_uniti_krt_config.routes.semakan_profil_skuad_uniti_krt_url;
                type = "POST";
                btn_text = 'Hantar Status Semakan &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=spsuk_status]').removeClass("is-invalid");
                $('[name=spsuk_disemak_note]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'spsuk_status') {
                        $('[name=spsuk_status]').addClass("is-invalid");
                        $('.error_spsuk_status').html(error);
                    }

                    if(index == 'spsuk_disemak_note') {
                        $('[name=spsuk_disemak_note]').addClass("is-invalid");
                        $('.error_spsuk_disemak_note').html(error);
                    }
                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
                $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm10.semakan_profil_skuad_uniti_krt')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop