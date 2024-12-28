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
		$('#arkr_nama_krt').html("{{$krt_profile->nama_krt}}");
		$('#arkr_alamat_krt').html("{{$krt_profile->alamat_krt}}");
		$('#arkr_negeri_krt').html("{{$krt_profile->negeri_krt}}");
		$('#arkr_daerah_krt').html("{{$krt_profile->daerah_krt}}");
		$('#arkr_parlimen_krt').html("{{$krt_profile->parlimen_krt}}");
		$('#arkr_dun_krt').html("{{$krt_profile->dun_krt}}");
		$('#arkr_pbt_krt').html("{{$krt_profile->pbt_krt}}");

    /* Maklumat Kewangan Rukun Tetangga */
      $('#arkr_krt_profile_id').val("{{$krt_profile->krt_profile_id}}");
      $('#arkr_kewangan_nama_bank').val("{{$krt_profile->krt_bank_nama}}");
      $('#arkr_kewangan_no_acc').val("{{$krt_profile->krt_bank_no_acc}}");
      $('#arkr_kewangan_no_evendor').val("{{$krt_profile->krt_bank_no_evendor}}");
      var tunai = "{{$krt_profile->krt_bank_baki_cash}}";
      var bank = "{{$krt_profile->krt_bank_baki_bank}}";
      var total_1 = parseFloat(tunai) + parseFloat(bank);
      var total = parseFloat(total_1).toFixed(2);
      $('#kewangan_baki_tunai').val(tunai);
      $('#kewangan_baki_bank').val(bank);
      $('#kewangan_jumlah_baki').val(total);

      $('#arkr_kewangan_alamat').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
          e.preventDefault();

          // Ajax code here parseInt

          return false;
        }
      });

      $('#arkr_kewangan_alamat').on("paste",function(e) {
          e.preventDefault();
      });

      $("#arkr_kewangan_jenis_kewangan").change(function(){
        if($('#arkr_kewangan_jenis_kewangan').val() == 1){
          var baki_tunai  = "{{$krt_profile->krt_bank_baki_cash}}";
          $("#arkr_kewangan_jumlah_tunai").keyup(function(){
            var terimatunai = $('#arkr_kewangan_jumlah_tunai').val();
            var total_tunai_1 = parseFloat(baki_tunai) + parseFloat(terimatunai);
            var total_tunai = parseFloat(total_tunai_1).toFixed(2);
            $('#kewangan_baki_tunai').val(total_tunai);
            var total_baki_tunai_1 =  parseFloat($('#kewangan_baki_tunai').val()) + parseFloat($('#kewangan_baki_bank').val());
            var total_baki_tunai_2 =  parseFloat(total_baki_tunai_1).toFixed(2);
            $('#kewangan_jumlah_baki').val(total_baki_tunai_2);
            $('#arkr_kewangan_baki_tunai').val(total_tunai);
            $('#arkr_kewangan_jumlah_baki').val(total_baki_tunai_2);
          });
         
          var baki_bank   = "{{$krt_profile->krt_bank_baki_bank}}";
          $("#arkr_kewangan_jumlah_bank").keyup(function(){
            var terimabank  = $('#arkr_kewangan_jumlah_bank').val();
            var total_bank_1  = parseFloat(baki_bank) + parseFloat(terimabank);
            var total_bank  = parseFloat(total_bank_1).toFixed(2);
            $('#kewangan_baki_bank').val(total_bank);
            var total_baki_bank_1 =  parseFloat($('#kewangan_baki_tunai').val()) + parseFloat($('#kewangan_baki_bank').val());
            var total_baki_bank_2 =  parseFloat(total_baki_bank_1).toFixed(2);
            $('#kewangan_jumlah_baki').val(total_baki_bank_2);
            $('#arkr_kewangan_baki_bank').val(total_bank);
            $('#arkr_kewangan_jumlah_baki').val(total_baki_bank_2);
          });
        }else{
          var baki_tunai  = "{{$krt_profile->krt_bank_baki_cash}}";
          $("#arkr_kewangan_jumlah_tunai").keyup(function(){
            var terimatunai = $('#arkr_kewangan_jumlah_tunai').val();
            var total_tunai_1 = parseFloat(baki_tunai) - parseFloat(terimatunai);
            var total_tunai = parseFloat(total_tunai_1).toFixed(2);
            $('#kewangan_baki_tunai').val(total_tunai);
            var total_baki_tunai_1 =  parseFloat($('#kewangan_baki_tunai').val()) + parseFloat($('#kewangan_baki_bank').val());
            var total_baki_tunai_2 =  parseFloat(total_baki_tunai_1).toFixed(2);
            $('#kewangan_jumlah_baki').val(total_baki_tunai_2);
            $('#arkr_kewangan_baki_tunai').val(total_tunai);
            $('#arkr_kewangan_jumlah_baki').val(total_baki_tunai_2);
          });

          var baki_bank   = "{{$krt_profile->krt_bank_baki_bank}}";
          $("#arkr_kewangan_jumlah_bank").keyup(function(){
            var terimabank  = $('#arkr_kewangan_jumlah_bank').val();
            var total_bank_1  = parseFloat(baki_bank) - parseFloat(terimabank);
            var total_bank  = parseFloat(total_bank_1).toFixed(2);
            $('#kewangan_baki_bank').val(total_bank);
            var total_baki_bank_1 =  parseFloat($('#kewangan_baki_tunai').val()) + parseFloat($('#kewangan_baki_bank').val());
            var total_baki_bank_2 =  parseFloat(total_baki_bank_1).toFixed(2);
            $('#kewangan_jumlah_baki').val(total_baki_bank_2);
            $('#arkr_kewangan_baki_bank').val(total_bank);
            $('#arkr_kewangan_jumlah_baki').val(total_baki_bank_2);
          });
			  }
      });

      
  });

  //my custom script
	var add_rekod_kewangan_rt_config = {
        routes: {
          add_rekod_kewangan_rt_url: "{{ route('rt-sm7.post_rekod_kewangan_rt') }}",
        }
    };

	$(document).on('submit', '#form_arkr', function(event){    
        event.preventDefault();
        $('#btn_send').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
        $('#btn_send').prop('disabled', true);
        var data = $("#form_arkr").serialize();
        var action = $('#post_rekod_kewangan_rt').val();
        var btn_text;
        if (action == 'add') {
            url = add_rekod_kewangan_rt_config.routes.add_rekod_kewangan_rt_url;
            type = "POST";
            btn_text = 'Hantar Maklumat Kewangan &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
        } 
		$.ajax({
            url: url,
            type: type,
            data: data,
        }).done(function(response) {        
        $('[name=arkr_kewangan_jenis_kewangan]').removeClass("is-invalid");
        $('[name=arkr_kewangan_nama_penuh]').removeClass("is-invalid");
        $('[name=arkr_kewangan_alamat]').removeClass("is-invalid");
        $('[name=arkr_kewangan_butiran]').removeClass("is-invalid");
        $('[name=arkr_kewangan_tarikh_t_b]').removeClass("is-invalid");
        $('[name=arkr_kewangan_cek_baucer]').removeClass("is-invalid");
        $('[name=arkr_kewangan_tarikh_cek]').removeClass("is-invalid");
        $('[name=arkr_kewangan_jumlah_tunai]').removeClass("is-invalid");
        $('[name=arkr_kewangan_jumlah_bank]').removeClass("is-invalid");
			
		if(response.errors){
            $.each(response.errors, function(index, error){
                if(index == 'arkr_kewangan_jenis_kewangan') {
                    $('[name=arkr_kewangan_jenis_kewangan]').addClass("is-invalid");
                    $('.error_arkr_kewangan_jenis_kewangan').html(error);
                }

                if(index == 'arkr_kewangan_nama_penuh') {
                    $('[name=arkr_kewangan_nama_penuh]').addClass("is-invalid");
                    $('.error_arkr_kewangan_nama_penuh').html(error);
                }

                if(index == 'arkr_kewangan_alamat') {
                    $('[name=arkr_kewangan_alamat]').addClass("is-invalid");
                    $('.error_arkr_kewangan_alamat').html(error);
                }

                if(index == 'arkr_kewangan_butiran') {
                  $('[name=arkr_kewangan_butiran]').addClass("is-invalid");
                  $('.error_arkr_kewangan_butiran').html(error);
                }

                if(index == 'arkr_kewangan_tarikh_t_b') {
                  $('[name=arkr_kewangan_tarikh_t_b]').addClass("is-invalid");
                  $('.error_arkr_kewangan_tarikh_t_b').html(error);
                }

                if(index == 'arkr_kewangan_cek_baucer') {
                  $('[name=arkr_kewangan_cek_baucer]').addClass("is-invalid");
                  $('.error_arkr_kewangan_cek_baucer').html(error);
                }
                
                if(index == 'arkr_kewangan_tarikh_cek') {
                  $('[name=arkr_kewangan_tarikh_cek]').addClass("is-invalid");
                  $('.error_arkr_kewangan_tarikh_cek').html(error);
                }

                if(index == 'arkr_kewangan_jumlah_tunai') {
                  $('[name=arkr_kewangan_jumlah_tunai]').addClass("is-invalid");
                  $('.error_arkr_kewangan_jumlah_tunai').html(error);
                }

                if(index == 'arkr_kewangan_jumlah_bank') {
                  $('[name=arkr_kewangan_jumlah_bank]').addClass("is-invalid");
                  $('.error_arkr_kewangan_jumlah_bank').html(error);
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