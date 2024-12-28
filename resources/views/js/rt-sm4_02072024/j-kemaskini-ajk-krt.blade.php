@include('js.modal.j-modal-edit-gambar-ajk-krt')
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<style>
    .avatar {
        vertical-align: middle;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        border-color: black;
    }
</style>
<script type="text/javascript">    
    
	$(document).ready( function () {

		/* Maklumat Kawasan Krt */
            $('#kak_krt_nama').html("{{$krt_ajk->krt_nama}}");
            $('#kak_krt_alamat').html("{{$krt_ajk->krt_alamat}}");
            $('#kak_krt_negeri').html("{{$krt_ajk->krt_negeri}}");
            $('#kak_krt_parlimen').html("{{$krt_ajk->krt_parlimen}}");
            $('#kak_krt_pbt').html("{{$krt_ajk->krt_pbt}}");
            $('#kak_krt_daerah').html("{{$krt_ajk->krt_daerah}}");
            $('#kak_krt_dun').html("{{$krt_ajk->krt_dun}}");

		/* Maklumat Pemohonan Ahli KRT */
            $('#kak_ajk_alamat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

            $('#kak_ajk_alamat').on("paste",function(e) {
                e.preventDefault();
            });

            $('#kak_ajk_berkepentingan_keterangan').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
            $('#kak_ajk_gambar').attr('src', "{{ asset('storage/ajk_krt') }}"+"/"+ "{{$krt_ajk->file_avatar}}");
            $('#kak_ajk_krt_id').val("{{$krt_ajk->id}}");
            $('#kak_ajk_nama').val("{{$krt_ajk->ajk_nama}}");
            $('#kak_ajk_ic').val("{{$krt_ajk->ajk_ic}}");
            $('#kak_ajk_jantina').val("{{$krt_ajk->ajk_jantina}}");
            $('#kak_ajk_warganegara').val("{{$krt_ajk->ajk_warganegara}}");
            $('#kak_ajk_agama').val("{{$krt_ajk->ajk_agama}}");
            $('#kak_ajk_tarikh_lahir').val("{{$krt_ajk->ajk_tarikh_lahir}}");
            $('#kak_ajk_k_umur').val("{{$krt_ajk->ajk_kelompok_umur}}");
            $('#kak_ajk_kaum').val("{{$krt_ajk->ajk_kaum}}");
            $('#kak_ajk_phone').val("{{$krt_ajk->ajk_phone}}");
            $('#kak_ajk_alamat').val("{{$krt_ajk->ajk_alamat}}");
            $('#kak_ajk_poskod').val("{{$krt_ajk->ajk_poskod}}");
            $('#kak_ajk_pendidikan_id').val("{{$krt_ajk->ajk_pendidikan_id}}");
            $('#kak_ajk_profession_id').val("{{$krt_ajk->ajk_profession_id}}");
            $('#kak_ajk_jawatan_krt_id').val("{{$krt_ajk->ajk_jawatan_krt_id}}");
            $('#kak_ajk_tarikh_mula').val("{{$krt_ajk->ajk_tarikh_mula}}");
            $('#kak_ajk_tarikh_akhir').val("{{$krt_ajk->ajk_tarikh_akhir}}");
            $('#meg_krt_ajk_krt_id').val("{{$krt_ajk->id}}");
            
            $('[name=kak_ajk_bekepentingan]').click(function(){
                if($('[name=kak_ajk_bekepentingan]').is(":checked")) {
                    $("[name=kak_ajk_bekepentingan_interaksi_1]").removeAttr("disabled");
                    $("[name=kak_ajk_bekepentingan_interaksi_2]").removeAttr("disabled");
                    $("[name=kak_ajk_bekepentingan_interaksi_3]").removeAttr("disabled");
                    $("[name=kak_ajk_bekepentingan_interaksi_4]").removeAttr("disabled");
                    $("[name=kak_ajk_bekepentingan_interaksi_5]").removeAttr("disabled");
                    $("[name=kak_ajk_berkepentingan_keterangan]").removeAttr("disabled");
                }
                else {
                    $("[name=kak_ajk_bekepentingan_interaksi_1]").attr("disabled", "disabled");
                    $("[name=kak_ajk_bekepentingan_interaksi_2]").attr("disabled", "disabled");
                    $("[name=kak_ajk_bekepentingan_interaksi_3]").attr("disabled", "disabled");
                    $("[name=kak_ajk_bekepentingan_interaksi_4]").attr("disabled", "disabled");
                    $("[name=kak_ajk_bekepentingan_interaksi_5]").attr("disabled", "disabled");
                    $("[name=kak_ajk_berkepentingan_keterangan]").attr("disabled", "disabled");
                }
            });

        /* Maklumat Status Ajk */
            $('#kak_ajk_status').val("{{$krt_ajk->ajk_status}}");
        
        /* Button */
            $('#btn_back').click(function(){
                window.location.href = '{{route('rt-sm4.senarai_ajk_krt')}}';
            });

	});

    /* click add gambar ajk */
		$(document).on('submit', '#form_meg', function(event){
			var info = $('.error_form_meg');
			event.preventDefault();

			var form_data = new FormData();
			form_data.append("meg_file_avatar",  $("#meg_file_avatar")[0].files[0]);
			form_data.append("meg_krt_ajk_krt_id", $("#meg_krt_ajk_krt_id").val() );
			form_data.append("post_edit_gambar", "edit" );
			console.log(form_data);

			$('#btn_edit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_edit').prop('disabled', true);

			btn_text = 'Kemaskini Gambar&nbsp;&nbsp;<i class="dropdown-icon fa fa-edit"></i>';
			url = "{{ route('rt-sm4.post_edit_gambar') }}";
			type = "POST";

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$.ajax({
				url: url,
				type: type,
				data: form_data,
				contentType: false,
            	processData: false,
      			async: false,
			}).done(function(response) {            
				info.hide().find('ul').empty();
				if(response.errors){
					$.each(response.errors, function(index, error){
						info.find('ul').append('<li>'+error+'</li>');
					});
					$('#btn_edit').html(btn_text);                
					$('#btn_edit').prop('disabled', false);
					info.slideDown();
				} else {
                    window.location.href = "{{route('rt-sm4.kemaskini_ajk_krt','')}}"+"/"+"{{$krt_ajk->id}}";
                    $('#modal_edit_gambar').modal('hide');
					
                    
					$('#form_meg').trigger("reset");
					$('#btn_edit').html(btn_text);
					$('#btn_edit').prop('disabled', false);
					
				}
			});
		});

    /* Btn Hantar */
        //my custom script
        var kemaskini_ahli_krt_config = {
            routes: {
                kemaskini_ahli_krt_url: "{{ route('rt-sm4.post_kemaskini_ahli_krt') }}",
            }
        };

        $(document).on('submit', '#form_kak', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_kak, #form_kak1").serialize();
            var action = $('#post_kemaskini_ahli_krt').val();
            var btn_text;
            if (action == 'edit') {
                url = kemaskini_ahli_krt_config.routes.kemaskini_ahli_krt_url;
                type = "POST";
                btn_text = 'Hantar Status Ahli Jawatankuasa &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=kak_ajk_status]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'kak_ajk_status') {
                            $('[name=kak_ajk_status]').addClass("is-invalid");
                            $('.error_kak_ajk_status').html(error);
                        }

                        if(index == 'kak_ajk_tarikh_lahir') {
                            $('[name=kak_ajk_tarikh_lahir]').addClass("is-invalid");
                            $('.error_kak_ajk_tarikh_lahir').html(error);
                        }

                        if(index == 'kak_ajk_k_umur') {
                            $('[name=kak_ajk_k_umur]').addClass("is-invalid");
                            $('.error_kak_ajk_k_umur').html(error);
                        }

                        if(index == 'kak_ajk_kaum') {
                            $('[name=kak_ajk_kaum]').addClass("is-invalid");
                            $('.error_kak_ajk_kaum').html(error);
                        }

                        if(index == 'kak_ajk_agama') {
                            $('[name=kak_ajk_agama]').addClass("is-invalid");
                            $('.error_kak_ajk_agama').html(error);
                        }

                        if(index == 'kak_ajk_phone') {
                            $('[name=kak_ajk_phone]').addClass("is-invalid");
                            $('.error_kak_ajk_phone').html(error);
                        }

                        if(index == 'kak_ajk_alamat') {
                            $('[name=kak_ajk_alamat]').addClass("is-invalid");
                            $('.error_kak_ajk_alamat').html(error);
                        }

                        if(index == 'kak_ajk_poskod') {
                            $('[name=kak_ajk_poskod]').addClass("is-invalid");
                            $('.error_kak_ajk_poskod').html(error);
                        }

                        if(index == 'kak_ajk_pendidikan_id') {
                            $('[name=kak_ajk_pendidikan_id]').addClass("is-invalid");
                            $('.error_kak_ajk_pendidikan_id').html(error);
                        }

                        if(index == 'kak_ajk_profession_id') {
                            $('[name=kak_ajk_profession_id]').addClass("is-invalid");
                            $('.error_kak_ajk_profession_id').html(error);
                        }

                        if(index == 'kak_ajk_jawatan_krt_id') {
                            $('[name=kak_ajk_jawatan_krt_id]').addClass("is-invalid");
                            $('.error_kak_ajk_jawatan_krt_id').html(error);
                        }

                    });
                    $('#btn_submit').html(btn_text);                
                    $('#btn_submit').prop('disabled', false);            
                } else {
                    $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm4.senarai_ajk_krt')}}";
                }
            });
        });
    
	

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop