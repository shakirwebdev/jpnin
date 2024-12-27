var table_peranan = $('#peranan_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {url: peranan_config.routes.user_datatable_url},
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
        "mRender": function ( value, type, full )  {
            return full.id
        }
    },{			
        "aTargets": [ 1 ], 
        "width": "45%", 
        "mRender": function ( value, type, full )  {
            return full.short_description
        }
    },{			
        "aTargets": [ 2 ], 
        "width": "35%", 
        "mRender": function ( value, type, full )  {
            return full.long_description;
        }
    },{
        "aTargets": [ 3 ], 
        "width": "20%", 
        "sClass": "text-center", 
        "mRender": function ( value, type, full )  {
            button_a = '<button type="button" class="btn btn-icon" title="Edit" id="edit-peranan" data-id="'+full.id+'"><i class="fa fa-edit"></i></button>';
            button_b = '<button type="button" class="btn btn-icon js-sweetalert" title="Delete" id="delete-peranan" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
            return button_a + button_b;
        }
    }],
    "order": [[ 0, 'asc' ]],
    initComplete: function () {
        $('#btn-save-peranan').html("Simpan");
    }
});

$('#myInputTextField_Peranan').keyup(function(){
    table_peranan.search( $(this).val() ).draw();
})

/* Clear modal form */
$('#ModalPeranan').on('hidden.bs.modal', function(e){
    $(this).find('form').trigger('reset');
    $('#ModalPerananLabel').html("Tambah Peranan Pengguna");
    $('#hidden_id_peranan').val("");
    $('#action_peranan').val("add");
    $('#method_peranan').val("");
    $('#btn-save-peranan').html("Simpan");
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

/* click delete peranan */
$('body').on('click', '#delete-peranan', function () {
    var delete_id = $(this).data("id");
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
        if (isConfirm) {
            $.ajax({
                type: "DELETE",
                url: peranan_config.routes.user_action_url + delete_id,
                success: function (data) {
                    $('#peranan_form').trigger("reset");
                    $('#peranan_table').DataTable().ajax.reload();
                    swal("Sudah dipadam!", "Rekod peranan telah dipadam dari pangkalan data", "success");
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

$(document).on('submit', '#peranan_form', function(event){
    var info = $('.error_alert');
    event.preventDefault();
    $('#btn-save-peranan').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
    $('#btn-save-peranan').prop('disabled', true);
    var data = $("#peranan_form").serialize();
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