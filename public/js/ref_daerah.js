var table_daerah = $('#daerah_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {url: rujukan_data_config.routes.daerah_datatable_url},
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
            return full.daerah_id
        }
    },{			
        "aTargets": [ 1 ], 
        "width": "40%", 
        "mRender": function ( value, type, full )  {
            return full.daerah_description
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
            button_a = '<button type="button" class="btn btn-icon" title="Edit" id="edit-daerah" data-id="'+full.id+'"><i class="fa fa-edit"></i></button>';
            button_b = '<button type="button" class="btn btn-icon js-sweetalert" title="Delete" id="delete-daerah" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
            return button_a + button_b;
        }
    }],
    "order": [[ 0, 'asc' ]],
    initComplete: function () {
        $('#btn-save-daerah').html("Simpan");
    }
});

$('#myInputTextField_Daerah').keyup(function(){
    table_daerah.search( $(this).val() ).draw();
})

$("#mySelectField_Daerah").on( 'keyup change clear', function () {
    var value = $(this).find('option:selected').text();
    var selectedIndex = $(this).find('option:selected').index();

    if (selectedIndex == '0') {
        table_daerah.search('').draw();
    } else {
        table_daerah
            .column()
            .search(value)
            .draw();
    }
} );

/* Clear modal form */
$('#ModalDaerah').on('hidden.bs.modal', function(e){
    $(this).find('form').trigger('reset');
    $('#ModalDaerahLabel').html("Tambah Daerah");
    $('#hidden_id_daerah').val("");
    $('#action_daerah').val("add");
    $('#method_daerah').val("");
    $('#btn-save-daerah').html("Simpan");
});

/* click edit daerah */
$('body').on('click', '#edit-daerah', function () {
    var daerah_id = $(this).data('id');
    var info = $('.error_alert');            
    info.hide();
    
    $.get(rujukan_data_config.routes.daerah_action_url + daerah_id +'/edit', function (data) {                          
        $('#ModalDaerahLabel').html("Kemaskini Daerah");
        $('#btn-save-daerah').html("Kemaskini");
        $('#ModalDaerah').modal('show');
        $('#hidden_id_daerah').val(data.id);
        $('#action_daerah').val("update");
        $('#method_daerah').val("PUT");
        $('#kod_daerah').val(data.daerah_id);
        $('#input_daerah').val(data.daerah_description);
        $('#select_negeri').val(data.state_id);
    })
});

/* click delete daerah */
$('body').on('click', '#delete-daerah', function () {
    var delete_id = $(this).data("id");
    swal({
        title: "Anda pasti?",
        text: "Anda akan memadam rekod daerah dari pangkalan data!",
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
                url: rujukan_data_config.routes.daerah_action_url + delete_id,
                success: function (data) {
                    $('#daerah_form').trigger("reset");
                    $('#daerah_table').DataTable().ajax.reload();
                    swal("Sudah dipadam!", "Rekod daerah telah dipadam dari pangkalan data", "success");
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

$(document).on('submit', '#daerah_form', function(event){
    var info = $('.error_alert');
    event.preventDefault();
    $('#btn-save-daerah').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
    $('#btn-save-daerah').prop('disabled', true);
    var data = $("#daerah_form").serialize();
    var action = $('#action_daerah').val();
    var btn_text;
    if (action == 'update') {
        var edit_value = $('#hidden_id_daerah').val();
        url = rujukan_data_config.routes.daerah_action_url + edit_value;
        type = "POST";
        btn_text = "Kemaskini";
    } else {
        url = rujukan_data_config.routes.daerah_store_url;
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
            $('#btn-save-daerah').html(btn_text);                
            $('#btn-save-daerah').prop('disabled', false);
            info.slideDown();
        } else {
            $('#daerah_form').trigger("reset");
            $('#ModalDaerah').modal('hide');
            $('#ModalDaerahLabel').html("Tambah Daerah");
            $('#hidden_id_daerah').val("");
            $('#action_daerah').val("add");
            $('#method_daerah').val("");
            $('#btn-save-daerah').html("Simpan");
            $('#btn-save-daerah').prop('disabled', false);
            $('#daerah_table').DataTable().ajax.reload();
        }
    });
});