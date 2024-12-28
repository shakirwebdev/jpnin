<script>
    //my custom script
    var jawatankuasa_penaja_config = {
        routes: {
            jawatankuasa_penaja_url: "{{ route('rt-sm1.get_view_jawatankuasa_penaja_table','') }}",
        }
    };

    function load_view_jawatankuasa_penaja_rt(id) {

        

        $.get(jawatankuasa_penaja_config.routes.jawatankuasa_penaja_url + '/' + id, function (data) {   
            // alert(id); 
            // $('#ModalJPNINLabel').html("Kemaskini Pengguna JPNIN");
            // $('#btn-save-jpnin').html("Kemaskini");                
            // $('#action_jpnin_user').val("update");
            // $('#method_jpnin_user').val("PUT");

            $('#ejpf_penaja_nama').val(data.penaja_nama);
            $('#ejpf_penaja_ic').val(data.penaja_ic);
            date = new Date(data.penaja_birth);
            $('#ejpf_penaja_birth').val(((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear());
            $('#ejpf_ref_jantinaID').val(data.ref_jantinaID);
            $('#ejpf_ref_kaumID').val(data.ref_kaumID);
            $('#ejpf_penaja_pekerjaan').val(data.penaja_pekerjaan);
            $('#ejpf_penaja_alamat_rumah').val(data.penaja_alamat_rumah);
            $('#ejpf_penaja_no_fone').val(data.penaja_no_fone);
            $('#ejpf_penaja_alamat_pejabat').val(data.penaja_alamat_pejabat);
            $('#ejpf_penaja_no_office').val(data.penaja_no_office);
            $('#modal_view_jawatankuasa_penaja_rt').modal('show');
        });

	}

</script>