
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<style type="text/css">
	.series-frame {
	  /*max-width: 600px;*/
	  display: flex;
	  justify-content: space-between;
	  align-items: center;
	  box-sizing: border-box;
	  border: 2px solid #113f50;
	  /*margin: 30px;*/
	  padding: 10px;
	}
    .blink {
        animation: blinker 1.0s linear infinite;
        color: #1c87c9;
        font-weight: bold;
        font-family: sans-serif;
    }
    @keyframes blinker {
        50% {
          opacity: 0;
        }
      }
</style>
<script type="text/javascript">    
    
	$(document).ready( function () {

        /* Maklumat Kawasan Krt */
            $('#ask1_nama_krt').html("{{$sejiwa->nama_krt}}");
            $('#ask1_alamat_krt').html("{{$sejiwa->alamat_krt}}");
            $('#ask1_negeri_krt').html("{{$sejiwa->negeri_krt}}");
            $('#ask1_parlimen_krt').html("{{$sejiwa->parlimen_krt}}");
            $('#ask1_pbt_krt').html("{{$sejiwa->pbt_krt}}");
            $('#ask1_daerah_krt').html("{{$sejiwa->daerah_krt}}");
            $('#ask1_dun_krt').html("{{$sejiwa->dun_krt}}");

        /* Maklumat Am Sejiwa */
            $('#ask1_sejiwa_nama').val("{{$sejiwa->sejiwa_nama}}");
            $('#ask1_sejiwa_tarikh_ditubuhkan').val("{{$sejiwa->sejiwa_tarikh_ditubuhkan}}");
            $('#ask1_sejiwa_pusat_operasi').val("{{$sejiwa->sejiwa_pusat_operasi}}");
           
        /* Maklumat Profile Sejiwa */
            $('#ask1_sejiwa_nama_pengerusi').val("{{$sejiwa->sejiwa_nama_pengerusi}}");
            $('#ask1_sejiwa_phone_pengerusi').val("{{$sejiwa->sejiwa_phone_pengerusi}}");
            $('#ask1_sejiwa_email_pengerusi').val("{{$sejiwa->sejiwa_email_pengerusi}}");
            $('#ask1_sejiwa_ic_pengerusi').val("{{$sejiwa->sejiwa_ic_pengerusi}}");
            $('#ask1_sejiwa_alamat_pengerusi').val("{{$sejiwa->sejiwa_alamat_pengerusi}}");
            $('#ask1_sejiwa_pekerjaan_pengerusi').val("{{$sejiwa->sejiwa_pekerjaan_pengerusi}}");
            $('#ask1_sejiwa_nama_timbalan').val("{{$sejiwa->sejiwa_nama_timbalan}}");
            $('#ask1_sejiwa_phone_timbalan').val("{{$sejiwa->sejiwa_phone_timbalan}}");
            $('#ask1_sejiwa_email_timbalan').val("{{$sejiwa->sejiwa_email_timbalan}}");
            $('#ask1_sejiwa_ic_timbalan').val("{{$sejiwa->sejiwa_ic_timbalan}}");
            $('#ask1_sejiwa_alamat_timbalan').val("{{$sejiwa->sejiwa_alamat_timbalan}}");
            $('#ask1_sejiwa_pekerjaan_timbalan').val("{{$sejiwa->sejiwa_pekerjaan_timbalan}}");
            $('#ask1_sejiwa_pekerjaan_timbalan').val("{{$sejiwa->sejiwa_pekerjaan_timbalan}}");
            $('#ask1_sejiwa_nama_su').val("{{$sejiwa->sejiwa_nama_su}}");
            $('#ask1_sejiwa_phone_su').val("{{$sejiwa->sejiwa_phone_su}}");
            $('#ask1_sejiwa_email_su').val("{{$sejiwa->sejiwa_email_su}}");
            $('#ask1_sejiwa_ic_su').val("{{$sejiwa->sejiwa_ic_su}}");
            $('#ask1_sejiwa_alamat_su').val("{{$sejiwa->sejiwa_alamat_su}}");
            $('#ask1_sejiwa_pekerjaan_su').val("{{$sejiwa->sejiwa_pekerjaan_su}}");

        /* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{ route('rt-sm10.senarai_sejiwa_krt_ppn') }}";
            });

            $('#btn_next').click(function(){
                window.location.href = "{{ route('rt-sm10.senarai_sejiwa_krt_ppn_2','') }}"+"/"+"{{$sejiwa->id}}";
            });

	});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop