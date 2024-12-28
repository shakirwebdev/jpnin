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
        $('#prkr_nama_krt').html("{{$rekod_kewangan_rt->nama_krt}}");
        $('#prkr_alamat_krt').html("{{$rekod_kewangan_rt->alamat_krt}}");
        $('#prkr_negeri_krt').html("{{$rekod_kewangan_rt->negeri_krt}}");
        $('#prkr_daerah_krt').html("{{$rekod_kewangan_rt->daerah_krt}}");
        $('#prkr_parlimen_krt').html("{{$rekod_kewangan_rt->parlimen_krt}}");
        $('#prkr_dun_krt').html("{{$rekod_kewangan_rt->dun_krt}}");
        $('#prkr_pbt_krt').html("{{$rekod_kewangan_rt->pbt_krt}}");

    /* Maklumat Kewangan Rukun Tetangga */
        $('#prkr_1_krt_kewangan_id').val("{{$rekod_kewangan_rt->id}}");
        $('#prkr_kewangan_no_acc').val("{{$rekod_kewangan_rt->krt_bank_no_acc}}");
        $('#prkr_kewangan_jenis_kewangan').val("{{$rekod_kewangan_rt->kewangan_jenis_kewangan}}");
        $('#prkr_kewangan_nama_bank').val("{{$rekod_kewangan_rt->krt_bank_nama}}");
        $('#prkr_kewangan_no_evendor').val("{{$rekod_kewangan_rt->krt_bank_no_evendor}}");
        $('#prkr_kewangan_nama_penuh').val("{{$rekod_kewangan_rt->kewangan_nama_penuh}}");
        $('#prkr_kewangan_alamat').val("{{$rekod_kewangan_rt->kewangan_alamat}}");
        $('#prkr_kewangan_butiran').val("{{$rekod_kewangan_rt->kewangan_butiran}}");
        $('#prkr_tarikh_t_b').val("{{$rekod_kewangan_rt->tarikh_t_b}}");
        $('#prkr_kewangan_cek_baucer').val("{{$rekod_kewangan_rt->kewangan_cek_baucer}}");
        $('#prkr_tarikh_c_b').val("{{$rekod_kewangan_rt->tarikh_c_b}}");
        $('#prkr_kewangan_jumlah_tunai').val("{{$rekod_kewangan_rt->kewangan_jumlah_tunai}}");
        $('#prkr_kewangan_jumlah_bank').val("{{$rekod_kewangan_rt->kewangan_jumlah_bank}}");
        $('#prkr_kewangan_baki_tunai').val("{{$rekod_kewangan_rt->kewangan_baki_tunai}}");
        $('#prkr_kewangan_baki_bank').val("{{$rekod_kewangan_rt->kewangan_baki_bank}}");
        $('#prkr_kewangan_jumlah_baki').val("{{$rekod_kewangan_rt->kewangan_jumlah_baki}}");
        $('#prkr_1_krt_profile_id').val("{{$rekod_kewangan_rt->krt_profile_id}}");
        $('#prkr_1_kewangan_baki_tunai').val("{{$rekod_kewangan_rt->kewangan_baki_tunai}}");
        $('#prkr_1_kewangan_baki_bank').val("{{$rekod_kewangan_rt->kewangan_baki_bank}}");

        $('#prkr_1_sahkan_noted').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

    /* Button */
        $('#btn_back').click(function(){
            window.location.href = '{{route('rt-sm7.pengesahan_rekod_kewangan_rt')}}';
        });
        
  });

    /* action submit */
        //my custom script
        var pengesahan_rekod_kewangan_rt_config = {
            routes: {
                pengesahan_rekod_kewangan_rt_url: "{{ route('rt-sm7.post_pengesahan_rekod_kewangan_rt') }}",
            }
        };

        $(document).on('submit', '#form_prkr_1', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_prkr_1").serialize();
            var action = $('#post_pengesahan_rekod_kewangan_rt').val();
            var btn_text;
            if (action == 'edit') {
                url = pengesahan_rekod_kewangan_rt_config.routes.pengesahan_rekod_kewangan_rt_url;
                type = "POST";
                btn_text = 'Hantar Status Pengesahan &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=prkr_1_kewangan_status]').removeClass("is-invalid");
                $('[name=prkr_1_sahkan_noted]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'prkr_1_kewangan_status') {
                        $('[name=prkr_1_kewangan_status]').addClass("is-invalid");
                        $('.error_prkr_1_kewangan_status').html(error);
                    }

                    if(index == 'prkr_1_sahkan_noted') {
                        $('[name=prkr_1_sahkan_noted]').addClass("is-invalid");
                        $('.error_prkr_1_sahkan_noted').html(error);
                    }
                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
            $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
            window.location.href = "{{route('rt-sm7.pengesahan_rekod_kewangan_rt')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop