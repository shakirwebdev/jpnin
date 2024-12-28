@section('page-script')



<script type="text/javascript"> 

    $(document).ready( function () {
        
    
		/* Maklumat Kewangan Rukun Tetangga */
            $('#user_nama').val("{{$profile->name}}");
            $('#no_kp').val("{{$profile->no_ic}}");
            $('#krt_nama').val("{{$profile->krt_nama}}");
			// $('#new_password').val("{{$profile->password}}");
			$('#user_email').val("{{$profile->user_email}}");
			$('#no_phone').val("{{$profile->no_phone}}");
			$('#user_profile_user_id').val("{{$profile->user_profile_user_id}}");
			$('#user_profile_id').val("{{$profile->user_profile_id}}");
			

		});
		

			/* click btn kemaskini */
		//my custom script

		// var kemaskini_user_krt_config = {
		// 	routes: {
		// 		kemaskini_user_url: "{{ route('update_user_profile') }}",
		// 	}
		// };

			
            
			$(document).on('submit', '#user_update_form', function(event){    
			event.preventDefault();
			$('#btn_send').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_send').prop('disabled', true);
			var data   = $("#user_update_form").serialize();
			var action = $('#update_user_profile').val();
			var btn_text; 
			btn_text = 'Simpan &nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';

			$.ajax({
				url:" {{ route('update_user_profile') }}",
				type: 'PUT',
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
					}
			}).done(function(response) {        
				$('[name=user_email]').removeClass("is-invalid");
				$('[name=no_phone]').removeClass("is-invalid");
				$('[name=new_password]').removeClass("is-invalid");
				$('[name=captcha]').removeClass("is-invalid");
			
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'user_email') {
							$('[name=user_email]').addClass("is-invalid");
							$('.error_user_email').html(error);
						}

						if(index == 'no_phone') {
							$('[name=no_phone]').addClass("is-invalid");
							$('.error_no_phone').html(error);
						}

						if(index == 'new_password') {
							$('[name=new_password]').addClass("is-invalid");
							$('.error_new_password').html(error);
						}

						if(index == 'captcha') {
							$('[name=captcha]').addClass("is-invalid");
							$('.error_captcha').html(error);
						}
					});
					$('#btn_send').html(btn_text);                
					$('#btn_send').prop('disabled', false);            
				} else {
					$('#btn_send').html(btn_text);
					$('#btn_send').prop('disabled', false); 
					event.preventDefault();
					swal("Profil  Berjaya Dikemaskini!", "Rekod dikemaskini di dalam pangkalan data", "success");
					window.location.href = "{{ route('update_user_profile') }}";
				}
			});
		});
            
   
		$(document).on('click', '.eye-icon', function() {
        var input = $($(this).attr('toggle'));
        if (input.attr('type') == 'password') {
            input.attr('type', 'text');
            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            $(this).removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });


	$(document).ready( function () {
        $('.show-pwd').click(function () {
            $(this).toggleClass("active");
            var input=$("#new_password");
            if(input.attr("type")=="text") {
                input.attr("type","password");
                $(this).css('color', '');
            } else {
                input.attr("type","text");
                $(this).css('color', 'red');
            }
        });
    });

	



	function refreshCaptcha(){
        $.ajax({
            url: "/secure/refresh_captcha",
            type: 'get',
            dataType: 'html',
            success: function(json) {
                $('.refereshrecapcha').html(json);
            },
			error: function(xhr, status, error) {
        // Handle error (e.g., invalid CAPTCHA)
        if (xhr.responseJSON && xhr.responseJSON.message === 'Invalid CAPTCHA') {
            // If CAPTCHA is invalid, refresh the CAPTCHA
            refreshCaptcha();
        }
    }
        });
    }

</script>



<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop