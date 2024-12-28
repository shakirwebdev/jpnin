@include('js.modal.j-modal-view-jawatankuasa-penaja-rt')
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {

        /* Maklumat KRT Yang Dimohon */
            $('#kpk_krt_nama').html("{{$profile_krt->krt_nama}}");
            $('#kpk_krt_alamat').html("{{$profile_krt->krt_alamat}}");
            $('#kpk_tarikh_memohon').html("{{$profile_krt->created_at}}");

		/* Maklumat Pemohon */
            $('#kpk_pemohon_name').val("{{$profile_krt->user_fullname}}");
            $('#kpk_pemohon_ic').val("{{$profile_krt->no_ic}}");
            $('#kpk_pemohon_alamat').val("{{$profile_krt->user_address}}");

        /* Maklumat Status Pengesahan */
            $('#ppk_ppn_disahkan_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

		/* Maklumat Asas Kawasan */
            url_jawatankuasa_penaja_table 		= "{{ route('rt-sm1.get_jawatankuasa_penaja_table','') }}"+"/"+{{$profile_krt->id}};

            var jawatankuasa_penaja_table = $('#jawatankuasa_penaja_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_jawatankuasa_penaja_table,
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
                    "width": "40%", 
                    "mRender": function ( value, type, full )  {
                        return full.penaja_nama;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "48%", 
                    "mRender": function ( value, type, full )  {
                        return full.penaja_ic;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_jawatankuasa_penaja_rt(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        return button_a;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

		/* Maklumat Status Pengesahan */

            $('#ppk_ppn_krt_profile_id').val("{{$profile_krt->id}}");

            $('#btn_back').click(function(){
                window.location.href = "{{route('rt-sm1.pengesahan_permohonan_krt_ppn_3','')}}"+"/"+{{$profile_krt->id}};
            });

	});

	/* action submit */
        //my custom script
        var pengesahan_permohonan_krt_ppn_config = {
            routes: {
                pengesahan_permohonan_krt_ppn_url: "{{ route('rt-sm1.post_pengesahan_permohonan_krt_ppn') }}",
            }
        };

        $(document).on('submit', '#form_ppk_ppn', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_ppk_ppn").serialize();
            var action = $('#post_pengesahan_permohonan_krt_ppn').val();
            var btn_text;
            if (action == 'edit') {
                url = pengesahan_permohonan_krt_ppn_config.routes.pengesahan_permohonan_krt_ppn_url;
                type = "POST";
                btn_text = 'Hantar Status Pengesahan&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=ppk_ppn_krt_status]').removeClass("is-invalid");
                $('[name=ppk_ppn_disahkan_note]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'ppk_ppn_krt_status') {
                        $('[name=ppk_ppn_krt_status]').addClass("is-invalid");
                        $('.error_ppk_ppn_krt_status').html(error);
                    }

                    if(index == 'ppk_ppn_disahkan_note') {
                        $('[name=ppk_ppn_disahkan_note]').addClass("is-invalid");
                        $('.error_ppk_ppn_disahkan_note').html(error);
                    }
                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
                $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm1.pengesahan_permohonan_krt_baharu')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop