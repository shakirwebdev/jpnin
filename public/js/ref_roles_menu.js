$(function(){    
   //init editables 
   $('.myeditable').editable({
      url: peranan_config.routes.menu_store_url,
      placement: 'right',
      mode: 'inline'
   });

   $('#peranan_menu_tabs').editable({
        prepend: "not selected",
        mode: 'inline',
        source: [
            {value: 1, text: 'Tidak'},
            {value: 2, text: 'Ya'}
        ],
        display: function(value, sourceData) {
            var colors = {"": "gray", 1: "red", 2: "green"},
                elem = $.grep(sourceData, function(o){return o.value == value;});
                
            if(elem.length) {    
                $(this).text(elem[0].text).css("color", colors[value]); 
            } else {
                $(this).empty(); 
            }
        }   
    });
   
   //make username required
   $('#peranan_menu_nama').editable('option', 'validate', function(v) {
       if(!v) return 'Isi ruangan ini';
   });
   
   //create new user
   $('#btn-save-menu').click(function() {
        var info = $('.error_alert');
        event.preventDefault();
        $('#btn-save-menu').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
        $('#btn-save-menu').prop('disabled', true);

        var info = $('.error_alert');
        event.preventDefault();
        $('#btn-save-menu').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
        $('#btn-save-menu').prop('disabled', true);
        var data = $("#peranan_menu_form").serialize();
        var action = $('#action_peranan_menu').val();
        var btn_text;
        if (action == 'update') {
            var edit_value = $('#hidden_id_peranan_menu').val();
            url = peranan_config.routes.menu_action_url + edit_value;
            type = "POST";
            btn_text = "Kemaskini";
        } else {
            url = peranan_config.routes.menu_store_url;
            type = "POST";
            btn_text = "Simpan";
        }

        var m_url = $('#peranan_menu_url').html();
        var m_nama = $('#peranan_menu_nama').html();
        var m_ikon = $('#peranan_menu_ikon').html();
        var m_tab = $('#peranan_menu_tabs').html();


        $.ajax({
            url: url,
            type: type,
            data: {url:m_url, nama:m_nama, ikon:m_ikon, tab:m_tab},
        }).done(function(response) {            
            info.hide().find('ul').empty();
            if(response.errors){
                $.each(response.errors, function(index, error){
                    info.find('ul').append('<li>'+error+'</li>');
                });
                $('#btn-save-menu').html(btn_text);                
                $('#btn-save-menu').prop('disabled', false);
                info.slideDown();
            } else {
                $(this).find('form').trigger('reset');
                $('#hidden_id_peranan_menu').val("");
                $('#action_peranan_menu').val("add");
                $('#peranan_menu_tabs').html("not selected");    
                $('#method_peranan_menu').val("");
                $('#btn-save-menu').html("Simpan");
                $('.myeditable').editable('setValue', null)
                                .editable('option', 'pk', null)
                                .removeClass('editable-unsaved');
                
                $('#save-btn').show();
                $('#msg').hide();
            }
        });
   }); 
   
   //reset
   $('#reset-btn').click(function() {
       $('.myeditable').editable('setValue', null)
                       .editable('option', 'pk', null)
                       .removeClass('editable-unsaved');
                       
       $('#save-btn').show();
       $('#msg').hide();                
   });
});

$('#ModalMenuEdit').on('show.bs.modal', function (event) {
    var filtre=$(event.relatedTarget).attr('data-url');
    $('#peranan_menu_url').html(filtre);
    $('#peranan_menu_url_form').val(filtre);
});

/* Clear modal form */
$('#ModalMenuEdit').on('hidden.bs.modal', function(e){
    $(this).find('form').trigger('reset');
    $('#hidden_id_peranan_menu').val("");
    $('#action_peranan_menu').val("add");
    $('#peranan_menu_tabs').html("not selected");    
    $('#method_peranan_menu').val("");
    $('#btn-save-menu').html("Simpan");
    $('.myeditable').editable('setValue', null)
                    .editable('option', 'pk', null)
                    .removeClass('editable-unsaved');
    
    $('#save-btn').show();
    $('#msg').hide();
});

/* click edit peranan */
$('body').on('click', '#edit-peranan', function () {
    var peranan_id = $(this).data('id');
    var info = $('.error_alert');            
    info.hide();
    
    $.get(peranan_config.routes.user_action_url + peranan_id +'/edit', function (data) {                          
        $('#ModalPerananLabel').html("Kemaskini Peranan Pengguna");
        $('#btn-save-peranan').html("Kemaskini");
        $('#ModalPeranan').modal('show');
        $('#hidden_id_peranan').val(data.id);
        $('#action_peranan').val("update");
        $('#method_peranan').val("PUT");
        $('#input_peranan_nama').val(data.short_description);
        $('#input_peranan_penerangan').val(data.long_description);
    })
});

$(document).on('submit', '#peranan_menu_form', function(event){
    var info = $('.error_alert');
    event.preventDefault();
    $('#btn-save-peranan').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
    $('#btn-save-peranan').prop('disabled', true);
    var data = $("#peranan_menu_form").serialize();
    var action = $('#action_peranan').val();
    var btn_text;
    if (action == 'update') {
        var edit_value = $('#hidden_id_peranan').val();
        url = peranan_config.routes.user_action_url + edit_value;
        type = "POST";
        btn_text = "Kemaskini";
    } else {
        url = peranan_config.routes.user_store_url;
        type = "POST";
        btn_text = "Simpan";
    }

    $.ajax({
        url: url,
        type: type,
        data: data,
    }).done(function(response) {            
        info.hide().find('ul').empty();
        if(response.errors){
            $.each(response.errors, function(index, error){
                info.find('ul').append('<li>'+error+'</li>');
            });
            $('#btn-save-peranan').html(btn_text);                
            $('#btn-save-peranan').prop('disabled', false);
            info.slideDown();
        } else {
            $('#peranan_form').trigger("reset");
            $('#ModalPeranan').modal('hide');
            $('#ModalPerananLabel').html("Tambah Peranan Pengguna");
            $('#hidden_id_peranan').val("");
            $('#action_peranan').val("add");
            $('#method_peranan').val("");
            $('#btn-save-peranan').html("Simpan");
            $('#btn-save-peranan').prop('disabled', false);
            $('#peranan_table').DataTable().ajax.reload();
        }
    });
});