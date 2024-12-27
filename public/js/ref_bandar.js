var table_bandar = $('#bandar_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {url: rujukan_data_config.routes.bandar_datatable_url},
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
        "width": "30%", 
        "mRender": function ( value, type, full )  {
            return full.bandar_description
        }
    },{			
        "aTargets": [ 1 ], 
        "width": "30%", 
        "mRender": function ( value, type, full )  {
            var item = daerah_array.find(item => item.daerah_id === full.daerah_id);
            if (item) {
                return item.daerah_description;
            } else {
                return "-";
            }
            
        }
    },{			
        "aTargets": [ 2 ], 
        "width": "20%", 
        "mRender": function ( value, type, full )  {
            return full.state_description;
        }
    },{
        "aTargets": [ 3 ], 
        "width": "20%", 
        "sClass": "text-center", 
        "mRender": function ( value, type, full )  {
            button_a = '<button type="button" class="btn btn-icon" title="Edit" id="edit-bandar" data-id="'+full.id+'"><i class="fa fa-edit"></i></button>';
            button_b = '<button type="button" class="btn btn-icon js-sweetalert" title="Delete" id="delete-bandar" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
            return button_a + button_b;
        }
    }],
    "order": [[ 0, 'asc' ]],
    initComplete: function () {
        $('#btn-save-bandar').html("Simpan");
    }
});

$('#myInputTextField_Bandar').keyup(function(){
    table_bandar.search( $(this).val() ).draw();
})

$("#mySelectField_Bandar").on( 'keyup change clear', function () {
    var value = $(this).find('option:selected').text();
    var selectedIndex = $(this).find('option:selected').index();

    if (selectedIndex == '0') {
        table_bandar.search('').draw();
    } else {
        table_bandar
            .column()
            .search(value)
            .draw();
    }
} );

$("#select_negeri_bandar").on( 'change', function () {
    var value = $(this).find('option:selected').val();
    var selectedIndex = $(this).find('option:selected').index();
    $('#select_daerah_bandar').find('option').remove();

    if (selectedIndex !== '0') {
        $.ajax({
            type: "GET",
            url: rujukan_data_config.routes.bandar_action_url,
            data: {type: 'get_negeri', value: value},
            success: function (data) {
                $('#select_daerah_bandar').append($('<option>').text('- Pilih daerah').attr('value', ''));
                $.each(data,function(key, obj) 
                {
                    $('#select_daerah_bandar')
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
} );

/* Clear modal form */
$('#ModalBandar').on('hidden.bs.modal', function(e){
    $(this).find('form').trigger('reset');
    $('#ModalBandarLabel').html("Tambah Bandar / Kawasan");
    $('#hidden_id_bandar').val("");
    $('#action_bandar').val("add");
    $('#method_bandar').val("");
    $('#btn-save-bandar').html("Simpan");
});

/* click edit bandar */
$('body').on('click', '#edit-bandar', function () {
    var bandar_id = $(this).data('id');
    var info = $('.error_alert');            
    info.hide();
    
    $.get(rujukan_data_config.routes.bandar_action_url + bandar_id +'/edit', function (data) {                          
        $('#ModalBandarLabel').html("Kemaskini Bandar / Kawasan");
        $('#btn-save-bandar').html("Kemaskini");        
        $('#hidden_id_bandar').val(data.id);
        $('#action_bandar').val("update");
        $('#method_bandar').val("PUT");
        $('#input_bandar').val(data.bandar_description);
        $('#select_negeri_bandar').val(data.state_id);
        $("#select_negeri_bandar").change();
        setTimeout(function(){
            $('#select_daerah_bandar').val(data.daerah_id);
        }, 500);
        $('#ModalBandar').modal('show');
    })
});

/* click delete bandar */
$('body').on('click', '#delete-bandar', function () {
    var delete_id = $(this).data("id");
    swal({
        title: "Anda pasti?",
        text: "Anda akan memadam rekod bandar dari pangkalan data!",
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
                url: rujukan_data_config.routes.bandar_action_url + delete_id,
                success: function (data) {
                    $('#bandar_form').trigger("reset");
                    $('#bandar_table').DataTable().ajax.reload();
                    swal("Sudah dipadam!", "Rekod bandar telah dipadam dari pangkalan data", "success");
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

$(document).on('submit', '#bandar_form', function(event){
    var info = $('.error_alert');
    event.preventDefault();
    $('#btn-save-bandar').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
    $('#btn-save-bandar').prop('disabled', true);
    var data = $("#bandar_form").serialize();
    var action = $('#action_bandar').val();
    var btn_text;
    if (action == 'update') {
        var edit_value = $('#hidden_id_bandar').val();
        url = rujukan_data_config.routes.bandar_action_url + edit_value;
        type = "POST";
        btn_text = "Kemaskini";
    } else {
        url = rujukan_data_config.routes.bandar_store_url;
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
            $('#btn-save-bandar').html(btn_text);                
            $('#btn-save-bandar').prop('disabled', false);
            info.slideDown();
        } else {
            $('#bandar_form').trigger("reset");
            $('#ModalBandar').modal('hide');            
            $('#ModalBandarLabel').html("Tambah Bandar / Kawasan");
            $('#hidden_id_bandar').val("");
            $('#action_bandar').val("add");
            $('#method_bandar').val("");
            $('#btn-save-bandar').html("Simpan");
            $('#btn-save-bandar').prop('disabled', false);
            $('#bandar_table').DataTable().ajax.reload();
        }
    });
});