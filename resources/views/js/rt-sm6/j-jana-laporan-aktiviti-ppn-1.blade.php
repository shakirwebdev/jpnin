@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">    
    
    $(document).ready( function () {

        //my custom script
		var laporan_aktiviti_config = {
			routes: {
				laporan_aktiviti_url: "/rt/sm6/jana-laporan-aktiviti-ppn-1/{{$laporan_aktiviti->id}}"
			}
		};

        /* Maklumat Kawasan Krt */
            $('#plap_nama_krt').html("{{$laporan_aktiviti->nama_krt}}");
            $('#plap_alamat_krt').html("{{$laporan_aktiviti->alamat_krt}}");
            $('#plap_negeri_krt').html("{{$laporan_aktiviti->negeri_krt}}");
            $('#plap_parlimen_krt').html("{{$laporan_aktiviti->parlimen_krt}}");
            $('#plap_pbt_krt').html("{{$laporan_aktiviti->pbt_krt}}");
            $('#plap_daerah_krt').html("{{$laporan_aktiviti->daerah_krt}}");
            $('#plap_dun_krt').html("{{$laporan_aktiviti->dun_krt}}");

        /* Maklumat Tempat Aktiviti Perpaduan */
            $('#plap_state_id').val("{{$laporan_aktiviti->state_id}}");
            $('#plap_daerah_id').val("{{$laporan_aktiviti->daerah_id}}");
            $('#plap_aktiviti_tempat').val("{{$laporan_aktiviti->aktiviti_tempat}}");
            var aktiviti_kawasan_DL = "{{$laporan_aktiviti->aktiviti_kawasan_DL}}";
		    $("input[name=plap_aktiviti_kawasan_DL][value=" + aktiviti_kawasan_DL + "]").prop('checked', true);
            $("#plap_state_id").on( 'change', function () {
                var value = $(this).find('option:selected').val();
                var selectedIndex = $(this).find('option:selected').index();
                $('#plak_daerah_id').find('option').remove();
                $('#plak_daerah_id').prop("disabled", false);
                    if (selectedIndex !== '0') {
                        $.ajax({
                            type: "GET",
                            url: laporan_aktiviti_config.routes.laporan_aktiviti_url,
                            data: {type: 'get_daerah', value: value},
                            success: function (data) {
                                $('#plak_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                                $.each(data,function(key, obj) 
                                {
                                    $('#plak_daerah_id')
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
            
        /* Maklumat Asas */
            $('#plap1_aktiviti_tajuk').val("{{$laporan_aktiviti->aktiviti_tajuk}}");
            $('#plap1_aktiviti_tarikh').val("{{$laporan_aktiviti->aktiviti_tarikh}}");
            $('#plap1_aktiviti_tarikh_rancang').val("{{$laporan_aktiviti->aktiviti_tarikh_rancang}}");
            $('#plap1_aktiviti_masa').val("{{$laporan_aktiviti->aktiviti_masa}}");
            $('#plap1_penganjur_id').val("{{$laporan_aktiviti->penganjur_id}}");
            $('#plap1_peringkat_id').val("{{$laporan_aktiviti->peringkat_id}}");
            $('#plap1_agenda_id').val("{{$laporan_aktiviti->agenda_id}}");
            $('#plap1_program_id').val("{{$laporan_aktiviti->program_id}}");
            $('#plap1_bidang_id').val("{{$laporan_aktiviti->bidang_id}}");
            $('#plap1_aktiviti_id').val("{{$laporan_aktiviti->aktiviti_id}}");
            $('#plap1_sub_aktiviti_id').val("{{$laporan_aktiviti->sub_aktiviti_id}}");
            $('#plap1_aktiviti_pembelanjaan').val("{{$laporan_aktiviti->aktiviti_pembelanjaan}}");
            $('#plap1_kewangan_id').val("{{$laporan_aktiviti->kewangan_id}}");
            $('#plap1_aktiviti_sasar').val("{{$laporan_aktiviti->aktiviti_sasar}}");
            $('#plap1_aktiviti_perasmi').val("{{$laporan_aktiviti->aktiviti_perasmi}}");
            
        /* Button */
            $('#btn_back').click(function(){
                window.location.href = '{{route('rt-sm6.jana_laporan_aktiviti_ppn')}}';
            });

            $('#btn_next').click(function(){
                window.location.href = '{{route('rt-sm6.jana_laporan_aktiviti_ppn_2','')}}'+'/'+'{{$laporan_aktiviti->id}}';
            });
        
    });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
@stop