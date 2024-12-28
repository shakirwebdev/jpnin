@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	function sortTable() {
	  var table, rows, switching, i, x, y, z, shouldSwitch;
	  table = document.getElementById("senarai_kewangan_rt_table");
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
		  x = rows[i].getElementsByTagName("TD")[0];
		  y = rows[i + 1].getElementsByTagName("TD")[0];
		  //check if the two rows should switch place:
		  if(x.innerHTML > y.innerHTML) {
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
	
	function lihat(var_fname)
	{
		$('#dok_jenis').val("Penyata Bank");
		$('#dok_gambar').attr('src', "{{ asset('storage/dokumen_kewangan') }}"+"/"+ var_fname);
		$('#modal_view_dokumen').modal('show');
	}
	
	$(document).ready( function () 
	{
		$.fn.statechange = function() {
			var value = $('#lkr_carian_negeri').val();
			$('#divinfokrt').hide();
           	var selectedIndex = 1;
           	$('#lkr_carian_daerah').find('option').remove();
           	$('#lkr_carian_daerah').prop("disabled", false);
           	if (selectedIndex !== '0') {
               	$.ajax({
                   	type: "GET",
                   	url: "/rt/sm7/laporan-kewangan-rt",
                   	data: {type: 'get_daerah', value: value},
                   	success: function (data) {
						$('#lkr_carian_daerah').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                       	$.each(data,function(key, obj) 
                       	{
                           	$('#lkr_carian_daerah')
                           	.append($('<option>')
                           	.text(obj.daerah_description)
                           	.attr('value', obj.daerah_id));
                       	});
						if($('#load_daerah_id').val() != '')
						{
							$('#lkr_carian_daerah').val($('#load_daerah_id').val());
							$('#lkr_carian_daerah').prop('disabled', 'disabled');
						}
                   	},
               	 	error: function (data) {
                       	alert('error');
                   	}
               	}); 
           	}
		};
		
		var user_state = $('#load_state_id').val();
		if(user_state != '')
		{
			$('#lkr_carian_negeri').val(user_state);
			$('#lkr_carian_negeri').prop('disabled', 'disabled');
			$.fn.statechange();
			$('#divcarian').show();
		}else
		{
			$('#divcarian').show();
		}
		
		$("#lkr_carian_negeri").on( 'change', function () 
		{
           	var value = $('#lkr_carian_negeri').val();
			$('#divinfokrt').hide();
           	var selectedIndex = 1;
           	$('#lkr_carian_daerah').find('option').remove();
           	$('#lkr_carian_daerah').prop("disabled", false);
           	if (selectedIndex !== '0') {
               	$.ajax({
                   	type: "GET",
                   	url: "/rt/sm7/laporan-kewangan-rt",
                   	data: {type: 'get_daerah', value: value},
                   	success: function (data) {
                       	$('#lkr_carian_daerah').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                       	$.each(data,function(key, obj) 
                       	{
                           	$('#lkr_carian_daerah')
                           	.append($('<option>')
                           	.text(obj.daerah_description)
                           	.attr('value', obj.daerah_id));
                       	});
                   	},
               	 	error: function (data) {
                       	alert('error');
                   	}
               	}); 
           	}
        });
		
		$.fn.daerahchange = function() {
			$('#divinfokrt').hide();
			var value = $('#load_daerah_id').val();
			var selectedIndex = 1;
			$('#lkr_carian_krt').find('option').remove();
			$('#lkr_carian_krt').prop("disabled", false);
			if (selectedIndex !== '0') {
				$.ajax({
					type: "GET",
					url: "/rt/sm7/laporan-kewangan-rt",
					data: {type: 'get_krt', value: value},
					success: function (data) {
						$('#lkr_carian_krt').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#lkr_carian_krt')
							.append($('<option>')
							.text(obj.krt_nama)
							.attr('value', obj.id));
							if($('#load_krt_id').val() == obj.id)
							{
								$('#lkr_krt_nama').val(obj.krt_nama);
								$('#lkr_no_acc').val(obj.krt_bank_no_acc);
								$('#lkr_bank_nama').val(obj.krt_bank_nama);
								$('#lkr_no_evendor').val(obj.krt_bank_no_evendor);
								
							}
						});
						if($('#load_krt_id').val() != '')
						{
							$('#lkr_carian_krt').val($('#load_krt_id').val());
							$('#lkr_carian_krt').prop('disabled', 'disabled');
							$.fn.cari_kewangan();
							$('#divinfokrt').show();
							$('#divcarian').hide();
						}
					},
					error: function (data) {
						alert('error');
					}
				}); 
			}
		};
		
		var user_daerah = $('#load_daerah_id').val();
		if(user_daerah != '')
		{
			$.fn.daerahchange();
		}
		
		$("#lkr_carian_daerah").on( 'change', function () {
			$('#divinfokrt').hide();
			var value = $('#lkr_carian_daerah').val();
			var selectedIndex = 1;
			$('#lkr_carian_krt').find('option').remove();
			$('#lkr_carian_krt').prop("disabled", false);
			if (selectedIndex !== '0') {
				$.ajax({
					type: "GET",
					url: "/rt/sm7/laporan-kewangan-rt",
					data: {type: 'get_krt', value: value},
					success: function (data) {
						$('#lkr_carian_krt').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#lkr_carian_krt')
							.append($('<option>')
							.text(obj.krt_nama)
							.attr('value', obj.id));
						});
					},
					error: function (data) {
						alert('error');
					}
				}); 
			}
		});
			
		$.fn.cari_kewangan = function(){
			event.preventDefault();
			$('#senarai_kewangan_rt_table').dataTable().fnClearTable();
    		$('#senarai_kewangan_rt_table').dataTable().fnDestroy();
			$('#senarai_kewangan_rt_table2').dataTable().fnClearTable();
			if($('#load_krt_id').val() !== '')
				var krt=$('#load_krt_id').val();
			else
				var krt=$('#lkr_carian_krt').val();
				
			var senarai_kewangan_rt_table = $('#senarai_kewangan_rt_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: {
						url: "/rt/sm7/laporan-kewangan-rt",
						data:function(d){
								d.bulan=$('#lkr_bulan').val();
								d.tahun=$('#lkr_tahun').val();
								d.krt=krt;
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
					},
				"paging": false,
				"bFilter": true,
				"bSort": false,
				responsive: true,
				"info": false,
				"bFilter": false,
				scrollCollapse: true,
				scrollY: "55vh",
				"aoColumnDefs":[{          
						"aTargets": [ 0 ], 
						sClass: 'text-center',
						"mRender": function (data, type, full)  {
							return  full.tarikh_kewangan;
						}
					},{          
						"aTargets": [ 1 ], 
						"mRender": function ( value, type, full )  {
							return full.tarikh_t_b;
						}
					},{          
						"aTargets": [ 2 ], 
						"mRender": function ( value, type, full )  {
							return full.kewangan_butiran;
						}
					},{          
						"aTargets": [ 3 ], 
						"mRender": function ( value, type, full )  {
							return full.no_cek;
						}
					},{          
						"aTargets": [ 4 ], 
						"mRender": function ( value, type, full )  {
							return full.tarikh_cek;
						}
					},{          
						"aTargets": [ 5 ], 
						"mRender": function ( value, type, full )  {
							return full.no_resit;
						}
					},{          
						"aTargets": [ 6 ], 
						"mRender": function ( value, type, full )  {
							return full.tarikh_resit;
						}
					},{          
						"aTargets": [ 7 ],  
						"mRender": function ( value, type, full )  {
							return full.no_baucer;
						}
					},{          
						"aTargets": [ 8 ], 
						"mRender": function ( value, type, full )  {
							return full.tarikh_baucer;
						}
					},{          
						"aTargets": [ 9 ], 
						"mRender": function ( value, type, full )  {
							return full.terima_tunai;
						}
					},{          
						"aTargets": [ 10 ],  
						"mRender": function ( value, type, full )  {
							return full.terima_bank;
						}
					},{          
						"aTargets": [ 11 ], 
						"mRender": function ( value, type, full )  {
							return full.bayar_tunai;
						}
					},{          
						"aTargets": [ 12 ],  
						"mRender": function ( value, type, full )  {
							return full.bayar_bank;
						}
					},{          
						"aTargets": [ 13 ], 
						"mRender": function ( value, type, full )  {
							return full.kewangan_baki_tunai;
						}
					},{          
						"aTargets": [ 14 ], 
						"mRender": function ( value, type, full )  {
							return full.kewangan_baki_bank;
						}
					},{          
						"aTargets": [ 15 ], 
						"mRender": function ( value, type, full )  {
							return full.kewangan_jumlah_baki;
						}
					},{          
						"aTargets": [ 16 ], 
						"mRender": function ( value, type, full )  {
							return full.nama_fail_cek;
						}
					},{          
						"aTargets": [ 17 ], 
						"mRender": function ( value, type, full )  {
							return full.nama_fail_resit;
						}
					},{          
						"aTargets": [ 18 ], 
						"mRender": function ( value, type, full )  {
							return full.nama_fail_baucer;
						}
					}],
				"order": [[ 0, 'asc' ]],
					initComplete: function () {
						$('[data-toggle="tooltip"]').tooltip();
						sortTable();
						$.fn.copy_table();
					}
				});
		}
		
		$("#lkr_carian_krt").on( 'change', function () {
			var value = $('#lkr_carian_krt').val();
			var selectedIndex = 1;
			$('#divinfokrt').hide();
			if (selectedIndex !== '0') 
			{
				$.ajax({
					type: "GET",
					url: "/rt/sm7/laporan-kewangan-rt",
					data: {type: 'get_infokrt', value: value},
					success: function (data) {
						$.each(data,function(key, obj) 
						{
							$('#lkr_krt_nama').val(obj.krt_nama);
							$('#lkr_no_acc').val(obj.krt_bank_no_acc);
							$('#lkr_bank_nama').val(obj.krt_bank_nama);
							$('#lkr_no_evendor').val(obj.krt_bank_no_evendor);
						});
						$.fn.cari_kewangan();
						$('#divinfokrt').show();
					},
					error: function (data) {
						alert('error');
					}
				}); 
			}
        });
			
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
			
		if($var_bulan == null || $var_bulan == "")
		{
				//$var_bulan = new Date().getMonth() + 1;
			$var_bulan = "00";
		}
		if($var_tahun == null || $var_tahun == "")
		{
			$var_tahun = new Date().getFullYear();
		}
			
		$("#lkr_bulan").children("option[value='"+$var_bulan+"']").attr("selected", true);
		$("#lkr_tahun").children("option[value='"+$var_tahun+"']").attr("selected", true);
			
		$.fn.copy_table = function() {
			$('#senarai_kewangan_rt_table2').dataTable().fnClearTable();
			$('#button_excel').hide();
			$('#button_pdf').hide();
			$.each($("#senarai_kewangan_rt_table tr"),function(index){
				if(index>0)
				{
					var self=$(this).closest("tr");
					var member_1_value = self.find("td:eq(1)").text().trim(); //tarikh
					var member_2_value = self.find("td:eq(2)").text().trim(); //butiran
					var member_3_value = self.find("td:eq(3)").text().trim(); //no cek
					var member_4_value = self.find("td:eq(4)").text().trim(); //tarikh cek
					var member_5_value = self.find("td:eq(5)").text().trim(); //no resit
					var member_6_value = self.find("td:eq(6)").text().trim(); //tarikh resit
					var member_7_value = self.find("td:eq(7)").text().trim(); //no baucer
					var member_8_value = self.find("td:eq(8)").text().trim(); //tarikh baucer
					var member_9_value = self.find("td:eq(9)").text().trim(); //terima tunai
					var member_10_value = self.find("td:eq(10)").text().trim(); //terima bank
					var member_11_value = self.find("td:eq(11)").text().trim(); //bayar tunai
					var member_12_value = self.find("td:eq(12)").text().trim(); //bayar bank
					var member_13_value = self.find("td:eq(13)").text().trim(); //baki tunai
					var member_14_value = self.find("td:eq(14)").text().trim(); //baki bank
					var member_15_value = self.find("td:eq(15)").text().trim(); //jumlah baki
					var member_16_value = self.find("td:eq(16)").text().trim(); //nama fail cek
					var member_17_value = self.find("td:eq(17)").text().trim(); //nama fail resit
					var member_18_value = self.find("td:eq(18)").text().trim(); //nama fail baucer
					if(member_1_value != "")
					{
						member_3_value = "<label style='cursor:pointer; color:#0000FF;' onclick=\"lihat('"+member_16_value+"');\">"+member_3_value+"</label>";
						member_5_value = "<label style='cursor:pointer; color:#0000FF;' onclick=\"lihat('"+member_17_value+"');\">"+member_5_value+"</label>";
						member_7_value = "<label style='cursor:pointer; color:#0000FF;' onclick=\"lihat('"+member_18_value+"');\">"+member_7_value+"</label>";
						senarai_kewangan_rt_table2.row.add([index,member_1_value,member_2_value,(member_3_value+"<br>"+member_4_value),(member_5_value+"<br>"+member_6_value),(member_7_value+"<br>"+member_8_value),member_9_value,member_10_value,member_11_value,member_12_value,member_13_value,member_14_value,member_15_value]).draw(false);
						$('#button_excel').show();
						$('#button_pdf').show();
						$('#divinfokrt').show();
					}
				}
			});
		}

			var senarai_kewangan_rt_table = $('#senarai_kewangan_rt_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: {
						url: "/rt/sm7/laporan-kewangan-rt",
						data:function(d){
							d.bulan=$('#lkr_bulan').val();
							d.tahun=$('#lkr_tahun').val();
							d.krt=$('#lkr_carian_krt').val();
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
						},
				"paging": false,
				"bFilter": true,
				"bSort": false,
				responsive: true,
				"info": false,
				"bFilter": false,
				scrollCollapse: true,
				scrollY: "55vh",
				"aoColumnDefs":[{          
							"aTargets": [ 0 ], 
							sClass: 'text-center',
							"mRender": function (data, type, full)  {
								return  full.tarikh_kewangan;
							}
						},{          
							"aTargets": [ 1 ], 
							"mRender": function ( value, type, full )  {
								return full.tarikh_t_b;
							}
						},{          
							"aTargets": [ 2 ], 
							"mRender": function ( value, type, full )  {
								return full.kewangan_butiran;
							}
						},{          
							"aTargets": [ 3 ], 
							"mRender": function ( value, type, full )  {
								return full.no_cek;
							}
						},{          
							"aTargets": [ 4 ], 
							"mRender": function ( value, type, full )  {
								return full.tarikh_cek;
							}
						},{          
							"aTargets": [ 5 ], 
							"mRender": function ( value, type, full )  {
								return full.no_resit;
							}
						},{          
							"aTargets": [ 6 ], 
							"mRender": function ( value, type, full )  {
								return full.tarikh_resit;
							}
						},{          
							"aTargets": [ 7 ],  
							"mRender": function ( value, type, full )  {
								return full.no_baucer;
							}
						},{          
							"aTargets": [ 8 ], 
							"mRender": function ( value, type, full )  {
								return full.tarikh_baucer;
							}
						},{          
							"aTargets": [ 9 ], 
							"mRender": function ( value, type, full )  {
								return full.terima_tunai;
							}
						},{          
							"aTargets": [ 10 ],  
							"mRender": function ( value, type, full )  {
								return full.terima_bank;
							}
						},{          
							"aTargets": [ 11 ], 
							"mRender": function ( value, type, full )  {
								return full.bayar_tunai;
							}
						},{          
							"aTargets": [ 12 ],  
							"mRender": function ( value, type, full )  {
								return full.bayar_bank;
							}
						},{          
							"aTargets": [ 13 ], 
							"mRender": function ( value, type, full )  {
								return full.kewangan_baki_tunai;
							}
						},{          
							"aTargets": [ 14 ], 
							"mRender": function ( value, type, full )  {
								return full.kewangan_baki_bank;
							}
						},{          
							"aTargets": [ 15 ], 
							"mRender": function ( value, type, full )  {
								return full.kewangan_jumlah_baki;
								return full.nama_fail_cek;
							}
						},{          
							"aTargets": [ 16 ], 
							"mRender": function ( value, type, full )  {
								return full.nama_fail_cek;
							}
						},{          
							"aTargets": [ 17 ], 
							"mRender": function ( value, type, full )  {
								return full.nama_fail_resit;
							}
						},{          
							"aTargets": [ 18 ], 
							"mRender": function ( value, type, full )  {
								return full.nama_fail_baucer;
							}
						}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
							$('[data-toggle="tooltip"]').tooltip();
							sortTable();
							$.fn.copy_table();
					}
			});
		
		var senarai_kewangan_rt_table2 = $('#senarai_kewangan_rt_table2').DataTable({
			"language": {
					"paginate": {
						"previous": "Sebelumnya",
						"next": "Seterusnya",
						},
					"sSearch": "Carian",
					"sLengthMenu": "",
					"lengthMenu": "",
					"zeroRecords": "Tiada rekod ditemui",
					"info": "",
					"infoEmpty": "",
					"infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
			},
			"bSort": false,
			responsive: true,
			"info": false,
			"bFilter": false,
			paging: true,
			pageLength: 10,
			dom: 'rtip',
			"columns": [
					{ sClass: 'text-center', },
					{ sClass: 'text-center', },
					{ sClass: 'text-left', },
					{ sClass: 'text-center', },
					{ sClass: 'text-center', },
					{ sClass: 'text-center', },
					{ sClass: 'text-right', },
					{ sClass: 'text-right',},
					{ sClass: 'text-right', },
					{ sClass: 'text-right', },
					{ sClass: 'text-right', },
					{ sClass: 'text-right', },
					{ sClass: 'text-right', },
  				]
		});
			
		$("#cari_kewangan").click(function(){
			event.preventDefault();
			$('#senarai_kewangan_rt_table').dataTable().fnClearTable();
    		$('#senarai_kewangan_rt_table').dataTable().fnDestroy();
			$('#senarai_kewangan_rt_table2').dataTable().fnClearTable();
			var senarai_kewangan_rt_table = $('#senarai_kewangan_rt_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: {
					url: "/rt/sm7/laporan-kewangan-rt",
					data:function(d){
							d.bulan=$('#lkr_bulan').val();
							d.tahun=$('#lkr_tahun').val();
							d.krt=$('#lkr_carian_krt').val();
						} 
					},
				"paging": false,
				"bFilter": true,
				"bSort": false,
				responsive: true,
				"info": false,
				"bFilter": false,
				scrollCollapse: true,
				scrollY: "55vh",
				"aoColumnDefs":[{          
						"aTargets": [ 0 ], 
						sClass: 'text-center',
						"mRender": function (data, type, full)  {
							return  full.tarikh_kewangan;
						}
					},{          
						"aTargets": [ 1 ], 
						"mRender": function ( value, type, full )  {
							return full.tarikh_t_b;
						}
					},{          
						"aTargets": [ 2 ], 
						"mRender": function ( value, type, full )  {
							return full.kewangan_butiran;
						}
					},{          
						"aTargets": [ 3 ], 
						"mRender": function ( value, type, full )  {
							return full.no_cek;
						}
					},{          
						"aTargets": [ 4 ], 
						"mRender": function ( value, type, full )  {
							return full.tarikh_cek;
						}
					},{          
						"aTargets": [ 5 ], 
						"mRender": function ( value, type, full )  {
							return full.no_resit;
						}
					},{          
						"aTargets": [ 6 ], 
						"mRender": function ( value, type, full )  {
							return full.tarikh_resit;
						}
					},{          
						"aTargets": [ 7 ],  
						"mRender": function ( value, type, full )  {
							return full.no_baucer;
						}
					},{          
						"aTargets": [ 8 ], 
						"mRender": function ( value, type, full )  {
							return full.tarikh_baucer;
						}
					},{          
						"aTargets": [ 9 ], 
						"mRender": function ( value, type, full )  {
							return full.terima_tunai;
						}
					},{          
						"aTargets": [ 10 ],  
						"mRender": function ( value, type, full )  {
							return full.terima_bank;
						}
					},{          
						"aTargets": [ 11 ], 
						"mRender": function ( value, type, full )  {
							return full.bayar_tunai;
						}
					},{          
						"aTargets": [ 12 ],  
						"mRender": function ( value, type, full )  {
							return full.bayar_bank;
						}
					},{          
						"aTargets": [ 13 ], 
						"mRender": function ( value, type, full )  {
							return full.kewangan_baki_tunai;
						}
					},{          
						"aTargets": [ 14 ], 
						"mRender": function ( value, type, full )  {
							return full.kewangan_baki_bank;
						}
					},{          
						"aTargets": [ 15 ], 
						"mRender": function ( value, type, full )  {
							return full.kewangan_jumlah_baki;
						}
					},{          
						"aTargets": [ 16 ], 
						"mRender": function ( value, type, full )  {
							return full.nama_fail_cek;
						}
					},{          
						"aTargets": [ 17 ], 
						"mRender": function ( value, type, full )  {
							return full.nama_fail_resit;
						}
					},{          
						"aTargets": [ 18 ], 
						"mRender": function ( value, type, full )  {
							return full.nama_fail_baucer;
						}
					}],
				"order": [[ 0, 'asc' ]],
					initComplete: function () {
						$('[data-toggle="tooltip"]').tooltip();
						$('#myInput').val("complete");
						sortTable();
						$.fn.copy_table();
					}
				});
			}).ajax.reload(); 
    	});

		$('#btn_excel').on( 'click', function () {
			$var_krt = $('#lkr_carian_krt').val();
			$var_bulan = $('#lkr_bulan').val();
			$var_tahun = $('#lkr_tahun').val();
			$base_url = window.location.origin;
			$url = $base_url+"/rt/sm7/get_excel_file2/krt/"+$var_krt+"/bulan/"+$var_bulan+"/tahun/"+$var_tahun;
			window.location.href = $url;
			//window.location.href = "{{route('rt-sm7.get_excel_file','')}}"+"/"+$('#lkr_carian_krt').val();
		});

	
		$('#btn_pdf').on( 'click', function () {
			$var_krt = $('#lkr_carian_krt').val();
			$var_bulan = $('#lkr_bulan').val();
			$var_tahun = $('#lkr_tahun').val();
			$base_url = window.location.origin;
			$url = $base_url+"/pdf/laporan_kewangan_rt_pdf/krt/"+$var_krt+"/bulan/"+$var_bulan+"/tahun/"+$var_tahun;
			window.location.href = $url;
			//window.location.href = "{{route('pdf.laporan_kewangan_rt','')}}"+"/"+$('#lkr_carian_krt').val()+"/"+$('#lkr_bulan').val()+"/"+$('#lkr_tahun').val();
		});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop