@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
<script type="text/javascript">    
    //my custom script
        var pengguna_config = {
            routes: {
                user_jpnin_datatable_url: "{{ route('jpnin.index') }}",
                user_jpnin_store_url: "{{ route('jpnin.store') }}",
                user_orang_awam_datatable_url: "{{ route('orang_awam.index') }}",
                user_orang_awam_store_url: "{{ route('orang_awam.store') }}",
                user_krt_datatable_url: "{{ route('e_krt.index') }}",
                user_krt_store_url: "{{ route('e_krt.store') }}",
                user_srs_datatable_url: "{{ route('e_srs.index') }}",
                user_srs_store_url: "{{ route('e_srs.store') }}",
                user_esepakat_datatable_url: "{{ route('e_sepakat.index') }}",
                user_esepakat_store_url: "{{ route('e_sepakat.store') }}",
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

    /* Pengguna JPNIN */
        var user_jpnin_table = $('#user_jpnin_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {url: pengguna_config.routes.user_jpnin_datatable_url},
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
            "bFilter": true,
            responsive: true,
            rowCallback: function(nRow, aData, index) {
                    var info = user_jpnin_table.page.info();
                    $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
                },
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
                    return full.user_fullname;
                }
            },{			
                "aTargets": [ 2 ], 
                "width": "16%", 
                "mRender": function ( value, type, full )  {
                    return full.no_ic;
                }
            },{			
                "aTargets": [ 3 ], 
                "width": "16%", 
                "mRender": function ( value, type, full )  {
                    return full.no_phone;
                }
            },{			
                "aTargets": [ 4 ], 
                "width": "16%", 
                "mRender": function ( value, type, full )  {
                    return full.role;
                }
            },{			
                "aTargets": [ 5 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                    return full.created_at;
                }
            },{			
                "aTargets": [ 6 ], 
                "width": "6%", 
                "mRender": function ( value, type, full )  {
                    if (full.user_status == '1') {
                        return 'Aktif';
                    } else {
                        return 'Tidak Aktif';
                    }                
                }
            },{
                "aTargets": [ 7 ], 
                "width": "6%", 
                "sClass": "text-center", 
                "mRender": function ( value, type, full )  {
                    // button_a = '<button type="button" class="btn btn-icon" title="Reset Password" id="reset_pass" data-id="'+full.user_id+'"><i class="fa fa-expeditedssl"></i></button>'
                    button_b = '<button type="button" class="btn btn-icon" title="Kemaskini" id="edit_jpnin" data-id="'+full.user_id+'"><i class="fa fa-edit"></i></button>';
                    return button_b
                    // return button_a + '|' + button_b;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('#btn-save-jpnin').html("Simpan");
            }
        });

        $('#myInputTextField_UserJPNIN').keyup(function(){
            user_jpnin_table.search( $(this).val() ).draw();
        });

        $("#select_negeri_jpnin").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_daerah_jpnin').find('option').remove();

            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.user_jpnin_datatable_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#select_daerah_jpnin').append($('<option>').text('- Pilih daerah').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_daerah_jpnin')
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

        $("#select_daerah_jpnin").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_krt_jpnin').find('option').remove();

            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.user_jpnin_datatable_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#select_krt_jpnin').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_krt_jpnin')
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

    // click submit add pengguna JPNIN
        $(document).on('submit', '#user_jpnin_add_form', function(event){    
            event.preventDefault();
            $('#btn_save_jpnin').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_save_jpnin').prop('disabled', true);
            var data = $("#user_jpnin_add_form").serialize();
            var action = $('#action_jpnin').val();
            var btn_text;
            url = pengguna_config.routes.user_jpnin_store_url;
            type = "POST";
            btn_text = "Simpan";
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                // $('[name=select_peranan_jpnin]').removeClass("is-invalid");
                $('[name=select_negeri_jpnin]').removeClass("is-invalid");
                $('[name=select_daerah_jpnin]').removeClass("is-invalid");
                $('[name=select_krt_jpnin]').removeClass("is-invalid");
                $('[name=password_1]').removeClass("is-invalid");
                $('[name=password_2]').removeClass("is-invalid");
                $('[name=name]').removeClass("is-invalid");
                $('[name=ic]').removeClass("is-invalid");
                $('[name=phone]').removeClass("is-invalid");
                $('[name=email]').removeClass("is-invalid");

                if(response.errors){
                    $.each(response.errors, function(index, error){
                        // if(index == 'select_peranan_jpnin') {
                        //     $('[name=select_peranan_jpnin]').addClass("is-invalid");
                        //     $('.c_role').html(error);
                        // }

                        if(index == 'select_negeri_jpnin') {
                            $('[name=select_negeri_jpnin]').addClass("is-invalid");
                            $('.c_negeri').html(error);
                        }

                        if(index == 'select_daerah_jpnin') {
                            $('[name=select_daerah_jpnin]').addClass("is-invalid");
                            $('.c_daerah').html(error);
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

                    });
                    $('#btn_save_jpnin').html(btn_text);                
                    $('#btn_save_jpnin').prop('disabled', false);            
                } else {
                    $('#user_jpnin_add_form').trigger("reset");
                    $('#ModalAddJPNIN').modal('hide');
                    $('#btn_save_jpnin').html("Simpan");
                    $('#btn_save_jpnin').prop('disabled', false);
                    $('#user_jpnin_table').DataTable().ajax.reload();
                }
            });
        });

    // click reset password pengguna JPNIN
        $(document).on('click', '#reset_pass', function(){ 
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var action = 'reset_pass'; 
            var user_id = $(this).data('id');  
            var data = [action, user_id];
            url = pengguna_config.routes.user_jpnin_store_url;
            $.ajax({
                url: url,
                type: "POST",
                data: data,
            });
            alert(data);
        });

    // click edit pengguna JPNIN
        $('body').on('click', '#edit_jpnin', function () {
            var user_id = $(this).data('id');
            $.get(pengguna_config.routes.user_jpnin_datatable_url + '/' + user_id +'/edit', function (data) { 
                // alert(data2);
                
                $('[name=select_edit_negeri_jpnin]').val(data.state_id);
                $('[name=select_edit_daerah_jpnin]').val(data.daerah_id);
                $('[name=select_edit_krt_jpnin]').val(data.krt_id);
                $('[name=edit_username]').val(data.user_name);
                $('[name=edit_name]').val(data.user_fullname);
                $('[name=edit_ic]').val(data.no_ic); 
                $('[name=edit_phone]').val(data.no_phone); 
                $('[name=edit_email]').val(data.user_email);
                $('[name=user_profile_id]').val(data.user_id);
                $('[name=select_status_ekrt_jpnin]').val(data.user_status);
                
                // $("input[name='select_edit_peranan_jpnin[]'][value=" + data2[u].role_id + "]").prop('checked', true);
                
                $('#ModalEditJPNIN').modal('show');
            })

            
        });

        $("#select_edit_negeri_jpnin").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_edit_daerah_jpnin').find('option').remove();

            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.user_jpnin_datatable_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#select_edit_daerah_jpnin').append($('<option>').text('- Pilih daerah').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_edit_daerah_jpnin')
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

        $("#select_edit_daerah_jpnin").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_edit_krt_jpnin').find('option').remove();

            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.user_jpnin_datatable_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#select_edit_krt_jpnin').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_edit_krt_jpnin')
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

    // click sumbit kemaskini pengguna JPNIN
        $(document).on('submit', '#user_jpnin_edit_form', function(event){    
            event.preventDefault();
            $('#btn_edit_jpnin').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_edit_jpnin').prop('disabled', true);
            var data = $("#user_jpnin_edit_form").serialize();
            var action = $('#action_jpnin').val();
            var btn_text;
            url = pengguna_config.routes.user_jpnin_store_url;
            type = "POST";
            btn_text = "Kemaskini";

            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=select_edit_peranan_jpnin]').removeClass("is-invalid");
                $('[name=select_edit_negeri_jpnin]').removeClass("is-invalid");
                $('[name=select_edit_daerah_jpnin]').removeClass("is-invalid");
                $('[name=edit_username]').removeClass("is-invalid");
                $('[name=edit_password_1]').removeClass("is-invalid");
                $('[name=edit_password_2]').removeClass("is-invalid");
                $('[name=edit_name]').removeClass("is-invalid");
                $('[name=edit_ic]').removeClass("is-invalid");
                $('[name=edit_phone]').removeClass("is-invalid");
                $('[name=edit_email]').removeClass("is-invalid");
                $('[name=select_krt_id]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'select_edit_peranan_jpnin') {
                            $('[name=select_edit_peranan_jpnin]').addClass("is-invalid");
                            $('.c_edit_role').html(error);
                        }

                        if(index == 'select_edit_negeri_jpnin') {
                            $('[name=select_edit_negeri_jpnin]').addClass("is-invalid");
                            $('.c_edit_negeri').html(error);
                        }

                        if(index == 'select_edit_daerah_jpnin') {
                            $('[name=select_edit_daerah_jpnin]').addClass("is-invalid");
                            $('.c_edit_daerah').html(error);
                        }

                        if(index == 'edit_username') {
                            $('[name=edit_username]').addClass("is-invalid");
                            $('.c_edit_username').html(error);
                        }

                        if(index == 'edit_password_1') {
                            $('[name=edit_password_1], [name=password_2]').addClass("is-invalid");
                            $('.c_edit_password').html(error);
                        }

                        if(index == 'edit_name') {
                            $('[name=edit_name]').addClass("is-invalid");
                            $('.c_edit_name').html(error);
                        }
                        
                        if(index == 'edit_ic') {
                            $('[name=edit_ic]').addClass("is-invalid");
                            $('.c_edit_ic').html(error);
                        }

                        if(index == 'edit_phone') {
                            $('[name=edit_phone]').addClass("is-invalid");
                            $('.c_edit_phone').html(error);
                        }

                        if(index == 'edit_email') {
                            $('[name=edit_email]').addClass("is-invalid");
                            $('.c_edit_email').html(error);
                        }
                        
                    });
                    $('#btn_edit_jpnin').html(btn_text);                
                    $('#btn_edit_jpnin').prop('disabled', false);            
                } else {
                    $('#user_jpnin_edit_form').trigger("reset");
                    $('#ModalEditJPNIN').modal('hide');
                    $('#btn_edit_jpnin').html("Simpan");
                    $('#btn_edit_jpnin').prop('disabled', false);
                    $('#user_jpnin_table').DataTable().ajax.reload();
                }
            });
        });

    /* Pengguna ORANG AWAM */
        var orang_awam_table = $('#orang_awam_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {url: pengguna_config.routes.user_orang_awam_datatable_url},
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
            "bFilter": true,
            responsive: true,
            rowCallback: function(nRow, aData, index) {
                    var info = user_jpnin_table.page.info();
                    $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
                },
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
                    return full.user_fullname
                }
            },{			
                "aTargets": [ 2 ], 
                "width": "16%", 
                "mRender": function ( value, type, full )  {
                    return full.no_ic
                }
            },{			
                "aTargets": [ 3 ], 
                "width": "16%", 
                "mRender": function ( value, type, full )  {
                    return full.no_phone
                }
            },{			
                "aTargets": [ 4 ], 
                "width": "16%", 
                "mRender": function ( value, type, full )  {
                    return full.short_description;
                }
            },{			
                "aTargets": [ 5 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                    return full.created_at;
                }
            },{			
                "aTargets": [ 6 ], 
                "width": "6%", 
                "mRender": function ( value, type, full )  {
                    if (full.user_status == '1') {
                        return 'Aktif';
                    } else {
                        return 'Tidak Aktif';
                    }                
                }
            },{
                "aTargets": [ 7 ], 
                "width": "6%", 
                "sClass": "text-center", 
                "mRender": function ( value, type, full )  {
                    button_a = '<button type="button" class="btn btn-icon" title="Edit" id="edit_orang_awam" data-id="'+full.user_id+'"><i class="fa fa-edit"></i></button>';
                    return button_a;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('#btn-save-jpnin').html("Simpan");
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
                    url: pengguna_config.routes.user_orang_awam_datatable_url,
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
                    url: pengguna_config.routes.user_orang_awam_datatable_url,
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

        $('#alamat_orang_awam').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

    // click edit pengguna orang awam
        $('body').on('click', '#edit_orang_awam', function () {
            var user_id = $(this).data('id');
            $.get(pengguna_config.routes.user_orang_awam_datatable_url + '/' + user_id +'/edit', function (data) { 
                $('[name=name_orang_awam]').val(data.user_fullname);
                $('[name=ic_orang_awam]').val(data.no_ic); 
                $('[name=phone_orang_awam]').val(data.no_phone); 
                $('[name=email_orang_awam]').val(data.user_email);
                $('[name=user_profile_id]').val(data.user_id);

                $('#ModalOrangAwam').modal('show');
            })
        });

    // click sumbit kemaskini orang awam
        $(document).on('submit', '#user_orang_awam_form', function(event){    
            event.preventDefault();
            $('#btn_save_orang_awam').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_save_orang_awam').prop('disabled', true);
            var data = $("#user_orang_awam_form").serialize();
            var action = $('#action_orang_awam').val();
            var btn_text;
            url = pengguna_config.routes.user_orang_awam_store_url;
            type = "POST";
            btn_text = "Kemaskini";
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=select_peranan_orang_awam]').removeClass("is-invalid");
                $('[name=select_negeri_orang_awam]').removeClass("is-invalid");
                $('[name=select_daerah_orang_awam]').removeClass("is-invalid");
                $('[name=select_krt_orang_awam]').removeClass("is-invalid");
                $('[name=name_orang_awam]').removeClass("is-invalid");
                $('[name=ic_orang_awam]').removeClass("is-invalid");
                $('[name=phone_orang_awam]').removeClass("is-invalid");
                $('[name=email_orang_awam]').removeClass("is-invalid");
                $('[name=alamat_orang_awam]').removeClass("is-invalid");
            
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'select_peranan_orang_awam') {
                            $('[name=select_peranan_orang_awam]').addClass("is-invalid");
                            $('.c_role_orang_awam').html(error);
                        }

                        if(index == 'select_negeri_orang_awam') {
                            $('[name=select_negeri_orang_awam]').addClass("is-invalid");
                            $('.c_negeri_orang_awam').html(error);
                        }

                        if(index == 'select_daerah_orang_awam') {
                            $('[name=select_daerah_orang_awam]').addClass("is-invalid");
                            $('.c_daerah_orang_awam').html(error);
                        }

                        if(index == 'select_krt_orang_awam') {
                            $('[name=select_krt_orang_awam]').addClass("is-invalid");
                            $('.c_krt_orang_awam').html(error);
                        }

                        if(index == 'name_orang_awam') {
                            $('[name=name_orang_awam]').addClass("is-invalid");
                            $('.c_name_orang_awam').html(error);
                        }

                        if(index == 'ic_orang_awam') {
                            $('[name=ic_orang_awam]').addClass("is-invalid");
                            $('.c_ic_orang_awam').html(error);
                        }

                        if(index == 'phone_orang_awam') {
                            $('[name=phone_orang_awam]').addClass("is-invalid");
                            $('.c_phone_orang_awam').html(error);
                        }
                        
                        if(index == 'email_orang_awam') {
                            $('[name=email_orang_awam]').addClass("is-invalid");
                            $('.c_email_orang_awam').html(error);
                        }

                        if(index == 'alamat_orang_awam') {
                            $('[name=alamat_orang_awam]').addClass("is-invalid");
                            $('.c_alamat_orang_awam').html(error);
                        }
                    });
                    $('#btn_save_orang_awam').html(btn_text);                
                    $('#btn_save_orang_awam').prop('disabled', false);            
                } else {
                        $('#user_orang_awam_form').trigger("reset");
                        $('#ModalOrangAwam').modal('hide');
                        $('#btn_save_orang_awam').html("Simpan");
                        $('#btn_save_orang_awam').prop('disabled', false);
                        $('#orang_awam_table').DataTable().ajax.reload();
                }
            });
        });

    /* Pengguna KRT */
        var KRT_table = $('#KRT_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {url: pengguna_config.routes.user_krt_datatable_url},
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
            rowCallback: function(nRow, aData, index) {
                var info = KRT_table.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
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
                "width": "16%", 
                "mRender": function ( value, type, full )  {
                    return full.user_fullname
                }
            },{			
                "aTargets": [ 2 ], 
                "width": "16%", 
                "mRender": function ( value, type, full )  {
                    return full.no_ic
                }
            },{			
                "aTargets": [ 3 ], 
                "width": "16%", 
                "mRender": function ( value, type, full )  {
                    return full.no_phone
                }
            },{			
                "aTargets": [ 4 ], 
                "width": "16%", 
                "mRender": function ( value, type, full )  {
                    return full.short_description;
                }
            },{			
                "aTargets": [ 5 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                    return full.created_at;
                }
            },{			
                "aTargets": [ 6 ], 
                "width": "6%", 
                "mRender": function ( value, type, full )  {
                    if (full.user_status == '1') {
                        return 'Aktif';
                    } else {
                        return 'Tidak Aktif';
                    }                
                }
            },{
                "aTargets": [ 7 ], 
                "width": "6%", 
                "sClass": "text-center", 
                "mRender": function ( value, type, full )  {
                    button_a = '<button type="button" class="btn btn-icon" title="Edit" id="edit_krt" data-id="'+full.user_id+'"><i class="fa fa-edit"></i></button>';
                    return button_a;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                
            }
        });

        $('#select_peranan_ekrt').on('change', function() {
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

        $("#select_negeri_ekrt").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_daerah_ekrt').find('option').remove();

            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.user_krt_datatable_url,
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

            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.user_krt_datatable_url,
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

        $('#alamat_ekrt').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

        $('#select_daerah_ekrt_edit').on('change', function() {
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

        $("#select_negeri_ekrt_edit").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_daerah_ekrt_edit').find('option').remove();

            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.user_krt_datatable_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#select_daerah_ekrt_edit').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_daerah_ekrt_edit')
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

        $("#select_daerah_ekrt_edit").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_krt_ekrt_edit').find('option').remove();

            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.user_krt_datatable_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#select_krt_ekrt_edit').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_krt_ekrt_edit')
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

        $('#ic_ekrt_edit').mask('999999999999');

        $('#alamat_ekrt_edit').on('keyup keypress', function(e) {
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
            url = pengguna_config.routes.user_krt_store_url;
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
                $('[name=username_ekrt]').removeClass("is-invalid");
                $('[name=password_1_ekrt]').removeClass("is-invalid");
                $('[name=password_2_ekrt]').removeClass("is-invalid");
                $('[name=name_ekrt]').removeClass("is-invalid");
                $('[name=ic_ekrt]').removeClass("is-invalid");
                $('[name=phone_ekrt]').removeClass("is-invalid");
                $('[name=email_ekrt]').removeClass("is-invalid");
                $('[name=alamat_ekrt]').removeClass("is-invalid");

                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'select_peranan_ekrt') {
                            $('[name=select_peranan_ekrt]').addClass("is-invalid");
                            $('.c_role_ekrt').html(error);
                        }

                        if(index == 'select_negeri_ekrt') {
                            $('[name=select_negeri_ekrt]').addClass("is-invalid");
                            $('.c_negeri_ekrt').html(error);
                        }

                        if(index == 'select_daerah_ekrt') {
                            $('[name=select_daerah_ekrt]').addClass("is-invalid");
                            $('.c_daerah_ekrt').html(error);
                        }

                        if(index == 'select_krt_ekrt') {
                            $('[name=select_krt_ekrt]').addClass("is-invalid");
                            $('.c_krt_ekrt').html(error);
                        }
                        
                        if(index == 'username_ekrt') {
                            $('[name=username_ekrt]').addClass("is-invalid");
                            $('.c_username_ekrt').html(error);
                        }

                        if(index == 'password_1_ekrt') {
                            $('[name=password_1_ekrt], [name=password_2_ekrt]').addClass("is-invalid");
                            $('.c_password_ekrt').html(error);
                        }

                        if(index == 'name_ekrt') {
                            $('[name=name_ekrt]').addClass("is-invalid");
                            $('.c_name_ekrt').html(error);
                        }
                        
                        if(index == 'ic_ekrt') {
                            $('[name=ic_ekrt]').addClass("is-invalid");
                            $('.c_ic_ekrt').html(error);
                        }

                        if(index == 'phone_ekrt') {
                            $('[name=phone_ekrt]').addClass("is-invalid");
                            $('.c_phone_ekrt').html(error);
                        }

                        if(index == 'email_ekrt') {
                            $('[name=email_ekrt]').addClass("is-invalid");
                            $('.c_email_ekrt').html(error);
                        }
                        
                        if(index == 'alamat_ekrt') {
                            $('[name=alamat_ekrt]').addClass("is-invalid");
                            $('.c_alamat_ekrt').html(error);
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
        $('body').on('click', '#edit_krt', function () {
            var user_id = $(this).data('id');
            $.get(pengguna_config.routes.user_krt_datatable_url + '/' + user_id +'/edit', function (data) { 
                $('[name=select_peranan_ekrt_edit]').val(data.user_role);
                $('[name=select_negeri_ekrt_edit]').val(data.state_id);
                $('[name=select_daerah_ekrt_edit]').val(data.daerah_id);
                $('[name=select_krt_ekrt_edit]').val(data.krt_id);
                $('[name=username_ekrt_edit]').val(data.user_name);
                $('[name=name_ekrt_edit]').val(data.user_fullname);
                $('[name=ic_ekrt_edit]').val(data.no_ic); 
                $('[name=phone_ekrt_edit]').val(data.no_phone); 
                $('[name=email_ekrt_edit]').val(data.user_email);
                $('[name=alamat_ekrt_edit]').val(data.user_address);
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
            url = pengguna_config.routes.user_krt_store_url;
            type = "POST";
            btn_text = "Kemaskini";

            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=select_peranan_ekrt_edit]').removeClass("is-invalid");
                $('[name=select_negeri_ekrt_edit]').removeClass("is-invalid");
                $('[name=select_daerah_ekrt_edit]').removeClass("is-invalid");
                $('[name=select_krt_ekrt_edit]').removeClass("is-invalid");
                $('[name=password_1_ekrt_edit]').removeClass("is-invalid");
                $('[name=password_2_ekrt_edit]').removeClass("is-invalid");
                $('[name=name_ekrt_edit]').removeClass("is-invalid");
                $('[name=phone_ekrt_edit]').removeClass("is-invalid");
                $('[name=email_ekrt_edit]').removeClass("is-invalid");
                $('[name=alamat_ekrt_edit]').removeClass("is-invalid");
                $('[name=select_status_ekrt]').removeClass("is-invalid");

                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'select_peranan_ekrt_edit') {
                            $('[name=select_peranan_ekrt_edit]').addClass("is-invalid");
                            $('.c_role_ekrt_edit').html(error);
                        }

                        if(index == 'select_negeri_ekrt_edit') {
                            $('[name=select_negeri_ekrt_edit]').addClass("is-invalid");
                            $('.c_negeri_ekrt_edit').html(error);
                        }

                        if(index == 'select_daerah_ekrt_edit') {
                            $('[name=select_daerah_ekrt_edit]').addClass("is-invalid");
                            $('.c_daerah_ekrt_edit').html(error);
                        }

                        if(index == 'select_krt_ekrt_edit') {
                            $('[name=select_krt_ekrt_edit]').addClass("is-invalid");
                            $('.c_krt_ekrt_edit').html(error);
                        }
                        
                        if(index == 'password_1_ekrt_edit') {
                            $('[name=password_1_ekrt_edit], [name=password_2_ekrt_edit]').addClass("is-invalid");
                            $('.c_password_ekrt_edit').html(error);
                        }

                        if(index == 'name_ekrt_edit') {
                            $('[name=name_ekrt_edit]').addClass("is-invalid");
                            $('.c_name_ekrt_edit').html(error);
                        }
                        
                        if(index == 'phone_ekrt_edit') {
                            $('[name=phone_ekrt_edit]').addClass("is-invalid");
                            $('.c_phone_ekrt_edit').html(error);
                        }

                        if(index == 'email_ekrt_edit') {
                            $('[name=email_ekrt_edit]').addClass("is-invalid");
                            $('.c_email_ekrt_edit').html(error);
                        }
                        
                        if(index == 'alamat_ekrt_edit') {
                            $('[name=alamat_ekrt_edit]').addClass("is-invalid");
                            $('.c_alamat_ekrt_edit').html(error);
                        }
                    });
                    $('#btn_edit_krt').html(btn_text);                
                    $('#btn_edit_krt').prop('disabled', false);            
                } else {
                    $('#user_krt_edit_form').trigger("reset");
                    $('#ModalEditeKRT').modal('hide');
                    $('#btn_edit_krt').html("Kemaskini");
                    $('#btn_edit_krt').prop('disabled', false);
                    $('#KRT_table').DataTable().ajax.reload();
                }
            });
        });

    /* Pengguna SRS */
        $('#srs_nama_penuh').keyup(function(){
            KRT_table.search( $(this).val() ).draw();
        });
        
        $('#srs_no_ic').keyup(function(){
            KRT_table.search( $(this).val() ).draw();
        });

        var pengguna_SRS_table = $('#pengguna_SRS_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {url: pengguna_config.routes.user_srs_datatable_url},
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
                    return full.user_fullname
                }
            },{			
                "aTargets": [ 2 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.no_ic
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
                    return full.short_description;
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
                    url: pengguna_config.routes.user_srs_datatable_url,
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
                    url: pengguna_config.routes.user_srs_datatable_url,
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
                    url: pengguna_config.routes.user_srs_datatable_url,
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

        $('#ic_esrs').mask('999999999999');

        $('#alamat_esrs').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

        $("#select_negeri_esrs_edit").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_daerah_esrs_edit').find('option').remove();

            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.user_srs_datatable_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#select_daerah_esrs_edit').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_daerah_esrs_edit')
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

        $("#select_daerah_esrs_edit").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_krt_esrs_edit').find('option').remove();

            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.user_srs_datatable_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#select_krt_esrs_edit').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_krt_esrs_edit')
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

        $('#ic_esrs_edit').mask('999999999999');

        $('#alamat_esrs_edit').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();

                // Ajax code here

                return false;
            }
        });

    // click add pengguna srs
        $(document).on('submit', '#user_srs_add_form', function(event){    
            event.preventDefault();
            $('#btn_add_srs').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_add_srs').prop('disabled', true);
            var data = $("#user_srs_add_form").serialize();
            var action = $('#action_srs').val();
            var btn_text;
            url = pengguna_config.routes.user_srs_store_url;
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
                $('[name=username_esrs]').removeClass("is-invalid");
                $('[name=password_1_esrs]').removeClass("is-invalid");
                $('[name=password_2_esrs]').removeClass("is-invalid");
                $('[name=name_esrs]').removeClass("is-invalid");
                $('[name=ic_esrs]').removeClass("is-invalid");
                $('[name=phone_esrs]').removeClass("is-invalid");
                $('[name=email_esrs]').removeClass("is-invalid");
                $('[name=alamat_esrs]').removeClass("is-invalid");

                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'select_peranan_esrs') {
                            $('[name=select_peranan_esrs]').addClass("is-invalid");
                            $('.c_role_esrs').html(error);
                        }

                        if(index == 'select_negeri_esrs') {
                            $('[name=select_negeri_esrs]').addClass("is-invalid");
                            $('.c_negeri_esrs').html(error);
                        }

                        if(index == 'select_daerah_esrs') {
                            $('[name=select_daerah_esrs]').addClass("is-invalid");
                            $('.c_daerah_esrs').html(error);
                        }

                        if(index == 'select_krt_esrs') {
                            $('[name=select_krt_esrs]').addClass("is-invalid");
                            $('.c_krt_esrs').html(error);
                        }

                        if(index == 'select_srs_esrs') {
                            $('[name=select_srs_esrs]').addClass("is-invalid");
                            $('.c_srs_esrs').html(error);
                        }
                        
                        if(index == 'username_esrs') {
                            $('[name=username_esrs]').addClass("is-invalid");
                            $('.c_username_esrs').html(error);
                        }

                        if(index == 'password_1_esrs') {
                            $('[name=password_1_esrs], [name=password_2_esrs]').addClass("is-invalid");
                            $('.c_password_esrs').html(error);
                        }

                        if(index == 'name_esrs') {
                            $('[name=name_esrs]').addClass("is-invalid");
                            $('.c_name_esrs').html(error);
                        }
                        
                        if(index == 'ic_esrs') {
                            $('[name=ic_esrs]').addClass("is-invalid");
                            $('.c_ic_esrs').html(error);
                        }

                        if(index == 'phone_esrs') {
                            $('[name=phone_esrs]').addClass("is-invalid");
                            $('.c_phone_esrs').html(error);
                        }

                        if(index == 'email_esrs') {
                            $('[name=email_esrs]').addClass("is-invalid");
                            $('.c_email_esrs').html(error);
                        }
                        
                        if(index == 'alamat_esrs') {
                            $('[name=alamat_esrs]').addClass("is-invalid");
                            $('.c_alamat_esrs').html(error);
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
        $('body').on('click', '#edit_srs', function () {
            var user_id = $(this).data('id');
            $.get(pengguna_config.routes.user_srs_datatable_url + '/' + user_id +'/edit', function (data) { 
                $('[name=select_peranan_esrs_edit]').val(data.user_role);
                $('[name=select_negeri_esrs_edit]').val(data.state_id);
                $('[name=select_daerah_esrs_edit]').val(data.daerah_id);
                $('[name=select_krt_esrs_edit]').val(data.krt_id);
                $('[name=select_srs_esrs_edit]').val(data.srs_id);
                $('[name=username_esrs_edit]').val(data.user_name);
                $('[name=name_esrs_edit]').val(data.user_fullname);
                $('[name=ic_esrs_edit]').val(data.no_ic); 
                $('[name=phone_esrs_edit]').val(data.no_phone); 
                $('[name=email_esrs_edit]').val(data.user_email);
                $('[name=alamat_esrs_edit]').val(data.user_address);
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
            url = pengguna_config.routes.user_srs_store_url;
                type = "POST";
                btn_text = "Kemaskini";

            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=select_peranan_esrs_edit]').removeClass("is-invalid");
                $('[name=select_negeri_esrs_edit]').removeClass("is-invalid");
                $('[name=select_daerah_esrs_edit]').removeClass("is-invalid");
                $('[name=select_krt_esrs_edit]').removeClass("is-invalid");
                $('[name=select_srs_esrs_edit]').removeClass("is-invalid");
                $('[name=password_1_esrs_edit]').removeClass("is-invalid");
                $('[name=password_2_esrs_edit]').removeClass("is-invalid");
                $('[name=name_esrs_edit]').removeClass("is-invalid");
                $('[name=phone_esrs_edit]').removeClass("is-invalid");
                $('[name=email_esrs_edit]').removeClass("is-invalid");
                $('[name=alamat_esrs_edit]').removeClass("is-invalid");

                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'select_peranan_esrs_edit') {
                            $('[name=select_peranan_esrs_edit]').addClass("is-invalid");
                            $('.c_role_esrs_edit').html(error);
                        }

                        if(index == 'select_negeri_esrs_edit') {
                            $('[name=select_negeri_esrs_edit]').addClass("is-invalid");
                            $('.c_negeri_esrs_edit').html(error);
                        }

                        if(index == 'select_daerah_esrs_edit') {
                            $('[name=select_daerah_esrs_edit]').addClass("is-invalid");
                            $('.c_daerah_esrs_edit').html(error);
                        }

                        if(index == 'select_krt_esrs_edit') {
                            $('[name=select_krt_esrs_edit]').addClass("is-invalid");
                            $('.c_krt_esrs_edit').html(error);
                        }

                        if(index == 'select_srs_esrs_edit') {
                            $('[name=select_srs_esrs_edit]').addClass("is-invalid");
                            $('.c_srs_esrs_edit').html(error);
                        }
                        
                        if(index == 'password_1_esrs_edit') {
                            $('[name=password_1_esrs_edit], [name=password_2]').addClass("is-invalid");
                            $('.c_password_esrs_edit').html(error);
                        }

                        if(index == 'name_esrs_edit') {
                            $('[name=name_esrs_edit]').addClass("is-invalid");
                            $('.c_name_esrs_edit').html(error);
                        }
                        
                        if(index == 'phone_esrs_edit') {
                            $('[name=phone_esrs_edit]').addClass("is-invalid");
                            $('.c_phone_esrs_edit').html(error);
                        }

                        if(index == 'email_esrs_edit') {
                            $('[name=email_esrs_edit]').addClass("is-invalid");
                            $('.c_email_esrs_edit').html(error);
                        }
                        
                        if(index == 'alamat_esrs_edit') {
                            $('[name=alamat_esrs_edit]').addClass("is-invalid");
                            $('.c_alamat_esrs_edit').html(error);
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

    /* Pengguna E-Sepakat */
        $('#select_peranan_sepakat').on('change', function() {
            var i_val = this.value;
            console.log(i_val);
            if (i_val == '15') {
                $(".negeri").css("display", "block");
                $(".daerah").css("display", "block");
            } else if (i_val == '16') {
                $(".negeri").css("display", "block");
                $(".daerah").css("display", "block");
            } else if (i_val == '17') {
                $(".negeri").css("display", "block");
                $(".daerah").css("display", "none");
            } else if (i_val == '18') {
                $(".negeri").css("display", "block");
                $(".daerah").css("display", "none");
            } else if (i_val == '19') {
                $(".negeri").css("display", "none");
                $(".daerah").css("display", "none");
            } else if (i_val == '20') {
                $(".negeri").css("display", "none");
                $(".daerah").css("display", "none");
            } else if (i_val == '21') {
                $(".negeri").css("display", "none");
                $(".daerah").css("display", "none");
            } else if (i_val == '22') {
                $(".negeri").css("display", "block");
                $(".daerah").css("display", "none");
            } else if (i_val == '23') {
                $(".negeri").css("display", "none");
                $(".daerah").css("display", "none");
            } else if (i_val == '24') {
                $(".negeri").css("display", "block");
                $(".daerah").css("display", "none");
            } else if (i_val == '25') {
                $(".negeri").css("display", "block");
                $(".daerah").css("display", "none");
            } 
        });

        $("#select_negeri_sepakat").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#select_daerah_sepakat').find('option').remove();

            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: pengguna_config.routes.user_esepakat_datatable_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#select_daerah_sepakat').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#select_daerah_sepakat')
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

        var pengguna_eSepakat_table = $('#pengguna_eSepakat_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {url: pengguna_config.routes.user_esepakat_datatable_url},
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
                    return full.user_fullname
                }
            },{			
                "aTargets": [ 2 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.no_ic
                }
            },{			
                "aTargets": [ 3 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.no_phone;
                }
            },{			
                "aTargets": [ 4 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.short_description;
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
                    button_a = '<button type="button" class="btn btn-icon" title="Kemaskini" id="edit_esepakat" data-id="'+full.user_id+'"><i class="fa fa-edit"></i></button>';
                    return button_a;
                }
            }]
        });

    // click add pengguna e-Sepakat
        $(document).on('submit', '#user_eSepakat_add_form', function(event){    
            event.preventDefault();
            $('#btn_save_sepakat').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_save_sepakat').prop('disabled', true);
            var data = $("#user_eSepakat_add_form").serialize();
            var action = $('#action_sepakat').val();
            var btn_text;
            url = pengguna_config.routes.user_esepakat_store_url;
            type = "POST";
            btn_text = "Simpan";
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=select_peranan_sepakat]').removeClass("is-invalid");
                $('[name=select_negeri_sepakat]').removeClass("is-invalid");
                $('[name=select_daerah_sepakat]').removeClass("is-invalid");
                $('[name=username_sepakat]').removeClass("is-invalid");
                $('[name=password_1_sepakat]').removeClass("is-invalid");
                $('[name=password_2_sepakat]').removeClass("is-invalid");
                $('[name=name_sepakat]').removeClass("is-invalid");
                $('[name=ic_sepakat]').removeClass("is-invalid");
                $('[name=phone_sepakat]').removeClass("is-invalid");
                $('[name=email_sepakat]').removeClass("is-invalid");

                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'select_peranan_sepakat') {
                            $('[name=select_peranan_sepakat]').addClass("is-invalid");
                            $('.c_peranan_sepakat').html(error);
                        }

                        if(index == 'select_negeri_sepakat') {
                            $('[name=select_negeri_sepakat]').addClass("is-invalid");
                            $('.c_negeri_sepakat').html(error);
                        }

                        if(index == 'select_daerah_sepakat') {
                            $('[name=select_daerah_sepakat]').addClass("is-invalid");
                            $('.c_daerah_sepakat').html(error);
                        }
                        
                        if(index == 'username_sepakat') {
                            $('[name=username_sepakat]').addClass("is-invalid");
                            $('.c_username_sepakat').html(error);
                        }

                        if(index == 'password_1_sepakat') {
                            $('[name=password_1_sepakat], [name=password_2_sepakat]').addClass("is-invalid");
                            $('.c_password_sepakat').html(error);
                        }

                        if(index == 'name_sepakat') {
                            $('[name=name_sepakat]').addClass("is-invalid");
                            $('.c_name_sepakat').html(error);
                        }
                        
                        if(index == 'ic_sepakat') {
                            $('[name=ic_sepakat]').addClass("is-invalid");
                            $('.c_ic_sepakat').html(error);
                        }

                        if(index == 'phone_sepakat') {
                            $('[name=phone_sepakat]').addClass("is-invalid");
                            $('.c_phone_sepakat').html(error);
                        }

                        if(index == 'email_sepakat') {
                            $('[name=email_sepakat]').addClass("is-invalid");
                            $('.c_email_sepakat').html(error);
                        }
                    });
                    $('#btn_save_sepakat').html(btn_text);                
                    $('#btn_save_sepakat').prop('disabled', false);            
                } else {
                    $('#user_eSepakat_add_form').trigger("reset");
                    $('#ModalAddeSepakat').modal('hide');
                    $('#btn_save_sepakat').html("Simpan");
                    $('#btn_save_sepakat').prop('disabled', false);
                    $('#pengguna_eSepakat_table').DataTable().ajax.reload();
                }
            });
        });

    // click edit pengguna e-Sepakat
        $('body').on('click', '#edit_esepakat', function () {
            var user_id = $(this).data('id');
            $.get(pengguna_config.routes.user_esepakat_datatable_url + '/' + user_id +'/edit', function (data) { 
                $('[name=select_peranan_sepakat_edit]').val(data.user_role);
                if (data.user_role == '15') {
                    $(".negeri").css("display", "block");
                    $(".daerah").css("display", "block");
                } else if (data.user_role == '16') {
                    $(".negeri").css("display", "block");
                    $(".daerah").css("display", "block");
                } else if (data.user_role == '17') {
                    $(".negeri").css("display", "block");
                    $(".daerah").css("display", "none");
                } else if (data.user_role == '18') {
                    $(".negeri").css("display", "block");
                    $(".daerah").css("display", "none");
                } else if (data.user_role == '19') {
                    $(".negeri").css("display", "block");
                    $(".daerah").css("display", "block");
                } else if (data.user_role == '20') {
                    $(".negeri").css("display", "block");
                    $(".daerah").css("display", "block");
                } else if (data.user_role == '21') {
                    $(".negeri").css("display", "none");
                    $(".daerah").css("display", "none");
                } else if (data.user_role == '22') {
                    $(".negeri").css("display", "block");
                    $(".daerah").css("display", "none");
                } else if (data.user_role == '23') {
                    $(".negeri").css("display", "none");
                    $(".daerah").css("display", "none");
                } else if (data.user_role == '24') {
                    $(".negeri").css("display", "block");
                    $(".daerah").css("display", "none");
                } else if (data.user_role == '25') {
                    $(".negeri").css("display", "block");
                    $(".daerah").css("display", "none");
                } 
                $('[name=select_negeri_sepakat_edit]').val(data.state_id);
                $('[name=select_daerah_sepakat_edit]').val(data.daerah_id);
                $('[name=username_sepakat_edit]').val(data.user_name);
                $('[name=name_sepakat_edit]').val(data.user_fullname);
                $('[name=ic_sepakat_edit]').val(data.no_ic); 
                $('[name=phone_sepakat_edit]').val(data.no_phone); 
                $('[name=email_sepakat_edit]').val(data.user_email);
                $('[name=select_status_sepakat]').val(data.user_status);
                $('[name=user_profile_id]').val(data.user_id);
                $('#ModalEditeSepakat').modal('show');
            })
        });

    // click kemaskini pengguna e-Sepakat
        $(document).on('submit', '#user_eSepakat_edit_form', function(event){    
            event.preventDefault();
            $('#btn_edit_sepakat').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_edit_sepakat').prop('disabled', true);
            var data = $("#user_eSepakat_edit_form").serialize();
            var action = $('#action_sepakat').val();
            var btn_text;
            url = pengguna_config.routes.user_esepakat_store_url;
                type = "POST";
                btn_text = "Kemaskini";

            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=select_peranan_sepakat_edit]').removeClass("is-invalid");
                $('[name=select_negeri_sepakat_edit]').removeClass("is-invalid");
                $('[name=select_daerah_sepakat_edit]').removeClass("is-invalid");
                $('[name=password_1_sepakat_edit]').removeClass("is-invalid");
                $('[name=password_2_sepakat_edit]').removeClass("is-invalid");
                $('[name=name_sepakat_edit]').removeClass("is-invalid");
                $('[name=phone_sepakat_edit]').removeClass("is-invalid");
                $('[name=email_sepakat_edit]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'select_peranan_sepakat_edit') {
                            $('[name=select_peranan_sepakat_edit]').addClass("is-invalid");
                            $('.c_peranan_sepakat_edit').html(error);
                        }

                        if(index == 'select_negeri_sepakat_edit') {
                            $('[name=select_negeri_sepakat_edit]').addClass("is-invalid");
                            $('.c_negeri_sepakat_edit').html(error);
                        }

                        if(index == 'select_daerah_sepakat_edit') {
                            $('[name=select_daerah_sepakat_edit]').addClass("is-invalid");
                            $('.c_daerah_sepakat_edit').html(error);
                        }

                        if(index == 'password_1_sepakat_edit') {
                            $('[name=password_1_sepakat_edit], [name=password_2]').addClass("is-invalid");
                            $('.c_password_sepakat_edit').html(error);
                        }

                        if(index == 'name_sepakat_edit') {
                            $('[name=name_sepakat_edit]').addClass("is-invalid");
                            $('.c_name_sepakat_edit').html(error);
                        }
                        
                        if(index == 'phone_sepakat_edit') {
                            $('[name=phone_sepakat_edit]').addClass("is-invalid");
                            $('.c_phone_sepakat_edit').html(error);
                        }

                        if(index == 'email_sepakat_edit') {
                            $('[name=email_sepakat_edit]').addClass("is-invalid");
                            $('.c_email_sepakat_edit').html(error);
                        }
                        
                    });
                    $('#btn_edit_sepakat').html(btn_text);                
                    $('#btn_edit_sepakat').prop('disabled', false);            
                } else {
                    $('#user_eSepakat_edit_form').trigger("reset");
                    $('#ModalEditeSepakat').modal('hide');
                    $('#btn_edit_sepakat').html("Simpan");
                    $('#btn_edit_sepakat').prop('disabled', false);
                    $('#pengguna_eSepakat_table').DataTable().ajax.reload();
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop