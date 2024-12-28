
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
            $('#ppesk_nama_krt').html("{{$projek_ekonomi_st->nama_krt}}");
            $('#ppesk_alamat_krt').html("{{$projek_ekonomi_st->alamat_krt}}");
            $('#ppesk_negeri_krt').html("{{$projek_ekonomi_st->negeri_krt}}");
            $('#ppesk_parlimen_krt').html("{{$projek_ekonomi_st->parlimen_krt}}");
            $('#ppesk_pbt_krt').html("{{$projek_ekonomi_st->pbt_krt}}");
            $('#ppesk_daerah_krt').html("{{$projek_ekonomi_st->daerah_krt}}");
            $('#ppesk_dun_krt').html("{{$projek_ekonomi_st->dun_krt}}");

        /* Maklumat Projek */
            $('#ppesk1_projek_st_nama').val("{{$projek_ekonomi_st->projek_st_nama}}");
            $('#ppesk1_projek_st_kategori').val("{{$projek_ekonomi_st->projek_st_kategori}}");
            $('#ppesk1_projek_st_cabaran').val("{{$projek_ekonomi_st->projek_st_cabaran}}");
            $('#ppesk1_projek_st_peruntukan_jabatan').val("{{$projek_ekonomi_st->projek_st_peruntukan_jabatan}}");
            $('#ppesk1_projek_st_tahun').val("{{$projek_ekonomi_st->projek_st_tahun}}");
            $('#ppesk1_projek_st_pendapatan').val("{{$projek_ekonomi_st->projek_st_pendapatan}}");
            $('#ppesk1_projek_st_pembelanjaan').val("{{$projek_ekonomi_st->projek_st_pembelanjaan}}");

        /* Maklumat Peserta Projek */
            url_table_peserta      = "{{ route('rt-sm10.get_peserta_table','') }}"+"/"+"{{$projek_ekonomi_st->id}}";
            url_delete_peserta 	   = "{{ route('rt-sm10.delete_peserta','') }}";
        
            var senarai_peserta_table = $('#senarai_peserta_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_table_peserta,
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
                    "width": "88%", 
                    "mRender": function ( value, type, full )  {
                        return full.nama_peserta;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_peserta" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
                        return button_a;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

            $('#ppesk2_pelaksanaan_projek_ekonomi_id').val("{{$projek_ekonomi_st->id}}");

            $('#ppesk3_pelaksanaan_projek_ekonomi_id').val("{{$projek_ekonomi_st->id}}");

        /* Maklumat Note Kemaskini */   
            $('#ppesk_status').val("{{$projek_ekonomi_st->status}}"); 

            if($('#ppesk_status').val() == '5'){
                $("#ppesk_perlu_kemaskini").show();
                $('#ppesk_status_description').html("{{$projek_ekonomi_st->status_description}}");
                $('#ppesk_disemak_note').html("{{$projek_ekonomi_st->disemak_note}}");
            }

            if($('#ppesk_status').val() == '7'){
                $("#ppesk_perlu_kemaskini").show();
                $('#ppesk_status_description').html("{{$projek_ekonomi_st->status_description}}");
                $('#ppesk_disahkan_note').html("{{$projek_ekonomi_st->disahkan_note}}");
            }

        /* Button */
        $('#btn_back').click(function(){
			window.location.href = "{{ route('rt-sm10.pelaksanaan_projek_ekonomi_st_krt') }}";
		});

	});

    /* click add peserta */
        $(document).on('submit', '#form_ppesk2', function(event){
            var info = $('.error_form_ppesk2');
            event.preventDefault();

            $('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_save').prop('disabled', true);

            var data = $("#form_ppesk2").serialize();
            btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
            url = "{{ route('rt-sm10.post_peserta_projek_ekonomi') }}";
            type = "POST";

            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {            
                info.hide().find('ul').empty();
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        info.find('ul').append('<li>'+error+'</li>');
                    });
                    $('#btn_save').html(btn_text);                
                    $('#btn_save').prop('disabled', false);
                    info.slideDown();
                } else {
                    swal("Peserta Projek ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
                    $('#form_ppesk2').trigger("reset");
                    $('#btn_save').html(btn_text);
                    $('#btn_save').prop('disabled', false);
                    $('#senarai_peserta_table').DataTable().ajax.reload();
                }
            });
        });

    /* click delete peserta */
        $('body').on('click', '#delete_peserta', function () {
            var delete_id = $(this).data("id");
            swal({
                title: "Anda pasti?",
                text: "Anda akan memadam rekod ini dari pangkalan data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                confirmButtonText: "Ya, sila padam!",
                cancelButtonText: "Tidak",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "GET",
                        url: url_delete_peserta +"/" + delete_id,
                        success: function (data) {
                            // $('#peranan_form').trigger("reset");
                            $('#senarai_peserta_table').DataTable().ajax.reload();
                            swal("Sudah dipadam!", "Rekod peranan telah dipadam dari pangkalan data", "success");
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });                    
                } else {
                    swal("Tidak", "Proses pemadaman tidak berlaku", "error");
                }
            });
        });

    /* Button Submit */
        //my custom script
        var pelaksanaan_projek_ekonomi_config = {
            routes: {
                pelaksanaan_projek_ekonomi_url: "{{ route('rt-sm10.post_pelaksanaan_projek_ekonomi_1') }}",
            }
        };

        $(document).on('submit', '#form_ppesk3', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data   = $("#form_ppesk1, #form_ppesk3").serialize();
            var action = $('#post_pelaksanaan_projek_ekonomi_1').val();
            var btn_text;
            if (action == 'edit') {
                url = pelaksanaan_projek_ekonomi_config.routes.pelaksanaan_projek_ekonomi_url;
                type = "POST";
                btn_text = 'Hantar Pelaksanaan Projek Ekonomi &nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=ppesk1_projek_st_nama]').removeClass("is-invalid");
                $('[name=ppesk1_projek_st_kategori]').removeClass("is-invalid");
                $('[name=ppesk1_projek_st_cabaran]').removeClass("is-invalid");
                $('[name=ppesk1_projek_st_peruntukan_jabatan]').removeClass("is-invalid");
                $('[name=ppesk1_projek_st_tahun]').removeClass("is-invalid");
                $('[name=ppesk1_projek_st_pendapatan]').removeClass("is-invalid");
                $('[name=ppesk1_projek_st_pembelanjaan]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'ppesk1_projek_st_nama') {
                            $('[name=ppesk1_projek_st_nama]').addClass("is-invalid");
                            $('.error_ppesk1_projek_st_nama').html(error);
                        }

                        if(index == 'ppesk1_projek_st_kategori') {
                            $('[name=ppesk1_projek_st_kategori]').addClass("is-invalid");
                            $('.error_ppesk1_projek_st_kategori').html(error);
                        }

                        if(index == 'ppesk1_projek_st_cabaran') {
                            $('[name=ppesk1_projek_st_cabaran]').addClass("is-invalid");
                            $('.error_ppesk1_projek_st_cabaran').html(error);
                        }

                        if(index == 'ppesk1_projek_st_peruntukan_jabatan') {
                            $('[name=ppesk1_projek_st_peruntukan_jabatan]').addClass("is-invalid");
                            $('.error_ppesk1_projek_st_peruntukan_jabatan').html(error);
                        }

                        if(index == 'ppesk1_projek_st_tahun') {
                            $('[name=ppesk1_projek_st_tahun]').addClass("is-invalid");
                            $('.error_ppesk1_projek_st_tahun').html(error);
                        }

                        if(index == 'ppesk1_projek_st_pendapatan') {
                            $('[name=ppesk1_projek_st_pendapatan]').addClass("is-invalid");
                            $('.error_ppesk1_projek_st_pendapatan').html(error);
                        }

                        if(index == 'ppesk1_projek_st_pembelanjaan') {
                            $('[name=ppesk1_projek_st_pembelanjaan]').addClass("is-invalid");
                            $('.error_ppesk1_projek_st_pembelanjaan').html(error);
                        }

                    });
                    $('#btn_submit').html(btn_text);                
                    $('#btn_submit').prop('disabled', false);            
                } else {
                    $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm10.pelaksanaan_projek_ekonomi_st_krt')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop