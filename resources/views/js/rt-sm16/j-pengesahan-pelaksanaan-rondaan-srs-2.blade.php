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

		//my custom script
        var pelaksanaan_rondaans_config = {
            routes: {
                pelaksanaan_rondaan_url: "/rt/sm16/penyediaan-pelaksanaan-rondaan-srs-2/{{$pelaksanaan_rondaan->id}}"
            }
        };
        
    	/* Maklumat Kawasan Krt */
			$('#pprpd2_nama_krt').html("{{$pelaksanaan_rondaan->nama_krt}}");
			$('#pprpd2_alamat_krt').html("{{$pelaksanaan_rondaan->alamat_krt}}");
			$('#pprpd2_negeri_krt').html("{{$pelaksanaan_rondaan->negeri_krt}}");
			$('#pprpd2_daerah_krt').html("{{$pelaksanaan_rondaan->daerah_krt}}");
			$('#pprpd2_parlimen_krt').html("{{$pelaksanaan_rondaan->parlimen_krt}}");
			$('#pprpd2_dun_krt').html("{{$pelaksanaan_rondaan->dun_krt}}");
			$('#pprpd2_pbt_krt').html("{{$pelaksanaan_rondaan->pbt_krt}}");

		/* Maklumat kes */
            $('#pprpd2_kategori_id').val("{{$pelaksanaan_rondaan->kategori_kes_id}}");
            $('#pprpd2_jenis_id').val("{{$pelaksanaan_rondaan->jenis_kes_id}}");
            $('#pprpd2_kes_keterangan').html("{{$pelaksanaan_rondaan->kes_keterangan}}");
            $('#pprpd2_kes_keterangan').summernote({
				height: 200
			});

			url_kaum_terlibat      		= "{{ route('rt-sm16.get_kaum_terlibat_table','') }}"+"/"+"{{$pelaksanaan_rondaan->id}}";
			
            var senarai_terlibat_table = $('#senarai_terlibat_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_kaum_terlibat,
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
						return full.kaum_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "29%", 
					"mRender": function ( value, type, full )  {
						return full.terlibat_bilangan;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "29%", 
					"mRender": function ( value, type, full )  {
						return full.jantina_description;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "29%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.terlibat_umur;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

            $('#pprpd2_kes_jumlah_org_terlibat').val("{{$pelaksanaan_rondaan->kes_jumlah_org_terlibat}}");
            $('#pprpd2_kes_dirujuk_id').val("{{$pelaksanaan_rondaan->kes_dirujuk_id}}");

        /* Maklumat Status Pengesahan */
            $('#pprpd2_srs_pelaksanaan_rondaan_id').val("{{$pelaksanaan_rondaan->id}}");

		/* Button */
			$('#btn_back').click(function(){
                window.location.href = '{{route('rt-sm16.pengesahan_pelaksanaan_rondaan_srs_1','')}}'+'/'+'{{$pelaksanaan_rondaan->id}}';
            });
    });

	/* action submit */
        //my custom script
        var pengesahan_pelaksanaan_rondaan_srs_config = {
            routes: {
                pengesahan_pelaksanaan_rondaan_srs_url: "{{ route('rt-sm16.post_pengesahan_pelaksanaan_rondaan_srs_2') }}",
            }
        };

        $(document).on('click', '#btn_submit', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_pprpd2").serialize();
            var action = $('#post_pengesahan_pelaksanaan_rondaan_srs_2').val();
            var btn_text;
            if (action == 'edit') {
                url = pengesahan_pelaksanaan_rondaan_srs_config.routes.pengesahan_pelaksanaan_rondaan_srs_url;
                type = "POST";
                btn_text = 'Hantar Status Pengesahan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=pprpd2_pelaksanaan_rondaan_status]').removeClass("is-invalid");
                $('[name=pprpd2_disemak_note]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'pprpd2_pelaksanaan_rondaan_status') {
                        $('[name=pprpd2_pelaksanaan_rondaan_status]').addClass("is-invalid");
                        $('.error_pprpd2_pelaksanaan_rondaan_status').html(error);
                    }

                    if(index == 'pprpd2_disemak_note') {
                        $('[name=pprpd2_disemak_note]').addClass("is-invalid");
                        $('.error_pprpd2_disemak_note').html(error);
                    }
                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
                $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm16.pengesahan_pelaksanaan_rondaan_srs')}}";
                }
            });
        });

    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop