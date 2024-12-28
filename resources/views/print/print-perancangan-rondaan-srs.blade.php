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
        <title>Surat Perancangan Rondaan SRS</title>
    </head>
    <body>
        <table border="0" cellpadding="0" width="100%">
            <tr>
                <th width="100%" align="center"><b>Perancangan Rondaan SRS</b></th>
            </tr>
        </table>
        <br/><br/><br/><br/>
        <table border="0" cellpadding="0" width="100%">
            <tr>
                <th width="20%"><th>
                <th width="29%" align="left">Negeri <th>
                <th width="1%" align="left">:<th>
                <th width="30%" align="left"><b>{{$perancangan_rondaan->negeri_krt}}</b></th>
                <th width="20%"><th>
            </tr>
        </table>
        <table border="0" cellpadding="0" width="100%">
            <tr>
                <th width="20%"><th>
                <th width="29%" align="left">Daerah <th>
                <th width="1%" align="left">:<th>
                <th width="30%" align="left"><b>{{$perancangan_rondaan->daerah_krt}}</b></th>
                <th width="20%"><th>
            </tr>
        </table>
        <table border="0" cellpadding="0" width="100%">
            <tr>
                <th width="20%"><th>
                <th width="29%" align="left">Nama SRS <th>
                <th width="1%" align="left">:<th>
                <th width="30%" align="left"><b>{{$perancangan_rondaan->nama_srs}}</b></th>
                <th width="20%"><th>
            </tr>
        </table>
        <table border="0" cellpadding="0" width="100%">
            <tr>
                <th width="20%"><th>
                <th width="29%" align="left">Tarikh Rondaan <th>
                <th width="1%" align="left">:<th>
                <th width="30%" align="left"><b>{{$perancangan_rondaan->perancangan_rondaan_tarikh}}</b></th>
                <th width="20%"><th>
            </tr>
        </table>
        <br>
        <br>
        <table border="1" cellpadding="5" width="100%">
            <thead>
                <tr>
                    <th width="6%" align="center">Bil</th>
                    <th width="42%" align="center">Nama Ahli Peronda</th>
                    <th width="42%" align="center">Kad Pengenalan</th>
                </tr>
            </thead>
            <tbody>
            @php $no = 1; @endphp
            @foreach($ahli_peronda as $item)
            <tr>
                <td width="6%" align="center">{{ $no++ }}</th>
                <td width="42%" align="center">&nbsp; {{ $item->peronda_nama }}</th>
                <td width="42%" align="center">{{ $item->peronda_ic }}</th>
            </tr>
            @endforeach
        </tbody>
        </table>
    </body>
</html>








