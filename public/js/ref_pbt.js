var table_pbt = $('#pbt_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {url: rujukan_data_config.routes.pbt_datatable_url},
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
        "width": "45%", 
        "mRender": function ( value, type, full )  {
            return full.pbt_id
        }
    },{			
        "aTargets": [ 1 ], 
        "width": "45%", 
        "mRender": function ( value, type, full )  {
            return full.pbt_description
        }
    },{			
        "aTargets": [ 2 ], 
        "width": "35%", 
        "mRender": function ( value, type, full )  {
            return full.state_description;
        }
    },{
        "aTargets": [ 3 ], 
        "width": "20%", 
        "sClass": "text-center", 
        "mRender": function ( value, type, full )  {
            button_a = '<button type="button" class="btn btn-icon" title="Edit" id="edit-pbt" data-id="'+full.id+'"><i class="fa fa-edit"></i></button>';
            button_b = '<button type="button" class="btn btn-icon js-sweetalert" title="Delete" id="delete-pbt" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
            return button_a + button_b;
        }
    }],
    "order": [[ 0, 'asc' ]],
    initComplete: function () {
        $('#btn-save-pbt').html("Simpan");
    }
});

$('#myInputTextField_PBT').keyup(function(){
    table_pbt.search( $(this).val() ).draw();
})

$("#mySelectField_PBT").on( 'keyup change clear', function () {
    var value = $(this).find('option:selected').text();
    var selectedIndex = $(this).find('option:selected').index();

    if (selectedIndex == '0') {
        table_pbt.search('').draw();
    } else {
        table_pbt
            .column()
            .search(value)
            .draw();
    }
} );

/* Clear modal form */
$('#ModalPBT').on('hidden.bs.modal', function(e){
    $(this).find('form').trigger('reset');
    $('#ModalPBTLabel').html("Tambah PBT");
    $('#hidden_id_pbt').val("");
    $('#action_pbt').val("add");
    $('#method_pbt').val("");
    $('#btn-save-pbt').html("Simpan");
});

/* click edit pbt */
$('body').on('click', '#edit-pbt', function () {
    var pbt_id = $(this).data('id');
    var info = $('.error_alert');            
    info.hide();
    
    $.get(rujukan_data_config.routes.pbt_action_url + pbt_id +'/edit', function (data) {                          
        $('#ModalPBTLabel').html("Kemaskini PBT");
        $('#btn-save-pbt').html("Kemaskini");
        $('#ModalPBT').modal('show');
        $('#hidden_id_pbt').val(data.id);
        $('#action_pbt').val("update");
        $('#method_pbt').val("PUT");
        $('#kod_pbt').val(data.pbt_id);
        $('#input_pbt').val(data.pbt_description);
        $('#select_negeri_pbt').val(data.state_id);
    })
});

/* click delete pbt */
$('body').on('click', '#delete-pbt', function () {
    var delete_id = $(this).data("id");
    swal({
        title: "Anda pasti?",
        text: "Anda akan memadam rekod pbt dari pangkalan data!",
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
                url: rujukan_data_config.routes.pbt_action_url + delete_id,
                success: function (data) {
                    $('#pbt_form').trigger("reset");
                    $('#pbt_table').DataTable().ajax.reload();
                    swal("Sudah dipadam!", "Rekod pbt telah dipadam dari pangkalan data", "success");
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

$(document).on('submit', '#pbt_form', function(event){
    var info = $('.error_alert');
    event.preventDefault();
    $('#btn-save-pbt').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
    $('#btn-save-pbt').prop('disabled', true);
    var data = $("#pbt_form").serialize();
    var action = $('#action_pbt').val();
    var btn_text;
    if (action == 'update') {
        var edit_value = $('#hidden_id_pbt').val();
        url = rujukan_data_config.routes.pbt_action_url + edit_value;
        type = "POST";
        btn_text = "Kemaskini";
    } else {
        url = rujukan_data_config.routes.pbt_store_url;
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
            $('#btn-save-pbt').html(btn_text);                
            $('#btn-save-pbt').prop('disabled', false);
            info.slideDown();
        } else {
            $('#pbt_form').trigger("reset");
            $('#ModalPBT').modal('hide');
            $('#ModalPBTLabel').html("Tambah PBT");
            $('#hidden_id_pbt').val("");
            $('#action_pbt').val("add");
            $('#method_pbt').val("");
            $('#btn-save-pbt').html("Simpan");
            $('#btn-save-pbt').prop('disabled', false);
            $('#pbt_table').DataTable().ajax.reload();
        }
    });
});