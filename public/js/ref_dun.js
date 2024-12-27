var table_dun = $('#dun_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {url: rujukan_data_config.routes.dun_datatable_url},
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
    "aoColumnDefs":[{			
        "aTargets": [ 0 ], 
        "width": "5%", 
        "mRender": function ( value, type, full )  {
            return full.dun_id
        }
    },{			
        "aTargets": [ 1 ], 
        "width": "30%", 
        "mRender": function ( value, type, full )  {
            return full.dun_description
        }
    },{			
        "aTargets": [ 2 ], 
        "width": "30%", 
        "mRender": function ( value, type, full )  {
            return full.parlimen_description;
        }
    },{			
        "aTargets": [ 3 ], 
        "width": "20%", 
        "mRender": function ( value, type, full )  {
            return full.state_description;
        }
    },{
        "aTargets": [ 4 ], 
        "width": "20%", 
        "sClass": "text-center", 
        "mRender": function ( value, type, full )  {
            button_a = '<button type="button" class="btn btn-icon" title="Edit" id="edit-dun" data-id="'+full.id+'"><i class="fa fa-edit"></i></button>';
            button_b = '<button type="button" class="btn btn-icon js-sweetalert" title="Delete" id="delete-dun" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
            return button_a + button_b;
        }
    }],
    "order": [[ 0, 'asc' ]],
    initComplete: function () {
        $('#btn-save-dun').html("Simpan");
    }
});

$('#myInputTextField_DUN').keyup(function(){
    table_dun.search( $(this).val() ).draw();
})

$("#mySelectField_DUN").on( 'keyup change clear', function () {
    var value = $(this).find('option:selected').text();
    var selectedIndex = $(this).find('option:selected').index();

    if (selectedIndex == '0') {
        table_dun.search('').draw();
    } else {
        table_dun
            .column()
            .search(value)
            .draw();
    }
} );

$("#select_negeri_dun").on( 'change', function () {
    var value = $(this).find('option:selected').val();
    var selectedIndex = $(this).find('option:selected').index();
    $('#select_parlimen_dun').find('option').remove();

    if (selectedIndex !== '0') {
        $.ajax({
            type: "GET",
            url: rujukan_data_config.routes.dun_action_url,
            data: {type: 'get_negeri', value: value},
            success: function (data) {
                $('#select_parlimen_dun').append($('<option>').text('- Pilih parlimen').attr('value', ''));
                $.each(data,function(key, obj) 
                {
                    $('#select_parlimen_dun')
                    .append($('<option>')
                    .text(obj.parlimen_description)
                    .attr('value', obj.id));
                });
            },
            error: function (data) {
                console.log('Error:', data);
            }
        }); 
    }
} );

/* Clear modal form */
$('#ModalDUN').on('hidden.bs.modal', function(e){
    $(this).find('form').trigger('reset');
    $('#ModalDUNLabel').html("Tambah DUN");
    $('#hidden_id_dun').val("");
    $('#action_dun').val("add");
    $('#method_dun').val("");
    $('#btn-save-dun').html("Simpan");
});

/* click edit dun */
$('body').on('click', '#edit-dun', function () {
    var dun_id = $(this).data('id');
    var info = $('.error_alert');            
    info.hide();
    
    $.get(rujukan_data_config.routes.dun_action_url + dun_id +'/edit', function (data) {                          
        $('#ModalDUNLabel').html("Kemaskini DUN");
        $('#btn-save-dun').html("Kemaskini");        
        $('#hidden_id_dun').val(data.id);
        $('#action_dun').val("update");
        $('#method_dun').val("PUT");
        $('#kod_dun').val(data.dun_id);
        $('#input_dun').val(data.dun_description);
        $('#select_negeri_dun').val(data.state_id);
        $("#select_negeri_dun").change();
        setTimeout(function(){
            $('#select_parlimen_dun').val(data.parlimen_id);
        }, 500);
        $('#ModalDUN').modal('show');
    })
});

/* click delete dun */
$('body').on('click', '#delete-dun', function () {
    var delete_id = $(this).data("id");
    swal({
        title: "Anda pasti?",
        text: "Anda akan memadam rekod DUN dari pangkalan data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, sila padam!",
        cancelButtonText: "Tidak",
        closeOnConfirm: false,
        closeOnCancel: false
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: "DELETE",
                url: rujukan_data_config.routes.dun_action_url + delete_id,
                success: function (data) {
                    $('#dun_form').trigger("reset");
                    $('#dun_table').DataTable().ajax.reload();
                    swal("Sudah dipadam!", "Rekod DUN telah dipadam dari pangkalan data", "success");
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });                    
        } else {
            swal("Tidak", "Proses pemadaman tidak berlaku", "error");
        }
    });
});

$(document).on('submit', '#dun_form', function(event){
    var info = $('.error_alert');
    event.preventDefault();
    $('#btn-save-dun').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
    $('#btn-save-dun').prop('disabled', true);
    var data = $("#dun_form").serialize();
    var action = $('#action_dun').val();
    var btn_text;
    if (action == 'update') {
        var edit_value = $('#hidden_id_dun').val();
        url = rujukan_data_config.routes.dun_action_url + edit_value;
        type = "POST";
        btn_text = "Kemaskini";
    } else {
        url = rujukan_data_config.routes.dun_store_url;
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
            $('#btn-save-dun').html(btn_text);                
            $('#btn-save-dun').prop('disabled', false);
            info.slideDown();
        } else {
            $('#dun_form').trigger("reset");
            $('#ModalDUN').modal('hide');            
            $('#ModalDUNLabel').html("Tambah DUN");
            $('#hidden_id_dun').val("");
            $('#action_dun').val("add");
            $('#method_dun').val("");
            $('#btn-save-dun').html("Simpan");
            $('#btn-save-dun').prop('disabled', false);
            $('#dun_table').DataTable().ajax.reload();
        }
    });
});