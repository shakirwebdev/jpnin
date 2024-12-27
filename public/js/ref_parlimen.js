var table_parlimen = $('#parlimen_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {url: rujukan_data_config.routes.parlimen_datatable_url},
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
        "width": "10%", 
        "mRender": function ( value, type, full )  {
            return full.parlimen_id
        }
    },{			
        "aTargets": [ 1 ], 
        "width": "40%", 
        "mRender": function ( value, type, full )  {
            return full.parlimen_description
        }
    },{			
        "aTargets": [ 2 ], 
        "width": "30%", 
        "mRender": function ( value, type, full )  {
            return full.state_description;
        }
    },{
        "aTargets": [ 3 ], 
        "width": "20%", 
        "sClass": "text-center", 
        "mRender": function ( value, type, full )  {
            button_a = '<button type="button" class="btn btn-icon" title="Edit" id="edit-parlimen" data-id="'+full.id+'"><i class="fa fa-edit"></i></button>';
            button_b = '<button type="button" class="btn btn-icon js-sweetalert" title="Delete" id="delete-parlimen" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
            return button_a + button_b;
        }
    }],
    "order": [[ 0, 'asc' ]],
    initComplete: function () {
        $('#btn-save-parlimen').html("Simpan");
    }
});

$('#myInputTextField_Parlimen').keyup(function(){
    table_parlimen.search( $(this).val() ).draw();
})

$("#mySelectField_Parlimen").on( 'keyup change clear', function () {
    var value = $(this).find('option:selected').text();
    var selectedIndex = $(this).find('option:selected').index();

    if (selectedIndex == '0') {
        table_parlimen.search('').draw();
    } else {
        table_parlimen
            .column()
            .search(value)
            .draw();
    }
} );

/* Clear modal form */
$('#ModalParlimen').on('hidden.bs.modal', function(e){
    $(this).find('form').trigger('reset');
    $('#ModalParlimenLabel').html("Tambah Parlimen");
    $('#hidden_id_parlimen').val("");
    $('#action_parlimen').val("add");
    $('#method_parlimen').val("");
    $('#btn-save-parlimen').html("Simpan");
});

/* click edit parlimen */
$('body').on('click', '#edit-parlimen', function () {
    var parlimen_id = $(this).data('id');
    var info = $('.error_alert');            
    info.hide();
    
    $.get(rujukan_data_config.routes.parlimen_action_url + parlimen_id +'/edit', function (data) {                          
        $('#ModalParlimenLabel').html("Kemaskini Parlimen");
        $('#btn-save-parlimen').html("Kemaskini");
        $('#ModalParlimen').modal('show');
        $('#hidden_id_parlimen').val(data.id);
        $('#action_parlimen').val("update");
        $('#method_parlimen').val("PUT");
        $('#kod_parlimen').val(data.parlimen_id);
        $('#input_parlimen').val(data.parlimen_description);
        $('#select_negeri_parlimen').val(data.state_id);
    })
});

/* click delete parlimen */
$('body').on('click', '#delete-parlimen', function () {
    var delete_id = $(this).data("id");
    swal({
        title: "Anda pasti?",
        text: "Anda akan memadam rekod parlimen dari pangkalan data!",
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
                url: rujukan_data_config.routes.parlimen_action_url + delete_id,
                success: function (data) {
                    $('#parlimen_form').trigger("reset");
                    $('#parlimen_table').DataTable().ajax.reload();
                    swal("Sudah dipadam!", "Rekod parlimen telah dipadam dari pangkalan data", "success");
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

$(document).on('submit', '#parlimen_form', function(event){
    var info = $('.error_alert');
    event.preventDefault();
    $('#btn-save-parlimen').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
    $('#btn-save-parlimen').prop('disabled', true);
    var data = $("#parlimen_form").serialize();
    var action = $('#action_parlimen').val();
    var btn_text;
    if (action == 'update') {
        var edit_value = $('#hidden_id_parlimen').val();
        url = rujukan_data_config.routes.parlimen_action_url + edit_value;
        type = "POST";
        btn_text = "Kemaskini";
    } else {
        url = rujukan_data_config.routes.parlimen_store_url;
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
            $('#btn-save-parlimen').html(btn_text);                
            $('#btn-save-parlimen').prop('disabled', false);
            info.slideDown();
        } else {
            $('#parlimen_form').trigger("reset");
            $('#ModalParlimen').modal('hide');
            $('#ModalParlimenLabel').html("Tambah Parlimen");
            $('#hidden_id_parlimen').val("");
            $('#action_parlimen').val("add");
            $('#method_parlimen').val("");
            $('#btn-save-parlimen').html("Simpan");
            $('#btn-save-parlimen').prop('disabled', false);
            $('#parlimen_table').DataTable().ajax.reload();
        }
    });
});