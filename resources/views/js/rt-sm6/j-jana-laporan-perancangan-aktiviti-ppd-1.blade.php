@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">    
    
    $(document).ready( function () {

        //my custom script
		var perancangan_aktiviti_config = {
			routes: {
				perancangan_aktiviti_url: "/rt/sm6/jana-laporan-perancangan-aktiviti-ppd-1/{{$perancangan_aktiviti->id}}"
			}
		};

        /* Maklumat Kawasan Krt */
            $('#ppap_nama_krt').html("{{$perancangan_aktiviti->nama_krt}}");
            $('#ppap_alamat_krt').html("{{$perancangan_aktiviti->alamat_krt}}");
            $('#ppap_negeri_krt').html("{{$perancangan_aktiviti->negeri_krt}}");
            $('#ppap_parlimen_krt').html("{{$perancangan_aktiviti->parlimen_krt}}");
            $('#ppap_pbt_krt').html("{{$perancangan_aktiviti->pbt_krt}}");
            $('#ppap_daerah_krt').html("{{$perancangan_aktiviti->daerah_krt}}");
            $('#ppap_dun_krt').html("{{$perancangan_aktiviti->dun_krt}}");

        /* Maklumat Tempat Aktiviti Perpaduan */
            $('#ppap_state_id').val("{{$perancangan_aktiviti->state_id}}");
            $('#ppap_daerah_id').val("{{$perancangan_aktiviti->daerah_id}}");
            $('#ppap_aktiviti_tempat').val("{{$perancangan_aktiviti->aktiviti_tempat}}");
            var aktiviti_kawasan_DL = "{{$perancangan_aktiviti->aktiviti_kawasan_DL}}";
		    $("input[name=ppap_aktiviti_kawasan_DL][value=" + aktiviti_kawasan_DL + "]").prop('checked', true);
            $("#ppap_state_id").on( 'change', function () {
                var value = $(this).find('option:selected').val();
                var selectedIndex = $(this).find('option:selected').index();
                $('#ppak_daerah_id').find('option').remove();
                $('#ppak_daerah_id').prop("disabled", false);
                    if (selectedIndex !== '0') {
                        $.ajax({
                            type: "GET",
                            url: perancangan_aktiviti_config.routes.perancangan_aktiviti_url,
                            data: {type: 'get_daerah', value: value},
                            success: function (data) {
                                $('#ppak_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                                $.each(data,function(key, obj) 
                                {
                                    $('#ppak_daerah_id')
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
            $('#ppap1_aktiviti_tajuk').val("{{$perancangan_aktiviti->aktiviti_tajuk}}");
            $('#ppap1_aktiviti_tarikh').val("{{$perancangan_aktiviti->aktiviti_tarikh}}");
            $('#ppap1_aktiviti_tarikh_rancang').val("{{$perancangan_aktiviti->aktiviti_tarikh_rancang}}");
            $('#ppap1_aktiviti_masa').inputmask('hh:mm', { placeholder: '__:__ _m', alias: 'time24', hourFormat: '24' });
            $('#ppap1_aktiviti_masa').val("{{$perancangan_aktiviti->aktiviti_masa}}");
            $('#ppap1_penganjur_id').val("{{$perancangan_aktiviti->penganjur_id}}");
            $('#ppap1_peringkat_id').val("{{$perancangan_aktiviti->peringkat_id}}");
            $('#ppap1_program_id').val("{{$perancangan_aktiviti->program_id}}");
            $('#ppap1_agenda_id').val("{{$perancangan_aktiviti->agenda_id}}");
            $('#ppap1_bidang_id').val("{{$perancangan_aktiviti->bidang_id}}");
            $('#ppap1_aktiviti_id').val("{{$perancangan_aktiviti->aktiviti_id}}");
            $('#ppap1_sub_aktiviti_id').val("{{$perancangan_aktiviti->sub_aktiviti_id}}");
            $('#ppap1_aktiviti_pembelanjaan').val("{{$perancangan_aktiviti->aktiviti_pembelanjaan}}");
            $('#ppap1_kewangan_id').val("{{$perancangan_aktiviti->kewangan_id}}");
            $('#ppap1_aktiviti_sasar').val("{{$perancangan_aktiviti->aktiviti_sasar}}");
            $('#ppap1_aktiviti_perasmi').val("{{$perancangan_aktiviti->aktiviti_perasmi}}");
            $('#ppap1_aktiviti_perancangan_id').val("{{$perancangan_aktiviti->id}}");
            
        /* Button */
            $('#btn_back').click(function(){
                window.location.href = '{{route('rt-sm6.jana_laporan_perancangan_aktiviti_ppd')}}';
            });

            $('#btn_next').click(function(){
                window.location.href = '{{route('rt-sm6.jana_laporan_perancangan_aktiviti_ppd_2','')}}'+'/'+'{{$perancangan_aktiviti->id}}';
            });
        
    });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
@stop