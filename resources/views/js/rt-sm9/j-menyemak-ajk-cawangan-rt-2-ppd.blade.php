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
            $('#macr_ppd_3_nama_krt').html("{{$ajk_cawangan->nama_krt}}");
            $('#macr_ppd_3_alamat_krt').html("{{$ajk_cawangan->alamat_krt}}");
            $('#macr_ppd_3_negeri_krt').html("{{$ajk_cawangan->negeri_krt}}");
            $('#macr_ppd_3_parlimen_krt').html("{{$ajk_cawangan->parlimen_krt}}");
            $('#macr_ppd_3_pbt_krt').html("{{$ajk_cawangan->pbt_krt}}");
            $('#macr_ppd_3_daerah_krt').html("{{$ajk_cawangan->daerah_krt}}");
            $('#macr_ppd_3_dun_krt').html("{{$ajk_cawangan->dun_krt}}");

        /* Maklumat Cawangan RT */
            $('#macr_ppd_3_cawangan_id').val("{{$ajk_cawangan->cawangan_id}}");

        /* Maklumat Status Semakan */
            $('#macr_ppd_3_ajk_cawangan_id').val("{{$ajk_cawangan->id}}");
            $('#macr_ppd_3_disemak_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

        /* Maklumat Kerjaya */
            $("input[name=macr_ppd_4_status_perkejaan_id][value=" + "{{$ajk_cawangan->status_perkejaan_id}}" + "]").prop('checked', true);
            $('#macr_ppd_4_ajk_pekerjaan_jawatan').val("{{$ajk_cawangan->ajk_pekerjaan_jawatan}}");
            $('#macr_ppd_4_ajk_pekerjaan_bidang').val("{{$ajk_cawangan->ajk_pekerjaan_bidang}}");
            $('#macr_ppd_4_ajk_pekerjaan_pengalaman').val("{{$ajk_cawangan->ajk_pekerjaan_pengalaman}}");

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
            $('#macr_ppd_6_ajk_kemahiran').val("{{$ajk_cawangan->ajk_kemahiran}}");
            $('#macr_ppd_6_ajk_minat').val("{{$ajk_cawangan->ajk_minat}}");

        /* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{ route('rt-sm9.menyemak_ajk_cawangan_rt_1_ppd','') }}"+"/"+{{$ajk_cawangan->id}};
            });
    });

   /* action submit */
        //my custom script
        var menyemak_ajk_cawangan_rt_ppd_config = {
            routes: {
                menyemak_ajk_cawangan_rt_ppd_url: "{{ route('rt-sm9.post_semakan_ajk_cawangan_rt_ppd') }}",
            }
        };

        $(document).on('submit', '#form_macr_ppd_3', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_macr_ppd_3").serialize();
            var action = $('#post_semakan_ajk_cawangan_rt_ppd').val();
            var btn_text;
            if (action == 'edit') {
                url = menyemak_ajk_cawangan_rt_ppd_config.routes.menyemak_ajk_cawangan_rt_ppd_url;
                type = "POST";
                btn_text = 'Hantar Status Semakan &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=macr_ppd_3_ajk_status_form]').removeClass("is-invalid");
                $('[name=macr_ppd_3_disemak_note]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'macr_ppd_3_ajk_status_form') {
                        $('[name=macr_ppd_3_ajk_status_form]').addClass("is-invalid");
                        $('.error_macr_ppd_3_ajk_status_form').html(error);
                    }

                    if(index == 'macr_ppd_3_disemak_note') {
                        $('[name=macr_ppd_3_disemak_note]').addClass("is-invalid");
                        $('.error_macr_ppd_3_disemak_note').html(error);
                    }
                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
                $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm9.menyemak_ajk_cawangan_rt')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop