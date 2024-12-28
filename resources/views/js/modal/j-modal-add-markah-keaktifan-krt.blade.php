<script>  
    function load_add_markah_keaktifan_krt(id,markah) {
        $('#modal_add_markah_keaktifan_krt').modal('show');
        $('#mamkk_krt_profile_id').val(id);
        
        // $("#mamkk_markah").on("keyup change", function(e) {
        //     $('#mamkk_markah_1').val(parseInt(markah) + parseInt($("#mamkk_markah").val()));
        // });

        //my custom script
		var add_markah_keaktifan_ppd_config = {
			routes: {
				add_markah_keaktifan_ppd_url: "{{ route('rt-sm11.add_markah_keaktifan_ppd') }}",
			}
		};

        $(document).on('submit', '#form_mamkk', function(event){    
			event.preventDefault();
			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save').prop('disabled', true);
			$('#add_tahun').val($('#kkhq_tahun').val());
			var data = $("#form_mamkk").serialize();
			var action = $('#add_markah_keaktifan_ppd').val();
			var btn_text;
			
			if (action == 'add') {
				url = add_markah_keaktifan_ppd_config.routes.add_markah_keaktifan_ppd_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
			}

			$.ajax({
				url: url,
				type: type,
				data: data,
				error:function(x,e) {
							if (x.status==0) {
								alert('You are offline!!\n Please Check Your Network.');
							} else if(x.status==404) {
								alert('Requested URL not found.');
							} else if(x.status==500) {
								alert('Internel Server Error.');
							} else if(e=='parsererror') {
								alert('Error.\nParsing JSON Request failed.');
							} else if(e=='timeout'){
								alert('Request Time out.');
							} else {
								alert('Unknow Error.\n'+x.responseText);
							}
						},
			}).done(function(response) {        
				$('[name=mamkk_markah]').removeClass("is-invalid");
                
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'mamkk_markah') {
							$('[name=mamkk_markah]').addClass("is-invalid");
							$('.error_mamkk_markah').html(error);
						}
                    });
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);            
				} else {
					$('#modal_add_markah_keaktifan_krt').modal('hide');
					btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);   
					$.fn.myfunction();
				}
			});
		});

	}

</script>