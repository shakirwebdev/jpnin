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
			$('#vacr_nama_krt').html("{{$ajk_cawangan->nama_krt}}");
			$('#vacr_alamat_krt').html("{{$ajk_cawangan->alamat_krt}}");
			$('#vacr_negeri_krt').html("{{$ajk_cawangan->negeri_krt}}");
			$('#vacr_parlimen_krt').html("{{$ajk_cawangan->parlimen_krt}}");
			$('#vacr_pbt_krt').html("{{$ajk_cawangan->pbt_krt}}");
			$('#vacr_daerah_krt').html("{{$ajk_cawangan->daerah_krt}}");
			$('#vacr_dun_krt').html("{{$ajk_cawangan->dun_krt}}");
			$('#vacr_cawangan_id').val("{{$ajk_cawangan->cawangan_id}}");

        /* Maklumat Asas */
			$('#vacr_ajk_nama').val("{{$ajk_cawangan->ajk_nama}}");
			$('#vacr_ajk_tarikh_lahir').val("{{$ajk_cawangan->ajk_tarikh_lahir}}");
			$('#vacr_jantina_id').val("{{$ajk_cawangan->jantina_id}}");
			$('#vacr_ajk_ic').val("{{$ajk_cawangan->ajk_ic}}");
			$('#vacr_status_perkahwinan_id').val("{{$ajk_cawangan->status_perkahwinan_id}}");
			$('#vacr_ajk_alamat').val("{{$ajk_cawangan->ajk_alamat}}");
			$('#vacr_ajk_poskod').val("{{$ajk_cawangan->ajk_poskod}}");
			$('#vacr_ajk_phone').val("{{$ajk_cawangan->ajk_phone}}");
			$('#vacr_ajk_email').val("{{$ajk_cawangan->ajk_email}}");
			$('#vacr_jawatan_cawangan_id').val("{{$ajk_cawangan->jawatan_cawangan_id}}");
			$('#vacr_ajk_status').val("{{$ajk_cawangan->ajk_status}}");

        /* Maklumat Akademik */
        
        //my custom script
		url_add_pendidikan      = "{{ route('rt-sm9.get_pendidikan_table','') }}"+"/"+"{{$ajk_cawangan->id}}";
        
        var senarai_pendidikan_table = $('#senarai_pendidikan_table').DataTable( {
    		processing: true,
			serverSide: true,
			ajax: url_add_pendidikan,
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
                "width": "29%", 
                "mRender": function ( value, type, full )  {
                    return full.pendidikan_description;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "29%", 
                "mRender": function ( value, type, full )  {
                    return full.akademik_tahun;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "15%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.akademik_pencapaian;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });

        /* Button */
		$('#btn_back').click(function(){
			window.location.href = '{{route('rt-sm9.senarai_ajk_cawangan_rt')}}';
		});

		$('#btn_next').click(function(){
			window.location.href = "{{ route('rt-sm9.view_ajk_cawangan_rt_1','') }}"+"/"+{{$ajk_cawangan->id}};
		});

    });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop