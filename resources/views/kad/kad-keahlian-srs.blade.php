<style type="text/css">
    @page { margin: 0; margin-bottom: -20; padding: 0;}
    .page-break {
        page-break-after: always;

    }
    .bg {
        background-image: url("assets/images/kad_srs/KadSRS-depan.jpg");
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
        background-image: url("assets/images/kad_srs/KadSRS-belakang.jpg");
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
      top: 300px;
      width: 100%;
      font-size: 16px;
      font-weight: bold;
      text-transform: uppercase;
    }

    .bottomsec {
      text-align:center;
      position: absolute;
      left: 0px;
      top: 370px;
      width: 100%;
      font-size: 12px;
      font-weight: bold;
      text-transform: uppercase;
      color: #ffffff;
    }

</style>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Kad Keahlian AJK SRS</title>
    </head>
    <div class="bg">
      <div class="topsec">
        {{$kad_keahlian_ajk_srs->srs_id}}
      </div>
        <!-- <table border="0" cellpadding="0" width="100%">
            <tr>
                <th align="right"><b><font size="1"><br><br>{{$kad_keahlian_ajk_srs->srs_id}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></b></th>
            </tr>
        </table> -->
        <br><br><br><br><br><br>
        <!-- <center><b><font size="2">{{$kad_keahlian_ajk_srs->srs_id}}</font></b></center> -->
        <table border="0" cellpadding="4" width="100%">
        @php $path_gambar = ($kad_keahlian_ajk_srs->file_gambar_profile); @endphp
            <tr>
                <th align="center"><img src="{{ public_path('storage/ahli_peronda_srs/'.$path_gambar.'') }}" id="kas_peronda_gambar" name="kas_peronda_gambar" width="125px" height="160px"></th>
            </tr>
        </table>

        <div class="midsec">
          {{$kad_keahlian_ajk_srs->peronda_nama}}<br>
          {{$kad_keahlian_ajk_srs->peronda_ic}}<br>
        </div>

        <!-- <table border="0" cellpadding="2" width="100%">
            <tr>
                <th align="center" style="text-transform:uppercase"><b><font size="3">{{$kad_keahlian_ajk_srs->peronda_nama}}</font></b></th>
            </tr>
            <tr>
                <th align="center"><b><font size="2">{{$kad_keahlian_ajk_srs->peronda_ic}}</font></b></th>
            </tr>
        </table> -->
        <div class="bottomsec">
          {{$kad_keahlian_ajk_srs->srs_name}}<br>
          {{$kad_keahlian_ajk_srs->srs_daerah}}<br>
          {{$kad_keahlian_ajk_srs->srs_state}}
        </div>
        <!-- <div class="">
          <table border="0" cellpadding="0" width="100%">
              <tr>
                  <th align="center" style="text-transform:uppercase"><b><font size="1" color="white">{{$kad_keahlian_ajk_srs->srs_name}}<br>{{$kad_keahlian_ajk_srs->srs_daerah}}<br>{{$kad_keahlian_ajk_srs->srs_state}}</font></b></th>
              </tr>
          </table>
        </div> -->


    </div>
    <div class="page-break"></div>
    <div class="bg_1">
        <table border="0" cellpadding="4" width="100%" style="top: 320px !important; position: relative;">
            @php 
            $id = ($kad_keahlian_ajk_srs->id); 
            $url = 'https://smpv2.perpaduan.gov.my/secure/ajk_srs/'; 
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
</html>
