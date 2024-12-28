@include('js.modal.j-modal-view-dokumen')
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
    
	function sortTable() {
	  var table, rows, switching, i, x, y, shouldSwitch;
	  table = document.getElementById("senarai_trx");
	  switching = true;
	  /*Make a loop that will continue until
	  no switching has been done:*/
	  while (switching) {
		//start by saying: no switching is done:
		switching = false;
		rows = table.rows;
		/*Loop through all table rows (except the
		first, which contains table headers):*/
		for (i = 1; i < (rows.length - 1); i++) {
		  //start by saying there should be no switching:
		  shouldSwitch = false;
		  /*Get the two elements you want to compare,
		  one from current row and one from the next:*/
		  x = rows[i].getElementsByTagName("TD")[1];
		  y = rows[i + 1].getElementsByTagName("TD")[1];
		  //check if the two rows should switch place:
		  if(process(x.innerHTML) > process(y.innerHTML)) {
		  //if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
			//if so, mark as a switch and break the loop:
			shouldSwitch = true;
			break;
		  }
		}
		if (shouldSwitch) {
		  /*If a switch has been marked, make the switch
		  and mark that a switch has been done:*/
		  rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
		  switching = true;
		}
	  }
	}
	
	function process(date){
   		var parts = date.split("/");
   		return new Date(parts[2], parts[1] - 1, parts[0]);
	}
	
	function delete_dokumen(id,fname)
	{
		swal({
			title: "Anda pasti?",
			text: "Anda akan memadam rekod ini dari pangkalan data!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#dc3545",
			confirmButtonText: "Ya, sila padam!",
			cancelButtonText: "Tidak",
			closeOnConfirm: false,
			closeOnCancel: false
			}, function (isConfirm) {
				if (isConfirm) 
				{
					$.ajax({
						type: "GET",
						url: "{{ route('rt-sm7.delete_dokumen','') }}" + "/" + id,
						data: { filename: fname },
						success: function (response) {
									$("#senarai_dokumen_sokongan_table").DataTable().ajax.reload();
									swal("Sudah dipadam!", "Rekod dokumen sokongan telah dipadam dari pangkalan data", "success");
								},
						error: function (data) {
							console.log('Error:', data);
							}
					});
				} else {
					swal("Tidak", "Proses pemadaman tidak berlaku", "error");
				}
			});
  	}
	
	function kembali()
	{
		var ada=0;
		if($("#arkr_kewangan_jenis_kewangan").val() != null)
		{
			ada=1;
		}
		if($("#arkr_kewangan_nama_penuh").val() != "")
		{
			ada=1;
		}
		if($("#arkr_kewangan_alamat").val() != "")
		{
			ada=1;
		}
		if($("#arkr_kewangan_butiran").val() != "")
		{
			ada=1;
		}
		if($("#arkr_kewangan_tarikh_t_b").val() != "")
		{
			ada=1;
		}
		if($("#arkr_kewangan_cek_baucer").val() != "")
		{
			ada=1;
		}
		if($("#arkr_kewangan_tarikh_cek").val() != "")
		{
			ada=1;
		}
		if($("#senarai_dokumen_sokongan_table").length > 1)
		{
			ada=1;
		}
		if($("#arkr_kewangan_jumlah_tunai").val() != "")
		{
			ada=1;
		}
		if($("#arkr_kewangan_jumlah_bank").val() != "")
		{
			ada=1;
		}
		if($("#mag_dokumen_kewangan_id").val() != "")
		{
			ada=1;
		}
		if(ada == 0)
		{
			window.location.href = '{{route('rt-sm7.senarai_rekod_kewangan_rt')}}';
		}else
		{
			if($("#arkr_kewangan_jumlah_tunai").val() == "")
			{
				$("#arkr_kewangan_jumlah_tunai").val("0.00");
			}
			if($("#arkr_kewangan_jumlah_bank").val() == "")
			{
				$("#arkr_kewangan_jumlah_bank").val("0.00");
			}
			var url = "{{ route('rt-sm7.kembali_rekod_kewangan_rt') }}";
            var type = "POST";
			var data = $("#form_arkr").serialize();
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {       
				if(response.errors)
				{
					alert("error");
				} else {
					window.location.href = "{{route('rt-sm7.senarai_rekod_kewangan_rt')}}";
				}
			});
		}
	}
	
	$(document).ready( function () {
	
		$('#arkr_kewangan_time_t_b').inputmask('hh:mm', { placeholder: '__:__ _m', alias: 'time24', hourFormat: '24' });
		//$("#arkr_kewangan_time").inputmask("h:s",{ "placeholder": "hh/mm" });
	
		$.fn.kira_baki = function() { 
			var jenis=$("#arkr_kewangan_jenis_kewangan").val();
			var tkh=$("#arkr_kewangan_tarikh_t_b").val();
			var curr_tunai=$("#arkr_kewangan_jumlah_tunai").val();
			var curr_bank=$("#arkr_kewangan_jumlah_bank").val();
			if(curr_tunai == '')
			{
				curr_tunai = 0;
			}
			if(curr_bank == '')
			{
				curr_bank = 0;
			}
			let [day, month, year] = tkh.split('/');
			const dateObj = new Date(+year, +month - 1, +day);
			var baki_tunai=0;
			var baki_bank=0;
			var jum_baki=0;
			$.each($("#senarai_trx tr"),function(index){
				var self=$(this).closest("tr");
				var member_1_value = self.find("td:eq(1)").text().trim();
				let [day2, month2, year2] = member_1_value.split('/');
				const dateObj2 = new Date(+year2, +month2 - 1, +day2);
				var member_2_value = self.find("td:eq(2)").text().trim();
				var member_3_value = self.find("td:eq(3)").text().trim();
				var member_4_value = self.find("td:eq(4)").text().trim();
				if(index > 0)
				{
					/*if(dateObj2 < dateObj)
					{*/
					if(member_1_value != "")
					{
						if(member_2_value == '1')
						{
							baki_tunai = baki_tunai + parseFloat(member_3_value);
							baki_bank = parseFloat(baki_bank) + parseFloat(member_4_value);
						}else
						{
							baki_tunai = baki_tunai - parseFloat(member_3_value);
							baki_bank = parseFloat(baki_bank) - parseFloat(member_4_value);
						}
					}else
					{
						baki_tunai = baki_tunai;
						baki_bank = baki_bank;
					}
				//}
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
			$('#kewangan_baki_tunai').val(baki_tunai.toFixed(2));
			$('#kewangan_baki_bank').val(baki_bank.toFixed(2));
			$('#kewangan_jumlah_baki').val(jum_baki.toFixed(2));
		};
		
		url_get_senarai_trx = "{{ route('rt-sm7.get_senarai_trx','') }}"+"/"+"{{$krt_profile->krt_profile_id}}";
		if($('#mag_dokumen_kewangan_id').val() == "")
		{
			url_get_senarai_dokumen_sokongan	= "{{ route('rt-sm7.get_senarai_dokumen_sokongan','') }}"+"/0";
		}else
		{
			url_get_senarai_dokumen_sokongan	= "{{ route('rt-sm7.get_senarai_dokumen_sokongan','') }}"+"/"+$('#mag_dokumen_kewangan_id').val();
		}
		
    /* Maklumat Kawasan Krt */
		$('#arkr_nama_krt').html("{{$krt_profile->nama_krt}}");
		$('#arkr_alamat_krt').html("{{$krt_profile->alamat_krt}}");
		$('#arkr_negeri_krt').html("{{$krt_profile->negeri_krt}}");
		$('#arkr_daerah_krt').html("{{$krt_profile->daerah_krt}}");
		$('#arkr_parlimen_krt').html("{{$krt_profile->parlimen_krt}}");
		$('#arkr_dun_krt').html("{{$krt_profile->dun_krt}}");
		$('#arkr_pbt_krt').html("{{$krt_profile->pbt_krt}}");

    /* Maklumat Kewangan Rukun Tetangga */
		$('#mag_dokumen_krt_id').val("{{$krt_profile->krt_profile_id}}");
		
      	$('#arkr_krt_profile_id').val("{{$krt_profile->krt_profile_id}}");
      	$('#arkr_kewangan_nama_bank').val("{{$krt_profile->krt_bank_nama}}");
      	$('#arkr_kewangan_no_acc').val("{{$krt_profile->krt_bank_no_acc}}");
      	$('#arkr_kewangan_no_evendor').val("{{$krt_profile->krt_bank_no_evendor}}");
      	/*var tunai = "{{$krt_profile->krt_bank_baki_cash}}";
      	var bank = "{{$krt_profile->krt_bank_baki_bank}}";
      	var total_1 = parseFloat(tunai) + parseFloat(bank);
      	var total = parseFloat(total_1).toFixed(2);
      	$('#kewangan_baki_tunai').val(tunai);
      	$('#kewangan_baki_bank').val(bank);
      	$('#kewangan_jumlah_baki').val(total);*/

      	$('#arkr_kewangan_alamat').on('keyup keypress', function(e) {
        	var keyCode = e.keyCode || e.which;
        	if (keyCode === 13) { 
          		e.preventDefault();

          // Ajax code here parseInt

          		return false;
        	}
      	});
		
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
						button_b = "<button type='button' class='btn btn-icon' title='Buang Dokumen' onclick='delete_dokumen(\"" + full.id + "\",\"" + full.fail_dokumen + "\");'><i class='fa fa-trash-o text-danger'></i></button>";
						return button_a + button_b;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
		
    		$('#arkr_kewangan_alamat').on("paste",function(e) {
    			e.preventDefault();
    		});

			$("#arkr_kewangan_jenis_kewangan").change(function(){
        		if($('#arkr_kewangan_jenis_kewangan').val() == 1){
					$.fn.kira_baki();
          		/*var baki_tunai  = "{{$krt_profile->krt_bank_baki_cash}}";
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
         
          		/*var baki_bank   = "{{$krt_profile->krt_bank_baki_bank}}";
          		/*$("#arkr_kewangan_jumlah_bank").keyup(function(){
            		var terimabank  = $('#arkr_kewangan_jumlah_bank').val();
            		var total_bank_1  = parseFloat(baki_bank) + parseFloat(terimabank);
            		var total_bank  = parseFloat(total_bank_1).toFixed(2);
            		$('#kewangan_baki_bank').val(total_bank);
            		var total_baki_bank_1 =  parseFloat($('#kewangan_baki_tunai').val()) + parseFloat($('#kewangan_baki_bank').val());
            		var total_baki_bank_2 =  parseFloat(total_baki_bank_1).toFixed(2);
            		$('#kewangan_jumlah_baki').val(total_baki_bank_2);
            		$('#arkr_kewangan_baki_bank').val(total_bank);
            		$('#arkr_kewangan_jumlah_baki').val(total_baki_bank_2);
          		});*/
        		}else{
			    	$.fn.kira_baki();
          		/*var baki_tunai  = "{{$krt_profile->krt_bank_baki_cash}}";
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
          		});*/
				}
			});  
		
			$("#arkr_kewangan_jumlah_tunai").keyup(function(){
				$.fn.kira_baki();
			});
		
			$("#arkr_kewangan_jumlah_bank").keyup(function(){
				$.fn.kira_baki();
			});
		
			$("#upload_dokumen").click(function(){
				var form_data = new FormData(form_arkr);
				form_data.append("arkr_kewangan_jenis_kewangan",$("#arkr_kewangan_jenis_kewangan").val());
				form_data.append("arkr_kewangan_nama_penuh",$("#arkr_kewangan_nama_penuh").val());
				form_data.append("arkr_kewangan_alamat",$("#arkr_kewangan_alamat").val());
				form_data.append("arkr_kewangan_butiran",$("#arkr_kewangan_butiran").val());
				form_data.append("arkr_kewangan_tarikh_t_b",$("#arkr_kewangan_tarikh_t_b").val());
				form_data.append("arkr_kewangan_time_t_b",$("#arkr_kewangan_time_t_b").val());
				form_data.append("arkr_kewangan_cek_baucer",$("#arkr_kewangan_cek_baucer").val());
				form_data.append("arkr_kewangan_cek_baucer",$("#arkr_kewangan_cek_baucer").val());
				form_data.append("arkr_kewangan_tarikh_cek",$("#arkr_kewangan_tarikh_cek").val());
				form_data.append("arkr_kewangan_jumlah_tunai",$("#arkr_kewangan_jumlah_tunai").val());
				form_data.append("arkr_kewangan_jumlah_bank",$("#arkr_kewangan_jumlah_bank").val());
				form_data.append("mag_file_dokumen",  $("#mag_file_dokumen")[0].files[0]);
				form_data.append("mag_file_jenis", $("#mag_file_jenis").val() );
				form_data.append("mag_butiran", $("#mag_butiran").val() );
				form_data.append("mag_dokumen_krt_id", $("#mag_dokumen_krt_id").val() );
				form_data.append("post_add_gambar", "edit" );
				console.log(form_data);
				/*for(let [name, value] of form_data) {
  						alert(`${name} = ${value}`); // key1 = value1, then key2 = value2
				}*/
				url = "{{ route('rt-sm7.post_add_dokumen') }}";
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
						$('[name=mag_file_jenis]').removeClass("is-invalid");
						$('[name=mag_butiran]').removeClass("is-invalid");
						$('[name=mag_file_dokumen]').removeClass("is-invalid");      
						if(response.errors)
						{
							$.each(response.errors, function(index, error){
								if(index == 'mag_file_jenis') {
									$('[name=mag_file_jenis]').addClass("is-invalid");
									$('.error_mag_file_jenis').html(error);
								}
								if(index == 'mag_butiran') {
									$('[name=mag_butiran]').addClass("is-invalid");
									$('.error_mag_butiran').html(error);
								}
								if(index == 'mag_file_dokumen') {
									$('[name=mag_file_dokumen]').addClass("is-invalid");
									$('.error_mag_file_dokumen').html(error);
								}
							});
						}else
						{	
							$('#mag_dokumen_kewangan_id').val(response.success);
							document.getElementById("0").selected = "true";
							$('#mag_file_dokumen').val("");
							url_get_senarai_dokumen_sokongan = "{{ route('rt-sm7.get_senarai_dokumen_sokongan','') }}"+"/"+response.success;
							senarai_dokumen_sokongan.destroy();
							senarai_dokumen_sokongan = $('#senarai_dokumen_sokongan_table').DataTable( {
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
									"mRender": function ( value, type, full, meta)  {
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
										button_b = "<button type='button' class='btn btn-icon' title='Buang Dokumen' onclick='delete_dokumen(\"" + full.id + "\",\"" + full.fail_dokumen + "\");'><i class='fa fa-trash-o text-danger'></i></button>";
										return button_a + button_b;
									}
								}],
								"order": [[ 0, 'asc' ]],
								initComplete: function () {
									$('[data-toggle="tooltip"]').tooltip();
								}
							});
							swal("Maklumat Dokumen Sokongan ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
						}
					});
			});
		
	});

  //my custom scrip
		
	var add_rekod_kewangan_rt_config = {
        routes: {
          add_rekod_kewangan_rt_url: "{{ route('rt-sm7.post_rekod_kewangan_rt') }}",
        }
    };

	$(document).on('submit', '#form_arkr', function(event){    
        event.preventDefault();
		if($('#arkr_kewangan_jumlah_tunai').val() == "")
		{
			$('#arkr_kewangan_jumlah_tunai').val("0.00");
		}
		if($('#arkr_kewangan_jumlah_bank').val() == "")
		{
			$('#arkr_kewangan_jumlah_bank').val("0.00");
		}
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
			$('[name=arkr_kewangan_time_t_b]').removeClass("is-invalid");
			$('[name=arkr_kewangan_cek_baucer]').removeClass("is-invalid");
			$('[name=arkr_kewangan_tarikh_cek]').removeClass("is-invalid");
			$('[name=arkr_kewangan_jumlah_tunai]').removeClass("is-invalid");
			$('[name=arkr_kewangan_jumlah_bank]').removeClass("is-invalid");
				
			if(response.errors)
			{
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
						
						if(index == 'arkr_kewangan_time_t_b') {
						  $('[name=arkr_kewangan_time_t_b]').addClass("is-invalid");
						  $('.error_arkr_kewangan_time_t_b').html(error);
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
<script src="{{ asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
@stop