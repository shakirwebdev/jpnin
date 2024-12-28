@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
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

</style>
<script type="text/javascript">    
    
    $(document).ready( function () {

        /* Maklumat Kawasan Krt */
            $('#ppap5_nama_krt').html("{{$perancangan_aktiviti->nama_krt}}");
            $('#ppap5_alamat_krt').html("{{$perancangan_aktiviti->alamat_krt}}");
            $('#ppap5_negeri_krt').html("{{$perancangan_aktiviti->negeri_krt}}");
            $('#ppap5_parlimen_krt').html("{{$perancangan_aktiviti->parlimen_krt}}");
            $('#ppap5_pbt_krt').html("{{$perancangan_aktiviti->pbt_krt}}");
            $('#ppap5_daerah_krt').html("{{$perancangan_aktiviti->daerah_krt}}");
            $('#ppap5_dun_krt').html("{{$perancangan_aktiviti->dun_krt}}");

        /* Maklumat Tempat Aktiviti Perpaduan */
            $('#ppap5_state_id').val("{{$perancangan_aktiviti->state_id}}");
            $('#ppap5_daerah_id').val("{{$perancangan_aktiviti->daerah_id}}");
            $('#ppap5_aktiviti_tempat').val("{{$perancangan_aktiviti->aktiviti_tempat}}");
            var aktiviti_kawasan_DL = "{{$perancangan_aktiviti->aktiviti_kawasan_DL}}";
		    $("input[name=ppap5_aktiviti_kawasan_DL][value=" + aktiviti_kawasan_DL + "]").prop('checked', true);

        /* Maklumat Aktiviti Perpaduan */
            $('#ppap6_aktiviti_ringkasan_program').html("{{$perancangan_aktiviti->aktiviti_ringkasan_program}}");
            $('#ppap6_aktiviti_ringkasan_program').summernote({
                height: 200
            });
            $("#ppap6_aktiviti_ringkasan_program").summernote("disable");

            if ('{{$perancangan_aktiviti->aktiviti_post_mortem}}' == "1") {
                $("input[name=ppap6_aktiviti_post_mortem]").prop('checked', true);
            }
            if ('{{$perancangan_aktiviti->aktiviti_soal_selidik}}' == "1") {
                $("input[name=ppap6_aktiviti_soal_selidik]").prop('checked', true);
            }
            if ('{{$perancangan_aktiviti->aktiviti_pemerhatian}}' == "1") {
                $("input[name=ppap6_aktiviti_pemerhatian]").prop('checked', true);
            }
            if ('{{$perancangan_aktiviti->aktiviti_temubual}}' == "1") {
                $("input[name=ppap6_aktiviti_temubual]").prop('checked', true);
            }

            $('#ppap6_aktiviti_kekuatan').html("{{$perancangan_aktiviti->aktiviti_kekuatan}}");
            $('#ppap6_aktiviti_kekuatan').summernote({
                height: 200
            });
            $("#ppap6_aktiviti_kekuatan").summernote("disable");

            $('#ppap6_aktiviti_keberkesanan').html("{{$perancangan_aktiviti->aktiviti_keberkesanan}}");
            $('#ppap6_aktiviti_keberkesanan').summernote({
                height: 200
            });
            $("#ppap6_aktiviti_keberkesanan").summernote("disable");

            $('#ppap6_aktiviti_penambahbaikan').html("{{$perancangan_aktiviti->aktiviti_penambahbaikan}}");
            $('#ppap6_aktiviti_penambahbaikan').summernote({
                height: 200
            });
            $("#ppap6_aktiviti_penambahbaikan").summernote("disable");

        /* Button */
            $('#btn_back').click(function(){
                window.location.href = '{{route('rt-sm6.jana_laporan_perancangan_aktiviti_hq_2','')}}'+'/'+'{{$perancangan_aktiviti->id}}';
            });

    });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop