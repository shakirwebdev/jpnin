@include('js.modal.j-modal-view-dokumen')
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	function sortTable() {
		alert("dddddd");
	  var table, rows, switching, i, x, y, shouldSwitch;
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
		  x = rows[i].getElementsByTagName("TD")[7];
		  y = rows[i + 1].getElementsByTagName("TD")[7];
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
	
	function kira_baki() {
	  	var table, rows, i, idx, td_idx;
	  	table = document.getElementById("senarai_kewangan_rt_table");
		rows = table.rows;
		baki_tunai_sblm = 0;
		baki_bank_sblm = 0;
		idx = 1;
		for (i = 1; i < (rows.length-1); i++) {
	      td_idx = rows[i].getElementsByTagName("TD")[0];
		  td_idx.innerHTML = idx;
		  idx = idx + 1;
		}
	}
	
	function lihat_kewangan_rt(id)
	{
		window.location.href = "{{ route('rt-sm7.lihatsemakan_rekod_kewangan_rt_1','') }}"+"/"+id;
	}
	
    $(document).ready( function () {
			
			$.fn.check_display = function() {
				var ada=0, semakada=0;
				if($("#mag_id").val() == 0 )
				{
					$("#lihat_dokumen").attr("style", "display:none");
				}else
				{
					$("#lihat_dokumen").attr("style", "display:block");
				}
				$.each($("#senarai_kewangan_rt_table tr"),function(index){
					if(index>0)
					{
						var self=$(this).closest("tr");
						var member_1_value = self.find("td:eq(1)").text().trim();
						if(member_1_value!="")
						{
							ada=1;
							return false;
						}else
						{
							return false;
						}
					}
				});

				if($("#carian_bulan").val() != "00" && $("#carian_tahun").val() != "0000")
				{
					$("#divpenyata").show();
				}else
				{
					$("#divpenyata").hide();
				}
		
				if(ada==0)
				{
					$("#div_tindakan").attr("style", "display:none");
				}else
				{
					$.each($("#senarai_kewangan_rt_table tr"),function(index){
						if(index>0)
						{
							var self=$(this).closest("tr");
							var member_1_value = self.find("td:eq(1)").text().trim();
							var member_6_value = self.find("td:eq(6)").text().trim();
							if(member_6_value=="Dihantar Untuk Semakan")
							{
								semakada=1;
								return false;
							}
						}
					});
					if(semakada == 0)
					{
						$.each($("#senarai_kewangan_rt_table tr"),function(index){
							if(index>0)
							{
								var self=$(this).closest("tr");
								var member_1_value = self.find("td:eq(1)").text().trim();
								var member_6_value = self.find("td:eq(6)").text().trim();
								if(member_6_value=="Disemak")
								{
									semakada=1;
									return false;
								}
							}
						});
						if(semakada == 1)
						{
							$("#div_tindakan").attr("style", "display:block");
						}else
						{
							$("#div_tindakan").attr("style", "display:none");
						}
					}else
					{
						$("#div_tindakan").attr("style", "display:none");
					}
				}
			};
			
			$.fn.get_penyata = function() {
				var form_data = new FormData(form_mag);
				form_data.append("carian_bulan",$("#carian_bulan").val());
				form_data.append("carian_tahun",$("#carian_tahun").val());
				//form_data.append("mag_file_dokumen",  $("#mag_file_dokumen")[0].files[0]);
				//form_data.append("mag_krt_id", $("#mag_krt_id").val() );
				//form_data.append("mag_id", $("#mag_id").val() );
				console.log(form_data);
				url = "{{ route('rt-sm7.get_penyata') }}";
				type = "POST";
				$.ajax({
					url: url,
					type: type,
					data: form_data,
					contentType: false,
					processData: false,
					async: false,
				}).done(function(response) {   
						if(response.success)
						{	
							$.each(response.success, function(index, data){
								if(index == "id")
								{
									$('#mag_id').val(data);
								}
								if(index == "fail_penyata")
								{
									$('#mag_filename').val(data);
								}
							});
						}
					});
			};

	   		$.fn.copy_table = function() { 
				$.each($("#senarai_kewangan_rt_table tr"),function(index){
					if(index>0)
					{
						var self=$(this).closest("tr");
						var member_0_value = self.find("td:eq(0)").text().trim(); //bil
						var member_1_value = self.find("td:eq(1)").text().trim(); //butiran
						var member_2_value = self.find("td:eq(2)").text().trim(); //tarikh
						var member_3_value = self.find("td:eq(3)").text().trim(); //masa
						var member_4_value = self.find("td:eq(4)").text().trim(); //jenis
						var member_5_value = self.find("td:eq(5)").text().trim(); //status
						var member_6_value = self.find("td:eq(6)").text().trim(); //id
						var member_7_value = self.find("td:eq(7)").text().trim(); //tarikh_kewangan
						var member_8_value = self.find("td:eq(8)").text().trim(); //nama
						var member_9_value = self.find("td:eq(9)").text().trim(); //alamat
						if(member_5_value == "Dihantar Untuk Semakan")
						{
							var member_5_newvalue = "<button type='button' class='btn btn-icon' title='Semakan Kewangan RT' onclick=\"semakan_rekod_kewangan_rt('"+ member_6_value +"');\"><i class='fa fa-edit'></i></button>";
						}else
						{
							var member_5_newvalue = "<button type='button' class='btn btn-icon' title='Lihat Kewangan RT' onclick=\"lihat_kewangan_rt('"+ member_6_value + "');\"><i class='fa fa-search'></i></button>";;
						}
						if(member_2_value != "")
						{
							//var member_1_newvalue = "<label style=\"cursor:pointer;\" onclick=\"view_butiran("+member_8_value+",'"+member_9_value+"');\">"+member_1_value+"<br>Nama: "+.member_8_value+"</label>";
						//var member_7_value = '<button type="button" class="btn btn-icon" title="Kemaskini Kewangan RT" onclick="kemaskini_kewangan_rt(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
							senarai_kewangan_rt_table2.row.add([index,member_2_value+" "+member_3_value,member_4_value,("<b>"+member_1_value+"</b><br><b>Nama:</b>"+member_8_value+"<br><b>Alamat:</b>"+member_9_value),member_5_value,member_5_newvalue]).draw(false);
						}
					}
				});
			} 
    	//my custom script
		var senarai_rekod_kewangan_rt_config = {
			routes: {
				senarai_rekod_kewangan_rt_url: "{{ route('rt-sm7.semakan_rekod_kewangan_rt') }}",
			}
		};
		
		$("#mag_krt_id").val("{{$krt_profile->krt_profile_id}}");	

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
			//$var_tahun = new Date().getFullYear();
			$var_tahun = "0000";
		}
		
		$("#data_bulan").val($var_bulan);
		$("#data_tahun").val($var_tahun);
			
		$("#carian_bulan").children("option[value='"+$var_bulan+"']").attr("selected", true);
		$("#carian_tahun").children("option[value='"+$var_tahun+"']").attr("selected", true);
		
		if($var_bulan == "00")
			$("#penyata_bulan").html("");
		if($var_bulan == "01")
			$("#penyata_bulan").html("bulan Januari-");
		if($var_bulan == "02")
			$("#penyata_bulan").html("bulan Februari-");
		if($var_bulan == "03")
			$("#penyata_bulan").html("bulan Mac-");
		if($var_bulan == "04")
			$("#penyata_bulan").html("bulan April-");
		if($var_bulan == "05")
			$("#penyata_bulan").html("bulan Mei-");
		if($var_bulan == "06")
			$("#penyata_bulan").html("bulan Jun-");
		if($var_bulan == "07")
			$("#penyata_bulan").html("bulan Julai-");
		if($var_bulan == "08")
			$("#penyata_bulan").html("bulan Ogos-");
		if($var_bulan == "09")
			$("#penyata_bulan").html("bulan September-");
		if($var_bulan == "10")
			$("#penyata_bulan").html("bulan Oktober-");
		if($var_bulan == "11")
			$("#penyata_bulan").html("bulan November-");
		if($var_bulan == "12")
			$("#penyata_bulan").html("bulan Disember-");
		
		if($var_tahun == "0000")
			$("#penyata_tahun").html("");
		else
			$("#penyata_tahun").html($var_tahun);
			
		if($var_tahun == "0000" && $var_bulan == "00")
			$("#lab_bagi").hide();
		else
			$("#lab_bagi").show();
		
		var senarai_kewangan_rt_table = $('#senarai_kewangan_rt_table').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {
				url: senarai_rekod_kewangan_rt_config.routes.senarai_rekod_kewangan_rt_url,
				data:{
					bulan: $var_bulan,
					tahun: $var_tahun,
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
					},
			},
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
			pageLength: 300,
			dom: 'rtip',
			"bFilter": true,
			responsive: true,
			"aoColumnDefs":[{
				"aTargets": [ 0 ],
				"width": "5%",
				"mRender": function (data, type, full, meta)  {
					return  meta.row+1;
				}
			},{          
                "aTargets": [ 1 ], 
                "width": "18%", 
                "mRender": function ( value, type, full )  {
                    return full.kewangan_butiran;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.tarikh_t_b;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.masa_t_b;
                }
            },{                   
                "aTargets": [ 4 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.kewangan_jenis;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "18%", 
                "mRender": function ( value, type, full )  {
					return full.status_kewangan_description;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "5%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.id;
                }
			},{          
                "aTargets": [ 7 ], 
                "width": "5%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.tarikh_kewangan;
                }
			},{          
				"aTargets": [ 8 ], 
				"width": "5%", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.nama_penuh;
				}
			},{          
				"aTargets": [ 9], 
				"width": "5%", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.alamat;
				}
            }],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
				sortTable();
				//kira_baki();
				$.fn.copy_table();
				$.fn.get_penyata();
				$.fn.check_display();
				//$.fn.setcookie();
				//$.fn.getcookie();
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
    			{ "width": "5%",sClass: 'text-center',},
    			{ "width": "14%" },
    			{ "width": "10%",sClass: 'text-center', },
				{ "width": "45%" },
				{ "width": "16%",sClass: 'text-center', },
				{ "width": "10%",sClass: 'text-center', },
  			]
		});
    });

	function semakan_rekod_kewangan_rt(id){
        window.location.href = "{{ route('rt-sm7.semakan_rekod_kewangan_rt_1','') }}"+"/"+id+"?bulan="+$("#carian_bulan").val()+"&tahun="+$("#carian_tahun").val();
    }
	
	$("#carian_bulan").on( 'change', function () {
			$('#senarai_kewangan_rt_table').dataTable().fnClearTable();
    		$('#senarai_kewangan_rt_table').dataTable().fnDestroy();
			$('#senarai_kewangan_rt_table2').dataTable().fnClearTable();
			$v_bulan = $("#carian_bulan").val();
			$v_tahun = $("#carian_tahun").val();
			senarai_kewangan_rt_table = $('#senarai_kewangan_rt_table').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {
				url: senarai_rekod_kewangan_rt_config.routes.senarai_rekod_kewangan_rt_url,
				data:{
						bulan: $v_bulan,
						tahun: $v_tahun,
					 },
				error:function(x,e) {
						if (x.status==0) {
							alert('You are offline!!\n Please Check Your Network.');
						} else if(x.status==404) {
							alert('Requested URL not found.');
						} else if(x.status==500) {
							alert('Internel Server Error.');
						} else if(e=='parsererror') {
							alert('Error.\nParsing JSON Request failed.');
						} else if(e=='timeout'){
							alert('Request Time out.');
						} else {
							alert('Unknow Error.\n'+x.responseText);
						}
					},
			},
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
			pageLength: 300,
			dom: 'rtip',
			"bFilter": true,
			responsive: true,
			"aoColumnDefs":[{
				"aTargets": [ 0 ],
				"width": "5%",
				"mRender": function (data, type, full, meta)  {
					return  meta.row+1;
				}
			},{          
                "aTargets": [ 1 ], 
                "width": "18%", 
                "mRender": function ( value, type, full )  {
                    return full.kewangan_butiran;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.tarikh_t_b;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.masa_t_b;
                }
            },{                   
                "aTargets": [ 4 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.kewangan_jenis;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "18%", 
                "mRender": function ( value, type, full )  {
					return full.status_kewangan_description;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "5%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.id;
                }
			},{          
                "aTargets": [ 7 ], 
                "width": "5%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.tarikh_kewangan;
                }
			},{          
				"aTargets": [ 8 ], 
				"width": "5%", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.nama_penuh;
				}
			},{          
				"aTargets": [ 9], 
				"width": "5%", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.alamat;
				}
            }],
				"order": [[ 8, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
					sortTable();
					//kira_baki();
					$.fn.copy_table();
					$.fn.get_penyata();
					$.fn.check_display();
				}
			}); 
        });
	
	$("#carian_tahun").on( 'change', function () {
		$("#mag_id").val("0");
		$("#mag_filename").val("");
		$var_bulan = $("#carian_bulan").val();
		$var_tahun = $("#carian_tahun").val();
		$("#data_bulan").val($var_bulan);
		$("#data_tahun").val($var_tahun);
		$("#carian_bulan").children("option[value='"+$var_bulan+"']").attr("selected", true);
		$("#carian_tahun").children("option[value='"+$var_tahun+"']").attr("selected", true);
		if($var_bulan == "01")
			$("#penyata_bulan").html("Januari");
		if($var_bulan == "02")
			$("#penyata_bulan").html("Februari");
		if($var_bulan == "03")
			$("#penyata_bulan").html("Mac");
		if($var_bulan == "04")
			$("#penyata_bulan").html("April");
		if($var_bulan == "05")
			$("#penyata_bulan").html("Mei");
		if($var_bulan == "06")
			$("#penyata_bulan").html("Jun");
		if($var_bulan == "07")
			$("#penyata_bulan").html("Julai");
		if($var_bulan == "08")
			$("#penyata_bulan").html("Ogos");
		if($var_bulan == "09")
			$("#penyata_bulan").html("September");
		if($var_bulan == "10")
			$("#penyata_bulan").html("Oktober");
		if($var_bulan == "11")
			$("#penyata_bulan").html("November");
		if($var_bulan == "12")
			$("#penyata_bulan").html("Disember");
		
		if($var_tahun == "0000")
			$("#penyata_tahun").html("");
		else
			$("#penyata_tahun").html($var_tahun);
			
		if($var_tahun == "0000" && $var_bulan == "00")
			$("#lab_bagi").hide();
		else
			$("#lab_bagi").show();
		
		$senarai_rekod_kewangan_rt_url: "{{ route('rt-sm7.semakan_rekod_kewangan_rt') }}";
		
		//$('#senarai_kewangan_rt_table').DataTable().ajax.reload();
		//senarai_kewangan_rt_table.ajax.reload();
		$('#senarai_kewangan_rt_table').dataTable().fnClearTable();
    	$('#senarai_kewangan_rt_table').dataTable().fnDestroy();
		$('#senarai_kewangan_rt_table2').dataTable().fnClearTable();
		/*$('#senarai_kewangan_rt_table').DataTable({
        	ajax: {
            	url: "{{ route('rt-sm7.semakan_rekod_kewangan_rt') }}",
            	"data":{
					bulan: '02',
					tahun: '2023',
					},
        	},
    	}).ajax.reload(); */
		senarai_kewangan_rt_table = $('#senarai_kewangan_rt_table').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {
				url: senarai_rekod_kewangan_rt_config.routes.senarai_rekod_kewangan_rt_url,
				data:{
					bulan: $var_bulan,
					tahun: $var_tahun,
					},
			},
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
			pageLength: 300,
			dom: 'rtip',
			"bFilter": true,
			responsive: true,
			"aoColumnDefs":[{
				"aTargets": [ 0 ],
				"width": "5%",
				"mRender": function (data, type, full, meta)  {
					return  meta.row+1;
				}
			},{          
                "aTargets": [ 1 ], 
                "width": "18%", 
                "mRender": function ( value, type, full )  {
                    return full.kewangan_butiran;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.tarikh_t_b;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.masa_t_b;
                }
            },{                   
                "aTargets": [ 4 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.kewangan_jenis;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "18%", 
                "mRender": function ( value, type, full )  {
					return full.status_kewangan_description;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "5%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.id;
                }
			},{          
                "aTargets": [ 7 ], 
                "width": "5%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.tarikh_kewangan;
                }
			},{          
				"aTargets": [ 8 ], 
				"width": "5%", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.nama_penuh;
				}
			},{          
				"aTargets": [ 9], 
				"width": "5%", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.alamat;
				}
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
				sortTable();
				//kira_baki();
				$.fn.copy_table();
				$.fn.get_penyata();
				$.fn.check_display();
				$("#cari_kewangan").val("Cari");
            }
	    }).ajax.reload(); 
	});
	
	$("#upload_dokumen").click(function(){
		$("#upload_dokumen").val("Proses.....");
		var form_data = new FormData(form_mag);
		form_data.append("carian_bulan",$("#carian_bulan").val());
		form_data.append("carian_tahun",$("#carian_tahun").val());
		form_data.append("mag_file_dokumen",  $("#mag_file_dokumen")[0].files[0]);
		form_data.append("mag_krt_id", $("#mag_krt_id").val() );
		form_data.append("mag_id", $("#mag_id").val() );
		console.log(form_data);
			/*	for(let [name, value] of form_data) {
  						alert(`${name} = ${value}`); // key1 = value1, then key2 = value2
				}*/
		url = "{{ route('rt-sm7.post_add_penyata') }}";
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
						//alert("after");  
				$('[name=carian_bulan]').removeClass("is-invalid");
				$('[name=carian_tahun]').removeClass("is-invalid");
				$('[name=mag_file_dokumen]').removeClass("is-invalid");      
				if(response.errors)
				{
					$.each(response.errors, function(index, error){
						if(index == 'carian_bulan') {
							$('[name=carian_bulan]').addClass("is-invalid");
							$('.error_carian_bulan').html(error);
						}
						if(index == 'carian_tahun') {
							$('[name=carian_tahun]').addClass("is-invalid");
							$('.error_carian_tahun').html(error);
						}
						if(index == 'mag_file_dokumen') {
							$('[name=mag_file_dokumen]').addClass("is-invalid");
							$('.error_mag_file_dokumen').html(error);
						}
					});
							//alert("error");
				}else
				{	
					//alert("success");
					$.each(response.success, function(index, data){
						//alert(index+"-"+data);
						if(index == "dok_id")
						{
							$('#mag_id').val(data);
						}
						if(index == "filename")
						{
							$('#mag_filename').val(data);
						}
					});
					//$('#mag_file_dokumen').val("");
					swal("Maklumat Penyata Bank ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
				}
				$("#upload_dokumen").val("Muatnaik");
			});
			$.fn.check_display();
	});
	
	function lihat(){
		var var_id,var_fname;
		var_id=document.getElementById("mag_id").value;
		var_fname=document.getElementById("mag_filename").value;
		if(var_id == 0)
		{
			swal("Maklumat Penyata Bank!", "Tiada maklumat di dalam pangkalan data", "success");
		}else
		{
			$('#dok_gambar').attr('src', "{{ asset('storage/dokumen_kewangan') }}"+"/"+ var_fname);
			$('#modal_view_dokumen').modal('show');
			//view_dokumen('P',id);
		}
	}
	
	$("#btn_submit").click(function(){
			var form_data = new FormData(form_mag);
			form_data.append("mag_krt_id",$("#mag_krt_id").val());
			form_data.append("data_bulan",$("#data_bulan").val());
			form_data.append("data_tahun",$("#data_tahun").val());
			form_data.append("srkr_1_semak_noted",$("#srkr_1_semak_noted").val());
			console.log(form_data);
				/*for(let [name, value] of form_data) {
  						alert(`${name} = ${value}`); // key1 = value1, then key2 = value2
				}*/
			url = "{{ route('rt-sm7.post_hantarppd_rekod_kewangan_rt') }}";
			type = "POST";	
			$.ajax({
				url: url,
				type: type,
				data: form_data,
				contentType: false,
				processData: false,
				async: false,
			}).done(function(response) {  
						$('[name=srkr_1_semak_noted]').removeClass("is-invalid");  
						if(response.errors)
						{
							$.each(response.errors, function(index, error){
								if(index == 'srkr_1_semak_noted') {
									$('[name=srkr_1_semak_noted]').addClass("is-invalid");
									$('.error_srkr_1_semak_noted').html(error);
								}
							});
						}else
						{	
							window.location.href = "{{route('rt-sm7.semakan_rekod_kewangan_rt')}}"+"?bulan="+$("#data_bulan").val()+"&tahun="+$("#data_tahun").val();
						}
			});
	});
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop