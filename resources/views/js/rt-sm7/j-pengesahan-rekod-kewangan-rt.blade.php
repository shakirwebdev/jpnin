@include('js.modal.j-modal-view-dokumen_kewangan')
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 
	
	function sortTable2() {
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
		  x = rows[i].getElementsByTagName("TD")[0];
		  y = rows[i + 1].getElementsByTagName("TD")[0];
		  //check if the two rows should switch place:
		  if(x.innerHTML < y.innerHTML) {
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
	
	function check(val,objname,objname2) {
		document.getElementById(objname).innerHTML=val;
		if(val == 2)
		{
			document.getElementById(objname2).value = "";
			document.getElementById(objname2).style.display = "block";
		}else
		{
			document.getElementById(objname2).style.display = "none";
		}
	}
	
	function copynote(val,objname) {
		document.getElementById(objname).innerHTML=val;
	}
	
	function get_tabledata() 
	{
	  	var table, rows, i, x, y;
		//$("#senarai_penyata").empty();
		$("#select_list_dokumen").empty();
		$("#lab_senaraidok").hide();
		$("#select_list_dokumen").hide();
	  	table = document.getElementById("senarai_penyata");
		rows = table.rows;
		for (i = 1; i < rows.length; i++) {
		  	x = rows[i].getElementsByTagName("TD")[0];
		  	y = rows[i].getElementsByTagName("TD")[3];
		  	$('#dok_gambar').attr('src', "{{ asset('storage/dokumen_kewangan') }}"+"/"+ y.innerHTML);
		  	$('#modal_view_dokumen_kewangan').modal('show');
		}
	}
	
	function get_tabledata2() 
	{
	  	var table, rows, i, a, aa, bb, cc, dd, ee;
		var bil=0;
		$("#select_list_dokumen").empty();
		$("#lab_senaraidok").show();
		$("#select_list_dokumen").show();
	  	table = document.getElementById("senarai_dokumen");
		rows = table.rows;
		for (i = 1; i < rows.length; i++) {
			a = rows[i].getElementsByTagName("TD")[0]; //id
		  	aa = rows[i].getElementsByTagName("TD")[2]; // butiran
		  	bb = rows[i].getElementsByTagName("TD")[3]; //filename
		  	cc = rows[i].getElementsByTagName("TD")[4]; //no dok
		  	dd = rows[i].getElementsByTagName("TD")[5]; //tarikh dok
		  	if(a != "")
		  	{
				bil = bil + 1;
				var optText = aa.innerHTML +"/"+ cc.innerHTML + "/" + dd.innerHTML;
				var optValue = a.innerHTML;
				$('#select_list_dokumen').append('<option value="'+optValue+'">'+optText+'</option>');
				$('#dok_gambar').attr('src', "{{ asset('storage/dokumen_kewangan') }}"+"/"+bb.innerHTML);
				$('#modal_view_dokumen_kewangan').modal('show');
			}
		}
	}
	
	function tukar_imej(p_id)
	{
		var table, rows, i, a, aa, bb, cc, dd, ee;
		var bil=0;
	  	table = document.getElementById("senarai_dokumen");
		rows = table.rows;
		for (i = 1; i < rows.length; i++) {
			a = rows[i].getElementsByTagName("TD")[0]; //id
		  	aa = rows[i].getElementsByTagName("TD")[2]; // butiran
		  	bb = rows[i].getElementsByTagName("TD")[3]; //filename
		  	cc = rows[i].getElementsByTagName("TD")[4]; //no dok
		  	dd = rows[i].getElementsByTagName("TD")[5]; //tarikh dok
			if(a.innerHTML == p_id)
			{
				$('#dok_gambar').attr('src', "{{ asset('storage/dokumen_kewangan') }}"+"/"+ bb.innerHTML);
			}
		}
	}
	
	function lihat(p_jenis,p_id)
	{
		if(p_jenis == 1)
		{
			var bulan = document.getElementById("lkr_bulan").value;
			var tahun = document.getElementById("lkr_tahun").value;
			var krt = document.getElementById("prkpd_krt_id").value;
			$('#senarai_penyata').dataTable().fnClearTable();
    		$('#senarai_penyata').dataTable().fnDestroy();
			var senarai_penyata = $('#senarai_penyata').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
						url: "{{ route('rt-sm7.get_senarai_penyata') }}",
						data:function(d){
							d.bulan=bulan;
							d.tahun=tahun;
							d.krt_id=krt;
						} 
					},
				"bSort": false,
				responsive: true,
				"info": false,
				"bFilter": false,
				paging: false,
				dom: 'rtip',
				"aoColumnDefs":[{          
					"aTargets": [ 0 ], 
					sClass: 'text-center',
					"mRender": function (value, type, full)  {
						return  full.krt_profile_id;
					}
				},{			
					"aTargets": [ 1 ], 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.bulan;
					}
				},{			
					"aTargets": [ 2 ], 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.tahun;
					}
				},{			
					"aTargets": [ 3 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.fail;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
					get_tabledata();
						//$('#dok_gambar').attr('src', "{{ asset('storage/dokumen_kewangan') }}"+"/"+ full.fail);
						//$('#modal_view_dokumen_kewangan').modal('show');
				}
			}).ajax.reload();
		}else //jenis=2
		{
			var krt = document.getElementById("prkpd_krt_id").value;
			$('#senarai_dokumen').dataTable().fnClearTable();
    		$('#senarai_dokumen').dataTable().fnDestroy();
			senarai_dokumen = $('#senarai_dokumen').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
						url: "{{ route('rt-sm7.get_senarai_dokumen') }}",
						data:function(d){
							d.krt=krt;
							d.kew_id=p_id;
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
				"bSort": false,
				responsive: true,
				"info": false,
				"bFilter": false,
				paging: false,
				dom: 'rtip',
				"aoColumnDefs":[{          
					"aTargets": [ 0 ], 
					sClass: 'text-center',
					"mRender": function (value, type, full)  {
						return  full.id;
					}
				},{			
					"aTargets": [ 1 ], 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.jenis;
					}
				},{			
					"aTargets": [ 2 ], 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.butiran;
					}
				},{			
					"aTargets": [ 3 ], 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.fail_dokumen;
					}
				},{			
					"aTargets": [ 4 ], 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.no_dokumen;
					}
				},{			
					"aTargets": [ 5 ], 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.tarikh_dokumen;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
					get_tabledata2();
						//$('#dok_gambar').attr('src', "{{ asset('storage/dokumen_kewangan') }}"+"/"+ full.fail);
						//$('#modal_view_dokumen_kewangan').modal('show');
				}
			}).ajax.reload();
		}
	}
	
	function lihat3(p_jenis,id){
		if(p_jenis == 1)
		{
			var var_fname;
			var_fname=document.getElementById("disp_penyata").innerHTML;
			$('#dok_jenis').val("Penyata Bank");
			$('#dok_gambar').attr('src', "{{ asset('storage/dokumen_kewangan') }}"+"/"+ var_fname);
			$('#modal_view_dokumen').modal('show');
		}else
		{
			$('#list_dokumen').dataTable().fnClearTable();
    		$('#list_dokumen').dataTable().fnDestroy();
			senarai_dokumen = $('#list_dokumen').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
						url: "{{ route('rt-sm7.modal_senarai_dokumen') }}",
						data:function(d){
							d.kew_id=bil;
						} 
					},
				"bSort": false,
				responsive: true,
				"info": false,
				"bFilter": false,
				paging: false,
				dom: 'rtip',
				"aoColumnDefs":[{          
					"aTargets": [ 0 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function (value, type, full)  {
						return  full.id;
					}
				},{			
					"aTargets": [ 1 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.jenis;
					}
				},{			
					"aTargets": [ 2 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.butiran;
					}
				},{			
					"aTargets": [ 3 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.fail_dokumen;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
					get_list_dokumen();
					$('#modal_view_dokumen').modal('show');
				}
			}).ajax.reload();
		}
	}
	
    $(document).ready( function () {
			
			var senarai_penyata = $('#senarai_penyata').DataTable({
				"bPaginate": false,
				"bSort": false,
				responsive: true,
				"info": false,
				"bFilter": false,
				paging: false,
				"info": false,
				dom: 'rtip',
				"columns": [
					{ "width": "5%", className: "text-center" },
					{ "width": "10%", className: "text-center" },
					{ "width": "25%" },
					{ "width": "7%", className: "text-right" },
				]
			});
			
			var senarai_dokumen = $('#senarai_dokumen').DataTable({
				"bPaginate": false,
				"bSort": false,
				responsive: true,
				"info": false,
				"bFilter": false,
				paging: false,
				"info": false,
				dom: 'rtip',
				"columns": [
					{ "width": "5%", className: "text-center" },
					{ "width": "10%", className: "text-center" },
					{ "width": "25%" },
					{ "width": "7%", className: "text-right" },
					{ "width": "7%", className: "text-right" },
					{ "width": "7%", className: "text-right" },
				]
			});
			
			$.fn.get_krt_kewangan = function() {
				var form_data = new FormData(form_mag);
				form_data.append("prkpd_krt_id",$("#prkpd_krt_id").val());
				form_data.append("lkr_bulan",  $("#lkr_bulan").val());
				form_data.append("lkr_tahun", $("#lkr_tahun").val());
				//form_data.append("mag_id", $("#mag_id").val() );
				console.log(form_data);
				url = "{{ route('rt-sm7.get_krt_kewangan') }}";
				type = "POST";
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
						if(response.success)
						{	
							var idx=1;
							$.each(response.success, function(index, data){
								//alert(idx+"-"+index);
								if(idx == 2)
									$("#disp_nama_krt").html(data);
								if(idx == 3)
									$("#disp_alamat_krt").html(data);
								if(idx == 4)
									$("#disp_nama_bank").html(data); 
								if(idx == 5)
									$("#disp_acc_bank").html(data);
								if(idx == 6)
								{
									$("#disp_penyata").html(data);
									if(data == "tiada")
									{
										$('#divpenyata').hide();
									}else
									{
										$('#divpenyata').show();
									}
								}
								if(idx == 7)
									$("#disp_evendor").html(data);
									
								idx = idx + 1;
							});
						}
				});
				var table = $('#senarai_kewangan_rt_table4').DataTable();
				var rowtab= table.rows().count();
				if($('#prkpd_krt_id').val() == "" || $('#prkpd_krt_id').val() == null)
				{
					$('#divlabel').hide();
					$('#divtindakan').hide();
				}else
				{
					$('#divlabel').show();
					if(rowtab > 0)
					{
						$('#divtindakan').show();
					}else
					{
						$('#divtindakan').hide();
					}
				}
			};
			
			$.fn.copy_table = function() { 
				$.each($("#senarai_trx tr"),function(index){
					if(index>0)
					{
						var self=$(this).closest("tr");
						var member_0_value = self.find("td:eq(0)").text().trim(); //tarikhmasa
						var member_1_value = self.find("td:eq(1)").text().trim(); //id
						var member_2_value = self.find("td:eq(2)").text().trim(); //tarikh
						var member_3_value = self.find("td:eq(3)").text().trim(); //masa
						var member_4_value = self.find("td:eq(4)").text().trim(); //jenis
						var member_5_value = self.find("td:eq(5)").text().trim(); //butiran
						var member_6_value = self.find("td:eq(6)").text().trim(); //nama
						var member_7_value = self.find("td:eq(7)").text().trim(); //alamat
						var member_8_value = self.find("td:eq(8)").text().trim(); //jumlah_bank
						var member_9_value = self.find("td:eq(9)").text().trim(); //baki bank
						var member_10_value = self.find("td:eq(10)").text().trim(); //jumlah_tunai
						var member_11_value = self.find("td:eq(11)").text().trim(); //baki tunai
						var member_12_value = self.find("td:eq(12)").text().trim(); //status_desc
						var member_13_value = self.find("td:eq(13)").text().trim(); //no_cek
						var member_14_value = self.find("td:eq(14)").text().trim(); //tarikh_cek
						var member_15_value = self.find("td:eq(15)").text().trim(); //no_cek
						var member_16_value = self.find("td:eq(16)").text().trim(); //tarikh_cek
						var member_17_value = self.find("td:eq(17)").text().trim(); //no_cek
						var member_18_value = self.find("td:eq(18)").text().trim(); //tarikh_cek
						var member_1_newvalue = "<b>" + member_5_value + "</b><br>Nama Penuh: "+ member_6_value + "<br>Alamat: "+ member_7_value;
						if(member_13_value.length > 0)
						{
							member_1_newvalue = member_1_newvalue +"<br>No. Cek: "+member_13_value + "("+ member_14_value + ")";
						}
						if(member_15_value.length > 0)
						{
							member_1_newvalue = member_1_newvalue +"<br>No. Baucer: "+member_15_value + "("+ member_16_value + ")";
						}
						if(member_17_value.length > 0)
						{
							member_1_newvalue = member_1_newvalue +"<br>No. Resit: "+member_17_value + "("+ member_18_value + ")";
						}
						member_1_newvalue = member_1_newvalue +"<br><br><input type='button' value='Lihat Dokumen' onclick=\"lihat(2,"+member_1_value+");\">";
						var terima_tunai = 0;
						var terima_bank=0;
						var bayar_tunai = 0;
						var bayar_bank=0;
						if(member_4_value == 1)
						{
							terima_tunai = member_10_value;
							terima_bank = member_8_value;
							//member_7_newvalue = member_7_newvalue + "<button type='button' class='btn btn-icon' title='Padam Maklumat Kewangan RT' onclick=\"delete_kewangan_rt('"+ member_7_value +"');\"><i class='fa fa-trash-o text-danger'></i></button><br>";
						}else
						{
							bayar_tunai = member_10_value;
							bayar_bank = member_8_value;
						}
						terima_tunai=parseFloat(terima_tunai).toFixed(2);
						terima_bank=parseFloat(terima_bank).toFixed(2);
						bayar_tunai=parseFloat(bayar_tunai).toFixed(2);
						bayar_bank=parseFloat(bayar_bank).toFixed(2);
						member_9_value=parseFloat(member_9_value).toFixed(2);
						member_11_value=parseFloat(member_11_value).toFixed(2);
						var member_5_newvalue = '<input id="statuspilihan'+member_1_value+'" name="statuspilihan'+member_1_value+'" type="radio" value="1" onclick="check(this.value,\'tindakan_'+member_1_value+'\',\'noted_'+member_1_value+'\')"> Sahkan<br><input id="statuspilihan'+member_1_value+'" name="statuspilihan'+member_1_value+'" type="radio" value="2" onclick="check(this.value,\'tindakan_'+member_1_value+'\',\'noted_'+member_1_value+'\')"> Kemaskini<br><textarea class="form-control" rows="3" name="noted_'+member_1_value+'" id="noted_'+member_1_value+'" style="display:none" onkeyup="copynote(this.value,\'notedcopy_'+ member_1_value + '\')"></textarea>';
						var member_6_newvalue = '<div style="display:block;"><label id="tindakan_'+member_1_value+'"></label></div>';
						var member_7_newvalue = '<div style="display:block;"><label>'+member_1_value+'</label></div>';
						var member_8_newvalue = '<div style="display:block;"><label id="notedcopy_'+member_1_value+'"></label></div>';
						if(member_1_value != "")
						{
							if(member_12_value == "Dihantar Untuk Pengesahan")
							{
								//senarai_kewangan_rt_table2.row.add([index,member_1_value,member_2_value,member_3_newvalue,member_4_value,member_5_value,member_6_value,member_7_newvalue]).draw(false);
								//senarai_kewangan_rt_table2.row.add([member_0_value,member_1_newvalue,member_2_newvalue,member_3_newvalue,member_4_newvalue,member_5_newvalue]).draw(false);
								senarai_kewangan_rt_table.row.add([member_1_value,member_6_newvalue,member_8_newvalue]).draw(false);
								senarai_kewangan_rt_table4.row.add([index,member_2_value,member_1_newvalue,terima_tunai,terima_bank,bayar_tunai,bayar_bank,member_11_value,member_9_value,member_5_newvalue]).draw(false);
							}else
							{
								senarai_kewangan_rt_table4.row.add([index,member_2_value,member_1_newvalue,terima_tunai,terima_bank,bayar_tunai,bayar_bank,member_11_value,member_9_value,member_12_value]).draw(false);
							}
						}
					}
				});
			}
			
		$var_bulan=GetParameterValues('bulan');
		$var_tahun=GetParameterValues('tahun');
		$var_krt_id=GetParameterValues('krt_id');
			
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
			$var_bulan = "00";
		}
		if($var_tahun == null || $var_tahun == "")
		{
			//$var_tahun = new Date().getFullYear();
			$var_tahun = "0000";
		}
		$("#lkr_bulan").children("option[value='"+$var_bulan+"']").attr("selected", true);
		$("#lkr_tahun").children("option[value='"+$var_tahun+"']").attr("selected", true);
		$("#prkpd_krt_id").children("option[value='"+$var_krt_id+"']").attr("selected", true);

		//my custom script
		
		var senarai_rekod_kewangan_rt_config = {
			routes: {
				senarai_rekod_kewangan_rt_url: "{{ route('rt-sm7.pengesahan_rekod_kewangan_rt') }}"
			}
		};
		
        //$("#prkpd_krt_id").on( 'change', function () {
            //alert($(this).val());
			//senarai_kewangan_rt_table.search( $(this).val() ).draw();
			//senarai_kewangan_rt_table.search( "2298" ).draw();
        //});
		var senarai_trx = $('#senarai_trx').DataTable({
			processing: true,
        	serverSide: true,
			ajax: {
					url: "{{ route('rt-sm7.pengesahan_rekod_kewangan_rt_trx') }}",
					data:function(d){
						d.bulan=$('#lkr_bulan').val();
						d.tahun=$('#lkr_tahun').val();
						d.krt_id=$('#prkpd_krt_id').val();
						//d.bulan='10';
						//d.tahun='2022';
						//d.krt_id=2298;
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
			paging: false,
				pageLength: 300,
				dom: 'rtip',
				"bFilter": true,
				responsive: true,
				"aoColumnDefs":[{
					"aTargets": [ 0 ],
					"mRender": function (data, type, full, meta)  {
						return  full.tarikh_kewangan;
					}
				},{          
					"aTargets": [ 1 ], 
					"mRender": function ( value, type, full )  {
						return full.id;
					}
				},{          
					"aTargets": [ 2 ], 
					"mRender": function ( value, type, full )  {
						return full.tarikh;
					}
				},{          
					"aTargets": [ 3 ], 
					"mRender": function ( value, type, full )  {
						return full.masa;
					}
				},{          
					"aTargets": [ 4 ], 
					"mRender": function ( value, type, full )  {
						return full.jenis;
					}
				},{                   
					"aTargets": [ 5 ],  
					"mRender": function ( value, type, full )  {
						return full.butiran;
					}
				},{          
					"aTargets": [ 6 ], 
					"mRender": function ( value, type, full )  {
						return full.nama_penuh;
					}
				},{          
					"aTargets": [ 7 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.alamat;
					}
				},{          
					"aTargets": [ 8 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.jumlah_bank;
					}
				},{          
					"aTargets": [ 9 ], 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.baki_bank;
					}
				},{          
					"aTargets": [ 10 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.jumlah_tunai;
					}
				},{          
					"aTargets": [ 11 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.baki_tunai;
					}
				},{          
					"aTargets": [ 12 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.status_desc;
					}
				},{          
					"aTargets": [ 13 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.no_cek;
					}
				},{          
					"aTargets": [ 14 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.tarikh_cek;
					}
				},{          
					"aTargets": [ 15 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.no_baucer;
					}
				},{          
					"aTargets": [ 16 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.tarikh_baucer;
					}
				},{          
					"aTargets": [ 17 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.no_resit;
					}
				},{          
					"aTargets": [ 18 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.tarikh_resit;
					}
				}],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
				sortTable2();
				$.fn.copy_table();
				$.fn.get_krt_kewangan();
            }
		});
		
		var senarai_kewangan_rt_table = $('#senarai_kewangan_rt_table').DataTable({
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
			paging: false,
			dom: 'rtip',
			"columns": [
    			{ "width": "5%" },
    			{ "width": "35%" },
    			{ "width": "15%" },
  			]
		});
		
		var senarai_kewangan_rt_table4 = $('#senarai_kewangan_rt_table4').DataTable({
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
			dom: 'rtip',
			"columns": [
    			{ "width": "5%", className: "text-center" },
    			{ "width": "10%", className: "text-center" },
    			{ "width": "25%" },
				{ "width": "7%", className: "text-right" },
				{ "width": "7%", className: "text-right" },
				{ "width": "7%", className: "text-right" },
				{ "width": "7%", className: "text-right" },
				{ "width": "7%", className: "text-right" },
				{ "width": "7%", className: "text-right" },
				{ "width": "18%", className: "text-left" },
  			]
		});
		
		$("#prkpd_krt_id").on( 'change', function () {
			$('#prolab').show();
			$('#senarai_trx').dataTable().fnClearTable();
    		$('#senarai_trx').dataTable().fnDestroy();
			$('#senarai_kewangan_rt_table4').dataTable().fnClearTable();
			$('#senarai_kewangan_rt_table').dataTable().fnClearTable();
			//$('#senarai_kewangan_rt_table3').dataTable().fnClearTable();
			
			senarai_trx = $('#senarai_trx').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
						url: "{{ route('rt-sm7.pengesahan_rekod_kewangan_rt_trx') }}",
						data:function(d){
							d.bulan=$('#lkr_bulan').val();
							d.tahun=$('#lkr_tahun').val();
							d.krt_id=$('#prkpd_krt_id').val();
							//d.bulan='10';
							//d.tahun='2022';
							//d.krt_id=2298;
						} 
					},
				paging: false,
				pageLength: 300,
				dom: 'rtip',
				"bFilter": true,
				responsive: true,
				"aoColumnDefs":[{
					"aTargets": [ 0 ],
					"mRender": function (data, type, full, meta)  {
						return  full.tarikh_kewangan;
					}
				},{          
					"aTargets": [ 1 ], 
					"mRender": function ( value, type, full )  {
						return full.id;
					}
				},{          
					"aTargets": [ 2 ], 
					"mRender": function ( value, type, full )  {
						return full.tarikh;
					}
				},{          
					"aTargets": [ 3 ], 
					"mRender": function ( value, type, full )  {
						return full.masa;
					}
				},{          
					"aTargets": [ 4 ], 
					"mRender": function ( value, type, full )  {
						return full.jenis;
					}
				},{                   
					"aTargets": [ 5 ],  
					"mRender": function ( value, type, full )  {
						return full.butiran;
					}
				},{          
					"aTargets": [ 6 ], 
					"mRender": function ( value, type, full )  {
						return full.nama_penuh;
					}
				},{          
					"aTargets": [ 7 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.alamat;
					}
				},{          
					"aTargets": [ 8 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.jumlah_bank;
					}
				},{          
					"aTargets": [ 9 ], 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.baki_bank;
					}
				},{          
					"aTargets": [ 10 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.jumlah_tunai;
					}
				},{          
					"aTargets": [ 11 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.baki_tunai;
					}
				},{          
					"aTargets": [ 12 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.status_desc;
					}
				},{          
					"aTargets": [ 13 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.no_cek;
					}
				},{          
					"aTargets": [ 14 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.tarikh_cek;
					}
				},{          
					"aTargets": [ 15 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.no_baucer;
					}
				},{          
					"aTargets": [ 16 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.tarikh_baucer;
					}
				},{          
					"aTargets": [ 17 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.no_resit;
					}
				},{          
					"aTargets": [ 18 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.tarikh_resit;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
					sortTable2();
					$.fn.copy_table();
					$.fn.get_krt_kewangan();
					$('#prolab').hide();
				}
			}).ajax.reload(); 
		});
		
		$("#lkr_bulan").on( 'change', function () {
			$('#prolab').show();
			$('#senarai_trx').dataTable().fnClearTable();
    		$('#senarai_trx').dataTable().fnDestroy();
			$('#senarai_kewangan_rt_table4').dataTable().fnClearTable();
			$('#senarai_kewangan_rt_table').dataTable().fnClearTable();
			
			senarai_trx = $('#senarai_trx').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
						url: "{{ route('rt-sm7.pengesahan_rekod_kewangan_rt_trx') }}",
						data:function(d){
							d.bulan=$('#lkr_bulan').val();
							d.tahun=$('#lkr_tahun').val();
							d.krt_id=$('#prkpd_krt_id').val();
							//d.bulan='10';
							//d.tahun='2022';
							//d.krt_id=2298;
						} 
					},
				paging: false,
				pageLength: 300,
				dom: 'rtip',
				"bFilter": true,
				responsive: true,
				"aoColumnDefs":[{
					"aTargets": [ 0 ],
					"mRender": function (data, type, full, meta)  {
						return  full.tarikh_kewangan;
					}
				},{          
					"aTargets": [ 1 ], 
					"mRender": function ( value, type, full )  {
						return full.id;
					}
				},{          
					"aTargets": [ 2 ], 
					"mRender": function ( value, type, full )  {
						return full.tarikh;
					}
				},{          
					"aTargets": [ 3 ], 
					"mRender": function ( value, type, full )  {
						return full.masa;
					}
				},{          
					"aTargets": [ 4 ], 
					"mRender": function ( value, type, full )  {
						return full.jenis;
					}
				},{                   
					"aTargets": [ 5 ],  
					"mRender": function ( value, type, full )  {
						return full.butiran;
					}
				},{          
					"aTargets": [ 6 ], 
					"mRender": function ( value, type, full )  {
						return full.nama_penuh;
					}
				},{          
					"aTargets": [ 7 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.alamat;
					}
				},{          
					"aTargets": [ 8 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.jumlah_bank;
					}
				},{          
					"aTargets": [ 9 ], 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.baki_bank;
					}
				},{          
					"aTargets": [ 10 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.jumlah_tunai;
					}
				},{          
					"aTargets": [ 11 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.baki_tunai;
					}
				},{          
					"aTargets": [ 12 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.status_desc;
					}
				},{          
					"aTargets": [ 13 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.no_cek;
					}
				},{          
					"aTargets": [ 14 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.tarikh_cek;
					}
				},{          
					"aTargets": [ 15 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.no_baucer;
					}
				},{          
					"aTargets": [ 16 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.tarikh_baucer;
					}
				},{          
					"aTargets": [ 17 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.no_resit;
					}
				},{          
					"aTargets": [ 18 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.tarikh_resit;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
					sortTable2();
					$.fn.copy_table();
					$.fn.get_krt_kewangan();
					$('#prolab').hide();
				}
			}).ajax.reload(); 
		});
		
		$("#lkr_tahun").on( 'change', function () {
			$('#prolab').show();
			$('#senarai_trx').dataTable().fnClearTable();
    		$('#senarai_trx').dataTable().fnDestroy();
			$('#senarai_kewangan_rt_table4').dataTable().fnClearTable();
			$('#senarai_kewangan_rt_table').dataTable().fnClearTable();
			
			var senarai_trx = $('#senarai_trx').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
						url: "{{ route('rt-sm7.pengesahan_rekod_kewangan_rt_trx') }}",
						data:function(d){
							d.bulan=$('#lkr_bulan').val();
							d.tahun=$('#lkr_tahun').val();
							d.krt_id=$('#prkpd_krt_id').val();
							//d.bulan='10';
							//d.tahun='2022';
							//d.krt_id=2298;
						} 
					},
				"bSort": false,
				responsive: true,
				"info": false,
				"bFilter": false,
				paging: false,
				dom: 'rtip',
				"aoColumnDefs":[{          
					"aTargets": [ 0 ], 
					"mRender": function (value, type, full)  {
						return  full.tarikh_kewangan;
					}
				},{          
					"aTargets": [ 1 ], 
					"mRender": function ( value, type, full )  {
						return full.id;
					}
				},{                
					"aTargets": [ 2 ], 
					"mRender": function ( value, type, full )  {
						return full.tarikh;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.masa;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.jenis;
					}
				},{          
					"aTargets": [ 5 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.butiran;
					}
				},{          
					"aTargets": [ 6 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.nama_penuh;
					}
				},{          
					"aTargets": [ 7 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.alamat;
					}
				},{          
					"aTargets": [ 8 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.jumlah_bank;
					}    
				},{          
					"aTargets": [ 9 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.baki_bank;
					}
				},{          
					"aTargets": [ 10 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.jumlah_tunai;
					} 
				},{          
					"aTargets": [ 11 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.baki_tunai;
					}
				},{  
					"aTargets": [ 12 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.status_desc;
					}
				},{          
					"aTargets": [ 13 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.no_cek;
					}
				},{          
					"aTargets": [ 14 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.tarikh_cek;
					}
				},{          
					"aTargets": [ 15 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.no_baucer;
					}
				},{          
					"aTargets": [ 16 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.tarikh_baucer;
					}
				},{          
					"aTargets": [ 17 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.no_resit;
					}
				},{          
					"aTargets": [ 18 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.tarikh_resit;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
					sortTable2();
					$.fn.copy_table();
					$.fn.get_krt_kewangan();
					$('#prolab').hide();
				}
			}).ajax.reload(); 
		});
		
		$("#btn_submit").click(function(){
			var ada_update="no";
			$.each($("#senarai_kewangan_rt_table tr"),function(index){
				if(index>0)
				{
					var self=$(this).closest("tr");
					var member_0_value = self.find("td:eq(0)").text().trim();
					var member_1_value = self.find("td:eq(1)").text().trim();
					var member_2_value = self.find("td:eq(2)").text().trim();
					if(member_0_value != "" && member_1_value != "")
					{
						$("#mag_kew_id").val(member_0_value);
						if(member_1_value == 1)
						{
							$("#mag_kew_status").val(1)
						}else
						{
							if(member_1_value == 2)
							{
								$("#mag_kew_status").val(4)
								$("#mag_kew_noted").val(member_2_value);
							}
						}
						if(member_1_value == 1 || member_1_value == 2)
						{
							var form_data = new FormData(form_mag);
							form_data.append("mag_kew_id",$("#mag_kew_id").val());
							form_data.append("mag_kew_status",$("#mag_kew_status").val());
							form_data.append("mag_kew_noted",$("#mag_kew_noted").val());
							console.log(form_data);
							url = "{{ route('rt-sm7.post_ppdsah_rekod_kewangan_rt') }}";
							type = "POST";	
							$.ajax({
								url: url,
								type: type,
								data: form_data,
								contentType: false,
								processData: false,
								async: false,
							}).done(function(response) {  	
								$("#mag_kew_id").val("");
								ada_update = "ada";
								swal("Maklumat Kewangan dikemaskini!", "Rekod dikemaskini di dalam pangkalan data", "success");
							});
						}
					}
				}
			});
			if(ada_update == "ada")
			{
				$("#lkr_bulan").change();
			}
		});
	});
	
    function pengesahan_rekod_kewangan_rt(id){
        window.location.href = "{{ route('rt-sm7.pengesahan_rekod_kewangan_rt_1','') }}"+"/"+id;
    }
	
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop