
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
            $('#spesk_nama_krt').html("{{$projek_ekonomi_st->nama_krt}}");
            $('#spesk_alamat_krt').html("{{$projek_ekonomi_st->alamat_krt}}");
            $('#spesk_negeri_krt').html("{{$projek_ekonomi_st->negeri_krt}}");
            $('#spesk_parlimen_krt').html("{{$projek_ekonomi_st->parlimen_krt}}");
            $('#spesk_pbt_krt').html("{{$projek_ekonomi_st->pbt_krt}}");
            $('#spesk_daerah_krt').html("{{$projek_ekonomi_st->daerah_krt}}");
            $('#spesk_dun_krt').html("{{$projek_ekonomi_st->dun_krt}}");

        /* Maklumat Status Menyemak */
            $('#spesk_disemak_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

        /* Maklumat Projek */
            $('#spesk_projek_st_nama').val("{{$projek_ekonomi_st->projek_st_nama}}");
            $('#spesk_projek_st_kategori').val("{{$projek_ekonomi_st->projek_st_kategori}}");
            $('#spesk_projek_st_cabaran').val("{{$projek_ekonomi_st->projek_st_cabaran}}");
            $('#spesk_projek_st_peruntukan_jabatan').val("{{$projek_ekonomi_st->projek_st_peruntukan_jabatan}}");
            $('#spesk_projek_st_tahun').val("{{$projek_ekonomi_st->projek_st_tahun}}");
            $('#spesk_projek_st_pendapatan').val("{{$projek_ekonomi_st->projek_st_pendapatan}}");
            $('#spesk_projek_st_pembelanjaan').val("{{$projek_ekonomi_st->projek_st_pembelanjaan}}");

        /* Maklumat Peserta Projek */
            url_table_peserta      = "{{ route('rt-sm10.get_peserta_table','') }}"+"/"+"{{$projek_ekonomi_st->id}}";
            
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
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

            $('#spesk_pelaksanaan_projek_ekonomi_id').val("{{$projek_ekonomi_st->id}}");

        /* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{ route('rt-sm10.semakan_projek_ekonomi_st_krt') }}";
            });

	});

    /* action submit */
        //my custom script
        var semakan_pelaksanaan_projek_ekonomi_config = {
            routes: {
                semakan_pelaksanaan_projek_ekonomi_url: "{{ route('rt-sm10.post_semakan_pelaksanaan_projek_ekonomi') }}",
            }
        };

        $(document).on('submit', '#form_spesk', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_spesk").serialize();
            var action = $('#post_semakan_pelaksanaan_projek_ekonomi').val();
            var btn_text;
            if (action == 'edit') {
                url = semakan_pelaksanaan_projek_ekonomi_config.routes.semakan_pelaksanaan_projek_ekonomi_url;
                type = "POST";
                btn_text = 'Hantar Status Semakan &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=spesk_status]').removeClass("is-invalid");
                $('[name=spesk_disemak_note]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'spesk_status') {
                        $('[name=spesk_status]').addClass("is-invalid");
                        $('.error_spesk_status').html(error);
                    }

                    if(index == 'spesk_disemak_note') {
                        $('[name=spesk_disemak_note]').addClass("is-invalid");
                        $('.error_spesk_disemak_note').html(error);
                    }
                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
                $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm10.semakan_projek_ekonomi_st_krt')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop