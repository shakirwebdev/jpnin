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
		for (i = 2; i < (rows.length - 1); i++) {
		  //start by saying there should be no switching:
		  shouldSwitch = false;
		  /*Get the two elements you want to compare,
		  one from current row and one from the next:*/
		  x = rows[i].getElementsByTagName("TD")[2];
		  y = rows[i + 1].getElementsByTagName("TD")[2];
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
	
	function kira_baki() {
	  	var table, rows, i, idx, td_idx, terima_tunai, terima_bank, bayar_tunai ,bayar_bank, baki_tunai, baki_bank,baki_tunai_sblm, baki_bank_sblm,td_baki_tunai,td_baki_bank;
		var baki_tunai_sblm=parseFloat(document.getElementById("lkr_baki_tunai_awal").value);
		var baki_bank_sblm=parseFloat(document.getElementById("lkr_baki_bank_awal").value);
	  	table = document.getElementById("senarai_kewangan_rt_table");
		rows = table.rows;
		idx = 1;
		for (i = 2; i < (rows.length); i++) {
	      td_idx = rows[i].getElementsByTagName("TD")[0];
		  td_idx.innerHTML = idx;
		  idx = idx + 1;
		  terima_tunai = rows[i].getElementsByTagName("TD")[5];
		  terima_bank = rows[i].getElementsByTagName("TD")[6];
		  bayar_tunai = rows[i].getElementsByTagName("TD")[7];
		  bayar_bank = rows[i].getElementsByTagName("TD")[8];
		  td_baki_tunai = rows[i].getElementsByTagName("TD")[9];
		  td_baki_bank = rows[i].getElementsByTagName("TD")[10];
		  if(i == 2)
		  {
		  	baki_bank = baki_bank_sblm + (parseFloat(terima_bank.innerHTML)) - parseFloat(bayar_bank.innerHTML);
			baki_tunai = baki_tunai_sblm + (parseFloat(terima_tunai.innerHTML)) - parseFloat(bayar_tunai.innerHTML);
		  }else
		  {
			baki_bank = baki_bank + (parseFloat(terima_bank.innerHTML)) - parseFloat(bayar_bank.innerHTML);
			baki_tunai = baki_tunai + (parseFloat(terima_tunai.innerHTML)) - parseFloat(bayar_tunai.innerHTML);
		  }
		  td_baki_tunai.innerHTML = baki_tunai.toFixed(2);
		  td_baki_bank.innerHTML = baki_bank.toFixed(2);
		}
	}
	
	function kira_baki_awal()
	{
		var i,td_no1,td_no2,td_no3,td_no4;
		var bulan = document.getElementById("lkr_bulan").value;
		var tahun = document.getElementById("lkr_tahun").value;
		var table = document.getElementById("senarai_trans");
		var currmonth = tahun+bulan;
		var rows = table.rows;
		var baki_tunai = 0;
		var baki_bank = 0;
		for (i = 0; i < (rows.length); i++) {
	      	td_no1 = rows[i].getElementsByTagName("TD")[0];
			td_no2 = rows[i].getElementsByTagName("TD")[1];
			td_no3 = rows[i].getElementsByTagName("TD")[2];
			td_no4 = rows[i].getElementsByTagName("TD")[3];
			td_no5 = rows[i].getElementsByTagName("TD")[4];
			if(((td_no2.innerHTML+td_no1.innerHTML) < currmonth ) && td_no1.innerHTML != "")
			{
				//alert((td_no2.innerHTML+td_no1.innerHTML)+"-"+currmonth+"="+td_no4.innerHTML+":"+td_no5.innerHTML);
				if(td_no3.innerHTML == '1')
				{
					baki_tunai = baki_tunai + parseFloat(td_no4.innerHTML);
					baki_bank = baki_bank + parseFloat(td_no5.innerHTML);
				}else
				{
					baki_tunai = baki_tunai - parseFloat(td_no4.innerHTML);
					baki_bank = baki_bank - parseFloat(td_no5.innerHTML);
				}
			}
		}
		document.getElementById("lkr_baki_tunai_awal").value=baki_tunai.toFixed(2);
		document.getElementById("lkr_baki_bank_awal").value=baki_bank.toFixed(2);
	}
	
	$(document).ready( function () {
        //my custom script
			var laporan_kewangan_rt_config = {
				routes: {
				laporan_kewangan_rt_url: "/rt/sm7/laporan-kewangan-rt",
				check_baki_url: "/rt/sm7/check_baki"
				}
			};

		/* Maklumat Kewangan Rukun Tetangga */
			$('#lkr_krt_nama').val("{{$krt->krt_nama}}");
            $('#lkr_no_acc').val("{{$krt->bank_no_acc}}");
            $('#lkr_bank_nama').val("{{$krt->bank_nama}}");
            $('#lkr_no_evendor').val("{{$krt->no_evendor}}");
            $('#lkr_daerah').val("{{$krt->daerah}}");
            $('#lkr_negeri').val("{{$krt->state}}");
			
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
			
			kira_baki_awal();
			
			$.fn.copy_table = function() { 
				$.each($("#senarai_kewangan_rt_table tr"),function(index){
					if(index>0)
					{
						var self=$(this).closest("tr");
						var member_1_value = self.find("td:eq(1)").text().trim();
						var member_2_value = self.find("td:eq(2)").text().trim();
						var member_3_value = self.find("td:eq(3)").text().trim();
						var member_4_value = self.find("td:eq(4)").text().trim();
						var member_5_value = self.find("td:eq(5)").text().trim();
						var member_6_value = self.find("td:eq(6)").text().trim();
						var member_7_value = self.find("td:eq(7)").text().trim();
						var member_8_value = self.find("td:eq(8)").text().trim();
						var member_9_value = self.find("td:eq(9)").text().trim();
						var member_10_value = self.find("td:eq(10)").text().trim();
						//alert(member_1_value+"-"+member_8_value+"-"+member_9_value+"-"+member_10_value);
						//var member_7_value = '<button type="button" class="btn btn-icon" title="Kemaskini Kewangan RT" onclick="kemaskini_kewangan_rt(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
						if(member_1_value != "")
						{
							senarai_kewangan_rt_table2.row.add([index-1,member_1_value,member_2_value,member_3_value,member_4_value,member_5_value,member_6_value,member_7_value,member_8_value,member_9_value,member_10_value]).draw(false);
						}
					}
				});
			}
			
            var senarai_kewangan_rt_table = $('#senarai_kewangan_rt_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: {
					url: laporan_kewangan_rt_config.routes.laporan_kewangan_rt_url,
					data:function(d){
						d.bulan=$('#lkr_bulan').val();
						d.tahun=$('#lkr_tahun').val();
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
                "aoColumnDefs":[
						{          
                    		"aTargets": [ 0 ], 
                    		"width": "6%", 
                    		sClass: 'text-center',
							"bSortable": false,
                    		"mRender": function (data, type, full, meta)  {
                        			return  meta.row+1;
                    				}
                		},{          
                    	"aTargets": [ 1 ], 
                    	"width": "16%", 
                    	"mRender": function ( value, type, full )  {
                        			return full.kewangan_butiran;
                    				}
                		},{          
						"aTargets": [ 2 ], 
						"width": "13%", 
						"mRender": function ( value, type, full )  {
							return full.tarikh_t_b;
						}
						},{          
							"aTargets": [ 3 ], 
							"width": "14%", 
							"mRender": function ( value, type, full )  {
								return full.kewangan_cek_baucer;
							}
						},{          
							"aTargets": [ 4 ], 
							"width": "14%", 
							"mRender": function ( value, type, full )  {
								return full.kewangan_tarikh_cek;
							}
						},{          
							"aTargets": [ 5 ], 
							"width": "10%", 
							"mRender": function ( value, type, full )  {
								return full.terima_tunai;
							}
						},{          
							"aTargets": [ 6 ], 
							"width": "10%", 
							"mRender": function ( value, type, full )  {
								return full.terima_bank;
							}
						},{          
							"aTargets": [ 7 ], 
							"width": "10%", 
							"mRender": function ( value, type, full )  {
								return full.bayar_tunai;
							}
						},{          
							"aTargets": [ 8 ], 
							"width": "10%", 
							"mRender": function ( value, type, full )  {
								return full.bayar_bank;
							}
						},{          
							"aTargets": [ 9 ], 
							"width": "10%", 
							"mRender": function ( value, type, full )  {
								return full.kewangan_baki_tunai;
							}
						},{          
							"aTargets": [ 10 ], 
							"width": "10%", 
							"mRender": function ( value, type, full )  {
								return full.kewangan_baki_bank;
							}
                	}],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
					sortTable();
					kira_baki();
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
						{ "width": "6%", sClass: 'text-center', },
						{ "width": "16%" },
						{ "width": "13%" },
						{ "width": "14%" },
						{ "width": "14%" },
						{ "width": "10%" },
						{ "width": "10%" },
						{ "width": "10%" },
						{ "width": "10%" },
						{ "width": "10%" },
						{ "width": "10%" },
  					]
			});
			
			$("#cari_kewangan").click(function(){
				event.preventDefault();
				kira_baki_awal();
				$('#senarai_kewangan_rt_table').dataTable().fnClearTable();
    			$('#senarai_kewangan_rt_table').dataTable().fnDestroy();
				$('#senarai_kewangan_rt_table2').dataTable().fnClearTable();
				var senarai_kewangan_rt_table = $('#senarai_kewangan_rt_table').DataTable( {
					processing: true,
					serverSide: true,
					ajax: {
						url: laporan_kewangan_rt_config.routes.laporan_kewangan_rt_url,
						data:function(d){
							d.bulan=$('#lkr_bulan').val();
							d.tahun=$('#lkr_tahun').val();
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
						"width": "6%", 
						sClass: 'text-center',
						"mRender": function (data, type, full, meta)  {
							return  meta.row+1;
						}
					},{          
						"aTargets": [ 1 ], 
						"width": "16%", 
						"mRender": function ( value, type, full )  {
							return full.kewangan_butiran;
						}
					},{          
						"aTargets": [ 2 ], 
						"width": "13%", 
						"mRender": function ( value, type, full )  {
							return full.tarikh_t_b;
						}
					},{          
						"aTargets": [ 3 ], 
						"width": "14%", 
						"mRender": function ( value, type, full )  {
							return full.kewangan_cek_baucer;
						}
					},{          
						"aTargets": [ 4 ], 
						"width": "14%", 
						"mRender": function ( value, type, full )  {
							return full.kewangan_tarikh_cek;
						}
					},{          
						"aTargets": [ 5 ], 
						"width": "10%", 
						"mRender": function ( value, type, full )  {
							return full.terima_tunai;
						}
					},{          
						"aTargets": [ 6 ], 
						"width": "10%", 
						"mRender": function ( value, type, full )  {
							return full.terima_bank;
						}
					},{          
						"aTargets": [ 7 ], 
						"width": "10%", 
						"mRender": function ( value, type, full )  {
							return full.bayar_tunai;
						}
					},{          
						"aTargets": [ 8 ], 
						"width": "10%", 
						"mRender": function ( value, type, full )  {
							return full.bayar_bank;
						}
					},{          
						"aTargets": [ 9 ], 
						"width": "10%", 
						"mRender": function ( value, type, full )  {
							return full.kewangan_baki_tunai;
						}
					},{          
						"aTargets": [ 10 ], 
						"width": "10%", 
						"mRender": function ( value, type, full )  {
							return full.kewangan_baki_bank;
						}
					}],
					"order": [[ 0, 'asc' ]],
					initComplete: function () {
						$('[data-toggle="tooltip"]').tooltip();
						$('#myInput').val("complete");
						sortTable();
						kira_baki();
						$.fn.copy_table();
					}
				});
			}).ajax.reload(); ;
    });

    function print_laporan_kewangan_rt(){
		window.location.href = "{{route('pdf.laporan_kewangan_rt','')}}"+"/"+"{{$krt->id}}";
	}

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop