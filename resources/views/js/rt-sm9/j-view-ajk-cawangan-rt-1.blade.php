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
            $('#vacr_1_nama_krt').html("{{$ajk_cawangan->nama_krt}}");
            $('#vacr_1_alamat_krt').html("{{$ajk_cawangan->alamat_krt}}");
            $('#vacr_1_negeri_krt').html("{{$ajk_cawangan->negeri_krt}}");
            $('#vacr_1_parlimen_krt').html("{{$ajk_cawangan->parlimen_krt}}");
            $('#vacr_1_pbt_krt').html("{{$ajk_cawangan->pbt_krt}}");
            $('#vacr_1_daerah_krt').html("{{$ajk_cawangan->daerah_krt}}");
            $('#vacr_1_dun_krt').html("{{$ajk_cawangan->dun_krt}}");

        /* Maklumat Cawangan RT */
            $('#vacr_1_cawangan_id').val("{{$ajk_cawangan->cawangan_id}}");

        /* Maklumat Status Cawangan RT */
            $('#vacr1_ajk_cawangan_id').val("{{$ajk_cawangan->id}}");
            $('#vacr1_ajk_status').val("{{$ajk_cawangan->ajk_status}}");

        /* Maklumat Kerjaya */
            $("input[name=vacr_1_status_perkejaan_id][value=" + "{{$ajk_cawangan->status_perkejaan_id}}" + "]").prop('checked', true);
            $('#vacr_1_ajk_pekerjaan_jawatan').val("{{$ajk_cawangan->ajk_pekerjaan_jawatan}}");
            $('#vacr_1_ajk_pekerjaan_bidang').val("{{$ajk_cawangan->ajk_pekerjaan_bidang}}");
            $('#vacr_1_ajk_pekerjaan_pengalaman').val("{{$ajk_cawangan->ajk_pekerjaan_pengalaman}}");

        /* Maklumat Pengalaman */
        
        //my custom script
		    url_table_pengalaman      = "{{ route('rt-sm9.get_pengalaman_table','') }}"+"/"+"{{$ajk_cawangan->id}}";
        
            var senarai_pengalaman_table = $('#senarai_pengalaman_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_table_pengalaman,
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
                    "width": "10%", 
                    "mRender": function ( value, type, full )  {
                        return full.pengalaman_tahun;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "78%", 
                    "mRender": function ( value, type, full )  {
                        return full.pengalaman_program;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

        /* Maklumat Kemahiran & Hobi */
            $('#vacr_1_ajk_kemahiran').val("{{$ajk_cawangan->ajk_kemahiran}}");
            $('#vacr_1_ajk_minat').val("{{$ajk_cawangan->ajk_minat}}");

        /* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{ route('rt-sm9.view_ajk_cawangan_rt','') }}"+"/"+"{{$ajk_cawangan->id}}";
            });

    });

   /* action submit */
        //my custom script
        var kemaskini_ajk_cawangan_krt_config = {
            routes: {
                kemaskini_ajk_cawangan_krt_url: "{{ route('rt-sm9.post_kemaskini_status_ajk') }}",
            }
        };

        $(document).on('submit', '#form_vacr1', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_vacr1").serialize();
            var action = $('#post_kemaskini_status_ajk').val();
            var btn_text;
            if (action == 'edit') {
                url = kemaskini_ajk_cawangan_krt_config.routes.kemaskini_ajk_cawangan_krt_url;
                type = "POST";
                btn_text = 'Kemakini Status Ahli Jawatankuasa &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=vacr1_ajk_status]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'vacr1_ajk_status') {
                            $('[name=vacr1_ajk_status]').addClass("is-invalid");
                            $('.error_vacr1_ajk_status').html(error);
                        }

                    });
                    $('#btn_submit').html(btn_text);                
                    $('#btn_submit').prop('disabled', false);            
                } else {
                    $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm9.senarai_ajk_cawangan_rt')}}";
                }
            });
        });
        

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop