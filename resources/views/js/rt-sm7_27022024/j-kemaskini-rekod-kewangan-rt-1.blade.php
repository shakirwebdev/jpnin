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
        
    /* Maklumat Kawasan Krt */
		$('#krkr_nama_krt').html("{{$rekod_kewangan_rt->nama_krt}}");
		$('#krkr_alamat_krt').html("{{$rekod_kewangan_rt->alamat_krt}}");
		$('#krkr_negeri_krt').html("{{$rekod_kewangan_rt->negeri_krt}}");
		$('#krkr_daerah_krt').html("{{$rekod_kewangan_rt->daerah_krt}}");
		$('#krkr_parlimen_krt').html("{{$rekod_kewangan_rt->parlimen_krt}}");
		$('#krkr_dun_krt').html("{{$rekod_kewangan_rt->dun_krt}}");
		$('#krkr_pbt_krt').html("{{$rekod_kewangan_rt->pbt_krt}}");

    /* Maklumat Kewangan Rukun Tetangga */
        $('#krkr_krt_kewangan_id').val("{{$rekod_kewangan_rt->id}}");
        $('#krkr_kewangan_no_acc').val("{{$rekod_kewangan_rt->krt_bank_no_acc}}");
        $('#krkr_kewangan_jenis_kewangan').val("{{$rekod_kewangan_rt->kewangan_jenis_kewangan}}");
        $('#krkr_kewangan_nama_penuh').val("{{$rekod_kewangan_rt->kewangan_nama_penuh}}");
        $('#krkr_kewangan_alamat').val("{{$rekod_kewangan_rt->kewangan_alamat}}");

        $('#krkr_kewangan_nama_bank').val("{{$rekod_kewangan_rt->krt_bank_nama}}");
        $('#krkr_kewangan_no_evendor').val("{{$rekod_kewangan_rt->krt_bank_no_evendor}}");
        $('#krkr_kewangan_butiran').val("{{$rekod_kewangan_rt->kewangan_butiran}}");
        $('#krkr_kewangan_tarikh_t_b').val("{{$rekod_kewangan_rt->tarikh_t_b}}");
        $('#krkr_kewangan_cek_baucer').val("{{$rekod_kewangan_rt->kewangan_cek_baucer}}");
        $('#krkr_kewangan_tarikh_cek').val("{{$rekod_kewangan_rt->tarikh_c_b}}");
        $('#krkr_kewangan_jumlah_tunai').val("{{$rekod_kewangan_rt->kewangan_jumlah_tunai}}");
        $('#krkr_kewangan_jumlah_bank').val("{{$rekod_kewangan_rt->kewangan_jumlah_bank}}");
        $('#krkr_kewangan_baki_tunai').val("{{$rekod_kewangan_rt->kewangan_baki_tunai}}");
        $('#krkr_kewangan_baki_bank').val("{{$rekod_kewangan_rt->kewangan_baki_bank}}");
        $('#krkr_kewangan_jumlah_baki').val("{{$rekod_kewangan_rt->kewangan_jumlah_baki}}");

        $('#krkr_kewangan_alamat').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

        var tunai = parseInt("{{$rekod_kewangan_rt->krt_bank_baki_cash}}");
        var bank = parseInt("{{$rekod_kewangan_rt->krt_bank_baki_bank}}");
        var total = parseInt(tunai) + parseInt(bank);
        $('#kewangan_baki_tunai').val(tunai);
        $('#kewangan_baki_bank').val(bank);
        $('#kewangan_jumlah_baki').val(total);
        if($('#krkr_kewangan_jenis_kewangan').val() == 1){
          var baki_tunai  = parseInt("{{$rekod_kewangan_rt->krt_bank_baki_cash}}");
          $("#krkr_kewangan_jumlah_tunai").keyup(function(){
            var terimatunai = parseInt($('#krkr_kewangan_jumlah_tunai').val());
            var total_tunai = parseInt(baki_tunai) + parseInt(terimatunai);
            $('#kewangan_baki_tunai').val(total_tunai);
            $('#kewangan_jumlah_baki').val(parseInt($('#kewangan_baki_tunai').val()) + parseInt($('#kewangan_baki_bank').val()));
            $('#krkr_kewangan_baki_tunai').val(total_tunai);
            $('#krkr_kewangan_jumlah_baki').val(parseInt($('#kewangan_baki_tunai').val()) + parseInt($('#kewangan_baki_bank').val()));
          });
         
          var baki_bank   = parseInt("{{$rekod_kewangan_rt->krt_bank_baki_bank}}");
          $("#krkr_kewangan_jumlah_bank").keyup(function(){
            var terimabank  = parseInt($('#krkr_kewangan_jumlah_bank').val());
            var total_bank  = parseInt(baki_bank) + parseInt(terimabank);
            $('#kewangan_baki_bank').val(total_bank);
            $('#kewangan_jumlah_baki').val(parseInt($('#kewangan_baki_tunai').val()) + parseInt($('#kewangan_baki_bank').val()));
            $('#krkr_kewangan_baki_bank').val(total_bank);
            $('#krkr_kewangan_jumlah_baki').val(parseInt($('#kewangan_baki_tunai').val()) + parseInt($('#kewangan_baki_bank').val()));
          });
        }else{
          var baki_tunai  = parseInt("{{$rekod_kewangan_rt->krt_bank_baki_cash}}");
          $("#krkr_kewangan_jumlah_tunai").keyup(function(){
            var terimatunai = parseInt($('#krkr_kewangan_jumlah_tunai').val());
            var total_tunai = parseInt(baki_tunai) - parseInt(terimatunai);
            $('#kewangan_baki_tunai').val(total_tunai);
            $('#kewangan_jumlah_baki').val(parseInt($('#kewangan_baki_tunai').val()) + parseInt($('#kewangan_baki_bank').val()));
            $('#krkr_kewangan_baki_tunai').val(total_tunai);
            $('#krkr_kewangan_jumlah_baki').val(parseInt($('#kewangan_baki_tunai').val()) + parseInt($('#kewangan_baki_bank').val()));
          });

          var baki_bank   = parseInt("{{$rekod_kewangan_rt->krt_bank_baki_bank}}");
          $("#krkr_kewangan_jumlah_bank").keyup(function(){
            var terimabank  = parseInt($('#krkr_kewangan_jumlah_bank').val());
            var total_bank  = parseInt(baki_bank) - parseInt(terimabank);
            $('#kewangan_baki_bank').val(total_bank);
            $('#kewangan_jumlah_baki').val(parseInt($('#kewangan_baki_tunai').val()) + parseInt($('#kewangan_baki_bank').val()));
            $('#krkr_kewangan_baki_bank').val(total_bank);
            $('#krkr_kewangan_jumlah_baki').val(parseInt($('#kewangan_baki_tunai').val()) + parseInt($('#kewangan_baki_bank').val()));
          });
		}


        $("#krkr_kewangan_jenis_kewangan").change(function(){
        if($('#krkr_kewangan_jenis_kewangan').val() == 1){
          var baki_tunai  = parseInt("{{$rekod_kewangan_rt->krt_bank_baki_cash}}");
          $("#krkr_kewangan_jumlah_tunai").keyup(function(){
            var terimatunai = parseInt($('#krkr_kewangan_jumlah_tunai').val());
            var total_tunai = parseInt(baki_tunai) + parseInt(terimatunai);
            $('#kewangan_baki_tunai').val(total_tunai);
            $('#kewangan_jumlah_baki').val(parseInt($('#kewangan_baki_tunai').val()) + parseInt($('#kewangan_baki_bank').val()));
            $('#krkr_kewangan_baki_tunai').val(total_tunai);
            $('#krkr_kewangan_jumlah_baki').val(parseInt($('#kewangan_baki_tunai').val()) + parseInt($('#kewangan_baki_bank').val()));
          });
         
          var baki_bank   = parseInt("{{$rekod_kewangan_rt->krt_bank_baki_bank}}");
          $("#krkr_kewangan_jumlah_bank").keyup(function(){
            var terimabank  = parseInt($('#krkr_kewangan_jumlah_bank').val());
            var total_bank  = parseInt(baki_bank) + parseInt(terimabank);
            $('#kewangan_baki_bank').val(total_bank);
            $('#kewangan_jumlah_baki').val(parseInt($('#kewangan_baki_tunai').val()) + parseInt($('#kewangan_baki_bank').val()));
            $('#krkr_kewangan_baki_bank').val(total_bank);
            $('#krkr_kewangan_jumlah_baki').val(parseInt($('#kewangan_baki_tunai').val()) + parseInt($('#kewangan_baki_bank').val()));
          });
        }else{
          var baki_tunai  = parseInt("{{$rekod_kewangan_rt->krt_bank_baki_cash}}");
          $("#krkr_kewangan_jumlah_tunai").keyup(function(){
            var terimatunai = parseInt($('#krkr_kewangan_jumlah_tunai').val());
            var total_tunai = parseInt(baki_tunai) - parseInt(terimatunai);
            $('#kewangan_baki_tunai').val(total_tunai);
            $('#kewangan_jumlah_baki').val(parseInt($('#kewangan_baki_tunai').val()) + parseInt($('#kewangan_baki_bank').val()));
            $('#krkr_kewangan_baki_tunai').val(total_tunai);
            $('#krkr_kewangan_jumlah_baki').val(parseInt($('#kewangan_baki_tunai').val()) + parseInt($('#kewangan_baki_bank').val()));
          });

          var baki_bank   = parseInt("{{$rekod_kewangan_rt->krt_bank_baki_bank}}");
          $("#krkr_kewangan_jumlah_bank").keyup(function(){
            var terimabank  = parseInt($('#krkr_kewangan_jumlah_bank').val());
            var total_bank  = parseInt(baki_bank) - parseInt(terimabank);
            $('#kewangan_baki_bank').val(total_bank);
            $('#kewangan_jumlah_baki').val(parseInt($('#kewangan_baki_tunai').val()) + parseInt($('#kewangan_baki_bank').val()));
            $('#krkr_kewangan_baki_bank').val(total_bank);
            $('#krkr_kewangan_jumlah_baki').val(parseInt($('#kewangan_baki_tunai').val()) + parseInt($('#kewangan_baki_bank').val()));
          });
		}
      });

    /* Maklumat Note Kemaskini */
        $('#krkr_status').val("{{$rekod_kewangan_rt->kewangan_status}}");
            
            if($('#krkr_status').val() == '4'){
                $("#krkr_perlu_kemaskini").show();
                $('#krkr_status_description').html("{{$rekod_kewangan_rt->status_kewangan_description}}");
                $('#krkr_semak_note').html("{{$rekod_kewangan_rt->semak_noted}}");
            }

            if($('#krkr_status').val() == '5'){
                $("#krkr_perlu_kemaskini").show();
                $('#krkr_status_description').html("{{$rekod_kewangan_rt->status_kewangan_description}}");
                $('#krkr_sah_note').html("{{$rekod_kewangan_rt->sah_noted}}");
            }

    /* Button */
		$('#btn_back').click(function(){
			window.location.href = "{{route('rt-sm7.senarai_rekod_kewangan_rt')}}";
		});
        
    });

    /* action submit */
        //my custom script
        var kemaskini_rekod_kewangan_rt_config = {
            routes: {
                kemaskini_rekod_kewangan_rt_url: "{{ route('rt-sm7.post_edit_rekod_kewangan_rt') }}",
            }
        };

        $(document).on('submit', '#form_krkr', function(event){    
            event.preventDefault();
            $('#btn_send').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_send').prop('disabled', true);
            var data = $("#form_krkr").serialize();
            var action = $('#post_edit_rekod_kewangan_rt').val();
            var btn_text;
            if (action == 'edit') {
                url = kemaskini_rekod_kewangan_rt_config.routes.kemaskini_rekod_kewangan_rt_url;
                type = "POST";
                btn_text = 'Hantar Maklumat Kewangan &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=krkr_kewangan_jenis_kewangan]').removeClass("is-invalid");
                $('[name=krkr_kewangan_nama_bank]').removeClass("is-invalid");
                $('[name=krkr_kewangan_no_acc]').removeClass("is-invalid");
                $('[name=krkr_kewangan_no_evendor]').removeClass("is-invalid");
                $('[name=krkr_kewangan_nama_penuh]').removeClass("is-invalid");
                $('[name=krkr_kewangan_alamat]').removeClass("is-invalid");
                $('[name=krkr_kewangan_butiran]').removeClass("is-invalid");
                $('[name=krkr_tarikh_t_b]').removeClass("is-invalid");
                $('[name=krkr_kewangan_cek_baucer]').removeClass("is-invalid");
                $('[name=krkr_tarikh_c_b]').removeClass("is-invalid");
                $('[name=krkr_kewangan_jumlah_tunai]').removeClass("is-invalid");
                $('[name=krkr_kewangan_jumlah_bank]').removeClass("is-invalid");
                $('[name=krkr_kewangan_baki_tunai]').removeClass("is-invalid");
                $('[name=krkr_kewangan_baki_bank]').removeClass("is-invalid");
                $('[name=krkr_kewangan_jumlah_baki]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'krkr_kewangan_jenis_kewangan') {
                        $('[name=krkr_kewangan_jenis_kewangan]').addClass("is-invalid");
                        $('.error_krkr_kewangan_jenis_kewangan').html(error);
                    }

                    if(index == 'krkr_kewangan_nama_penuh') {
                        $('[name=krkr_kewangan_nama_penuh]').addClass("is-invalid");
                        $('.error_krkr_kewangan_nama_penuh').html(error);
                    }

                    if(index == 'krkr_kewangan_alamat') {
                        $('[name=krkr_kewangan_alamat]').addClass("is-invalid");
                        $('.error_krkr_kewangan_alamat').html(error);
                    }

                    if(index == 'krkr_kewangan_butiran') {
                        $('[name=krkr_kewangan_butiran]').addClass("is-invalid");
                        $('.error_krkr_kewangan_butiran').html(error);
                    }

                    if(index == 'krkr_kewangan_tarikh_t_b') {
                        $('[name=krkr_kewangan_tarikh_t_b]').addClass("is-invalid");
                        $('.error_krkr_kewangan_tarikh_t_b').html(error);
                    }

                    if(index == 'krkr_kewangan_cek_baucer') {
                        $('[name=krkr_kewangan_cek_baucer]').addClass("is-invalid");
                        $('.error_krkr_kewangan_cek_baucer').html(error);
                    }

                    if(index == 'krkr_tarikh_c_b') {
                        $('[name=krkr_tarikh_c_b]').addClass("is-invalid");
                        $('.error_krkr_tarikh_c_b').html(error);
                    }

                    if(index == 'krkr_kewangan_jumlah_tunai') {
                        $('[name=krkr_kewangan_jumlah_tunai]').addClass("is-invalid");
                        $('.error_krkr_kewangan_jumlah_tunai').html(error);
                    }

                    if(index == 'krkr_kewangan_jumlah_bank') {
                        $('[name=krkr_kewangan_jumlah_bank]').addClass("is-invalid");
                        $('.error_krkr_kewangan_jumlah_bank').html(error);
                    }

                    if(index == 'krkr_kewangan_baki_tunai') {
                        $('[name=krkr_kewangan_baki_tunai]').addClass("is-invalid");
                        $('.error_krkr_kewangan_baki_tunai').html(error);
                    }

                    if(index == 'krkr_kewangan_baki_bank') {
                        $('[name=krkr_kewangan_baki_bank]').addClass("is-invalid");
                        $('.error_krkr_kewangan_baki_bank').html(error);
                    }

                    if(index == 'krkr_kewangan_jumlah_baki') {
                        $('[name=krkr_kewangan_jumlah_baki]').addClass("is-invalid");
                        $('.error_krkr_kewangan_jumlah_baki').html(error);
                    }
                });
                $('#btn_send').html(btn_text);                
                $('#btn_send').prop('disabled', false);            
            } else {
            $('#btn_send').html(btn_text);
            $('#btn_send').prop('disabled', false); 
            window.location.href = "{{route('rt-sm7.senarai_rekod_kewangan_rt')}}";
                }
            });
        });
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop