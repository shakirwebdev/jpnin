@include('js.modal.j-modal-view-dokumen')
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
	
		$.fn.kira_baki = function() { 
			var jenis=$("#srkr_kewangan_jenis_kewangan").val();
			var tkh=$("#srkr_kewangan_tarikh_t_b").val();
			var masa=$("#srkr_kewangan_time_t_b").val();
			var curr_tunai=$("#srkr_kewangan_jumlah_tunai").val();
			var curr_bank=$("#srkr_kewangan_jumlah_bank").val();
			if(curr_tunai == '')
			{
				curr_tunai = 0;
			}
			if(curr_bank == '')
			{
				curr_bank = 0;
			}
			let [day, month, year] = tkh.split('/');
			let [hour, minit] = masa.split(':');
			//const dateObj = new Date(+year, +month - 1, +day);
			var curr_transdate= year+month+day+hour+minit+"00";
			var baki_tunai=0;
			var baki_bank=0;
			var jum_baki=0;
			$.each($("#senarai_trx tr"),function(index){
				var self=$(this).closest("tr");
				var member_1_value = self.find("td:eq(1)").text().trim();
				if(member_1_value != "")
				{
					var member_2_value = self.find("td:eq(2)").text().trim();
					var member_3_value = self.find("td:eq(3)").text().trim();
					var member_4_value = self.find("td:eq(4)").text().trim();
					var member_5_value = self.find("td:eq(5)").text().trim();
					if(index > 0)
					{
						/*if(dateObj2 < dateObj)
						{*/
						if((member_5_value+"00") < curr_transdate)
						{
							if(member_2_value == '1')
							{
								baki_tunai = parseFloat(baki_tunai) + parseFloat(member_3_value);
								baki_bank = parseFloat(baki_bank) + parseFloat(member_4_value);
							}else
							{
								baki_tunai = parseFloat(baki_tunai) - parseFloat(member_3_value);
								baki_bank = parseFloat(baki_bank) - parseFloat(member_4_value);
							}
						}
					//}
					}
				}
			});
			if(jenis == '1')
			{
				baki_tunai = parseFloat(baki_tunai) + parseFloat(curr_tunai);
				baki_bank = parseFloat(baki_bank) + parseFloat(curr_bank);
			}else
			{
				baki_tunai = parseFloat(baki_tunai) - parseFloat(curr_tunai);
				baki_bank = parseFloat(baki_bank) - parseFloat(curr_bank);
			}
			jum_baki=baki_tunai + baki_bank;
			$('#srkr_kewangan_baki_tunai').val(baki_tunai.toFixed(2));
			$('#srkr_kewangan_baki_bank').val(baki_bank.toFixed(2));
			$('#srkr_kewangan_jumlah_baki').val(jum_baki.toFixed(2));
		};
        
		$var_bulan=GetParameterValues('bulan');
		$var_tahun=GetParameterValues('tahun');
		
		function GetParameterValues(param) {  
            var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');  
            for (var i = 0; i < url.length; i++) {  
                var urlparam = url[i].split('=');  
                if (urlparam[0] == param) {  
                    return urlparam[1];  
                }  
            }  
        }
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
        $('#srkr_kewangan_tarikh_t_b').val("{{$rekod_kewangan_rt->tarikh_t_b}}");
		$('#srkr_kewangan_time_t_b').val("{{$rekod_kewangan_rt->masa_t_b}}");
        $('#srkr_kewangan_cek_baucer').val("{{$rekod_kewangan_rt->kewangan_cek_baucer}}");
        $('#srkr_kewangan_tarikh_c_b').val("{{$rekod_kewangan_rt->tarikh_c_b}}");
		var jum_tunai = parseFloat("{{$rekod_kewangan_rt->kewangan_jumlah_tunai}}");
		var newjum_tunai=jum_tunai.toFixed(2);
		$('#srkr_kewangan_jumlah_tunai').val(newjum_tunai);
        //$('#srkr_kewangan_jumlah_tunai').val("{{$rekod_kewangan_rt->kewangan_jumlah_tunai}}");
		var jum_bank = parseFloat("{{$rekod_kewangan_rt->kewangan_jumlah_bank}}");
		var newjum_bank=jum_bank.toFixed(2);
		$('#srkr_kewangan_jumlah_bank').val(newjum_bank);
		
		url_get_senarai_trx 				= "{{ route('rt-sm7.get_senarai_trx','') }}"+"/"+"{{$rekod_kewangan_rt->krt_profile_id}}";
		var senarai_trx = $('#senarai_trx').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_get_senarai_trx,
				"language": {
					"paginate": {
							"previous": "",
							"next": "",
					},
					"sSearch": "Carian",
					"sLengthMenu": "",
					"lengthMenu": "",
					"zeroRecords": "Tiada rekod ditemui",
					"info": "",
					"infoEmpty": "",
					"infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
				},
				paging: false,
				pageLength: 30,
				dom: 'rtip',
				"bFilter": true,
				responsive: true,
				"aoColumnDefs":[{
					"aTargets": [ 0 ],
					"width": "5%",
					sClass: 'text-center',
					"mRender": function (data, type, full, meta)  {
						return  full.id;
					}
				},{
					"asSorting": [ "asc" ],
					"aTargets": [ 1 ],
					"width": "55%",
					"mRender": function ( value, type, full )  {
						d = new Date(full.kewangan_tarikh_t_b);      
      					month = '' + (d.getMonth() + 1),
      					day = '' + d.getDate(),
      					year = d.getFullYear();
      					if (month.length < 2)
        					month = '0' + month;
      					if (day.length < 2)
        					day = '0' + day;
					    return [day, month, year].join('/');
					}
				},{
					"aTargets": [ 2 ],
					"width": "55%",
					"mRender": function ( value, type, full )  {
						return full.kewangan_jenis_kewangan;
					}
				},{
					"aTargets": [ 3 ],
					"width": "55%",
					"mRender": function ( value, type, full )  {
						return full.kewangan_jumlah_tunai;
					}
				},{
					"aTargets": [ 4 ],
					"width": "55%",
					"mRender": function ( value, type, full )  {
						return full.kewangan_jumlah_bank;
					}
				},{
					"aTargets": [ 5 ],
					"width": "55%",
					"mRender": function ( value, type, full )  {
						return full.tarikh_kewangan;
					}
				}],
				"order": [[ 5, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
					//sortTable();
					$.fn.kira_baki();
				}
			});
			
		/*var baki_tunai = parseFloat("{{$rekod_kewangan_rt->kewangan_baki_tunai}}");
		var newbaki_tunai=baki_tunai.toFixed(2);
		$('#srkr_kewangan_baki_tunai').val(newbaki_tunai);
		var baki_bank = parseFloat("{{$rekod_kewangan_rt->kewangan_baki_bank}}");
		var newbaki_bank=baki_bank.toFixed(2);
		$('#srkr_kewangan_baki_bank').val(newbaki_bank);
		var jumlah_baki = parseFloat("{{$rekod_kewangan_rt->kewangan_baki_tunai + $rekod_kewangan_rt->kewangan_baki_bank}}");
		var newjumlah_baki=jumlah_baki.toFixed(2);
		$('#srkr_kewangan_jumlah_baki').val(newjumlah_baki);*/

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
			window.location.href = "{{route('rt-sm7.semakan_rekod_kewangan_rt')}}"+"?bulan="+$var_bulan+"&tahun="+$var_tahun;
		});
		
		url_get_senarai_dokumen_sokongan	= "{{ route('rt-sm7.get_senarai_dokumen_sokongan','') }}"+"/"+"{{$rekod_kewangan_rt->id}}";
		
		var senarai_dokumen_sokongan = $('#senarai_dokumen_sokongan_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_get_senarai_dokumen_sokongan,
				"paging": false,
				"bSort": false,
        		responsive: true,
				"info": false,
            	"bFilter": false,
				"aoColumnDefs":[{
					"asSorting": [ "asc" ],
					"aTargets": [ 0 ],
					"width": "5%",
					"mRender": function ( value, type, full, meta )  {
					    return meta.row+1;
					}
				},{
					"aTargets": [ 1 ],
					"width": "5%",
					"mRender": function ( value, type, full )  {
						jenis_desc = "";
						if(full.jenis == 1)
							jenis_desc = "Baucer";
						if(full.jenis == 2)
							jenis_desc = "Cek";
						if(full.jenis == 3)
							jenis_desc = "Resit";
						return jenis_desc;
					}
				},{
					"aTargets": [ 2 ],
					"width": "70%",
					"mRender": function ( value, type, full )  {
						return full.butiran;
					}
				},{
					"aTargets": [ 3 ],
					"width": "55%",
					visible: false,
					"mRender": function ( value, type, full )  {
						return full.fail_dokumen;
					}
				},{
					"aTargets": [ 4 ],
					"width": "10%",
					"mRender": function ( value, type, full )  {
						button_a = "<button type='button' class='btn btn-icon' title='Lihat Dokumen' onclick='view_dokumen(\"" + full.jenis + "\",\"" + full.fail_dokumen + "\");'><i class='fa fa-search'></i></button>";
						//button_b = "<button type='button' class='btn btn-icon' title='Buang Dokumen' onclick='delete_dokumen(\"" + full.id + "\",\"" + full.fail_dokumen + "\");'><i class='fa fa-trash-o text-danger'></i></button>";
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
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
            		window.location.href = "{{route('rt-sm7.semakan_rekod_kewangan_rt')}}"+"?bulan="+"{{$rekod_kewangan_rt->tarikh_bulan}}"+"&tahun="+"{{$rekod_kewangan_rt->tarikh_tahun}}";
                }
            });
        });
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop