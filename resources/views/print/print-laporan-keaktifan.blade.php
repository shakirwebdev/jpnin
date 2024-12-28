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
	.menegak{
		writing-mode: vertical-lr;
  		text-orientation: mixed;
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
        <title>Laporan Keaktifan KRT</title>
    </head>
    <body>
		<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="6%"><img src="{{ public_path('images/logo_krt.png') }}" width="72%" height="42"></td>
				<td width="94%" style="font-size:12px;"><br><b>LAPORAN KEAKTIFAN KRT</b><hr></td>
			</tr>
		</table>
			<table border="1" cellpadding="3" width="760">
				<thead style="background-color:#666666; border:1px solid white;">
					<tr>
						<th rowspan="2" width="18" style="border:1px solid; color:#FFFFFF; text-align:center; font-size:10px;"><b>BIL</b></th>
						<th rowspan="2" width="41" style="border:1px solid; color:#FFFFFF; text-align:center; font-size:10px;"><b>NEGERI</b></th>
						<th rowspan="2" width="40" style="border:1px solid; color:#FFFFFF; text-align:center; font-size:10px;"><b>DAERAH</b></th>
						<th rowspan="2" width="40" style="border:1px solid; color:#FFFFFF; text-align:center; font-size:10px;"><b>PARLIMEN</b></th>
						<th rowspan="2" width="40" style="border:1px solid; color:#FFFFFF; text-align:center; font-size:10px;"><b>DUN</b></th>
						<th width="77" rowspan="2" style="border:1px solid; color:#FFFFFF; text-align:center; font-size:10px;"><b>NAMA KRT</b></th>
						<th width="50" rowspan="2" style="border:1px solid; color:#FFFFFF; text-align:center; font-size:10px;"><b>NO KRT</b></th>
						<th colspan="4" style="border:1px solid; color:#FFFFFF; text-align:center; font-size:10px;"><b>BILANGAN</b></th>
						<th colspan="7" style="border:1px solid; color:#FFFFFF; text-align:center; font-size:10px;"><b>MARKAH KEAKTIFAN KRT(%)</b></th>
						<th width="50" rowspan="2" style="border:1px solid; color:#FFFFFF; text-align:center; font-size:10px;"><b>STATUS</b></th>
					</tr>
					<tr>
						<th width="20" ><img src="{{ public_path('images/header_ajk.png') }}" width="20px"></th>
						<th width="20" ><img src="{{ public_path('images/header_aktiviti.png') }}" width="20px"></th>
						<th width="20" ><img src="{{ public_path('images/header_mesyuarat.png') }}" width="20px"></th>
						<th width="20" ><img src="{{ public_path('images/header_kewangan.png') }}" width="20px"></th>
						<th width="20" ><img src="{{ public_path('images/header_profile.png') }}"  width="20px"></th>
						<th width="20" ><img src="{{ public_path('images/header_ajk.png') }}" width="20px"></th>
						<th width="20" ><img src="{{ public_path('images/header_aktiviti.png') }}" width="20px"></th>
						<th width="20" ><img src="{{ public_path('images/header_mesyuarat.png') }}" width="20px"></th>
						<th width="20" ><img src="{{ public_path('images/header_kewangan.png') }}" width="20px"></th>
						<th width="20" ><img src="{{ public_path('images/header_manual.png') }}" width="20px"></th>
						<th width="20" ><img src="{{ public_path('images/header_jumlah.png') }}" width="20px"></th>
					</tr>
				</thead>
				<tbody>
				@php $no = 1; @endphp
				@foreach($data as $item)
					<tr>
						<td align="center" style="font-size:10px;">{{ $no++ }}</td>
						<td align="left" style="font-size:10px;">&nbsp; {{ $item->negeri }}</td>
						<td align="left" style="font-size:10px;">&nbsp; {{ $item->daerah }}</td>
						<td align="left" style="font-size:10px;">&nbsp; {{ $item->parlimen }}</td>
						<td align="left" style="font-size:10px;">&nbsp; {{ $item->dun }}</td>
						<td align="left" style="font-size:10px;">&nbsp; {{ $item->nama_krt }}</td>
						<td align="center" style="font-size:10px;">&nbsp; {{ $item->no_rujukan_krt }}</td>
						<td align="center" style="font-size:10px;">&nbsp; {{ $item->bil_ajk }}</td>
						<td align="center" style="font-size:10px;">&nbsp; {{ $item->bil_aktiviti }}</td>
						<td align="center" style="font-size:10px;">&nbsp; {{ $item->bil_mesyuarat }}</td>
						<td align="center" style="font-size:10px;">&nbsp; {{ $item->bil_kewangan }}</td>
						<td align="center" style="font-size:10px;">&nbsp; {{ ($item->markah_latar + $item->markah_penduduk + $item->markah_pekerjaan + $item->markah_rumah + $item->markah_pertubuhan + $item->markah_kemudahan + $item->markah_sosial + $item->markah_tempat_krt + $item->markah_profil_peta) }}</td>
						<td align="center" style="font-size:10px;">&nbsp; {{ $item->markah_ajk }}</td>
						<td align="center" style="font-size:10px;">&nbsp; {{ $item->markah_aktiviti }}</td>
						<td align="center" style="font-size:10px;">&nbsp; {{ $item->markah_mesyuarat }}</td>
						<td align="center" style="font-size:10px;">&nbsp; {{ $item->markah_kewangan }}</td>
						<td align="center" style="font-size:10px;">&nbsp; {{ $item->keaktifan_markah }}</td>
						<td align="center" style="font-size:10px;">&nbsp; {{ ($item->markah_latar + $item->markah_penduduk + $item->markah_pekerjaan + $item->markah_rumah + $item->markah_pertubuhan + $item->markah_kemudahan + $item->markah_sosial + $item->markah_tempat_krt + $item->markah_profil_peta) + ($item->markah_ajk + $item->markah_aktiviti + $item->markah_mesyuarat + $item->markah_kewangan + $item->keaktifan_markah) }}</td>
						<td align="center" style="font-size:10px;">&nbsp; {{ $item->status }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
    </body>
</html>