@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    //my custom script
    var krt_config = {
        routes: {
            krt_action_url: "/rt/sm1/semak-borang-cadangan-krt-baharu"

        }
    };

    $(document).ready( function () {
        
    	$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /* Maklumat Permohon */

        $('#krt_nama_pemohon').val("{{$applicant->user_fullname}}");
        $('#krt_no_ic_pemohon').val("{{$applicant->no_ic}}");
        $('#krt_no_telefon_pemohon').val("{{$applicant->no_phone}}");
        $('#krt_alamat_pemohon').val("{{$applicant->user_address}}");
        $('#select_negeri_krt').val("{{$applicant->state_id}}");
        $('#select_daerah_krt').val("{{$applicant->daerah_id}}");
        $('#krt_nama').val("{{$applicant->krt_name}}");
        $('#krt_catatan').val("{{$applicant->krt_note}}");

        
        $('#sbckb_application_id').val("{{$applicant->id}}");
        $('#sbckb_krt_nama').val("{{$applicant->krt_name}}");
        $('#sbckb_krt_alamat').val("{{$applicant->krt_note}}");
        $('#sbckb_krt_state_id').val("{{$applicant->state_id}}");
        $('#sbckb_krt_daerah_id').val("{{$applicant->daerah_id}}");

        $('#krt_disemak_note').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
            e.preventDefault();

            // Ajax code here

            return false;
        }
        });
        
        
    });

   

    //my custom script
	var semak_borang_cadangan_krt_baharu_config = {
        routes: {
            semak_borang_cadangan_krt_baharu_action_url: "{{ route('rt-sm1.post_semak_borang_cadangan_krt_baharu') }}",
        }
    };

    $(document).on('submit', '#form_sbckb', function(event){    
        event.preventDefault();
        $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
        $('#btn_submit').prop('disabled', true);
        var data = $("#form_sbckb").serialize();
        var action = $('#post_semak_borang_cadangan_krt_baharu').val();
        var btn_text;
        if (action == 'edit') {
            url = semak_borang_cadangan_krt_baharu_config.routes.semak_borang_cadangan_krt_baharu_action_url;
            type = "POST";
            btn_text = 'Hantar Semakan Cadangan Penubuhan KRT &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
        } 
		$.ajax({
            url: url,
            type: type,
            data: data,
        }).done(function(response) {        
            $('[name=select_status_cadangan_krt]').removeClass("is-invalid");
            
			if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'select_status_cadangan_krt') {
                        $('[name=select_status_cadangan_krt]').addClass("is-invalid");
                        $('.error_select_status_cadangan_krt').html(error);
                    }

                    if(index == 'krt_disemak_note') {
                        $('[name=krt_disemak_note]').addClass("is-invalid");
                        $('.error_krt_disemak_note').html(error);
                    }

                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
				$('#btn_submit').html(btn_text);
                $('#btn_submit').prop('disabled', false); 
				window.location.href = "{{route('rt-sm1.semakan_cadangan_krt_baharu')}}";
            }
        });
    });
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop