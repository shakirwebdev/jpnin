
<script>
    //my custom script
        var tindakan_susulan_config = {
            routes: {
                tindakan_susulan_url: "{{ route('rt-sm21.get_view_ts_ikes','') }}",
            }
        };

        
        

    function load_add_ts_ikes_ppn(id) {

        $.get(tindakan_susulan_config.routes.tindakan_susulan_url + '/' + id, function (data) {
            $("input[name=matipn_tempoh_tindakan][value=" + data.tempoh_tindakan + "]").prop('checked', true);
            $('#matipn_tarikh_arahan').val(data.tarikh_arahan);
            $('#matipn_jenis_arahan_id').val(data.jenis_arahan_id);
            var tindakan_ppn = data.tindakan_kepada_ppn;
            if (tindakan_ppn == "1") {
                $("input[name=matipn_tindakan_kepada_ppn]").prop('checked', true);
            }
            var tindakan_ppd = data.tindakan_kepada_ppd;
            if (tindakan_ppd == "1") {
                $("input[name=matipn_tindakan_kepada_ppd]").prop('checked', true);
            }

            $('#matipn_spk_ikes_id').val(data.id);
            $('#modal_add_ts_ikes_ppn').modal('show');
            
        });

        $('#matipn_keterangan_tindakan').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

        url_table_tindakan_susulan 			= "{{ route('rt-sm21.get_tindakan_susulan_ppn','') }}"+"/"+id;
        
        var senarai_ts_ikes = $('#senarai_ts_ikes').DataTable( {
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
                    return full.tarikh_tindakan;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "40%", 
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