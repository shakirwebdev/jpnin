
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

        //my custom script
            url_bil_mengikut_kaum	        = "{{ route('rt-sm10.get_senarai_terlibat_table','') }}"+"/"+"{{$isu_lokasi_kk->id}}";
           
        /* Maklumat Kawasan Krt */
            $('#silkk_nama_krt').html("{{$isu_lokasi_kk->nama_krt}}");
            $('#silkk_alamat_krt').html("{{$isu_lokasi_kk->alamat_krt}}");
            $('#silkk_negeri_krt').html("{{$isu_lokasi_kk->negeri_krt}}");
            $('#silkk_parlimen_krt').html("{{$isu_lokasi_kk->parlimen_krt}}");
            $('#silkk_pbt_krt').html("{{$isu_lokasi_kk->pbt_krt}}");
            $('#silkk_daerah_krt').html("{{$isu_lokasi_kk->daerah_krt}}");
            $('#silkk_dun_krt').html("{{$isu_lokasi_kk->dun_krt}}");
        
        /* Maklumat Semakan */
            $('#silkk1_isu_lokasi_kk_id').val("{{$isu_lokasi_kk->id}}");

        /* Maklumat Koperasi */
            $('#silkk_isu_lokasi_kanta_komuniti').val("{{$isu_lokasi_kk->isu_lokasi_kanta_komuniti}}");
            $('#silkk1_isu_bil_terlibat').val("{{$isu_lokasi_kk->isu_bil_terlibat}}");
            $('#silkk1_isu_kluster').val("{{$isu_lokasi_kk->isu_kluster}}");

            var senarai_terlibat_table = $('#senarai_terlibat_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_bil_mengikut_kaum,
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
					"width": "22%", 
					"mRender": function ( value, type, full )  {
						return full.bilangan;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "22%", 
					"mRender": function ( value, type, full )  {
						return full.kaum_description;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "22%", 
					"mRender": function ( value, type, full )  {
						return full.jantina_description;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "22%", 
					"mRender": function ( value, type, full )  {
						return full.umur;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

            $('#silkk3_isu_pelaksanan_daerah').val("{{$isu_lokasi_kk->isu_pelaksanan_daerah}}");
            $('#silkk3_isu_pelaksanan_negeri').val("{{$isu_lokasi_kk->isu_pelaksanan_negeri}}");
            $('#silkk3_isu_agensi_terlibat').val("{{$isu_lokasi_kk->isu_agensi_terlibat}}");
            $("input[name=silkk3_isu_status][value=" + "{{$isu_lokasi_kk->isu_status}}" + "]").prop('checked', true);
            
        /* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{ route('rt-sm10.semakan_isu_lokasi_kanta_komuniti') }}";
            });

	});

     /* action submit */
        //my custom script
        var semakan_isu_lokasi_kk_config = {
            routes: {
                semakan_isu_lokasi_kk_url: "{{ route('rt-sm10.post_semakan_isu_lokasi_kanta_komuniti') }}",
            }
        };

        $(document).on('submit', '#form_silkk1', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_silkk1").serialize();
            var action = $('#post_semakan_isu_lokasi_kanta_komuniti').val();
            var btn_text;
            if (action == 'edit') {
                url = semakan_isu_lokasi_kk_config.routes.semakan_isu_lokasi_kk_url;
                type = "POST";
                btn_text = 'Hantar Status Semakan &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=silkk1_status]').removeClass("is-invalid");
                $('[name=silkk1_disemak_note]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'silkk1_status') {
                        $('[name=silkk1_status]').addClass("is-invalid");
                        $('.error_silkk1_status').html(error);
                    }

                    if(index == 'silkk1_disemak_note') {
                        $('[name=silkk1_disemak_note]').addClass("is-invalid");
                        $('.error_silkk1_disemak_note').html(error);
                    }
                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
                $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm10.semakan_isu_lokasi_kanta_komuniti')}}";
                }
            });
        });

    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop