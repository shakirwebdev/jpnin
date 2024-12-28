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
        <title>Notis Pembatalan SRS</title>
    </head>
    <table border="0" cellpadding="0" width="100%">
        <tr>
            <th width="100%" align="right" ></th>
        </tr>
    </table>
    <br><br>
    <table border="0" cellpadding="5" width="100%">
        <tr>
            <th width="15%" align="left" >Negeri</th>
            <th width="1%" align="center" >:</th>
            <th width="84%" align="left" ><b>{{ $data_kewangan_krt1[0]->state }}</b></th>
        </tr>
        <tr>
            <th width="15%" align="left" >Daerah</th>
            <th width="1%" align="center" >:</th>
            <th width="84%" align="left" ><b>{{ $data_kewangan_krt1[0]->daerah }}</b></th>
        </tr>
        <tr>
            <th width="15%" align="left" >Nama KRT</th>
            <th width="1%" align="center" >:</th>
            <th width="84%" align="left" ><b>{{ $data_kewangan_krt1[0]->nama_krt }}</b></th>
        </tr>
    </table>
    <br>
    <table border="1" cellpadding="0" width="100%">
        <thead>
            <tr>
                <th width="6%" rowspan="2" align="center">Bil</th>
                <th align="center" rowspan="2">Butiran</th>
                <th align="center" rowspan="2">Tarikh Peneriamaan / Pembayaran</th>
                <th align="center" rowspan="2">No Cek / No Baucer</th>
                <th align="center" rowspan="2">Tarikh Cek / Baucer</th>
                <th align="center" colspan="2">Penerimaan</th>
                <th align="center" colspan="2">Pembayaran</th>
                <th align="center" colspan="3">Baki</th>
            </tr>
            <tr>
                <th align="center" >Bank<br>(RM)</th>
                <th align="center" >Tunai<br>(RM)</th>
                <th align="center" >Bank<br>(RM)</th>
                <th align="center" >Tunai<br>(RM)</th>
                <th align="center" >Bank<br>(RM)</th>
                <th align="center" >Tunai<br>(RM)</th>
                <th align="center" >Jumlah<br>(RM)</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($data_kewangan_krt1 as $item1)
            <tr>
                <td width="6%" align="center">{{ $no++ }}</th>
                <td>&nbsp; {{ $item1->butiran }}</th>
                <td>&nbsp; {{ $item1->tarikh_pp }}</th>
                <td>&nbsp; {{ $item1->no_cek_baucer }}</th>
                <td>&nbsp; {{ $item1->tarikh_cek_baucer }}</th>
                <td>&nbsp; {{ $item1->penerimaan_bank }}</th>
                <td>&nbsp; {{ $item1->penerimaan_tunai }}</th>
                <td>&nbsp; {{ $item1->pembayaran_bank }}</th>
                <td>&nbsp; {{ $item1->pembayaran_tunai }}</th>
                <td>&nbsp; {{ $item1->total_bank }}</th>
                <td>&nbsp; {{ $item1->total_tunai }}</th>
                <td>&nbsp; {{ $item1->total_baki }}</th>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    
    
    
</html>






