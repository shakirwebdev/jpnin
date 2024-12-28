<script>
    //my custom script
        var tindakan_susulan_config = {
            routes: {
                tindakan_susulan_url: "{{ route('rt-sm22.get_view_ts_imuhibbah_p','') }}",
            }
        };

    function load_view_ts_imuhibbah(id) {

        $.get(tindakan_susulan_config.routes.tindakan_susulan_url + '/' + id, function (data) {
            $("input[name=mvtip_tempoh_tindakan][value=" + data.tempoh_tindakan + "]").prop('checked', true);
            $('#mvtip_tarikh_arahan').val(data.tarikh_arahan);
            $('#mvtip_jenis_arahan_id').val(data.jenis_arahan_id);
            var tindakan_ppn = data.tindakan_kepada_ppn;
            if (tindakan_ppn == "1") {
                $("input[name=mvtip_tindakan_kepada_ppn]").prop('checked', true);
            }
            var tindakan_ppd = data.tindakan_kepada_ppd;
            if (tindakan_ppd == "1") {
                $("input[name=mvtip_tindakan_kepada_ppd]").prop('checked', true);
            }

            $('#modal_view_ts_imuhibbah').modal('show');
            
        });

        url_table_tindakan_susulan 			= "{{ route('rt-sm22.get_view_ts_table','') }}"+"/"+id;

        var senarai_ts_imuhibbah = $('#senarai_ts_imuhibbah').DataTable( {
            processing: true,
            serverSide: true,
            "bDestroy": true,
            ajax: url_table_tindakan_susulan,
            "language": {
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Seterusnya",
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
            responsive: true,
            "aoColumnDefs":[{          
                "aTargets": [ 0 ], 
                "width": "6%", 
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                    return  meta.row+1;
                }
            },{          
                "aTargets": [ 1 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.long_description;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.tarikh_tindakan;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.keterangan_tindakan;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    }

</script>