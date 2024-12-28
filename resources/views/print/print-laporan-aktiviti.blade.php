<style>
.page-break {
    page-break-after: always;
}
table {
  	border-collapse: collapse;
}
.maincontainer {
  display: table;
  width: 100%;
  border: 1px solid;
}
.container {
  display: table;
  width: 100%;
}
.subcontainer {
  display: table;
  width: 100%;
}
.lvl1_1_header {
  display: table-cell;
  padding: 0px;
  width: 5%;
  background-color: #CCCCCC;
  text-align: center;
  border-right: 1px solid;
}
.lvl1_1 {
  display: table-cell;
  padding: 0px;
  width: 5%;
  text-align: center;
  border-right: 1px solid;
}
.lvl1_12 {
  display: table-cell;
  padding: 0px;
  width: 5%;
}
.lvl1_123 {
  display: table-cell;
  padding: 0px;
  width: 5%;
}
.lvl1_2_header {
  display: table-cell;
  padding: 0px;
  width: 70%;
  text-align: center;
  background-color: #CCCCCC;
  border-right: 1px solid;
}
.lvl1_2_back {
  display: table-cell;
  padding: 0px;
  width: 70%;
}
.lvl1_2_back2 {
  display: table-cell;
  padding: 0px;
  width: 70%;
}
.lvl1_2 {
  display: table-cell;
  padding: 0px;
  width: 70%;
}
.lvl1_21 {
  display: table-cell;
  width: 65%;
}
.lvl1_213 {
  display: table-cell;
  width: 60%;
}
.lvl1_3_header {
  display: table-cell;
  padding: 0px;
  width: 25%;
  background-color: #CCCCCC;
  text-align: center;
}
.lvl1_3 {
  display: table-cell;
  padding: 0px;
  width: 25%;
  text-align: center;
  border-left: 1px solid;
}
p.small {
	line-height: 0.2;
}
p.small2 {
	line-height: 0.1;
}
</style>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Laporan Aktiviti</title>
    </head>
<body>
		<table border="0" cellpadding="0" width="100%">
			<tr>
				<th><img src="{{ public_path('images/logo_krt.png') }}" style="width: 10%"></th>
			</tr>
			<tr>
				<th>KAWASAN RUKUN TETANGGA</th>
			</tr>
			<tr>
				<th width="100%" align="center"><b>{{$data_krt->krt_nama}}</b></th>
			</tr>
			<tr>
				<th>{{strtoupper($data_krt->daerah)}}</th>
			</tr>
			<tr>
				<th>{{strtoupper($data_krt->negeri)}}</th>
			</tr>
			<tr>
				<th width="100%" align="center"><br><b>LAPORAN AKTIVITI<b></th>
			</tr>
		</table>
		<br/>
		<hr>
		<table border="0" cellpadding="0" width="100%">
			<tr>
				<th width="20%" align="left" >TAJUK</th>
				<th width="1%" align="center" >:</th>
				<th width="79%" align="left" >{{$data_basic->aktiviti_tajuk}}</th>
			</tr>
			<tr>
				<th width="20%" align="left" >TARIKH</th>
				<th width="1%" align="center" >:</th>
				<th width="79%" align="left" >{{$data_basic->aktiviti_tarikh}}</th>
			</tr>
			<tr>
				<th width="20%" align="left" >MASA</th>
				<th width="1%" align="center" >:</th>
				<th width="79%" align="left" >{{$data_basic->aktiviti_masa}}</th>
			</tr>
			<tr>
				<th width="20%" align="left" >TEMPAT</th>
				<th width="1%" align="center" >:</th>
				<th width="79%" align="left" >{{$data_basic->aktiviti_tempat}}</th>
			</tr>
			<tr>
				<th width="20%" align="left" >DAERAH</th>
				<th width="1%" align="center" >:</th>
				<th width="79%" align="left" >{{$data_basic->daerah_id}}</th>
			</tr>
			<tr>
				<th width="20%" align="left" >NEGERI</th>
				<th width="1%" align="center" >:</th>
				<th width="79%" align="left" >{{$data_basic->state_id}}</th>
			</tr>
		</table>
		<hr>
		<table border="0" cellpadding="0" width="100%">
			<tr>
				<tr>
					<th width="100%" align="left"><b>LAPORAN TERPERINCI<b></th>
				</tr>
			</tr>
		</table>
		<br>
		<table border="0" cellpadding="0" width="80%" align="center">
			<tr>
				<td width="20%"><b>Penganjur</b></td>
				<td width="1%"><b>:</b></td>
				<td width="59%">{{$data_basic->penganjur_id}}</td>
			</tr>
			<tr>
				<td width="20%"><b>Peringkat</b></td>
				<td width="1%"><b>:</b></td>
				<td width="59%">{{$data_basic->peringkat_id}}</td>
			</tr>
			<tr>
				<td width="20%"><b>Agenda kerja</b></td>
				<td width="1%"><b>:</b></td>
				<td width="59%">{{$data_basic->agenda_id}}</td>
			</tr>
			<tr>
				<td width="20%"><b>Program</b></td>
				<td width="1%"><b>:</b></td>
				<td width="59%">{{$data_basic->program_id}}</td>
			</tr>
			<tr>
				<td width="20%"><b>Bidang</b></td>
				<td width="1%"><b>:</b></td>
				<td width="59%">{{$data_basic->bidang_id}}</td>
			</tr>
			<tr>
				<td width="20%"><b>Kategori Aktiviti</b></td>
				<td width="1%"><b>:</b></td>
				<td width="59%">{{$data_basic->aktiviti_id}}</td>
			</tr>
			<tr>
				<td width="20%"><b>Jenis Aktiviti</b></td>
				<td width="1%"><b>:</b></td>
				<td width="59%">{{$data_basic->penganjur_id}}</td>
			</tr>
			<tr>
				<td width="20%"><b>Pembelanjaan</b></td>
				<td width="1%"><b>:</b></td>
				<td width="59%">{{$data_basic->aktiviti_pembelanjaan}}</td>
			</tr>
			<tr>
				<td width="20%"><b>Sumber Kewangan</b></td>
				<td width="1%"><b>:</b></td>
				<td width="59%">{{$data_basic->kewangan_id}}</td>
			</tr>
			<tr>
				<td width="20%"><b>Kumpulan Sasar</b></td>
				<td width="1%"><b>:</b></td>
				<td width="59%">{{$data_basic->aktiviti_sasar}}</td>
			</tr>
			<tr>
				<td width="20%"><b>Perasmi</b></td>
				<td width="1%"><b>:</b></td>
				<td width="59%">{{$data_basic->aktiviti_perasmi}}</td>
			</tr>
		</table>
		<br>
		<table border="0" cellpadding="0" width="100%">
			<tr>
				<tr>
					<th width="100%" align="left"><b>PENYERTAAN<b></th>
				</tr>
			</tr>
		</table>
		<br>
		<table border="0" cellpadding="0" width="100%">
			<tbody>
				@php $no = 1; @endphp
				
				@foreach($data_penyertaan as $item)
						<tr>
							<td width="6%" align="center">{{ $no++ }}.</td>
							<td width="74%" align="left">{{ $item->kaum_id }}</td>
							<td width="20%" align="left">{{ $item->jantina_id }}</td>
						</tr>
				@endforeach
			</tbody>
		</table>
		<br>
		<table border="0" cellpadding="0" width="100%">
			<tr>
				<tr>
					<th width="100%" align="left"><b>RAKAN PERPADUAN<b></th>
				</tr>
			</tr>
		</table>
		</br>
		<table border="0" cellpadding="0" width="100%">
			<tbody>
				@php $no = 1; @endphp
				@foreach($data_rakan as $item)
						<tr>
							<td width="6%" align="center">&nbsp;</th>
							<td width="74%" align="left">{{ $item->rakan_id }}</td>
							<td width="20%" align="center">{{ $item->sumbangan_id }}</th>
						</tr>
				@endforeach
			</tbody>
		</table>
		<br>
</body>
</html>
