@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {

		/* Maklumat Kawasan Krt */
            $('#pkpn_nama_krt').html("{{$krt_pemulihan->nama_krt}}");
            $('#pkpn_alamat_krt').html("{{$krt_pemulihan->alamat_krt}}");
            $('#pkpn_negeri_krt').html("{{$krt_pemulihan->negeri_krt}}");
            $('#pkpn_parlimen_krt').html("{{$krt_pemulihan->parlimen_krt}}");
            $('#pkpn_pbt_krt').html("{{$krt_pemulihan->pbt_krt}}");
            $('#pkpn_daerah_krt').html("{{$krt_pemulihan->daerah_krt}}");
            $('#pkpn_dun_krt').html("{{$krt_pemulihan->dun_krt}}");

        /* Maklumat Laporan Pemulihan KRT */
            $('#pkpn_pemulihan_tempoh_bulan').val("{{$krt_pemulihan->pemulihan_tempoh_bulan}}");
            $('#pkpn_pemulihan_punca_tidak_aktif').val("{{$krt_pemulihan->pemulihan_punca_tidak_aktif}}");
            $('#pkpn_pemulihan_suku_thn_1').val("{{$krt_pemulihan->pemulihan_suku_thn_1}}");
            $('#pkpn_pemulihan_suku_thn_2').val("{{$krt_pemulihan->pemulihan_suku_thn_2}}");
            $('#pkpn_pemulihan_suku_thn_3').val("{{$krt_pemulihan->pemulihan_suku_thn_3}}");
            $('#pkpn_pemulihan_suku_thn_4').val("{{$krt_pemulihan->pemulihan_suku_thn_4}}");
            $('#pkpn_pemulihan_tempoh_pelaksanaan').val("{{$krt_pemulihan->pemulihan_tempoh_pelaksanaan}}");
            $('#pkpn_pemulihan_cadangan_ppd').val("{{$krt_pemulihan->pemulihan_cadangan_ppd}}");
            $('#pkpn_pemulihan_cadangan_hq').val("{{$krt_pemulihan->pemulihan_cadangan_hq}}");

        /* Maklumat Status Semakan */
            $('#pkpn_pemulihan_krt_id').val("{{$krt_pemulihan->id}}");

        /* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{ route('rt-sm11.pemulihan_krt_ppn') }}";
            });
        
    });

    /* action submit */
        //my custom script
        var semakan_pemulihan_krt_config = {
            routes: {
                semakan_pemulihan_krt_url: "{{ route('rt-sm11.post_semakan_pemulihan_krt') }}",
            }
        };

        $(document).on('submit', '#form_pkpn', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data = $("#form_pkpn").serialize();
            var action = $('#post_semakan_pemulihan_krt').val();
            var btn_text;
            if (action == 'edit') {
                url = semakan_pemulihan_krt_config.routes.semakan_pemulihan_krt_url;
                type = "POST";
                btn_text = 'Hantar Status Semakan &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=pkpn_status]').removeClass("is-invalid");
                $('[name=pkpn_disemak_note]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'pkpn_status') {
                        $('[name=pkpn_status]').addClass("is-invalid");
                        $('.error_pkpn_status').html(error);
                    }

                    if(index == 'pkpn_disemak_note') {
                        $('[name=pkpn_disemak_note]').addClass("is-invalid");
                        $('.error_pkpn_disemak_note').html(error);
                    }
                });
                $('#btn_submit').html(btn_text);                
                $('#btn_submit').prop('disabled', false);            
            } else {
                $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm11.pemulihan_krt_ppn')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop