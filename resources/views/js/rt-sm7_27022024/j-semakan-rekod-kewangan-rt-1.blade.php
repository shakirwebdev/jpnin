@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
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
		$('#srkr_nama_krt').html("{{$rekod_kewangan_rt->nama_krt}}");
		$('#srkr_alamat_krt').html("{{$rekod_kewangan_rt->alamat_krt}}");
		$('#srkr_negeri_krt').html("{{$rekod_kewangan_rt->negeri_krt}}");
		$('#srkr_daerah_krt').html("{{$rekod_kewangan_rt->daerah_krt}}");
		$('#srkr_parlimen_krt').html("{{$rekod_kewangan_rt->parlimen_krt}}");
		$('#srkr_dun_krt').html("{{$rekod_kewangan_rt->dun_krt}}");
		$('#srkr_pbt_krt').html("{{$rekod_kewangan_rt->pbt_krt}}");

    /* Maklumat Kewangan Rukun Tetangga */
        $('#srkr_1_krt_kewangan_id').val("{{$rekod_kewangan_rt->id}}");
        $('#srkr_kewangan_no_acc').val("{{$rekod_kewangan_rt->krt_bank_no_acc}}");
        $('#srkr_kewangan_jenis_kewangan').val("{{$rekod_kewangan_rt->kewangan_jenis_kewangan}}");
        $('#srkr_kewangan_nama_penuh').val("{{$rekod_kewangan_rt->kewangan_nama_penuh}}");
        $('#srkr_kewangan_alamat').val("{{$rekod_kewangan_rt->kewangan_alamat}}");
        $('#srkr_kewangan_nama_bank').val("{{$rekod_kewangan_rt->krt_bank_nama}}");
        $('#srkr_kewangan_no_evendor').val("{{$rekod_kewangan_rt->krt_bank_no_evendor}}");
        $('#srkr_kewangan_butiran').val("{{$rekod_kewangan_rt->kewangan_butiran}}");
        $('#srkr_tarikh_t_b').val("{{$rekod_kewangan_rt->tarikh_t_b}}");
        $('#srkr_kewangan_cek_baucer').val("{{$rekod_kewangan_rt->kewangan_cek_baucer}}");
        $('#srkr_tarikh_c_b').val("{{$rekod_kewangan_rt->tarikh_c_b}}");
        $('#srkr_kewangan_jumlah_tunai').val("{{$rekod_kewangan_rt->kewangan_jumlah_tunai}}");
        $('#srkr_kewangan_jumlah_bank').val("{{$rekod_kewangan_rt->kewangan_jumlah_bank}}");
        $('#srkr_kewangan_baki_tunai').val("{{$rekod_kewangan_rt->kewangan_baki_tunai}}");
        $('#srkr_kewangan_baki_bank').val("{{$rekod_kewangan_rt->kewangan_baki_bank}}");
        $('#srkr_kewangan_jumlah_baki').val("{{$rekod_kewangan_rt->kewangan_jumlah_baki}}");

        $('#srkr_1_semak_noted').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

    /* Button */
		$('#btn_back').click(function(){
			window.location.href = "{{route('rt-sm7.semakan_rekod_kewangan_rt')}}";
		});
        
    });

    /* action submit */
        //my custom script
        var semakan_rekod_kewangan_rt_config = {
            routes: {
                semakan_rekod_kewangan_rt_url: "{{ route('rt-sm7.post_semakan_rekod_kewangan_rt') }}",
            }
        };

        $(document).on('submit', '#form_srkr_1', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_srkr_1").serialize();
            var action = $('#post_semakan_rekod_kewangan_rt').val();
            var btn_text;
            if (action == 'edit') {
                url = semakan_rekod_kewangan_rt_config.routes.semakan_rekod_kewangan_rt_url;
                type = "POST";
                btn_text = 'Hantar Status Semakan &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=srkr_1_kewangan_status]').removeClass("is-invalid");
                $('[name=srkr_1_semak_noted]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'srkr_1_kewangan_status') {
                        $('[name=srkr_1_kewangan_status]').addClass("is-invalid");
                        $('.error_srkr_1_kewangan_status').html(error);
                    }

                    if(index == 'srkr_1_semak_noted') {
                        $('[name=srkr_1_semak_noted]').addClass("is-invalid");
                        $('.error_srkr_1_semak_noted').html(error);
                    }
                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
            $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
            window.location.href = "{{route('rt-sm7.semakan_rekod_kewangan_rt')}}";
                }
            });
        });
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop