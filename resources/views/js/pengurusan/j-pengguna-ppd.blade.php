@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
<script type="text/javascript">   
    
        //my custom script
        var pengguna_config = {
            routes: {
                orang_awam_datatable_url: "{{ route('orang_awam_ppd.index') }}",
                orang_awam_kemaskini_url: "{{ route('orang_awam_ppd.store') }}",
                krt_datatable_url: "{{ route('krt_ppd.index') }}",
                krt_store_url: "{{ route('krt_ppd.store') }}",
                srs_datatable_url: "{{ route('srs_ppd.index') }}",
                srs_store_url: "{{ route('srs_ppd.store') }}",
            }
        };

        $('.icon-eye.show-pwd').click(function () {
            $(this).toggleClass("active");
            var input=$(this).parent().find("input");
            if(input.attr("type")=="text")
                input.attr("type","password");
            else
                input.attr("type","text");
        });

    /* Pengguna Orang Awam */
        var orang_awam_table = $('#orang_awam_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {url: pengguna_config.routes.orang_awam_datatable_url},
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
            "bSort": false,
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
                    return full.user_fullname
                }
            },{			
                "aTargets": [ 2 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.no_ic;
                }
            },{			
                "aTargets": [ 3 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.short_description;
                }
            },{			
                "aTargets": [ 4 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.created_at;
                }
            },{			
                "aTargets": [ 5 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    if (full.user_status == '1') {
                        return 'Aktif';
                    } else {
                        return 'Tidak Aktif';
                    }                
                }
            },{
                "aTargets": [ 6 ], 
                "width": "15%", 
                "sClass": "text-center", 
                "mRender": function ( value, type, full )  {
                    button_a = '<button type="button" class="btn btn-icon" title="Edit" id="edit_orang_awam" data-id="'+full.user_id+'"><i class="fa fa-edit"></i></button>';
                    return button_a;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        $('#select_peranan_orang_awam').on('change', function() {
            var i_val = this.value;
            console.log(i_val);
            if (i_val == '2') {
                $(".for_public").css("display", "block");
                $(".negeri").css("display", "none");
                $(".daerah").css("display", "none");
            } else if (i_val == '10') {
                $(".for_public").css("display", "block");
                $(".negeri").css("display", "block");
                $(".daerah").css("display", "block");
                $(".krt").css("display", "block");
            } else if (i_val == '11') {
                $(".for_public").css("display", "block");
                $(".negeri").css("display", "block");
                $(".daerah").css("display", "block");
                $(".krt").css("display", "block");
            } else if (i_val == '12') {
                $(".for_public").css("display", "block");
                $(".negeri").css("display", "block");
                $(".daerah").css("display", "block");
                $(".krt").css("display", "block");
            } 
        });

        $("#select_negeri_orang_awam").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_daerah_orang_awam').find('option').remove();

            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.orang_awam_datatable_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#select_daerah_orang_awam').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_daerah_orang_awam')
                            .append($('<option>')
                            .text(obj.daerah_description)
                            .attr('value', obj.daerah_id));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

        $("#select_daerah_orang_awam").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_krt_orang_awam').find('option').remove();

            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.orang_awam_datatable_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#select_krt_orang_awam').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_krt_orang_awam')
                            .append($('<option>')
                            .text(obj.krt_nama)
                            .attr('value', obj.id));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

        $('#alamat_org_awam').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

        // click edit orang awam
        $('body').on('click', '#edit_orang_awam', function () {
            var user_id = $(this).data('id');
            $.get(pengguna_config.routes.orang_awam_datatable_url + '/' + user_id +'/edit', function (data) { 
                $('[name=username]').val(data.user_name);
                $('[name=name]').val(data.user_fullname);
                $('[name=ic]').val(data.no_ic); 
                $('[name=phone]').val(data.no_phone); 
                $('[name=email]').val(data.user_email);
                $('[name=user_profile_id]').val(data.user_id);

                $('#ModalOrangAwam').modal('show');
            })
        });

        // click Kemaskini orang awam
        $(document).on('submit', '#user_orang_awam_form', function(event){    
            event.preventDefault();
            $('#btn_edit_org_awam').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_edit_org_awam').prop('disabled', true);
            var data = $("#user_orang_awam_form").serialize();
            var action = $('#edit_orang_awam').val();
            var btn_text;
            if (action == 'update') {
                url = pengguna_config.routes.orang_awam_kemaskini_url;
                type = "POST";
                btn_text = 'Kemaskini';
            } else {
                url = pengguna_config.routes.orang_awam_kemaskini_url;
                type = "POST";
                btn_text = "Kemaskini";
            }
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=select_peranan_orang_awam]').removeClass("is-invalid");
                $('[name=select_negeri_orang_awam]').removeClass("is-invalid");
                $('[name=select_daerah_orang_awam]').removeClass("is-invalid");
                $('[name=select_krt_orang_awam]').removeClass("is-invalid");
                $('[name=name]').removeClass("is-invalid");
                $('[name=ic]').removeClass("is-invalid");
                $('[name=phone]').removeClass("is-invalid");
                $('[name=email]').removeClass("is-invalid");
                $('[name=alamat]').removeClass("is-invalid");
            
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'select_peranan_orang_awam') {
                            $('[name=select_peranan_orang_awam]').addClass("is-invalid");
                            $('.c_role').html(error);
                        }

                        if(index == 'select_negeri_orang_awam') {
                            $('[name=select_negeri_orang_awam]').addClass("is-invalid");
                            $('.c_negeri').html(error);
                        }

                        if(index == 'select_daerah_orang_awam') {
                            $('[name=select_daerah_orang_awam]').addClass("is-invalid");
                            $('.c_daerah').html(error);
                        }

                        if(index == 'select_krt_orang_awam') {
                            $('[name=select_krt_orang_awam]').addClass("is-invalid");
                            $('.c_krt').html(error);
                        }

                        if(index == 'name') {
                            $('[name=name]').addClass("is-invalid");
                            $('.c_name').html(error);
                        }
                        
                        if(index == 'ic') {
                            $('[name=ic]').addClass("is-invalid");
                            $('.c_ic').html(error);
                        }

                        if(index == 'phone') {
                            $('[name=phone]').addClass("is-invalid");
                            $('.c_phone').html(error);
                        }

                        if(index == 'email') {
                            $('[name=email]').addClass("is-invalid");
                            $('.c_email').html(error);
                        }
                        
                        if(index == 'alamat') {
                            $('[name=alamat]').addClass("is-invalid");
                            $('.c_address').html(error);
                        }
                    });
                    $('#btn_edit_org_awam').html(btn_text);                
                    $('#btn_edit_org_awam').prop('disabled', false);            
                } else {
                        $('#user_ekrt_form').trigger("reset");
                        $('#ModalOrangAwam').modal('hide');
                        $('#btn_edit_org_awam').html("Simpan");
                        $('#btn_edit_org_awam').prop('disabled', false);
                        $('#orang_awam_table').DataTable().ajax.reload();
                }
            });
        });

    /* Pengguna KRT */
        $('#krt_nama_penuh').keyup(function(){
            KRT_table.search( $(this).val() ).draw();
        });
        
        $('#krt_no_ic').keyup(function(){
            KRT_table.search( $(this).val() ).draw();
        });

        var KRT_table = $('#KRT_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {url: pengguna_config.routes.krt_datatable_url},
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
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                        return  meta.row+1;
                }
            },{			
                "aTargets": [ 1 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.krt_nama
                }
            },{			
                "aTargets": [ 2 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.user_fullname
                }
            },{			
                "aTargets": [ 3 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.no_ic
                }
            },{			
                "aTargets": [ 4 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.role;
                }
            },{			
                "aTargets": [ 5 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.created_at;
                }
            },{			
                "aTargets": [ 6 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    if (full.user_status == '1') {
                        return 'Aktif';
                    } else {
                        return 'Tidak Aktif';
                    }                
                }
            },{
                "aTargets": [ 7 ], 
                "width": "15%", 
                "sClass": "text-center", 
                "mRender": function ( value, type, full )  {
                    button_a = '<button type="button" class="btn btn-icon" title="Edit" id="edit_krt" data-id="'+full.user_id+'"><i class="fa fa-edit"></i></button>';
                    return button_a;
                }
            }],
            "order": [[ 1, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        $('#select_peranan_ekrt').on('change', function() {
            var i_val = this.value;
            console.log(i_val);
            if (i_val == '2') {
                $(".for_public").css("display", "block");
                $(".negeri").css("display", "none");
                $(".daerah").css("display", "none");
            } else if (i_val == '4') {
                $(".for_public").css("display", "block");
                $(".negeri").css("display", "block");
                $(".daerah").css("display", "block");
                $(".krt").css("display", "block");
            } else if (i_val == '5') {
                $(".for_public").css("display", "block");
                $(".negeri").css("display", "block");
                $(".daerah").css("display", "block");
                $(".krt").css("display", "block");
            } else if (i_val == '6') {
                $(".for_public").css("display", "block");
                $(".negeri").css("display", "block");
                $(".daerah").css("display", "block");
                $(".krt").css("display", "block");
            } 
        });

        $("#select_negeri_ekrt").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_daerah_ekrt').find('option').remove();
            $('#select_daerah_ekrt').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.krt_datatable_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#select_daerah_ekrt').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_daerah_ekrt')
                            .append($('<option>')
                            .text(obj.daerah_description)
                            .attr('value', obj.daerah_id));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

        $("#select_daerah_ekrt").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_krt_ekrt').find('option').remove();
            $('#select_krt_ekrt').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.krt_datatable_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#select_krt_ekrt').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_krt_ekrt')
                            .append($('<option>')
                            .text(obj.krt_nama)
                            .attr('value', obj.id));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

        $('#no_ic_krt').mask('999999999999');

        $('#alamat_krt').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

        $('#alamat_krt_edit').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

        // click add pengguna krt
        $(document).on('submit', '#user_krt_add_form', function(event){    
            event.preventDefault();
            $('#btn_add_krt').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_add_krt').prop('disabled', true);
            var data = $("#user_krt_add_form").serialize();
            var action = $('#action_krt').val();
            var btn_text;
                url = pengguna_config.routes.krt_store_url;
                type = "POST";
                btn_text = "Simpan";

            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=select_peranan_ekrt]').removeClass("is-invalid");
                $('[name=select_negeri_ekrt]').removeClass("is-invalid");
                $('[name=select_daerah_ekrt]').removeClass("is-invalid");
                $('[name=select_krt_ekrt]').removeClass("is-invalid");
                $('[name=password_1]').removeClass("is-invalid");
                $('[name=password_2]').removeClass("is-invalid");
                $('[name=name]').removeClass("is-invalid");
                $('[name=ic]').removeClass("is-invalid");
                $('[name=phone]').removeClass("is-invalid");
                $('[name=email]').removeClass("is-invalid");
                $('[name=alamat]').removeClass("is-invalid");

                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'select_peranan_ekrt') {
                            $('[name=select_peranan_ekrt]').addClass("is-invalid");
                            $('.c_role').html(error);
                        }

                        if(index == 'select_negeri_ekrt') {
                            $('[name=select_negeri_ekrt]').addClass("is-invalid");
                            $('.c_negeri').html(error);
                        }

                        if(index == 'select_daerah_ekrt') {
                            $('[name=select_daerah_ekrt]').addClass("is-invalid");
                            $('.c_daerah').html(error);
                        }

                        if(index == 'select_krt_ekrt') {
                            $('[name=select_krt_ekrt]').addClass("is-invalid");
                            $('.c_krt').html(error);
                        }
                        
                        if(index == 'password_1') {
                            $('[name=password_1], [name=password_2]').addClass("is-invalid");
                            $('.c_password').html(error);
                        }

                        if(index == 'name') {
                            $('[name=name]').addClass("is-invalid");
                            $('.c_name').html(error);
                        }
                        
                        if(index == 'ic') {
                            $('[name=ic]').addClass("is-invalid");
                            $('.c_ic').html(error);
                        }

                        if(index == 'phone') {
                            $('[name=phone]').addClass("is-invalid");
                            $('.c_phone').html(error);
                        }

                        if(index == 'email') {
                            $('[name=email]').addClass("is-invalid");
                            $('.c_email').html(error);
                        }
                        
                        if(index == 'alamat') {
                            $('[name=alamat]').addClass("is-invalid");
                            $('.c_address').html(error);
                        }
                    });
                    $('#btn_add_krt').html(btn_text);                
                    $('#btn_add_krt').prop('disabled', false);            
                } else {
                    $('#user_krt_add_form').trigger("reset");
                    $('#ModalAddeKRT').modal('hide');
                    $('#btn_add_krt').html("Simpan");
                    $('#btn_add_krt').prop('disabled', false);
                    $('#KRT_table').DataTable().ajax.reload();
                }
            });
        });

        // click edit pengguna krt
        $("#select_negeri_ekrt_e").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_daerah_ekrt_e').find('option').remove();
            $('#select_daerah_ekrt_e').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.krt_datatable_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#select_daerah_ekrt_e').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_daerah_ekrt_e')
                            .append($('<option>')
                            .text(obj.daerah_description)
                            .attr('value', obj.daerah_id));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });
        
        $("#select_daerah_ekrt_e").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_krt_ekrt_e').find('option').remove();
            $('#select_krt_ekrt_e').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.krt_datatable_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#select_krt_ekrt_e').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_krt_ekrt_e')
                            .append($('<option>')
                            .text(obj.krt_nama)
                            .attr('value', obj.id));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

        $('body').on('click', '#edit_krt', function () {
             var user_id = $(this).data('id');
            $.get(pengguna_config.routes.krt_datatable_url + '/' + user_id +'/edit', function (data) { 
                
                $('[name=select_peranan_ekrt_e]').val(data.user_role);
                $('[name=select_negeri_ekrt_e]').val(data.state_id);

                if(data.state_id !== ''){
                    var value = data.state_id;
                    var value_daerah = data.daerah_id;
                    $('#select_daerah_ekrt_e').prop("disabled", false);
                    $.ajax({
                        type: "GET",
                        url: pengguna_config.routes.krt_datatable_url,
                        data: {type: 'get_daerah', value: value},
                        success: function (data) {
                            $('#select_daerah_ekrt_e').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                            $.each(data,function(key, obj) 
                            {
                                $('#select_daerah_ekrt_e')
                                .append($('<option>')
                                .text(obj.daerah_description)
                                .attr('value', obj.daerah_id));
                                $('#select_daerah_ekrt_e').val(value_daerah);
                            });
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    }); 
                }else{
                    
                }

                if(data.daerah_id !== ''){
                    var value = data.daerah_id;
                    var value_krt = data.krt_id;
                    $('#select_krt_ekrt_e').prop("disabled", false);
                    $.ajax({
                        type: "GET",
                        url: pengguna_config.routes.krt_datatable_url,
                        data: {type: 'get_krt', value: value},
                        success: function (data) {
                            $('#select_krt_ekrt_e').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                            $.each(data,function(key, obj) 
                            {
                                $('#select_krt_ekrt_e')
                                .append($('<option>')
                                .text(obj.krt_nama)
                                .attr('value', obj.id));
                                $('#select_krt_ekrt_e').val(value_krt);
                            });
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    }); 
                }else{
                    
                }
                
                $('[name=select_krt_ekrt]').val(data.krt_id);
                $('[name=username_edit]').val(data.user_name);
                $('[name=name]').val(data.user_fullname);
                $('[name=ic_edit]').val(data.no_ic); 
                $('[name=phone]').val(data.no_phone); 
                $('[name=email]').val(data.user_email);
                $('[name=alamat]').val(data.user_address);
                $('[name=select_status_ekrt]').val(data.user_status);
                $('[name=user_profile_id]').val(data.user_id);

                $('#ModalEditeKRT').modal('show');
            })
        });
        
        // click kemaskini pengguna krt
        $(document).on('submit', '#user_krt_edit_form', function(event){    
            event.preventDefault();
            $('#btn_edit_krt').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_edit_krt').prop('disabled', true);
            var data = $("#user_krt_edit_form").serialize();
            var action = $('#action_krt').val();
            var btn_text;
            url = pengguna_config.routes.krt_store_url;
            type = "POST";
            btn_text = "Simpan";

            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=select_peranan_ekrt]').removeClass("is-invalid");
                $('[name=select_negeri_ekrt]').removeClass("is-invalid");
                $('[name=select_daerah_ekrt]').removeClass("is-invalid");
                $('[name=select_krt_ekrt]').removeClass("is-invalid");
                $('[name=name]').removeClass("is-invalid");
                $('[name=phone]').removeClass("is-invalid");
                $('[name=email]').removeClass("is-invalid");
                $('[name=alamat]').removeClass("is-invalid");

                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'select_peranan_ekrt') {
                            $('[name=select_peranan_ekrt]').addClass("is-invalid");
                            $('.c_role').html(error);
                        }

                        if(index == 'select_negeri_ekrt') {
                            $('[name=select_negeri_ekrt]').addClass("is-invalid");
                            $('.c_negeri').html(error);
                        }

                        if(index == 'select_daerah_ekrt') {
                            $('[name=select_daerah_ekrt]').addClass("is-invalid");
                            $('.c_daerah').html(error);
                        }

                        if(index == 'select_krt_ekrt') {
                            $('[name=select_krt_ekrt]').addClass("is-invalid");
                            $('.c_krt').html(error);
                        }
                        
                        if(index == 'name') {
                            $('[name=name]').addClass("is-invalid");
                            $('.c_name').html(error);
                        }
                        
                        if(index == 'phone') {
                            $('[name=phone]').addClass("is-invalid");
                            $('.c_phone').html(error);
                        }

                        if(index == 'email') {
                            $('[name=email]').addClass("is-invalid");
                            $('.c_email').html(error);
                        }
                        
                        if(index == 'alamat') {
                            $('[name=alamat]').addClass("is-invalid");
                            $('.c_address').html(error);
                        }
                    });
                    $('#btn_edit_krt').html(btn_text);                
                    $('#btn_edit_krt').prop('disabled', false);            
                } else {
                    $('#user_krt_edit_form').trigger("reset");
                    $('#ModalEditeKRT').modal('hide');
                    $('#btn_edit_krt').html("Simpan");
                    $('#btn_edit_krt').prop('disabled', false);
                    $('#KRT_table').DataTable().ajax.reload();
                }
            });
        });

    /* Pengguna SRS */
        $('#srs_nama_penuh').keyup(function(){
            pengguna_SRS_table.search( $(this).val() ).draw();
        });
        
        $('#srs_no_ic').keyup(function(){
            pengguna_SRS_table.search( $(this).val() ).draw();
        });

        var pengguna_SRS_table = $('#pengguna_SRS_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {url: pengguna_config.routes.srs_datatable_url},
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
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                        return  meta.row+1;
                }
            },{			
                "aTargets": [ 1 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.krt_nama
                }
            },{			
                "aTargets": [ 2 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.user_fullname
                }
            },{			
                "aTargets": [ 3 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.no_ic
                }
            },{			
                "aTargets": [ 4 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.role;
                }
            },{			
                "aTargets": [ 5 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.created_at;
                }
            },{			
                "aTargets": [ 6 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    if (full.user_status == '1') {
                        return 'Aktif';
                    } else {
                        return 'Tidak Aktif';
                    }                
                }
            },{
                "aTargets": [ 7 ], 
                "width": "15%", 
                "sClass": "text-center", 
                "mRender": function ( value, type, full )  {
                    button_a = '<button type="button" class="btn btn-icon" title="Edit" id="edit_srs" data-id="'+full.user_id+'"><i class="fa fa-edit"></i></button>';
                    return button_a;
                }
            }]
        });

        $("#select_negeri_esrs").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_daerah_esrs').find('option').remove();
            $('#select_daerah_esrs').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.krt_datatable_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#select_daerah_esrs').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_daerah_esrs')
                            .append($('<option>')
                            .text(obj.daerah_description)
                            .attr('value', obj.daerah_id));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

        $("#select_daerah_esrs").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_krt_esrs').find('option').remove();
            $('#select_krt_esrs').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.krt_datatable_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#select_krt_esrs').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_krt_esrs')
                            .append($('<option>')
                            .text(obj.krt_nama)
                            .attr('value', obj.id));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

        $("#select_krt_esrs").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_srs_esrs').find('option').remove();
            $('#select_srs_esrs').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.krt_datatable_url,
                    data: {type: 'get_srs', value: value},
                    success: function (data) {
                        $('#select_srs_esrs').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_srs_esrs')
                            .append($('<option>')
                            .text(obj.srs_name)
                            .attr('value', obj.id));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

        $('#alamat_srs').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

        $('#alamat_srs_edit').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

        $('#no_ic_srs').mask('999999999999');

        // click add pengguna srs
        $(document).on('submit', '#user_srs_add_form', function(event){    
            event.preventDefault();
            $('#btn_add_srs').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_add_srs').prop('disabled', true);
            var data = $("#user_srs_add_form").serialize();
            var action = $('#action_srs').val();
            var btn_text;
            url = pengguna_config.routes.srs_store_url;
            type = "POST";
            btn_text = "Simpan";
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=select_peranan_esrs]').removeClass("is-invalid");
                $('[name=select_negeri_esrs]').removeClass("is-invalid");
                $('[name=select_daerah_esrs]').removeClass("is-invalid");
                $('[name=select_krt_esrs]').removeClass("is-invalid");
                $('[name=select_srs_esrs]').removeClass("is-invalid");
                $('[name=password_1]').removeClass("is-invalid");
                $('[name=password_2]').removeClass("is-invalid");
                $('[name=name]').removeClass("is-invalid");
                $('[name=ic]').removeClass("is-invalid");
                $('[name=phone]').removeClass("is-invalid");
                $('[name=email]').removeClass("is-invalid");
                $('[name=alamat]').removeClass("is-invalid");

                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'select_peranan_esrs') {
                            $('[name=select_peranan_esrs]').addClass("is-invalid");
                            $('.c_role').html(error);
                        }

                        if(index == 'select_negeri_esrs') {
                            $('[name=select_negeri_esrs]').addClass("is-invalid");
                            $('.c_negeri').html(error);
                        }

                        if(index == 'select_daerah_esrs') {
                            $('[name=select_daerah_esrs]').addClass("is-invalid");
                            $('.c_daerah').html(error);
                        }

                        if(index == 'select_krt_esrs') {
                            $('[name=select_krt_esrs]').addClass("is-invalid");
                            $('.c_krt').html(error);
                        }

                        if(index == 'select_srs_esrs') {
                            $('[name=select_srs_esrs]').addClass("is-invalid");
                            $('.c_srs').html(error);
                        }
                        
                        if(index == 'password_1') {
                            $('[name=password_1], [name=password_2]').addClass("is-invalid");
                            $('.c_password').html(error);
                        }

                        if(index == 'name') {
                            $('[name=name]').addClass("is-invalid");
                            $('.c_name').html(error);
                        }
                        
                        if(index == 'ic') {
                            $('[name=ic]').addClass("is-invalid");
                            $('.c_ic').html(error);
                        }

                        if(index == 'phone') {
                            $('[name=phone]').addClass("is-invalid");
                            $('.c_phone').html(error);
                        }

                        if(index == 'email') {
                            $('[name=email]').addClass("is-invalid");
                            $('.c_email').html(error);
                        }
                        
                        if(index == 'alamat') {
                            $('[name=alamat]').addClass("is-invalid");
                            $('.c_address').html(error);
                        }
                    });
                    $('#btn_add_srs').html(btn_text);                
                    $('#btn_add_srs').prop('disabled', false);            
                } else {
                    $('#user_srs_add_form').trigger("reset");
                    $('#ModalAddeSRS').modal('hide');
                    $('#btn_add_srs').html("Simpan");
                    $('#btn_add_srs').prop('disabled', false);
                    $('#pengguna_SRS_table').DataTable().ajax.reload();
                }
            });
        });

        // click edit pengguna srs
        $("#select_negeri_esrs_e").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_daerah_esrs_e').find('option').remove();
            $('#select_daerah_esrs_e').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.krt_datatable_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#select_daerah_esrs_e').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_daerah_esrs_e')
                            .append($('<option>')
                            .text(obj.daerah_description)
                            .attr('value', obj.daerah_id));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

        $("#select_daerah_esrs_e").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_krt_esrs_e').find('option').remove();
            $('#select_krt_esrs_e').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.krt_datatable_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#select_krt_esrs_e').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_krt_esrs_e')
                            .append($('<option>')
                            .text(obj.krt_nama)
                            .attr('value', obj.id));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

        $("#select_krt_esrs_e").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_srs_esrs_e').find('option').remove();
            $('#select_srs_esrs_e').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.krt_datatable_url,
                    data: {type: 'get_srs', value: value},
                    success: function (data) {
                        $('#select_srs_esrs_e').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_srs_esrs_e')
                            .append($('<option>')
                            .text(obj.srs_name)
                            .attr('value', obj.id));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

        $('body').on('click', '#edit_srs', function () {
            var user_id = $(this).data('id');
            $.get(pengguna_config.routes.srs_datatable_url + '/' + user_id +'/edit', function (data) { 
                $('[name=select_peranan_esrs_e]').val(data.user_role);
                $('[name=select_negeri_esrs_e]').val(data.state_id);
                // $('[name=select_daerah_esrs]').val(data.daerah_id);
                // $('[name=select_krt_esrs]').val(data.krt_id);
                // $('[name=select_srs_esrs]').val(data.srs_id);
                if(data.state_id !== ''){
                    var value = data.state_id;
                    var value_daerah = data.daerah_id;
                    $('#select_daerah_esrs_e').prop("disabled", false);
                    $.ajax({
                        type: "GET",
                        url: pengguna_config.routes.krt_datatable_url,
                        data: {type: 'get_daerah', value: value},
                        success: function (data) {
                            $('#select_daerah_esrs_e').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                            $.each(data,function(key, obj) 
                            {
                                $('#select_daerah_esrs_e')
                                .append($('<option>')
                                .text(obj.daerah_description)
                                .attr('value', obj.daerah_id));
                                $('#select_daerah_esrs_e').val(value_daerah);
                            });
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    }); 
                }else{
                    
                }

                if(data.daerah_id !== ''){
                    var value = data.daerah_id;
                    var value_krt = data.krt_id;
                    $('#select_krt_esrs_e').prop("disabled", false);
                    $.ajax({
                        type: "GET",
                        url: pengguna_config.routes.krt_datatable_url,
                        data: {type: 'get_krt', value: value},
                        success: function (data) {
                            $('#select_krt_esrs_e').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                            $.each(data,function(key, obj) 
                            {
                                $('#select_krt_esrs_e')
                                .append($('<option>')
                                .text(obj.krt_nama)
                                .attr('value', obj.id));
                                $('#select_krt_esrs_e').val(value_krt);
                            });
                        },
                        
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    }); 
                }else{
                    
                }

                if(data.krt_id !== ''){
                    var value = data.krt_id;
                    var value_srs = data.srs_id;
                    $('#select_srs_esrs_e').prop("disabled", false);
                    $.ajax({
                        type: "GET",
                        url: pengguna_config.routes.krt_datatable_url,
                        data: {type: 'get_srs', value: value},
                        success: function (data) {
                            $('#select_srs_esrs_e').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                            $.each(data,function(key, obj) 
                            {
                                $('#select_srs_esrs_e')
                                .append($('<option>')
                                .text(obj.krt_nama)
                                .attr('value', obj.id));
                                $('#select_srs_esrs_e').val(value_srs);
                            });
                        },
                        
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    }); 
                }else{
                    
                }

                $('[name=name]').val(data.user_fullname);
                $('[name=ic_edit]').val(data.no_ic); 
                $('[name=phone]').val(data.no_phone); 
                $('[name=email]').val(data.user_email);
                $('[name=alamat]').val(data.user_address);
                $('[name=alamat]').val(data.user_address);
                $('[name=select_status_esrs]').val(data.user_status);
                $('[name=user_profile_id]').val(data.user_id);

                $('#ModalEditeSRS').modal('show');
            })
        });

        // click kemaskini pengguna srs
        $(document).on('submit', '#user_srs_edit_form', function(event){    
            event.preventDefault();
            $('#btn_edit_srs').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_edit_srs').prop('disabled', true);
            var data = $("#user_srs_edit_form").serialize();
            var action = $('#action_srs').val();
            var btn_text;
            if (action == 'update') {
                var edit_value = $('#hidden_id_ekrt_user').val();
                url = pengguna_config.routes.srs_store_url + edit_value;
                type = "POST";
                btn_text = "Kemaskini";
            } else {
                url = pengguna_config.routes.srs_store_url;
                type = "POST";
                btn_text = "Kemaskini";
            }

            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=select_peranan_esrs]').removeClass("is-invalid");
                $('[name=select_negeri_esrs]').removeClass("is-invalid");
                $('[name=select_daerah_esrs]').removeClass("is-invalid");
                $('[name=select_krt_esrs]').removeClass("is-invalid");
                $('[name=select_srs_esrs]').removeClass("is-invalid");
                $('[name=name]').removeClass("is-invalid");
                $('[name=ic]').removeClass("is-invalid");
                $('[name=phone]').removeClass("is-invalid");
                $('[name=email]').removeClass("is-invalid");
                $('[name=alamat]').removeClass("is-invalid");

                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'select_peranan_esrs') {
                            $('[name=select_peranan_esrs]').addClass("is-invalid");
                            $('.c_role').html(error);
                        }

                        if(index == 'select_negeri_esrs') {
                            $('[name=select_negeri_esrs]').addClass("is-invalid");
                            $('.c_negeri').html(error);
                        }

                        if(index == 'select_daerah_esrs') {
                            $('[name=select_daerah_esrs]').addClass("is-invalid");
                            $('.c_daerah').html(error);
                        }

                        if(index == 'select_krt_esrs') {
                            $('[name=select_krt_esrs]').addClass("is-invalid");
                            $('.c_krt').html(error);
                        }

                        if(index == 'select_srs_esrs') {
                            $('[name=select_srs_esrs]').addClass("is-invalid");
                            $('.c_srs').html(error);
                        }
                        
                        if(index == 'name') {
                            $('[name=name]').addClass("is-invalid");
                            $('.c_name').html(error);
                        }
                        
                        if(index == 'ic') {
                            $('[name=ic]').addClass("is-invalid");
                            $('.c_ic').html(error);
                        }

                        if(index == 'phone') {
                            $('[name=phone]').addClass("is-invalid");
                            $('.c_phone').html(error);
                        }

                        if(index == 'email') {
                            $('[name=email]').addClass("is-invalid");
                            $('.c_email').html(error);
                        }
                        
                        if(index == 'alamat') {
                            $('[name=alamat]').addClass("is-invalid");
                            $('.c_address').html(error);
                        }
                    });
                    $('#btn_edit_srs').html(btn_text);                
                    $('#btn_edit_srs').prop('disabled', false);            
                } else {
                    $('#user_srs_edit_form').trigger("reset");
                    $('#ModalEditeSRS').modal('hide');
                    $('#btn_edit_srs').html("Simpan");
                    $('#btn_edit_srs').prop('disabled', false);
                    $('#pengguna_SRS_table').DataTable().ajax.reload();
                }
            });
        });
    
</script>


<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>

@stop