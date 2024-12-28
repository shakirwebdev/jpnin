<style type="text/css">
    @page { margin: 0; margin-bottom: -20; padding: 0;}
    .page-break {
        page-break-after: always;

    }
    .bg {
        background-image: url("assets/images/kad_mediator/KadMK-depan.jpg");
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
        background-image: url("assets/images/kad_mediator/KadMK-belakang.jpg");
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

</style>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Kad Keahlian iMediator</title>
    </head>
    <div class="bg">

        <table border="0" cellpadding="0" width="100%">
            <tr>
              @php
              $numberWithZero = str_pad($kad_keahlian_mkp->id, 3, '0', STR_PAD_LEFT)
              @endphp
                <th align="right" style="padding-right: 20px; color: #ffffff;"><b><font size="2"><br><br><br>MK{{$numberWithZero}}</font></b></th>
            </tr>
        </table>
        <br><br><br><br>
        <table border="0" cellpadding="2" width="100%" style="padding-top: 18px;">
        @php $path_gambar = ($kad_keahlian_mkp->file_gambar_profile); @endphp
            <tr>
                <th align="center" class="image"><img src="{{ public_path('storage/mkp_profile/'.$path_gambar.'') }}" id="kak_ajk_gambar" name="kak_ajk_gambar" ></th>
            </tr>
            <tr>
              <th><font size="1" style="color: #ffffff;"> TEMPOH : {{ $kad_keahlian_mkp->tarikh_mula }} HINGGA {{ $kad_keahlian_mkp->tarikh_tamat }}</font></th>
            </tr>
        </table>

        <table border="0" cellpadding="2" width="100%" style="padding-top: 8px;">
            <tr>
                <th align="center" style="text-transform:uppercase; color: #000000; line-height: 1">
                  <b>
                    <font size="2">{{$kad_keahlian_mkp->user_fullname}}</font>
                    <br>
                    <font size="2">{{$kad_keahlian_mkp->no_ic}}</font>
                    <br>
                    <font size="2">{{$kad_keahlian_mkp->mkp_state}}</font>
                  </b>
                </th>
            </tr>
            <!-- <tr>
                <th align="center" style="text-transform:uppercase"><b><font size="1">{{$kad_keahlian_mkp->user_fullname}}</font></b></th>
            </tr>
            <tr>
                <th align="center"><b><font size="1">{{$kad_keahlian_mkp->no_ic}}</font></b></th>
            </tr> -->
        </table>
        <table border="0" cellpadding="0" width="100%">
            <tr>
                <th align="center" style="text-transform:uppercase"><b><font size="1" color="white"><br></font></b></th>
            </tr>
        </table>
    </div>
    <div class="page-break"></div>
    <div class="bg_1">
      <br><br>
        <table border="0" cellpadding="2" width="100%" style="top: 270px !important; position: relative;">
            @php
            $id = ($kad_keahlian_mkp->id);
            $url = 'https://smpv2.perpaduan.gov.my/secure/ahli_mk/';
            $url_1 = 'https://chart.googleapis.com/chart?cht=qr&chl=';
            $url_2 = '&chs=150x150&chld=L|0';
            $url_qr = $url_1 . $url . $id . $url_2;
			$new_url = 'https://quickchart.io/qr?text='.$url.$id;
            @endphp
            <tr>
                <th align="right" style="text-transform:uppercase"><b><font size="2"><img src="<?php echo $new_url; ?>" width="60" height="60" class="qr-code img-thumbnail img-responsive"></font></b></th>
                <th></th>
            </tr>
        </table>
    </div>
    <script type="text/javascript">

    </script>
</html>
