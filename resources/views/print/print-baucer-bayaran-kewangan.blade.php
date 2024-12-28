<style type="text/css">
    .page-break {
        page-break-after: always;
    
    }
    table {
        margin:5px;
        font-size:15px;
        font-weight: 900;
        border-collapse: collapse;
    }
    th{
        font-weight: normal;
    }
    div.border {
        border-style: groove;
        text-align: justify;
    }
    p.groove {
        border-style: groove;
        text-align: justify;
    }
    span.text-center {
        display: block;
        text-align: center;
    }
    span.text-right {
        display: block;
        text-align: right;
    }
</style>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Baucer Bayaran Jawatankuasa Rukun Tetangga</title>
    </head>
    <body>
        <table border="0" cellpadding="0" width="100%">
            <tr>
                <th width="100%" align="right"><b>Lampiran RT C3</b></th>
            </tr>
            <tr>
                <th width="100%" align="center"><br><b>FORMAT BAUCER BAYARAN JAWATANKUASA RUKUN TETANGGA</b></th>
            </tr>
        </table>
        <br>
        <div class="border">
            <table border="0" cellpadding="0" width="100%">
                <tr>
                    <th width="100%" align="left"><br></th>
                </tr>
                <tr>
                    <th width="70%" align="left">Bayaran Kepada : <b>{{$data_baucer_pembayaran->kewangan_nama_penuh}}</b></th>
                    <th width="30%" align="right">Tarikh : <b>{{$data_baucer_pembayaran->tarikh_kewangan}}</b>&nbsp;&nbsp;</th>
                </tr>
                <tr>
                    <th width="100%" align="left"><br>(Nama dan Alamat) : <b>{{$data_baucer_pembayaran->kewangan_alamat}}</b></th>
                </tr>
            </table>
            <br>
            <table border="1" cellpadding="0" width="100%">
                <tr>
                    <th width="30%" align="center">Tarikh:</th>
                    <th width="40%" align="center">Butir-Butir Pembelanjaan :&nbsp;&nbsp;</th>
                    <th width="30%" align="center">Amount (RM):&nbsp;&nbsp;</th>
                </tr>
                <tr>
                    <th width="30%" align="center"><br><b>{{$data_baucer_pembayaran->tarikh_kewangan}}</b><br><br></th>
                    <th width="40%" align="center"><br><b>{{$data_baucer_pembayaran->kewangan_butiran}}</b><br><br></th>
                    <th width="30%" align="center"><br><b>{{$data_baucer_pembayaran->total_jumlah}}</b><br><br></th>
                </tr>
                <tr>
                    <th width="30%" align="center">&nbsp;</th>
                    <th width="40%" align="center"></th>
                    <th width="30%" align="center"></th>
                </tr>
            </table>
            <br>
            <table border="0" cellpadding="0" width="100%">
                <tr>
                    <th width="100%" align="left">Pebelanjaan ini diakui perlu dan diluluskan oleh *Pengerusi/Setiausaha dalam mesyuarat Jawatankuasa Rukun Tetangga pada <b>{{$data_baucer_pembayaran->tarikh_kewangan}}</b> Bayaran sebanyak RM <b>{{$data_baucer_pembayaran->total_jumlah}}</b> dibuat dalam * tunai/cek no</th>
                </tr>
            </table>
            <br><br><br><br>
            <table border="0" cellpadding="0" width="100%">
                <tr>
                    <th width="100%" align="left"><hr style="width:45%;text-align:left;margin-left:0"></th>
                </tr>
                <tr>
                    <th width="100%" align="left">(Tandatangan Pihak Yang Meluluskan)</th>
                </tr>
            </table>
            <table border="0" cellpadding="0" width="100%">
                <tr>
                    <th width="50%" align="left"></th>
                    <th width="50%" align="left">(Nama & Cop) <br><br><br></th>
                </tr>
                <tr>
                    <th width="50%" align="left"></th>
                    <th width="50%" align="left">Tandatangan <br><br><br></th>
                </tr>
                <tr>
                    <th width="50%" align="left"></th>
                    <th width="50%" align="left">Penerima : <b>{{$data_baucer_pembayaran->kewangan_nama_penuh}}</b><br><br></th>
                </tr>
                <tr>
                    <th width="50%" align="left"></th>
                    <th width="50%" align="left">No Kad Pengenalan :<br><br></th>
                </tr>
                <tr>
                    <th width="50%" align="left"></th>
                    <th width="50%" align="left">Tarikh : <b>{{$data_baucer_pembayaran->tarikh_kewangan}}</b><br><br></th>
                </tr>
            </table>
            <table border="0" cellpadding="0" width="100%">
                <tr>
                    <th width="100%" align="left">..................................................................</th>
                </tr>
                <tr>
                    <th width="100%" align="left">(Nama & Cop Pembayar)<br><br></th>
                </tr>
                <tr>
                    <th width="100%" align="left">Tarikh : <b>{{$data_baucer_pembayaran->tarikh_kewangan}}</b><br><br></th>
                </tr>
                <tr>
                    <th width="100%" align="left">* Potong yang tidak berkenaan <br></th>
                </tr>
            </table>
        </div>
    </body>
</html>








