@include('js.modal.j-modal-add-gambar-ajk-krt')
@include('js.modal.j-modal-pilih-ajk-krt')
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
            $('#bpe_nama_krt').html("{{$krt_profile->nama_krt}}");
            $('#bpe_alamat_krt').html("{{$krt_profile->alamat_krt}}");
            $('#bpe_negeri_krt').html("{{$krt_profile->negeri_krt}}");
            $('#bpe_daerah_krt').html("{{$krt_profile->daerah_krt}}");
            $('#bpe_parlimen_krt').html("{{$krt_profile->parlimen_krt}}");
            $('#bpe_dun_krt').html("{{$krt_profile->dun_krt}}");
            $('#bpe_pbt_krt').html("{{$krt_profile->pbt_krt}}");
			
			var ic = $('#bpe_ajk_ic').val().substr(0,2);
			if(ic !== "")
			{
				var dob_tahun="";
				if(ic >= 30)
				{
					dob_tahun="19" + $('#bpe_ajk_ic').val().substr(0,2);
				}else
				{
					dob_tahun="20" + $('#bpe_ajk_ic').val().substr(0,2);
				}
				var dob_bulan=$('#bpe_ajk_ic').val().substr(2,2);
				var dob_hari=$('#bpe_ajk_ic').val().substr(4,2);
				var tempDate = new Date();
				var today_tahun = tempDate.getFullYear();
				var today_bulan = (tempDate.getMonth()+1);
				var today_hari = tempDate.getDate();
				var today_bulan_str = ("00" + today_bulan).slice(-2);
				var today_hari_str = ("00" + today_hari).slice(-2);
				var today = today_tahun.toString() + today_bulan_str + today_hari_str;
				$('#bpe_ajk_tarikh_lahir').val(dob_hari+"/"+dob_bulan+"/"+dob_tahun);
				$('#bpe_ajk_k_umur').val(today_tahun-dob_tahun);
			}else
			{
				$('#bpe_ajk_tarikh_lahir').val(null);
				$('#bpe_ajk_k_umur').val(null);
			}

		/* Maklumat Pemohonan Ahli KRT */
            $('#bpe_ajk_alamat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

            $('#bpe_ajk_alamat').on("paste",function(e) {
                e.preventDefault();
            });

            $('#bpe_ajk_berkepentingan_keterangan').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

            $('#bpe_ajk_berkepentingan_keterangan').on("paste",function(e) {
                e.preventDefault();
            });

            $('#bpe_ajk_ic').mask('999999999999');
			
			$.fn.checktkhlantik = function() {
				t_mula = $('#bpe_ajk_tarikh_mula').val();
				t_tamat = $('#bpe_ajk_tarikh_akhir').val();
				if(t_mula !== '')
				{
					txt_penggal=$("#bpe_ajk_penggal option:selected").text();
					arr_penggal=txt_penggal.split("/");
					def_mula=arr_penggal[0] + '0101';
					def_akhir=arr_penggal[1] + '1231';
					tkh_ok=0;
					if(t_mula < def_mula)
					{
						tkh_ok=1;
					}
					if(tkh_ok == 0 && t_tamat > def_akhir)
					{
						tkh_ok =1;
					}
					if(tkh_ok == 1)
					{
						alert('M' + t_mula + 'T' + t_tamat + 'MM' + def_mula + 'TT' + def_akhir);
					}
				}
			};
			
			$.fn.checkajk = function() {
				$('#wujud_status').val(0);
				value = $('#bpe_ajk_ic').val();
				$("#ajk_list").find("tr:gt(0)").remove();
				if(value !== '' && value !== null && value !== undefined && value.length > 11)
				{
					url = "{{ route('rt-sm4.check_ajk') }}";
					ada = 0;
					$.ajax({
						url: url,
						type: "GET",
						data: {type: 'check_ajk', noic: value},
						success: function (data) {
								$("#ajk_list td").parent().remove();
								$.each(data,function(key, obj) 
								{
									ada = 1;
									$('#wujud_status').val(1);
									$("#ajk_list").append('<tr><td>'+obj.penggal_mula+'/'+obj.penggal_tamat+'</td><td>'+obj.krt_nama+'</td><td>'+obj.ajk_nama+'</td><td>'+obj.ajk_alamat+'</td><td align="center"><img src="'+ "{{ asset('storage/ajk_krt') }}"+"/"+ obj.file_avatar +'" width="50px"></td><td align="center"><input type="radio" name="pilihan1" value="'+obj.id+'"></td></tr>');
								});
								if(ada == 1)
								{
									senarai_penggal_ajk();
								}else
								{
									$('#bpe_ajk_gambar').attr('src', "{{ asset('storage/ajk_krt') }}"+"/"+ "{{$krt_ajk->file_avatar}}");
									$('#bpe_ajk_nama').val(null);
									$('#bpe_ajk_jantina').val(null);
									$('#bpe_ajk_warganegara').val(null);
									var ic = $('#bpe_ajk_ic').val().substr(0,2);
									if(ic !== "")
									{
										var dob_tahun="";
										if(ic >= 30)
										{
											dob_tahun="19" + $('#bpe_ajk_ic').val().substr(0,2);
										}else
										{
											dob_tahun="20" + $('#bpe_ajk_ic').val().substr(0,2);
										}
										var dob_bulan=$('#bpe_ajk_ic').val().substr(2,2);
										var dob_hari=$('#bpe_ajk_ic').val().substr(4,2);
										//alert(dob_hari+"/"+dob_bulan+"/"+dob_tahun);
										var tempDate = new Date();
										var today_tahun = tempDate.getFullYear();
										var today_bulan = (tempDate.getMonth()+1);
										var today_hari = tempDate.getDate();
										var today_bulan_str = ("00" + today_bulan).slice(-2);
										var today_hari_str = ("00" + today_hari).slice(-2);
										var today = today_tahun.toString() + today_bulan_str + today_hari_str;
										$('#bpe_ajk_tarikh_lahir').val(dob_hari+"/"+dob_bulan+"/"+dob_tahun);
										$('#bpe_ajk_k_umur').val(today_tahun-dob_tahun);
									}else
									{
										$('#bpe_ajk_tarikh_lahir').val(null);
										$('#bpe_ajk_k_umur').val(null);
									}
									$('#bpe_ajk_agama').val(null);
									//$('#bpe_ajk_k_umur').val(today_tahun-dob_tahun);
									$('#bpe_ajk_kaum').val(null);
									$('#bpe_ajk_phone').val(null);
									$('#bpe_ajk_alamat').val(null);
									$('#bpe_ajk_poskod').val(null);
									$('#bpe_ajk_pendidikan_id').val(null);
									$('#bpe_ajk_profession_id').val(null);
									$('#bpe_ajk_jawatan_krt_id').val(null);
									$('#bpe_ajk_tarikh_mula').val(null);
									$('#bpe_ajk_tarikh_akhir').val(null);
									$("input[name=bpe_ajk_bekepentingan]").prop('checked', false);
									$("[name=bpe_ajk_bekepentingan_interaksi_1]").prop('checked', false);
									$("[name=bpe_ajk_bekepentingan_interaksi_2]").prop('checked', false);
									$("[name=bpe_ajk_bekepentingan_interaksi_3]").prop('checked', false);
									$("[name=bpe_ajk_bekepentingan_interaksi_4]").prop('checked', false);
									$("[name=bpe_ajk_bekepentingan_interaksi_5]").prop('checked', false);
									$("[name=bpe_ajk_bekepentingan_interaksi_1]").attr("disabled", true);
									$("[name=bpe_ajk_bekepentingan_interaksi_2]").attr("disabled", true);
									$("[name=bpe_ajk_bekepentingan_interaksi_3]").attr("disabled", true);
									$("[name=bpe_ajk_bekepentingan_interaksi_4]").attr("disabled", true);
									$("[name=bpe_ajk_bekepentingan_interaksi_5]").attr("disabled", true);
									$('#bpe_ajk_berkepentingan_keterangan').val(null);
									$("[name=bpe_ajk_berkepentingan_keterangan]").attr("disabled", "disabled");
								}
							},
							error:function(x,e) {
									if (x.status==0) {
										alert('You are offline!!\n Please Check Your Network.');
									} else if(x.status==404) {
										alert('Requested URL not found.');
									} else if(x.status==500) {
										alert('Internel Server Error.'+x.responseText);
									} else if(e=='parsererror') {
										alert('Error.\nParsing JSON Request failed.');
									} else if(e=='timeout'){
										alert('Request Time out.');
									} else {
										alert('Unknow Error.\n'+x.responseText);
									}
							}
					});
				}else
				{
									$('#bpe_ajk_gambar').attr('src', "{{ asset('storage/ajk_krt') }}"+"/"+ "{{$krt_ajk->file_avatar}}");
									$('#bpe_ajk_nama').val(null);
									$('#bpe_ajk_jantina').val(null);
									$('#bpe_ajk_warganegara').val(null);
									$('#bpe_ajk_tarikh_lahir').val(null);
									$('#bpe_ajk_k_umur').val(null);
									$('#bpe_ajk_agama').val(null);
									$('#bpe_ajk_kaum').val(null);
									$('#bpe_ajk_phone').val(null);
									$('#bpe_ajk_alamat').val(null);
									$('#bpe_ajk_poskod').val(null);
									$('#bpe_ajk_pendidikan_id').val(null);
									$('#bpe_ajk_profession_id').val(null);
									$('#bpe_ajk_jawatan_krt_id').val(null);
									$('#bpe_ajk_tarikh_mula').val(null);
									$('#bpe_ajk_tarikh_akhir').val(null);
									$("input[name=bpe_ajk_bekepentingan]").prop('checked', false);
									$("[name=bpe_ajk_bekepentingan_interaksi_1]").prop('checked', false);
									$("[name=bpe_ajk_bekepentingan_interaksi_2]").prop('checked', false);
									$("[name=bpe_ajk_bekepentingan_interaksi_3]").prop('checked', false);
									$("[name=bpe_ajk_bekepentingan_interaksi_4]").prop('checked', false);
									$("[name=bpe_ajk_bekepentingan_interaksi_5]").prop('checked', false);
									$("[name=bpe_ajk_bekepentingan_interaksi_1]").attr("disabled", true);
									$("[name=bpe_ajk_bekepentingan_interaksi_2]").attr("disabled", true);
									$("[name=bpe_ajk_bekepentingan_interaksi_3]").attr("disabled", true);
									$("[name=bpe_ajk_bekepentingan_interaksi_4]").attr("disabled", true);
									$("[name=bpe_ajk_bekepentingan_interaksi_5]").attr("disabled", true);
									$('#bpe_ajk_berkepentingan_keterangan').val(null);
									$("[name=bpe_ajk_berkepentingan_keterangan]").attr("disabled", "disabled");
				}
			};
			
			$("#form_bpe").bind("keypress", function (e) {
				if (e.keyCode == 13) {
					var b = $('#bpe_ajk_ic').val();
					$.fn.checkajk();
					return false;
				}
			});
			
			$('#bpe_ajk_ic').keydown(function(e){
				if(e.keyCode === 9)
				{
					$('#dahchange').val($(this).val());
					$.fn.checkajk();
					$('#bpe_ajk_nama').focus();
				}
			});
			
			$('#bpe_ajk_ic').focusout(function(){
				$('#dahchange').val($(this).val());
				$.fn.checkajk();
				$('#bpe_ajk_nama').focus();
			});
			
			$('#bpe_ajk_ic').keyup(function(e){
				var a = $('#dahchange').val();
				var b = $(this).val();
				a = a.replace(/_/g, "");
				b = b.replace(/_/g, "");
				if(e.keyCode === 46 || e.keyCode === 8) //delete and backspace
				{
					$('#dahchange').val(b);				
				}else
				{
					if(e.keyCode >= 48 && e.keyCode <=57)
					{
						//a = a.concat(b);
						$('#dahchange').val(b);	
					}else
					{
						if(e.keyCode == 13)
						{
							//b = b.replace(/(\r\n|\n|\r)/gm, "");
							if(b!== "")
							{
								b=a;
								$.fn.checkajk();
								$('#bpe_ajk_nama').focus();
							}
							//$('#dahchange').val();
						}
					}
				}
				$('#bpe_ajk_ic').val(b.toString());
			});
			
			$('#bpe_ajk_ic').click(function(e, enterKeyPressed){
				var a=$(this).val();
				a = a.replace(/_/g, "");
				if(enterKeyPressed)
				{
					alert("Enter key");
				}
			});
			
			$('#bpe_ajk_ic').change(function() {
				var a=$('#dahchange').val();
				if(a !== $(this).val())
				{
					$('#dahchange').val($(this).val());
					$.fn.checkajk();
					$('#bpe_ajk_nama').focus();
				}
			});
			
			$('#modal_tutup').click(function(){
				var ic = $('#bpe_ajk_ic').val().substr(0,2);
									if(ic !== "")
									{
										var dob_tahun="";
										if(ic >= 30)
										{
											dob_tahun="19" + $('#bpe_ajk_ic').val().substr(0,2);
										}else
										{
											dob_tahun="20" + $('#bpe_ajk_ic').val().substr(0,2);
										}
										var dob_bulan=$('#bpe_ajk_ic').val().substr(2,2);
										var dob_hari=$('#bpe_ajk_ic').val().substr(4,2);
										//alert(dob_hari+"/"+dob_bulan+"/"+dob_tahun);
										var tempDate = new Date();
										var today_tahun = tempDate.getFullYear();
										var today_bulan = (tempDate.getMonth()+1);
										var today_hari = tempDate.getDate();
										var today_bulan_str = ("00" + today_bulan).slice(-2);
										var today_hari_str = ("00" + today_hari).slice(-2);
										var today = today_tahun.toString() + today_bulan_str + today_hari_str;
										$('#bpe_ajk_tarikh_lahir').val(dob_hari+"/"+dob_bulan+"/"+dob_tahun);
										$('#bpe_ajk_k_umur').val(today_tahun-dob_tahun);
									}else
									{
										$('#bpe_ajk_tarikh_lahir').val(null);
										$('#bpe_ajk_k_umur').val(null);
									}
			});
			
			$('#bpe_ajk_gambar').on('load', function () {
  				var imgsrc=$('#bpe_ajk_gambar').attr('src');
				var tarr = imgsrc.split('/');      // ["static","images","banner","blue.jpg"]
				var file = tarr[tarr.length-1]; 
				$('#imgfilename').val(file);
			});
			/*$('#bpe_ajk_tarikh_mula').datepicker({
				onSelect: function(dateText, inst) {
        					var date = $(this).val();
        					alert('on select triggered'+date);
    					}
					url = "{{ route('rt-sm4.check_ajk') }}";
					value = $('#bpe_ajk_ic').val();
					p_value = $('#bpe_ajk_penggal').val();
					alert(p_value);
					if(p_value == '')
					{
						alert("penggal kena pilih dahulu");
					}*/
				/*ada = 0;
				$.ajax({
					url: url,
					type: "GET",
					data: {type: 'check_ajk', noic: value, penggal:p_value},
					success: function (data) {
						$.each(data,function(key, obj) 
						{
							ada = 1;
							tkh_mula = obj.ajk_tarikh_mula.replace(/\-/g,'');
							tkh_akhir = obj.ajk_tarikh_akhir.replace(/\-/g,'');
							if(obj.ajk_status = 1)
							{
								alert("ajk telah wujud status aktif mula "+tkh_mula+" akhir "+tkh_akhir);
								
							}else
							{
								alert("ajk telah wujud status tidak aktif mula "+tkh_mula+" akhir "+tkh_akhir);
							}
						});
					},
					error: function (data) {
						alert('error');
					}
				});*/
			//});

            $('[name=bpe_ajk_bekepentingan]').click(function(){
                if($('[name=bpe_ajk_bekepentingan]').is(":checked")) {
                    $("[name=bpe_ajk_bekepentingan_interaksi_1]").removeAttr("disabled");
                    $("[name=bpe_ajk_bekepentingan_interaksi_2]").removeAttr("disabled");
                    $("[name=bpe_ajk_bekepentingan_interaksi_3]").removeAttr("disabled");
                    $("[name=bpe_ajk_bekepentingan_interaksi_4]").removeAttr("disabled");
                    $("[name=bpe_ajk_bekepentingan_interaksi_5]").removeAttr("disabled");
                    $("[name=bpe_ajk_berkepentingan_keterangan]").removeAttr("disabled");
                }
                else {
                    $("[name=bpe_ajk_bekepentingan_interaksi_1]").attr("disabled", "disabled");
                    $("[name=bpe_ajk_bekepentingan_interaksi_2]").attr("disabled", "disabled");
                    $("[name=bpe_ajk_bekepentingan_interaksi_3]").attr("disabled", "disabled");
                    $("[name=bpe_ajk_bekepentingan_interaksi_4]").attr("disabled", "disabled");
                    $("[name=bpe_ajk_bekepentingan_interaksi_5]").attr("disabled", "disabled");
                    $("[name=bpe_ajk_berkepentingan_keterangan]").attr("disabled", "disabled");
                }
            });
            $('#bpe_ajk_id').val("{{$krt_ajk->id}}");
			$('#bpe_ajk_penggal').val("{{$krt_ajk->ajk_penggal}}");
            $('#bpe_ajk_status_form').val("{{$krt_ajk->ajk_status_form}}");
            $('#bpe_ajk_gambar').attr('src', "{{ asset('storage/ajk_krt') }}"+"/"+ "{{$krt_ajk->file_avatar}}");
            $('#bpe_ajk_nama').val("{{$krt_ajk->ajk_nama}}");
            $('#bpe_ajk_tarikh_lahir').val("{{$krt_ajk->ajk_tarikh_lahir}}");
            $('#bpe_ajk_k_umur').val("{{$krt_ajk->ajk_kelompok_umur}}");
            $('#bpe_ajk_kaum').val("{{$krt_ajk->ajk_kaum}}");
            $('#bpe_ajk_jantina').val("{{$krt_ajk->ajk_jantina}}");
            $('#bpe_ajk_warganegara').val("{{$krt_ajk->ajk_warganegara}}");
            $('#bpe_ajk_agama').val("{{$krt_ajk->ajk_agama}}");
            $('#bpe_ajk_phone').val("{{$krt_ajk->ajk_phone}}");
            $('#bpe_ajk_ic').val("{{$krt_ajk->ajk_ic}}");
            $('#bpe_ajk_alamat').val("{{$krt_ajk->ajk_alamat}}");
            $('#bpe_ajk_poskod').val("{{$krt_ajk->ajk_poskod}}");
            $('#bpe_ajk_pendidikan_id').val("{{$krt_ajk->ajk_pendidikan_id}}");
            $('#bpe_ajk_profession_id').val("{{$krt_ajk->ajk_profession_id}}");
            $('#bpe_ajk_jawatan_krt_id').val("{{$krt_ajk->ajk_jawatan_krt_id}}");
            $('#bpe_ajk_tarikh_mula').val("{{$krt_ajk->ajk_tarikh_mula}}");
            $('#bpe_ajk_tarikh_akhir').val("{{$krt_ajk->ajk_tarikh_akhir}}");
            $('#mag_krt_ajk_krt_id').val("{{$krt_ajk->id}}");
            var ajk_bekepentingan = "{{$krt_ajk->ajk_bekepentingan}}";
            var ajk_bekepentingan_interaksi_1 = "{{$krt_ajk->ajk_bekepentingan_interaksi_1}}";
            var ajk_bekepentingan_interaksi_2 = "{{$krt_ajk->ajk_bekepentingan_interaksi_2}}";
            var ajk_bekepentingan_interaksi_3 = "{{$krt_ajk->ajk_bekepentingan_interaksi_3}}";
            var ajk_bekepentingan_interaksi_4 = "{{$krt_ajk->ajk_bekepentingan_interaksi_4}}";
            var ajk_bekepentingan_interaksi_5 = "{{$krt_ajk->ajk_bekepentingan_interaksi_5}}";
            if (ajk_bekepentingan == "1") {
                $("input[name=bpe_ajk_bekepentingan]").prop('checked', true);
                $("[name=bpe_ajk_bekepentingan_interaksi_1]").removeAttr("disabled");
                $("[name=bpe_ajk_bekepentingan_interaksi_2]").removeAttr("disabled");
                $("[name=bpe_ajk_bekepentingan_interaksi_3]").removeAttr("disabled");
                $("[name=bpe_ajk_bekepentingan_interaksi_4]").removeAttr("disabled");
                $("[name=bpe_ajk_bekepentingan_interaksi_5]").removeAttr("disabled");
                $("[name=bpe_ajk_berkepentingan_keterangan]").removeAttr("disabled");
            }
            if (ajk_bekepentingan_interaksi_1 == "1") {
                $("input[name=bpe_ajk_bekepentingan_interaksi_1]").prop('checked', true);
            }
            if (ajk_bekepentingan_interaksi_2 == "1") {
                $("input[name=bpe_ajk_bekepentingan_interaksi_2]").prop('checked', true);
            }
            if (ajk_bekepentingan_interaksi_3 == "1") {
                $("input[name=bpe_ajk_bekepentingan_interaksi_3]").prop('checked', true);
            }
            if (ajk_bekepentingan_interaksi_4 == "1") {
                $("input[name=bpe_ajk_bekepentingan_interaksi_4]").prop('checked', true);
            }
            if (ajk_bekepentingan_interaksi_5 == "1") {
                $("input[name=bpe_ajk_bekepentingan_interaksi_5]").prop('checked', true);
            }
            $('#bpe_ajk_berkepentingan_keterangan').val("{{$krt_ajk->ajk_berkepentingan_keterangan}}");

        /* Maklumat Note Kemaskini */
            $('#bpe_status').val("{{$krt_ajk->ajk_status_form}}");
            
            if($('#bpe_status').val() == '6'){
                $("#bpe_perlu_kemaskini").show();
                $('#bpe_status_description').html("{{$krt_ajk->status_description}}");
                $('#bpe_disahkan_note').html("{{$krt_ajk->disahkan_note}}");
            }


        /* Button */
            $('#btn_back').click(function(){
				$("#bpe_ajk_status_form").val(3);
				var b=$("#bpe_ajk_alamat").val();
				b = b.replace(/(\r\n|\n|\r)/gm, " ");
				$("#bpe_ajk_alamat").val(b);
				var penggal = $('#bpe_ajk_penggal option:selected').text();
				$('[name=bpe_ajk_penggal]').removeClass("is-invalid");
				if(penggal === '' || penggal === undefined || penggal === null || penggal === '-- Sila Pilih --')
				{
					$('[name=bpe_ajk_penggal]').addClass("is-invalid");
					$('.error_bpe_ajk_penggal').html("Sila pilih penggal perlantikan");
				}else
				{
					var tkh_lahir_data = $('#bpe_ajk_tarikh_lahir').val();
					var tkh_lahir_arr = tkh_lahir_data.split("/");
					var tkh_lahir = tkh_lahir_arr[2]+tkh_lahir_arr[1].padStart(2, '0')+tkh_lahir_arr[0].padStart(2, '0');
					var d = new Date();
					var tkh_skrg = d.getFullYear().toString() + (d.getMonth()+1).toString().padStart(2, '0') + d.getDate().toString().padStart(2, '0');
					$('[name=bpe_ajk_tarikh_lahir]').removeClass("is-invalid");
					if(tkh_lahir> tkh_skrg)
					{
						$('[name=bpe_ajk_tarikh_lahir]').addClass("is-invalid");
						swal("Ralat!", "Tarikh lahir tidak sah", "success");
					}else
					{
						var tkh_mula_data = $('#bpe_ajk_tarikh_mula').val();
						var tkh_mula_arr = tkh_mula_data.split("/");
						var tkh_mula =  tkh_mula_arr[2]+tkh_mula_arr[1].padStart(2, '0')+tkh_mula_arr[0].padStart(2, '0');
						var tkh_akhir_data = $('#bpe_ajk_tarikh_akhir').val();
						var tkh_akhir_arr = tkh_akhir_data.split("/");
						var tkh_akhir =  tkh_akhir_arr[2]+tkh_akhir_arr[1].padStart(2, '0')+tkh_akhir_arr[0].padStart(2, '0');
						var penggal_data = penggal.split("/");
						var penggal_mula = penggal_data[0]+"01"+"01";
						var penggal_akhir = penggal_data[1]+"12"+"31";
						$('[name=bpe_ajk_tarikh_mula]').removeClass("is-invalid");
						$('[name=bpe_ajk_tarikh_akhir]').removeClass("is-invalid");
						if(tkh_mula > tkh_akhir)
						{
							$('[name=bpe_ajk_tarikh_mula]').addClass("is-invalid");
							$('[name=bpe_ajk_tarikh_akhir]').addClass("is-invalid");
							swal("Ralat!", "Tarikh mula lantikan tidak boleh melebihi tarikh akhir lantikan", "success");
						}else
						{
							if(tkh_mula < penggal_mula || tkh_akhir > penggal_akhir)
							{
								swal("Ralat!", "Tarikh lantikan tidak selari dengan penggal", "success");
							}else
							{
								$('#btn_back').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
								$('#btn_back').prop('disabled', true);
								var data = $("#form_bpe").serialize();
								var action = $('#post_pendaftaran_ahli_krt').val();
								var btn_text;
								if (action == 'edit') {
									url = daftar_ahli_krt_config.routes.daftar_ahli_krt_url;
									type = "POST";
									btn_text = 'Simpan & Kembali&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
								} 
								$.ajax({
									url: url,
									type: type,
									data: data,
								}).done(function(response) {        
									$('[name=bpe_ajk_nama]').removeClass("is-invalid");
									$('[name=bpe_ajk_ic]').removeClass("is-invalid");
									$('[name=bpe_ajk_tarikh_lahir]').removeClass("is-invalid");
									$('[name=bpe_ajk_jantina]').removeClass("is-invalid");
									$('[name=bpe_ajk_k_umur]').removeClass("is-invalid");
									$('[name=bpe_ajk_kaum]').removeClass("is-invalid");
									$('[name=bpe_ajk_warganegara]').removeClass("is-invalid");
									$('[name=bpe_ajk_agama]').removeClass("is-invalid");
									$('[name=bpe_ajk_phone]').removeClass("is-invalid");
									$('[name=bpe_ajk_alamat]').removeClass("is-invalid");
									$('[name=bpe_ajk_poskod]').removeClass("is-invalid");
									$('[name=bpe_ajk_profession_id]').removeClass("is-invalid");
									$('[name=bpe_ajk_pendidikan_id]').removeClass("is-invalid");
									$('[name=bpe_ajk_jawatan_krt_id]').removeClass("is-invalid");
									$('[name=bpe_ajk_tarikh_mula]').removeClass("is-invalid");
									$('[name=bpe_ajk_tarikh_akhir]').removeClass("is-invalid");
									$('[name=bpe_ajk_bekepentingan]').removeClass("is-invalid");
									$('[name=bpe_ajk_bekepentingan_interaksi_1]').removeClass("is-invalid");
									$('[name=bpe_ajk_bekepentingan_interaksi_2]').removeClass("is-invalid");
									$('[name=bpe_ajk_bekepentingan_interaksi_3]').removeClass("is-invalid");
									$('[name=bpe_ajk_bekepentingan_interaksi_4]').removeClass("is-invalid");
									$('[name=bpe_ajk_bekepentingan_interaksi_5]').removeClass("is-invalid");
									$('[name=bpe_ajk_berkepentingan_keterangan]').removeClass("is-invalid");
					
									if(response.errors)
									{
										if(response.errors === 1)
										{
											$('#btn_back').html(btn_text);                
											$('#btn_back').prop('disabled', false);
											swal("Ralat!", "No IC telah wujud untuk penggal ini yang telah disahkan dan tidak dibenarkan untuk dikemaskini", "success");
										}else
										{
											if(response.errors === 2)
											{
												$('#btn_back').html(btn_text);                
												$('#btn_back').prop('disabled', false);
												swal("Ralat!", "No IC telah wujud yang aktif dan tidak dibenarkan untuk dikemaskini. Sila tukar status dahulu.", "success");
											}else
											{
												$.each(response.errors, function(index, error){
													if(index == 'bpe_ajk_nama') {
														$('[name=bpe_ajk_nama]').addClass("is-invalid");
														$('.error_bpe_ajk_nama').html(error);
													}
							
													if(index == 'bpe_ajk_ic') {
														$('[name=bpe_ajk_ic]').addClass("is-invalid");
														$('.error_bpe_ajk_ic').html(error);
													}
							
													if(index == 'bpe_ajk_tarikh_lahir') {
														$('[name=bpe_ajk_tarikh_lahir]').addClass("is-invalid");
														$('.error_bpe_ajk_tarikh_lahir').html(error);
													}
							
													if(index == 'bpe_ajk_jantina') {
														$('[name=bpe_ajk_jantina]').addClass("is-invalid");
														$('.error_bpe_ajk_jantina').html(error);
													}
							
													if(index == 'bpe_ajk_k_kaum') {
														$('[name=bpe_ajk_k_kaum]').addClass("is-invalid");
														$('.error_bpe_ajk_k_kaum').html(error);
													}
							
													if(index == 'bpe_ajk_kaum') {
														$('[name=bpe_ajk_kaum]').addClass("is-invalid");
														$('.error_bpe_ajk_kaum').html(error);
													}
							
													if(index == 'bpe_ajk_warganegara') {
														$('[name=bpe_ajk_warganegara]').addClass("is-invalid");
														$('.error_bpe_ajk_warganegara').html(error);
													}
							
													if(index == 'bpe_ajk_k_umur') {
														$('[name=bpe_ajk_k_umur]').addClass("is-invalid");
														$('.error_bpe_ajk_k_umur').html(error);
													}
													
													if(index == 'bpe_ajk_agama') {
														$('[name=bpe_ajk_agama]').addClass("is-invalid");
														$('.error_bpe_ajk_agama').html(error);
													}
							
													if(index == 'bpe_ajk_phone') {
														$('[name=bpe_ajk_phone]').addClass("is-invalid");
														$('.error_bpe_ajk_phone').html(error);
													}
							
													if(index == 'bpe_ajk_alamat') {
														$('[name=bpe_ajk_alamat]').addClass("is-invalid");
														$('.error_bpe_ajk_alamat').html(error);
													}
							
													if(index == 'bpe_ajk_poskod') {
														$('[name=bpe_ajk_poskod]').addClass("is-invalid");
														$('.error_bpe_ajk_poskod').html(error);
													}
							
													if(index == 'bpe_ajk_profession_id') {
														$('[name=bpe_ajk_profession_id]').addClass("is-invalid");
														$('.error_bpe_ajk_profession_id').html(error);
													}
							
													if(index == 'bpe_ajk_pendidikan_id') {
														$('[name=bpe_ajk_pendidikan_id]').addClass("is-invalid");
														$('.error_bpe_ajk_pendidikan_id').html(error);
													}
							
													if(index == 'bpe_ajk_jawatan_krt_id') {
														$('[name=bpe_ajk_jawatan_krt_id]').addClass("is-invalid");
														$('.error_bpe_ajk_jawatan_krt_id').html(error);
													}
							
													if(index == 'bpe_ajk_tarikh_mula') {
														$('[name=bpe_ajk_tarikh_mula]').addClass("is-invalid");
														$('.error_bpe_ajk_tarikh_mula').html(error);
													}
							
													if(index == 'bpe_ajk_tarikh_akhir') {
														$('[name=bpe_ajk_tarikh_akhir]').addClass("is-invalid");
														$('.error_bpe_ajk_tarikh_akhir').html(error);
													}
							
													if(index == 'bpe_ajk_berkepentingan_keterangan') {
														$('[name=bpe_ajk_berkepentingan_keterangan]').addClass("is-invalid");
														$('.error_bpe_ajk_berkepentingan_keterangan').html(error);
													}
							
												});
												$('#btn_back').html(btn_text);                
												$('#btn_back').prop('disabled', false);  
											}//end else response.status=2 
										}        
									} else 
									{
										$('#btn_back').html(btn_text);
										$('#btn_back').prop('disabled', false); 
										window.location.href = "{{route('rt-sm4.pendaftaran_ahli_krt_utama')}}";
									}
								});
							}//end else tkh_mula
						}//end else tkh_mula<penggal_mula
					} //end else tkh_lahir
				}
                //window.location.href = '{{route('rt-sm4.pendaftaran_ahli_krt_utama')}}';
            });

	});

    /* click add gambar ajk */
		$(document).on('submit', '#form_mag', function(event){
			var info = $('.error_form_mag');
			event.preventDefault();

			var form_data = new FormData();
			form_data.append("mag_file_avatar",  $("#mag_file_avatar")[0].files[0]);
			form_data.append("mag_krt_ajk_krt_id", $("#mag_krt_ajk_krt_id").val() );
			form_data.append("post_add_gambar", "edit" );
			console.log(form_data);

			$('#btn_add').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_add').prop('disabled', true);

			btn_text = 'Tambah&nbsp;&nbsp;<i class="dropdown-icon fa fa-edit"></i>';
			url = "{{ route('rt-sm4.post_add_gambar') }}";
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
					$('#btn_add').html(btn_text);                
					$('#btn_add').prop('disabled', false);
					info.slideDown();
				} else {
                    window.location.href = "{{route('rt-sm4.borang_pendaftaran_eIDRT','')}}"+"/"+"{{$krt_ajk->id}}";
                    $('#modal_add_gambar').modal('hide');
					
                    
					$('#form_mag').trigger("reset");
					$('#btn_add').html(btn_text);
					$('#btn_add').prop('disabled', false);
					
				}
			});
		});
		
		$(document).on('submit', '#form_pilih', function(event){
			//var info = $('.error_form_mag');
			var adapilih=0;
			event.preventDefault();
			var value = $('input[name=pilihan1]:checked', '#form_pilih').val();
			if(value != undefined)
			{
				url = "{{ route('rt-sm4.check_ajk') }}";
				$.ajax({
					url: url,
					type: 'GET',
					data: {type: 'get_ajk', noic: value},
					//contentType: 'application/json',
					//beforeSend: function(xhr){xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")},
					success: function(data) {
						$.each(data,function(key, obj) 
						{
							$('#wujud_status').val(1);
							tkh_mula = obj.ajk_tarikh_mula.replace(/\-/g,'');
							tkh_akhir = obj.ajk_tarikh_akhir.replace(/\-/g,'');
							$('#bpe_ajk_gambar').attr('src', "{{ asset('storage/ajk_krt') }}"+"/"+ obj.file_avatar);
							$('#bpe_ajk_nama').val(obj.ajk_nama);
										$('#bpe_ajk_jantina').val(obj.ajk_jantina);
										$('#bpe_ajk_warganegara').val(obj.ajk_warganegara);
										var ic = $('#bpe_ajk_ic').val().substr(0,2);
										var dob_tahun="";
										if(ic >= 30)
										{
											dob_tahun="19" + $('#bpe_ajk_ic').val().substr(0,2);
										}else
										{
											dob_tahun="20" + $('#bpe_ajk_ic').val().substr(0,2);
										}
										var dob_bulan=$('#bpe_ajk_ic').val().substr(2,2);
										var dob_hari=$('#bpe_ajk_ic').val().substr(4,2);
										//alert(dob_hari+"/"+dob_bulan+"/"+dob_tahun);
										var tempDate = new Date();
										var today_tahun = tempDate.getFullYear();
										var today_bulan = (tempDate.getMonth()+1);
										var today_hari = tempDate.getDate();
										var today_bulan_str = ("00" + today_bulan).slice(-2);
										var today_hari_str = ("00" + today_hari).slice(-2);
										var today = today_tahun.toString() + today_bulan_str + today_hari_str;
										$('#bpe_ajk_tarikh_lahir').val(dob_hari+"/"+dob_bulan+"/"+dob_tahun);
										$('#bpe_ajk_agama').val(obj.ajk_agama);
										$('#bpe_ajk_k_umur').val(today_tahun-dob_tahun);
										$('#bpe_ajk_kaum').val(obj.ajk_kaum);
										$('#bpe_ajk_phone').val(obj.ajk_phone);
										$('#bpe_ajk_alamat').val(obj.ajk_alamat);
										$('#bpe_ajk_poskod').val(obj.ajk_poskod);
										$('#bpe_ajk_pendidikan_id').val(obj.ajk_pendidikan_id);
										$('#bpe_ajk_profession_id').val(obj.ajk_profession_id);
										$('#bpe_ajk_jawatan_krt_id').val(obj.ajk_jawatan_krt_id);
										tempDate = new Date(obj.ajk_tarikh_mula);
										formattedDate = [tempDate.getDate(), tempDate.getMonth() + 1, tempDate.getFullYear()].join('/');
										$('#bpe_ajk_tarikh_mula').val(formattedDate);
										tempDate = new Date(obj.ajk_tarikh_akhir);
										formattedDate = [tempDate.getDate(), tempDate.getMonth() + 1, tempDate.getFullYear()].join('/');
										$('#bpe_ajk_tarikh_akhir').val(formattedDate);
										if (obj.ajk_bekepentingan == "1") {
											$("input[name=bpe_ajk_bekepentingan]").prop('checked', true);
											$("[name=bpe_ajk_bekepentingan_interaksi_1]").removeAttr("disabled");
											$("[name=bpe_ajk_bekepentingan_interaksi_2]").removeAttr("disabled");
											$("[name=bpe_ajk_bekepentingan_interaksi_3]").removeAttr("disabled");
											$("[name=bpe_ajk_bekepentingan_interaksi_4]").removeAttr("disabled");
											$("[name=bpe_ajk_bekepentingan_interaksi_5]").removeAttr("disabled");
											$("[name=bpe_ajk_berkepentingan_keterangan]").removeAttr("disabled");
										}
										if (obj.ajk_bekepentingan_interaksi_1 == "1") {
											$("input[name=bpe_ajk_bekepentingan_interaksi_1]").prop('checked', true);
										}
										if (obj.ajk_bekepentingan_interaksi_2 == "1") {
											$("input[name=bpe_ajk_bekepentingan_interaksi_2]").prop('checked', true);
										}
										if (obj.ajk_bekepentingan_interaksi_3 == "1") {
											$("input[name=bpe_ajk_bekepentingan_interaksi_3]").prop('checked', true);
										}
										if (obj.ajk_bekepentingan_interaksi_4 == "1") {
											$("input[name=bpe_ajk_bekepentingan_interaksi_4]").prop('checked', true);
										}
										if (obj.ajk_bekepentingan_interaksi_5 == "1") {
											$("input[name=bpe_ajk_bekepentingan_interaksi_5]").prop('checked', true);
										}
										$('#bpe_ajk_berkepentingan_keterangan').val(obj.ajk_berkepentingan_keterangan);
						});
						$('.modal').each(function(){
							$(this).modal('hide');
						});
					}
				});/*
							error:function(x,e) {
									if (x.status==0) {
										alert('You are offline!!\n Please Check Your Network.');
									} else if(x.status==404) {
										alert('Requested URL not found.');
									} else if(x.status==500) {
										alert('Internel Server Error.'+x.responseText);
									} else if(e=='parsererror') {
										alert('Error.\nParsing JSON Request failed.');
									} else if(e=='timeout'){
										alert('Request Time out.');
									} else {
										alert('Unknow Error.\n'+x.responseText);
									}
							}
				 */
			}else
			{
				alert("Tiada rekod yang dipilih");
			}
		});

	/* Btn Tambah */

        //my custom script
        var daftar_ahli_krt_config = {
            routes: {
                daftar_ahli_krt_url: "{{ route('rt-sm4.post_pendaftaran_ahli_krt') }}",
            }
        };

        $(document).on('submit', '#form_bpe', function(event){    
            event.preventDefault();
			var be=$("#bpe_ajk_alamat").val();
			be = be.replace(/(\r\n|\n|\r)/gm, " ");
			$("bpe_ajk_alamat").val(be);
			var penggal = $('#bpe_ajk_penggal option:selected').text();
			$('[name=bpe_ajk_penggal]').removeClass("is-invalid");
			if(penggal === '' || penggal === undefined || penggal === null || penggal === '-- Sila Pilih --')
			{
				$('[name=bpe_ajk_penggal]').addClass("is-invalid");
				$('.error_bpe_ajk_penggal').html("Sila pilih penggal perlantikan");
			}else
			{
				var tkh_lahir_data = $('#bpe_ajk_tarikh_lahir').val();
				var tkh_lahir_arr = tkh_lahir_data.split("/");
				var tkh_lahir = tkh_lahir_arr[2]+tkh_lahir_arr[1].padStart(2, '0')+tkh_lahir_arr[0].padStart(2, '0');
				var d = new Date();
				var tkh_skrg = d.getFullYear().toString() + (d.getMonth()+1).toString().padStart(2, '0') + d.getDate().toString().padStart(2, '0');
				$('[name=bpe_ajk_tarikh_lahir]').removeClass("is-invalid");
				if(tkh_lahir> tkh_skrg)
				{
					$('[name=bpe_ajk_tarikh_lahir]').addClass("is-invalid");
					swal("Ralat!", "Tarikh lahir tidak sah", "success");
				}else
				{
					var tkh_mula_data = $('#bpe_ajk_tarikh_mula').val();
					var tkh_mula_arr = tkh_mula_data.split("/");
					var tkh_mula =  tkh_mula_arr[2]+tkh_mula_arr[1].padStart(2, '0')+tkh_mula_arr[0].padStart(2, '0');
					var tkh_akhir_data = $('#bpe_ajk_tarikh_akhir').val();
					var tkh_akhir_arr = tkh_akhir_data.split("/");
					var tkh_akhir =  tkh_akhir_arr[2]+tkh_akhir_arr[1].padStart(2, '0')+tkh_akhir_arr[0].padStart(2, '0');
					var penggal_data = penggal.split("/");
					var penggal_mula = penggal_data[0]+"01"+"01";
					var penggal_akhir = penggal_data[1]+"12"+"31";
					$('[name=bpe_ajk_tarikh_mula]').removeClass("is-invalid");
					$('[name=bpe_ajk_tarikh_akhir]').removeClass("is-invalid");
					if(tkh_mula > tkh_akhir)
					{
						$('[name=bpe_ajk_tarikh_mula]').addClass("is-invalid");
						$('[name=bpe_ajk_tarikh_akhir]').addClass("is-invalid");
						swal("Ralat!", "Tarikh mula lantikan tidak boleh melebihi tarikh akhir lantikan", "success");
					}else
					{
						if(tkh_mula < penggal_mula || tkh_akhir > penggal_akhir)
						{
							swal("Ralat!", "Tarikh lantikan tidak selari dengan penggal", "success");
						}else
						{
							$('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
							$('#btn_next').prop('disabled', true);
							$("#bpe_ajk_status_form").val(4);
							var data = $("#form_bpe").serialize();
							var action = $('#post_pendaftaran_ahli_krt').val();
							var btn_text;
							if (action == 'edit') {
								url = daftar_ahli_krt_config.routes.daftar_ahli_krt_url;
								type = "POST";
								btn_text = 'Hantar Maklumat Ahli KRT&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
							} 
							$.ajax({
								url: url,
								type: type,
								data: data,
							}).done(function(response) {        
								$('[name=bpe_ajk_nama]').removeClass("is-invalid");
								$('[name=bpe_ajk_ic]').removeClass("is-invalid");
								$('[name=bpe_ajk_tarikh_lahir]').removeClass("is-invalid");
								$('[name=bpe_ajk_jantina]').removeClass("is-invalid");
								$('[name=bpe_ajk_k_umur]').removeClass("is-invalid");
								$('[name=bpe_ajk_kaum]').removeClass("is-invalid");
								$('[name=bpe_ajk_warganegara]').removeClass("is-invalid");
								$('[name=bpe_ajk_agama]').removeClass("is-invalid");
								$('[name=bpe_ajk_phone]').removeClass("is-invalid");
								$('[name=bpe_ajk_alamat]').removeClass("is-invalid");
								$('[name=bpe_ajk_poskod]').removeClass("is-invalid");
								$('[name=bpe_ajk_profession_id]').removeClass("is-invalid");
								$('[name=bpe_ajk_pendidikan_id]').removeClass("is-invalid");
								$('[name=bpe_ajk_jawatan_krt_id]').removeClass("is-invalid");
								$('[name=bpe_ajk_tarikh_mula]').removeClass("is-invalid");
								$('[name=bpe_ajk_tarikh_akhir]').removeClass("is-invalid");
								$('[name=bpe_ajk_bekepentingan]').removeClass("is-invalid");
								$('[name=bpe_ajk_bekepentingan_interaksi_1]').removeClass("is-invalid");
								$('[name=bpe_ajk_bekepentingan_interaksi_2]').removeClass("is-invalid");
								$('[name=bpe_ajk_bekepentingan_interaksi_3]').removeClass("is-invalid");
								$('[name=bpe_ajk_bekepentingan_interaksi_4]').removeClass("is-invalid");
								$('[name=bpe_ajk_bekepentingan_interaksi_5]').removeClass("is-invalid");
								$('[name=bpe_ajk_berkepentingan_keterangan]').removeClass("is-invalid");
				
								if(response.errors){
									if(response.errors === 1)
									{
										$('#btn_next').html(btn_text);                
										$('#btn_next').prop('disabled', false);
										swal("Ralat!", "No IC telah wujud untuk penggal ini yang telah disahkan dan tidak dibenarkan untuk dikemaskini", "success");
									}else
									{
										if(response.errors === 2)
										{
											$('#btn_next').html(btn_text);                
											$('#btn_next').prop('disabled', false);
											swal("Ralat!", "No IC telah wujud yang aktif dan tidak dibenarkan untuk dikemaskini. Sila tukar status dahulu.", "success");
										}else
										{
											$.each(response.errors, function(index, error){
												if(index == 'bpe_ajk_nama') {
													$('[name=bpe_ajk_nama]').addClass("is-invalid");
													$('.error_bpe_ajk_nama').html(error);
												}
						
												if(index == 'bpe_ajk_ic') {
													$('[name=bpe_ajk_ic]').addClass("is-invalid");
													$('.error_bpe_ajk_ic').html(error);
												}
						
												if(index == 'bpe_ajk_tarikh_lahir') {
													$('[name=bpe_ajk_tarikh_lahir]').addClass("is-invalid");
													$('.error_bpe_ajk_tarikh_lahir').html(error);
												}
						
												if(index == 'bpe_ajk_jantina') {
													$('[name=bpe_ajk_jantina]').addClass("is-invalid");
													$('.error_bpe_ajk_jantina').html(error);
												}
						
												if(index == 'bpe_ajk_k_kaum') {
													$('[name=bpe_ajk_k_kaum]').addClass("is-invalid");
													$('.error_bpe_ajk_k_kaum').html(error);
												}
						
												if(index == 'bpe_ajk_kaum') {
													$('[name=bpe_ajk_kaum]').addClass("is-invalid");
													$('.error_bpe_ajk_kaum').html(error);
												}
						
												if(index == 'bpe_ajk_warganegara') {
													$('[name=bpe_ajk_warganegara]').addClass("is-invalid");
													$('.error_bpe_ajk_warganegara').html(error);
												}
												
												if(index == 'bpe_ajk_k_umur') {
													$('[name=bpe_ajk_k_umur]').addClass("is-invalid");
													$('.error_bpe_ajk_k_umur').html(error);
												}
														
												if(index == 'bpe_ajk_agama') {
													$('[name=bpe_ajk_agama]').addClass("is-invalid");
													$('.error_bpe_ajk_agama').html(error);
												}
						
												if(index == 'bpe_ajk_phone') {
													$('[name=bpe_ajk_phone]').addClass("is-invalid");
													$('.error_bpe_ajk_phone').html(error);
												}
						
												if(index == 'bpe_ajk_alamat') {
													$('[name=bpe_ajk_alamat]').addClass("is-invalid");
													$('.error_bpe_ajk_alamat').html(error);
												}
						
												if(index == 'bpe_ajk_poskod') {
													$('[name=bpe_ajk_poskod]').addClass("is-invalid");
													$('.error_bpe_ajk_poskod').html(error);
												}
						
												if(index == 'bpe_ajk_profession_id') {
													$('[name=bpe_ajk_profession_id]').addClass("is-invalid");
													$('.error_bpe_ajk_profession_id').html(error);
												}
						
												if(index == 'bpe_ajk_pendidikan_id') {
													$('[name=bpe_ajk_pendidikan_id]').addClass("is-invalid");
													$('.error_bpe_ajk_pendidikan_id').html(error);
												}
						
												if(index == 'bpe_ajk_jawatan_krt_id') {
													$('[name=bpe_ajk_jawatan_krt_id]').addClass("is-invalid");
													$('.error_bpe_ajk_jawatan_krt_id').html(error);
												}
						
												if(index == 'bpe_ajk_tarikh_mula') {
													$('[name=bpe_ajk_tarikh_mula]').addClass("is-invalid");
													$('.error_bpe_ajk_tarikh_mula').html(error);
												}
						
												if(index == 'bpe_ajk_tarikh_akhir') {
													$('[name=bpe_ajk_tarikh_akhir]').addClass("is-invalid");
													$('.error_bpe_ajk_tarikh_akhir').html(error);
												}
						
												if(index == 'bpe_ajk_berkepentingan_keterangan') {
													$('[name=bpe_ajk_berkepentingan_keterangan]').addClass("is-invalid");
													$('.error_bpe_ajk_berkepentingan_keterangan').html(error);
												}
						
											});
											$('#btn_next').html(btn_text);                
											$('#btn_next').prop('disabled', false);  
										}
									}          
								} else {
									$('#btn_next').html(btn_text);
									$('#btn_next').prop('disabled', false); 
									window.location.href = "{{route('rt-sm4.pendaftaran_ahli_krt_utama')}}";
								}
							});
						}//end else tkh_mula
					}//end else tkh_mula<penggal_mula
				} //end else tkh_lahir
			}
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
@stop