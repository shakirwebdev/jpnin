@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">    
		
	$(document).ready( function () {
	
		var curr_year = new Date().getFullYear();
		$('#kkhq_tahun').val(curr_year);
		$("#kkhq_state_id").val({{ Auth::user()->state_id}});
		
		var user_state = {{ Auth::user()->state_id }};
		var new_state = {{ Auth::user()->state_id }};
		if (user_state == 1)
			new_state = "01";
		if (user_state == 2)
			new_state = "02";
		if (user_state == 3)
			new_state = "03";
		if (user_state == 4)
			new_state = "04";
		if (user_state == 5)
			new_state = "05";
		if (user_state == 6)
			new_state = "06";
		if (user_state == 7)
			new_state = "07";
		if (user_state == 8)
			new_state = "08";
		if (user_state == 9)
			new_state = "09";
		$("#kkhq_state_id").val(new_state);

		//my custom script
		var senarai_keaktifan_krt_config = {
			routes: {
				senarai_keaktifan_krt_url: "/rt/sm11/keaktifan-krt-ppn"
			}
		};

        $.fn.statechange = function() {
            var value = $('#kkhq_state_id').val();
            var selectedIndex = 1;
            $('#kkhq_daerah_id').find('option').remove();
            $('#kkhq_daerah_id').prop("disabled", false);
			$('#kkhq_parlimen_id').find('option').remove();
            $('#kkhq_parlimen_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: senarai_keaktifan_krt_config.routes.senarai_keaktifan_krt_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#kkhq_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#kkhq_daerah_id')
                            .append($('<option>')
                            .text(obj.daerah_description)
                            .attr('value', obj.daerah_id));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
				$.ajax({
                    type: "GET",
                    url: senarai_keaktifan_krt_config.routes.senarai_keaktifan_krt_url,
                    data: {type: 'get_parlimen', value: value},
                    success: function (data) {
                        $('#kkhq_parlimen_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#kkhq_parlimen_id')
                            .append($('<option>')
                            .text(obj.parlimen_description)
                            .attr('value', obj.parlimen_id));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        };

        $("#kkhq_daerah_id").on( 'change', function () {
            var value = $('#kkhq_daerah_id').val();
            var selectedIndex = 1;
            $('#kkhq_krt_id').find('option').remove();
            $('#kkhq_krt_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: senarai_keaktifan_krt_config.routes.senarai_keaktifan_krt_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#kkhq_krt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#kkhq_krt_id')
                            .append($('<option>')
                            .text(obj.krt_nama)
                            .attr('value', obj.id));
                        });
						$.fn.myfunction();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });
		
		$("#kkhq_parlimen_id").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#kkhq_dun_id').find('option').remove();
            $('#kkhq_dun_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: senarai_keaktifan_krt_config.routes.senarai_keaktifan_krt_url,
                    data: {type: 'get_dun', value: value},
                    success: function (data) {
                        $('#kkhq_dun_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#kkhq_dun_id')
                            .append($('<option>')
                            .text(obj.dun_description)
                            .attr('value', obj.dun_id));
                        });
						$.fn.myfunction();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });
		
		$("#kkhq_dun_id").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#kkhq_krt_id').find('option').remove();
            $('#kkhq_krt_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: senarai_keaktifan_krt_config.routes.senarai_keaktifan_krt_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#kkhq_krt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#kkhq_krt_id')
                            .append($('<option>')
                            .text(obj.dun_description)
                            .attr('value', obj.dun_id));
                        });
						$.fn.myfunction();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

        $("#kkhq_krt_id").on( 'change', function () {
            //senarai_keaktifan_krt.search( $(this).val() ).draw();
			$.fn.myfunction();
        });
		
		$.fn.getmarkahkunci = function() {
			$('#kunci_markah_ajk').val('');
			$('#kunci_markah_aktiviti').val('');
			$('#kunci_markah_mesyuarat').val('');
			$.each($("#data_kunci tr"),function(index){
				if(index>0)
				{
					var self=$(this).closest("tr");
					var member_1_value = self.find("td:eq(1)").text().trim(); //tahun
					var member_2_value = self.find("td:eq(2)").text().trim(); //jenis
					var member_3_value = self.find("td:eq(3)").text().trim(); //tkh_kunci
					if(member_1_value == $('#kkhq_tahun').val());
					{
						if(member_2_value == '1')
						{
							$('#kunci_markah_ajk').val(member_3_value);
						}
						if(member_2_value == '2')
						{
							$('#kunci_markah_aktiviti').val(member_3_value);
						}
						if(member_2_value == '3')
						{
							$('#kunci_markah_mesyuarat').val(member_3_value);
						}
						if(member_2_value == '4')
						{
							$('#kunci_markah_kewangan').val(member_3_value);
						}
					}
				}
			});
			if($('#kunci_markah_ajk').val() == '')
			{
				$('#kunci_markah_ajk').val($('#kkhq_tahun').val()+'1231000000');
			}
			if($('#kunci_markah_aktiviti').val() == '')
			{
				$('#kunci_markah_aktiviti').val($('#kkhq_tahun').val()+'1231000000');
			}
			if($('#kunci_markah_mesyuarat').val() == '')
			{
				$('#kunci_markah_mesyuarat').val($('#kkhq_tahun').val()+'1231000000');
			}
			if($('#kunci_markah_kewangan').val() == '')
			{
				$('#kunci_markah_kewangan').val($('#kkhq_tahun').val()+'1231000000');
			}
		};
		
		$("#kkhq_tahun").on( 'change', function () {
            //senarai_keaktifan_krt.search( $(this).val() ).draw();
			$.fn.myfunction();
        });

		$.fn.myfunction = function() {
      		$v_state=$('#kkhq_state_id').val(); 
			$v_parlimen=$('#kkhq_parlimen_id').val();
			$v_daerah=$('#kkhq_daerah_id').val();
			$v_dun=$('#kkhq_dun_id').val();
			$v_krt=$('#kkhq_krt_id').val();
			$v_tahun=$('#kkhq_tahun').val();
			$('#data_kunci').dataTable().fnDestroy();
			senarai_data_kunci = $('#data_kunci').DataTable( {
				processing: true,
				serverSide: true,
				ajax: {
					url: "/rt/sm11/keaktifan-krt-ppd-kunci",
					data: {tahun_penilaian:$('#kkhq_tahun').val()},
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
				"bFilter": false,
				"bSort": false,
				responsive: false,
				"bPaginate": false,
				"paging": false,
				"aoColumnDefs":[{          
					"aTargets": [ 0 ], 
					sClass: 'text-center',
					"mRender": function (data, type, full, meta)  {
						return  meta.row+1;
					}
				},{          
					"aTargets": [ 1 ], 
					"mRender": function ( value, type, full )  {
						return full.tahun;
					}
				},{          
					"aTargets": [ 2 ], 
					"mRender": function ( value, type, full )  {
						return full.jenis;
					}
				},{          
					"aTargets": [ 3 ], 
					"mRender": function ( value, type, full )  {
						return full.tkh_kunci;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
					$.fn.getmarkahkunci();
				}
			}).ajax.reload();
			//$('#senarai_keaktifan_krt').dataTable().fnClearTable();
    		$('#senarai_keaktifan_krt').dataTable().fnDestroy();
			$v_markah_profile=0;
			$v_kunci_ajk = $('#kunci_markah_ajk').val();
			$v_kunci_aktiviti = $('#kunci_markah_aktiviti').val();
			$v_kunci_mesyuarat = $('#kunci_markah_mesyuarat').val();
			$v_kunci_kewangan = $('#kunci_markah_kewangan').val();
			senarai_keaktifan_krt = $('#senarai_keaktifan_krt').DataTable( {
				processing: true,
				serverSide: true,
				ajax: {
					url: senarai_keaktifan_krt_config.routes.senarai_keaktifan_krt_url,
					data: {negeri: $v_state, parlimen: $v_parlimen, daerah: $v_daerah, dun: $v_dun, krt: $v_krt, tahun: $v_tahun, tkh_kunci_ajk: $v_kunci_ajk, tkh_kunci_aktiviti: $v_kunci_aktiviti,tkh_kunci_mesyuarat: $v_kunci_mesyuarat, tkh_kunci_kewangan: $v_kunci_kewangan},
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
				"language": {
					"paginate": {
						"previous": "Sebelumnya",
						"next": "Seterusnya",
						searchPanes: {
							emptyPanes: 'There are no panes to display. :/'
						}
					},
					"sSearch": "Carian",
					"sLengthMenu": "Paparan _MENU_ rekod",
					"lengthMenu": "Paparan _MENU_ rekod setiap laman",
					"zeroRecords": "Tiada rekod ditemui",
					"info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
					"infoEmpty": "",
					"infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
				},
				dom: 'rtip',
				"bFilter": true,
				"bSort": false,
				responsive: true,
				"aoColumnDefs":[{          
				"aTargets": [ 0 ], 
					sClass: 'text-center',
					"mRender": function (data, type, full, meta)  {
						return  meta.row+1;
					}
				},{          
					"aTargets": [ 1 ], 
					"mRender": function ( value, type, full )  {
						return full.parlimen;
					}
				},{          
					"aTargets": [ 2 ], 
					"mRender": function ( value, type, full )  {
						return full.daerah;
					}
				},{          
					"aTargets": [ 3 ],  
					"mRender": function ( value, type, full )  {
						return full.nama_krt;
					}
				},{          
					"aTargets": [ 4 ],  
					"mRender": function ( value, type, full )  {
						return full.no_rujukan_krt;
					}
				},{          
					"aTargets": [ 5 ], 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						$v_markah_profile = full.markah_latar + full.markah_penduduk + full.markah_pekerjaan + full.markah_rumah +  full.markah_pertubuhan + full.markah_kemudahan + full.markah_sosial + full.markah_tempat_krt + full.markah_profil_peta; 
						if($v_markah_profile == null)
							return '0%';
						else
							return $v_markah_profile+'%';
					}
				},{          
					"aTargets": [ 6 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						if(full.markah_ajk == null)
							return '0%';
						else
							return parseFloat(full.markah_ajk).toFixed(1)+'%';
					}
				},{          
					"aTargets": [ 7 ], 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						if(full.markah_aktiviti == null)
							return '0%';
						else
							return parseInt(full.markah_aktiviti)+'%';
					}
				},{          
					"aTargets": [ 8 ], 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						if(full.markah_mesyuarat == null)
							return '0%';
						else
							return parseInt(full.markah_mesyuarat)+'%';
					}
				},{          
					"aTargets": [ 9 ], 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						if(full.markah_kewangan == null)
							return '0%';
						else
							return parseInt(full.markah_kewangan)+'%';
					}
				},{          
					"aTargets": [ 10 ], 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						if(full.keaktifan_markah == null)
							return '0%';
						else
							return parseInt(full.keaktifan_markah)+'%';
					}
				},{          
					"aTargets": [ 11 ],  
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						let va = parseFloat($v_markah_profile);
						let vb = parseFloat(full.markah_ajk);
						let vc = parseFloat(full.markah_aktiviti);
						let vd = parseFloat(full.markah_mesyuarat);
						let ve = parseFloat(full.markah_kewangan);
						let vf = parseFloat(full.keaktifan_markah);
						return (va + vb + vc + vd + ve + vf).toFixed(1) + '%';
					}
				},{          
					"aTargets": [ 12 ], 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.status;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			}).ajax.reload();;
   		};
		 
		var senarai_data_kunci = $('#data_kunci').DataTable( {
			processing: true,
        	serverSide: true,
			ajax: {
				url: "/rt/sm11/keaktifan-krt-ppd-kunci",
				data: {tahun_penilaian:$('#kkhq_tahun').val()},
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
        	"bFilter": false,
			"bSort": false,
        	responsive: false,
			"bPaginate": false,
			"paging": false,
			"aoColumnDefs":[{          
                "aTargets": [ 0 ], 
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                    return  meta.row+1;
                }
			},{          
                "aTargets": [ 1 ], 
                "mRender": function ( value, type, full )  {
                    return full.tahun;
                }
			},{          
                "aTargets": [ 2 ], 
                "mRender": function ( value, type, full )  {
                    return full.jenis;
                }
			},{          
                "aTargets": [ 3 ], 
                "mRender": function ( value, type, full )  {
                    return full.tkh_kunci;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
				$.fn.getmarkahkunci();
            }
		});
		
		$v_markah_profile=0;
		$v_kunci_ajk = $('#kunci_markah_ajk').val();
		$v_kunci_aktiviti = $('#kunci_markah_aktiviti').val();
		$v_kunci_mesyuarat = $('#kunci_markah_mesyuarat').val();
		$v_kunci_kewangan = $('#kunci_markah_kewangan').val();
        var senarai_keaktifan_krt = $('#senarai_keaktifan_krt').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {
				url: senarai_keaktifan_krt_config.routes.senarai_keaktifan_krt_url,
				data: {negeri: $('#kkhq_state_id').val(), parlimen: $('#kkhq_parlimen_id').val(), dun: $('#kkhq_dun_id').val(),daerah: $('#kkhq_daerah_id').val(), krt: $('#kkhq_krt_id').val(), tahun: $('#kkhq_tahun').val(), tkh_kunci_ajk: $v_kunci_ajk, tkh_kunci_aktiviti: $v_kunci_aktiviti,tkh_kunci_mesyuarat: $v_kunci_mesyuarat,tkh_kunci_kewangan: $v_kunci_kewangan},
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
        	"language": {
	            "paginate": {
	                "previous": "Sebelumnya",
	                "next": "Seterusnya",
	                searchPanes: {
		                emptyPanes: 'There are no panes to display. :/'
		            }
	            },
	            "sSearch": "Carian",
	            "sLengthMenu": "Paparan _MENU_ rekod",
	            "lengthMenu": "Paparan _MENU_ rekod setiap laman",
	            "zeroRecords": "Tiada rekod ditemui",
	            "info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
	            "infoEmpty": "",
	            "infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
        	},
        	dom: 'rtip',
        	"bFilter": true,
			"bSort": false,
        	responsive: true,
			"aoColumnDefs":[{          
                "aTargets": [ 0 ], 
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                    return  meta.row+1;
                }
			},{          
                "aTargets": [ 1 ], 
                "mRender": function ( value, type, full )  {
                    return full.parlimen;
                }
            },{          
                "aTargets": [ 2 ], 
                "mRender": function ( value, type, full )  {
                    return full.daerah;
                }
            },{          
                "aTargets": [ 3 ], 
                "mRender": function ( value, type, full )  {
                    return full.nama_krt;
                }
            },{          
                "aTargets": [ 4 ], 
                "mRender": function ( value, type, full )  {
                    return full.no_rujukan_krt;
                }
            },{          
                "aTargets": [ 5 ], 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					$v_markah_profile = full.markah_latar + full.markah_penduduk + full.markah_pekerjaan + full.markah_rumah +  full.markah_pertubuhan + full.markah_kemudahan + full.markah_sosial + full.markah_tempat_krt + full.markah_profil_peta; 
					if($v_markah_profile == null)
						return '0%';
					else
                    	return $v_markah_profile+'%';
                }
            },{          
                "aTargets": [ 6 ], 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					if(full.markah_ajk == null)
						return '0%';
					else
                    	return parseFloat(full.markah_ajk).toFixed(1)+'%';
                }
            },{          
                "aTargets": [ 7 ], 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					if(full.markah_aktiviti == null)
						return '0%';
					else
                    	return parseInt(full.markah_aktiviti)+'%';
                }
            },{          
                "aTargets": [ 8 ], 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					if(full.markah_mesyuarat == null)
						return '0%';
					else
                    	return parseInt(full.markah_mesyuarat)+'%';
                }
            },{          
                "aTargets": [ 9 ], 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					if(full.markah_kewangan == null)
						return '0%';
					else
                    	return parseInt(full.markah_kewangan)+'%';
                }
            },{          
                "aTargets": [ 10 ], 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					if(full.keaktifan_markah == null)
						return '0%';
					else
                    	return parseInt(full.keaktifan_markah)+'%';
                }
            },{          
                "aTargets": [ 11 ], 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    let va = parseFloat($v_markah_profile);
					let vb = parseFloat(full.markah_ajk);
					let vc = parseFloat(full.markah_aktiviti);
					let vd = parseFloat(full.markah_mesyuarat);
					let ve = parseFloat(full.markah_kewangan);
					let vf = parseFloat(full.keaktifan_markah);
					return (va + vb + vc + vd + ve + vf).toFixed(1) + '%';
                }
            },{          
                "aTargets": [ 12 ],  
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.status;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
				$.fn.statechange();
            }
	    });

		$('#btn_excel').on( 'click', function () {
			$v_state=$('#kkhq_state_id').val(); 
			
			$v_parlimen=0;
			if($('#kkhq_parlimen_id').val() === null || $('#kkhq_parlimen_id').val() == '')
			{
				$v_parlimen == 0;
			}else
			{
				$v_parlimen=$('#kkhq_parlimen_id').val();
			}
			
			$v_daerah=0;
			if($('#kkhq_daerah_id').val() === null || $('#kkhq_daerah_id').val() == '')
			{
				$v_daerah == 0;
			}else
			{
				$v_daerah=$('#kkhq_daerah_id').val();
			}
			
			$v_dun=0;
			if($('#kkhq_dun_id').val() === null || $('#kkhq_dun_id').val() == '')
			{
				$v_dun == 0;
			}else
			{
				$v_dun=$('#kkhq_dun_id').val();
			}
			
			$v_krt=0;
			if($('#kkhq_krt_id').val() === null || $('#kkhq_krt_id').val() == '')
			{
				$v_krt == 0;
			}else
			{
				$v_krt=$('#kkhq_krt_id').val();
			}
			
			$v_tahun=$('#kkhq_tahun').val();
			$v_kunci_ajk = $('#kunci_markah_ajk').val();
			$v_kunci_aktiviti = $('#kunci_markah_aktiviti').val();
			$v_kunci_mesyuarat = $('#kunci_markah_mesyuarat').val();
			$v_kunci_kewangan = $('#kunci_markah_kewangan').val();
			$base_url = window.location.origin;
			$url = $base_url+"/rt/sm11/get_excel_file/state/"+$v_state+"/parlimen/"+$v_parlimen+"/daerah/"+$v_daerah+"/dun/"+$v_dun+"/krt/"+$v_krt+"/tahun/"+$v_tahun+"/kunci_ajk/"+$v_kunci_ajk+"/kunci_aktiviti/"+$v_kunci_aktiviti+"/kunci_mesyuarat/"+$v_kunci_mesyuarat+"/kunci_kewangan/"+$v_kunci_kewangan;
			window.location.href = $url;
		});
        
		$('#btn_pdf').on( 'click', function () {
			$v_state=$('#kkhq_state_id').val(); 
			
			$v_parlimen=0;
			if($('#kkhq_parlimen_id').val() === null || $('#kkhq_parlimen_id').val() == '')
			{
				$v_parlimen == 0;
			}else
			{
				$v_parlimen=$('#kkhq_parlimen_id').val();
			}
			
			$v_daerah=0;
			if($('#kkhq_daerah_id').val() === null || $('#kkhq_daerah_id').val() == '')
			{
				$v_daerah == 0;
			}else
			{
				$v_daerah=$('#kkhq_daerah_id').val();
			}
			
			$v_dun=0;
			if($('#kkhq_dun_id').val() === null || $('#kkhq_dun_id').val() == '')
			{
				$v_dun == 0;
			}else
			{
				$v_dun=$('#kkhq_dun_id').val();
			}
			
			$v_krt=0;
			if($('#kkhq_krt_id').val() === null || $('#kkhq_krt_id').val() == '')
			{
				$v_krt == 0;
			}else
			{
				$v_krt=$('#kkhq_krt_id').val();
			}
			
			$v_tahun=$('#kkhq_tahun').val();
			$v_kunci_ajk = $('#kunci_markah_ajk').val();
			$v_kunci_aktiviti = $('#kunci_markah_aktiviti').val();
			$v_kunci_mesyuarat = $('#kunci_markah_mesyuarat').val();
			$v_kunci_kewangan = $('#kunci_markah_kewangan').val();
			$base_url = window.location.origin;
			$url = $base_url+"/pdf/laporan_keaktifan/state/"+$v_state+"/parlimen/"+$v_parlimen+"/daerah/"+$v_daerah+"/dun/"+$v_dun+"/krt/"+$v_krt+"/tahun/"+$v_tahun+"/kunci_ajk/"+$v_kunci_ajk+"/kunci_aktiviti/"+$v_kunci_aktiviti+"/kunci_mesyuarat/"+$v_kunci_mesyuarat+"/kunci_kewangan/"+$v_kunci_kewangan;
			window.location.href = $url;
		});
		
    }); 

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop