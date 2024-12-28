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
        border-color: #92a8d1;
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
        <title>Laporan Kewangan RT</title>
    </head>
    <body>
        <table border="0" cellpadding="0" width="100%" style="font-size:11px;">
            <tr>
                <th width="100%" align="right"><b>LAMPIRAN RT C1</b></th>
            </tr>
            <tr>
                <th width="100%" align="center"><br><b>FORMAT BUKU TUNAI RUKUN TETANGGA {{$profile_krt->krt_nama}} BAGI BULAN {{$profile_krt->kew_bulan}}/{{$profile_krt->kew_tahun}}</b></th>
            </tr>
        </table>
        <br/>
		<table border="0" cellpadding="0" width="100%" style="font-size:11px; font-weight:normal">
            <tr>
                <td width="10%"><b>NAMA KRT</b></td>
				<td width="1%"><b>:</b></td>
				<td width="89%">{{$profile_krt->krt_nama}}</td>
            </tr>
			<tr>
                <td><b>DAERAH</b></td>
				<td><b>:</b></td>
				<td>{{$profile_krt->daerah}}</td>
            </tr>
			<tr>
                <td><b>NEGERI</b></td>
				<td><b>:</b></td>
				<td>{{$profile_krt->state}}</td>
            </tr>
			<tr>
                <td><b>NO AKAUN</b></td>
				<td><b>:</b></td>
				<td>{{$profile_krt->bank_no_acc}}</td>
            </tr>
			<tr>
                <td><b>NAMA BANK</b></td>
				<td><b>:</b></td>
				<td>{{$profile_krt->bank_nama}}</td>
            </tr>
			<tr>
                <td><b>NO EVENDOR</b></td>
				<td><b>:</b></td>
				<td>{{$profile_krt->no_evendor}}</td>
            </tr>
        </table>
		<br>
        <table border="1" cellpadding="2" width="100%" style="font-size:11px;">
            <thead style="background-color:#CCCCCC;">
                <tr>
                    <th width="4%" align="center" rowspan="2">Bil</th>
                    <th width="8%" align="center" rowspan="2">Tarikh Penerimaan/ Pembayaran</th>
                    <th width="15%" align="center" rowspan="2">Butiran</th>
                    <th width="8%" align="center" rowspan="2">No Cek /<br>Tarikh Cek</th>
                    <th width="8%" align="center" rowspan="2">No Resit /<br>Tarikh Resit</th>
					<th width="8%" align="center" rowspan="2">No Baucer /<br>Tarikh Baucer</th>
                    <th width="8%" align="center" colspan="2">Penerimaan</th>
                    <th width="8%" align="center" colspan="2">Pembayaran</th>
                    <th width="10%" align="center" colspan="3">Baki</th>
					<th width="8%" align="center" rowspan="2">Singkatan Tandatangan</th>
                </tr>
                <tr>
                    <th>Tunai</th>
                    <th>Bank</th>
                    <th>Tunai</th>
                    <th>Bank</th>
                    <th>Tunai</th>
                    <th>Bank</th>
					<th>Jumlah</th>
                </tr>
            </thead>
            <tbody style="font-weight:normal;">
				@php $no = 1; @endphp
				@foreach($laporan_kewangan as $item)
				<tr>
					<td align="center">{{ $no++ }}</td>
					<td align="center">&nbsp; {{ $item->tarikh_t_b }}</td>
					<td align="left">&nbsp; {{ $item->kewangan_butiran }}</td>
					<td align="center">&nbsp; {{ $item->no_cek }} / {{ $item->tarikh_cek }}</td>
					<td align="center">&nbsp; {{ $item->no_resit }} / {{ $item->tarikh_resit }}</td>
					<td align="center">&nbsp; {{ $item->no_baucer }} / {{ $item->tarikh_baucer }}</td>
					<td align="center">&nbsp; {{ $item->terima_tunai }}</td>
					<td align="center">&nbsp; {{ $item->terima_bank }}</td>
					<td align="center">&nbsp; {{ $item->bayar_tunai }}</td>
					<td align="center">&nbsp; {{ $item->bayar_bank }}</td>
					<td align="center">&nbsp; {{ $item->kewangan_baki_tunai }}</td>
					<td align="center">&nbsp; {{ $item->kewangan_baki_bank }}</td>
					<td align="center">&nbsp; {{ $item->kewangan_jumlah_baki }}</td>
					<td>&nbsp;</td>
				</tr>
				@endforeach
			</tbody>
        </table>
		<br><br>
		<table border="0" cellpadding="0" width="100%" style="font-size:11px;">
			<tr>
				<td>Disediakan oleh: </td>
				<td>Disemak oleh: </td>
			</tr>
			<tr>
				<td><br><br><br></td>
				<td><br><br><br></td>
				<td><br><br><br></td>
			</tr>
			<tr>
				<td>{{$sign_bendahari->user_fullname}}</td>
				<td>{{$sign_pengerusi->user_fullname}}</td>
			</tr>
			<tr>
				<td>BENDAHARI</td>
				<td>PENGERUSI</td>
			</tr>
		</table>
		<br><br>
		<table border="0" cellpadding="0" width="100%" style="font-size:11px;">
			<tr>
				<td width="100%" align="center" style="font-weight:normal;"><i>Ini adalah cetakan komputer dan tidak memerlukan tandatangan</i></td>
			</tr>
		</table>
    </body>
</html>








