<style type="text/css">
    @page { margin: 0; margin-bottom: -20; padding: 0;}
    .page-break {
        page-break-after: always;

    }
    .bg {
        background-image: url("assets/images/kad_krt/KadRT-depan.jpg");
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        width:100%;
        height:95%;
        top: 0;
        bottom:0;
        background-size: cover;
        margin-top: 0;
        margin-right: 0;
        margin-bottom: 0;
        margin-left: 0;
        padding: 0;
    }

    .bg_1 {
        background-image: url("assets/images/kad_krt/KadRT-belakang.jpg");
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        width:100%;
        height:95%;
        top: 0;
        bottom:0;
        background-size: cover;
        margin-top: 0;
        margin-right: 0;
        margin-bottom: 0;
        margin-left: 0;
        padding: 0;
    }

    .nobg{
        background: #59252F;
    }

    body {
        margin: 0;
        padding: 0;
        font-family: Helvetica, sans-serif;
    }

    .image {
        width: 200px;
        height: auto;
    }

    /* Resize images */
    .image img {
        width: 121px;
        height: 140px;
    }

    .topsec {
      text-align:center;
      position: absolute;
      left: 0px;
      top: 100px;
      width: 100%;
      font-size: 14px;
      font-weight: bold;
    }

    .midsec {
      text-align:center;
      position: absolute;
      left: 0px;
      top: 280px;
      width: 100%;
      font-size: 14px;
      font-weight: bold;
      text-transform: uppercase;
    }

    .bottomsec {

    }

</style>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Kad Keahlian AJK KRT</title>
    </head>
    <div class="bg">
      <div class="topsec">
        {{$kad_keahlian_ajk_krt->krt_id}}
      </div>
        <!-- <table border="0" cellpadding="0" width="100%">
            <tr>
                <th align="right"><b><font size="1"><br><br>{{$kad_keahlian_ajk_krt->krt_id}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></b></th>
            </tr>
        </table> -->
        <br><br><br><br><br><br>
        <!-- <center><font size="2"><b>{{$kad_keahlian_ajk_krt->krt_id}}</b></font></center> -->
        <table border="0" cellpadding="2" width="100%">
        @php $path_gambar = ($kad_keahlian_ajk_krt->file_avatar); @endphp
            <tr>
                <th align="center" class="image"><img src="{{ public_path('storage/ajk_krt/'.$path_gambar.'') }}" id="kak_ajk_gambar" name="kak_ajk_gambar" ></th>
            </tr>
        </table>
        <div class="midsec">
          {{$kad_keahlian_ajk_krt->ajk_jawatan}}<br>
          {{$kad_keahlian_ajk_krt->ajk_nama}}<br>
          {{$kad_keahlian_ajk_krt->ajk_ic}}<br>
          Tempoh : {{$kad_keahlian_ajk_krt->ajk_tarikh_mula}} - {{$kad_keahlian_ajk_krt->ajk_tarikh_akhir}}
        </div>
        <!-- <div class="" style="position: fixed;">
          <table border="0" cellpadding="4" width="100%">
              <tr>
                  <th align="center" style="text-transform:uppercase">
                    <b>
                      <font size="2">{{$kad_keahlian_ajk_krt->ajk_jawatan}}</font><br>
                      <font size="2">{{$kad_keahlian_ajk_krt->ajk_nama}}</font><br>
                      <font size="2">{{$kad_keahlian_ajk_krt->ajk_ic}}</font><br>
                    </b>
                    <font size="2">Tempoh : {{$kad_keahlian_ajk_krt->ajk_tarikh_mula}} - {{$kad_keahlian_ajk_krt->ajk_tarikh_akhir}}</font>
                  </th>
              </tr>
              <tr>
                  <th align="center"><b><font size="2">{{$kad_keahlian_ajk_krt->ajk_ic}}</font></b></th>
              </tr>
          </table>
        </div> -->

        <div class="" style="top: 90px !important; position: relative;">
          <table border="0" cellpadding="0" width="100%" style="margin-top: 20px;">
              <tr>
                  <th align="center" style="text-transform:uppercase"><b><font size="1" color="white">{{$kad_keahlian_ajk_krt->krt_nama}}<br> {{$kad_keahlian_ajk_krt->krt_daerah}}<br> {{$kad_keahlian_ajk_krt->krt_state}}</font></b></th>
              </tr>
          </table>
        </div>

    </div>
    <div class="page-break"></div>
    <div class="bg_1">
        <table border="0" cellpadding="4" width="100%" style="top: 320px !important; position: relative;">
            @php 
            $id = ($kad_keahlian_ajk_krt->id); 
            $url = 'https://smpv2.perpaduan.gov.my/secure/ajk_krt/'; 
            $url_1 = 'https://chart.googleapis.com/chart?cht=qr&chl=';
            $url_2 = '&chs=150x150&chld=L|0'; 
            $url_qr = $url_1 . $url . $id . $url_2;
			$new_url = 'https://quickchart.io/qr?text='.$url.$id;
            @endphp
            <tr>
                <th align="right" style="text-transform:uppercase"><b><font size="2"><img src="<?php echo $new_url; ?>" width="50" height="50" class="qr-code img-thumbnail img-responsive"></font></b></th>
                <th></th>
            </tr>
        </table>
    </div>
    <script type="text/javascript">
        $(document).ready( function () {
            $('#kak_krt_nama').html("{{$kad_keahlian_ajk_krt->ajk_nama}}");
            $('#kak_ajk_gambar').attr('src', "{{ public_path('storage/ajk_krt') }}"+"/"+ "{{$kad_keahlian_ajk_krt->file_avatar}}");
        });
    </script>
</html>
