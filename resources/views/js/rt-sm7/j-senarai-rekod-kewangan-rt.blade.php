@include('js.modal.j-modal-view-butiran')
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	function sortTable() {
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
	
	function kira_baki() {
	  	var table, rows, i, idx, td_idx;
	  	table = document.getElementById("senarai_kewangan_rt_table");
		rows = table.rows;
		baki_tunai_sblm = 0;
		baki_bank_sblm = 0;
		idx = 1;
		for (i = 1; i < (rows.length); i++) {
	      td_idx = rows[i].getElementsByTagName("TD")[0];
		  td_idx.innerHTML = idx;
		  idx = idx + 1;
		}
	}
	
	function kemaskini_kewangan_rt(id,act)
	{
		if(act == 'E')
			window.location.href = "{{ route('rt-sm7.kemaskini_rekod_kewangan_rt_1','') }}"+"/"+id;
		else
			window.location.href = "{{ route('rt-sm7.lihat_rekod_kewangan_rt_1','') }}"+"/"+id;
	}
	
	function delete_kewangan_rt(id)
	{
		url_delete_kewangan = "{{ route('rt-sm7.delete_kewangan','') }}";
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
					url: url_delete_kewangan +"/" + id,
					success: function (data) {
								//$("#senarai_kewangan_rt_table").DataTable().ajax.reload();
								//var table = $('#senarai_kewangan_rt_table2').DataTable();
								//clear datatable
								//table.clear().draw();
								//destroy datatable
								//table.destroy();
								//$.fn.copy_table();
								swal("Sudah dipadam!", "Rekod kewangan telah dipadam dari pangkalan data", "success");
								location.reload();
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
	
    $(document).ready( function () {
     
	 	/*function kemaskini_kewangan_rt(id){
			alert($id);
        //window.location.href = "{{ route('rt-sm7.kemaskini_rekod_kewangan_rt_1','') }}"+"/"+id;
    	} */  
		
		$.fn.copy_table = function() 
		{ 
			$.each($("#senarai_kewangan_rt_table tr"),function(index)
			{
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
					if(member_2_value != "")
					{
						var terima_tunai = 0;
						var terima_bank = 0;
						var bayar_tunai = 0;
						var bayar_bank = 0;
						if(member_4_value == 1)
						{
							terima_tunai = member_10_value;
							terima_bank = member_8_value;
						}else
						{
							bayar_tunai = member_10_value;
							bayar_bank = member_8_value;
						}
						if(member_12_value == "Perlu Dikemaskini")
						{
							var member_13_newvalue = "<button type='button' class='btn btn-icon' title='Kemaskini Kewangan RT' onclick=\"kemaskini_kewangan_rt('"+ member_1_value + "','E');\"><i class='fa fa-edit'></i></button>";
							member_13_newvalue = member_13_newvalue + "<button type='button' class='btn btn-icon' title='Padam Maklumat Kewangan RT' onclick=\"delete_kewangan_rt('"+ member_1_value +"');\"><i class='fa fa-trash-o text-danger'></i></button><br>";
						}else
						{
							var member_13_newvalue = "<button type='button' class='btn btn-icon' title='Lihat Kewangan RT' onclick=\"kemaskini_kewangan_rt('"+ member_1_value + "','L');\"><i class='fa fa-search'></i></button>";;
						}
						//var member_1_newvalue = "<label style=\"cursor:pointer;\" onclick=\"view_butiran("+member_8_value+",'"+member_9_value+"');\">"+member_1_value+"<br>Nama: "+.member_8_value+"</label>";
					//var member_7_value = '<button type="button" class="btn btn-icon" title="Kemaskini Kewangan RT" onclick="kemaskini_kewangan_rt(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
						senarai_kewangan_rt_table2.row.add([index,member_2_value,("<b>"+member_5_value+"</b><br><b>Nama:</b>"+member_6_value),parseFloat(terima_tunai).toFixed(2),parseFloat(terima_bank).toFixed(2),parseFloat(bayar_tunai).toFixed(2),parseFloat(bayar_bank).toFixed(2),parseFloat(member_11_value).toFixed(2),parseFloat(member_9_value).toFixed(2),member_12_value,member_13_newvalue]).draw(false);
					}
				}
			});
		}
		
    	//my custom script
		var senarai_rekod_kewangan_rt_config = {
			routes: {
				senarai_rekod_kewangan_rt_url: "/rt/sm7/senarai-rekod-kewangan-rt"
			}
		};

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
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
					sortTable();
					//kira_baki();
					$.fn.copy_table();
				}
			}).ajax.reload(); 
        });
		
		$("#carian_tahun").on( 'change', function () {
			//senarai_kewangan_rt_table.search( carian_data ).draw();
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
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
					sortTable();
					//kira_baki();
					$.fn.copy_table();
				}
			}).ajax.reload(); 
		});
		
		$v_bulan = $("#carian_bulan").val();
		$v_tahun = $("#carian_tahun").val();
		var senarai_kewangan_rt_table = $('#senarai_kewangan_rt_table').DataTable( {
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
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
				sortTable();
				//kira_baki();
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
    			{ sClass: 'text-center',},
    			{ sClass: 'text-center',},
    			{ sClass: 'text-left',},
				{ sClass: 'text-right',},
				{ sClass: 'text-right',},
				{ sClass: 'text-right',},
				{ sClass: 'text-right',},
    			{ sClass: 'text-right',},
    			{ sClass: 'text-right',},
				{ sClass: 'text-left',},
				{ sClass: 'text-center',},  			
			]
		});
        
    });
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop