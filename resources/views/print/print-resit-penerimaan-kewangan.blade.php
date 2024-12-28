<style type="text/css">
    .page-break {
        page-break-after: always;
    
    }
    table {
        border-collapse: collapse;
    }
    p.groove {
        border-style: groove;
        text-align: justify;
    }
    span.text-center {
        display: block;
        text-align: center;
    }
</style>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Resit Penerimaan Kewangan</title>
    </head>
    <body>
        <table border="0" cellpadding="0" width="100%">
            <tr>
                <th width="100%" align="right">Lampiran RT C2</th>
            </tr>
            <tr>
                <th width="100%" align="center">Format Resit</th>
            </tr>
        </table>
        <p class="groove" width="100%">
            <br>
            <span class="text-center"> <b>Kawasan Rukun Tetangga</b></span>
            <br><br><br>
            <span>&nbsp; Diterima Daripada : <b>{{$data_resit_penerimaan->kewangan_nama_penuh}}</b></span>
            <br><br>
            <span>&nbsp; Ringgit : <b>RM {{$data_resit_penerimaan->total_jumlah}}</b></span>
            <br><br>
            <span>&nbsp; *Tunai/ No Cek : <b>{{$data_resit_penerimaan->kewangan_cek_baucer}}</b></span>
            <br><br>
            <span>&nbsp; Untuk Bayaran : <b>{{$data_resit_penerimaan->kewangan_butiran}}</b></span>
            <br><br><br><br><br><br><br><br>
            <span>&nbsp; ........................................................................</span>
            <br>
            <span>&nbsp; Tandatangan Penerima</span>
            <br><br><br><br><br><br><br><br><br><br>
            <span>&nbsp; Cop : Setiausaha / Bendahari</span>
            <br><br>
            <span>&nbsp; Tarikh : <b>{{$data_resit_penerimaan->tarikh_kewangan}}</b></span>
            <br><br><br>
            <span>&nbsp; * Potong tidak berkenaan </span>
            <br><br>
        </p>
    </body>
</html>








