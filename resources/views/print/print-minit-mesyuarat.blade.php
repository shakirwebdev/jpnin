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
        <title>Minit Mesyuarat Bulanan</title>
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
				<th width="100%" align="center"><b>{{$data_minit_mesyuarat->nama_krt}}</b></th>
			</tr>
			<tr>
				<th>{{strtoupper($data_krt->daerah)}}</th>
			</tr>
			<tr>
				<th>{{strtoupper($data_krt->negeri)}}</th>
			</tr>
			<tr>
				<th width="100%" align="center"><br><b>MINIT MESYUARAT<b></th>
			</tr>
			<tr>
				<th width="100%" align="center"><b>({{$data_minit_mesyuarat->mesyuarat_title}})</b></th>
			</tr>
			<tr>
				<th width="100%" align="center"><b>BIL. {{$data_minit_mesyuarat->mesyuarat_bil}}<b></th>
			</tr>
		</table>
		<br/><br/><br/><br/>
		<hr>
		<table border="0" cellpadding="0" width="100%">
			<tr>
				<th width="20%" align="left" >TARIKH</th>
				<th width="1%" align="center" >:</th>
				<th width="79%" align="left" >{{$data_minit_mesyuarat->tarikh_mesyuarat}}</th>
			</tr>
			<tr>
				<th width="20%" align="left" >MASA</th>
				<th width="1%" align="center" >:</th>
				<th width="79%" align="left" >{{$data_minit_mesyuarat->masa_mesyuarat}}</th>
			</tr>
			<tr>
				<th width="20%" align="left" >TEMPAT</th>
				<th width="1%" align="center" >:</th>
				<th width="79%" align="left" >{{$data_minit_mesyuarat->tempat_mesyuarat}}</th>
			</tr>
		</table>
		<hr>
		<br>
		<table border="0" cellpadding="0" width="100%">
			<tr>
				<tr>
					<th width="100%" align="left"><b>KEHADIRAN<b></th>
				</tr>
			</tr>
		</table>
		<br>
		<table border="0" cellpadding="0" width="100%">
			<tbody>
				@php $pengerusi_nama = ""; @endphp
				@php $pengerusi_jawatan = ""; @endphp
				@php $pengerusi_id = ""; @endphp
				@php $pencatat_minit_nama = ""; @endphp
				@php $pencatat_minit_jawatan = ""; @endphp
				@php $pencatat_id = ""; @endphp
				@php $no = 1; @endphp
				
				@foreach($data_kehadiran as $item)
					@if ($item->id == $data_minit_mesyuarat->pengerusi_krt)
						@php $pengerusi_nama = $item->kehadiran_nama; @endphp
						@php $pengerusi_jawatan = $item->kehadiran_jawatan; @endphp
						@php $pengerusi_id = $item->kehadiran_ic; @endphp
						<tr>
							<td width="6%" align="center">{{ $no++ }}.</td>
							<td width="74%" align="left">{{ ucwords(strtolower($item->kehadiran_nama)) }}</td>
							<td width="20%" align="left"> - Pengerusi</td>
						</tr>
						<tr>
							<td width="6%" align="center">&nbsp;</td>
							<td width="74%" align="left">{{ $item->kehadiran_jawatan }}</td>
							<td width="20%" align="center">&nbsp;</td>
						</tr>
						@if($item->jenis_kehadiran == 0)
						<tr>
							<td width="6%" align="center">&nbsp;</td>
							<td width="74%" align="left">KRT {{ ucwords(strtolower($data_minit_mesyuarat->nama_krt)) }}</td>
							<td width="20%" align="center">&nbsp;</td>
						</tr>
						@endif
					@endif
				@endforeach
				
				@foreach($data_kehadiran as $item)
					@if ($item->id == $data_minit_mesyuarat->pencatat)
						@php $pencatat_minit_nama = $item->kehadiran_nama; @endphp
						@php $pencatat_minit_jawatan = $item->kehadiran_jawatan; @endphp
						@php $pencatat_id = $item->kehadiran_ic; @endphp
						<tr>
							<td width="6%" align="center">{{ $no++ }}.</td>
							<td width="74%" align="left">{{ ucwords(strtolower($item->kehadiran_nama)) }}</td>
							<td width="20%" align="left"> - Pencatat minit</td>
						</tr>
						<tr>
							<td width="6%" align="center">&nbsp;</td>
							<td width="74%" align="left">{{ $item->kehadiran_jawatan }}</td>
							<td width="20%" align="center">&nbsp;</td>
						</tr>
						@if($item->jenis_kehadiran == 0)
						<tr>
							<td width="6%" align="center">&nbsp;</td>
							<td width="74%" align="left">KRT {{ ucwords(strtolower($data_minit_mesyuarat->nama_krt)) }}</td>
							<td width="20%" align="center">&nbsp;</td>
						</tr>
						@endif
					@endif
				@endforeach
				
				@foreach($data_kehadiran as $item)
					@if($item->jenis_kehadiran == 0 && $item->id != $data_minit_mesyuarat->pengerusi_krt && $item->id != $data_minit_mesyuarat->pencatat)
						<tr>
							<td width="6%" align="center">{{ $no++ }}.</td>
							<td width="74%" align="left">{{ ucwords(strtolower($item->kehadiran_nama)) }}</td>
							<td width="20%" align="left"></td>
						</tr>
						<tr>
							<td width="6%" align="center">&nbsp;</td>
							<td width="74%" align="left">{{ $item->kehadiran_jawatan }}</td>
							<td width="20%" align="center">&nbsp;</td>
						</tr>
						<tr>
							<td width="6%" align="center">&nbsp;</td>
							<td width="74%" align="left">KRT {{ ucwords(strtolower($data_minit_mesyuarat->nama_krt)) }}</td>
							<td width="20%" align="center">&nbsp;</td>
						</tr>
					@endif
				@endforeach
			</tbody>
		</table>
		<br>
		<table border="0" cellpadding="0" width="100%">
			<tr>
				<tr>
					<th width="100%" align="left"><b>TURUT HADIR<b></th>
				</tr>
			</tr>
		</table>
		</br>
		<table border="0" cellpadding="0" width="100%">
			<tbody>
				@php $no = 1; @endphp
				@foreach($data_kehadiran as $item)
					@if($item->jenis_kehadiran == 1 && $item->id != $data_minit_mesyuarat->pengerusi_krt && $item->id != $data_minit_mesyuarat->pencatat)
						<tr>
							<td width="6%" align="center">{{ $no++ }}.</td>
							<td width="74%" align="left">{{ ucwords(strtolower($item->kehadiran_nama)) }}</td>
							<td width="20%" align="center"></td>
						</tr>
						<tr>
							<td width="6%" align="center">&nbsp;</th>
							<td width="74%" align="left">{{ $item->kehadiran_jawatan }}</td>
							<td width="20%" align="center">&nbsp;</th>
						</tr>
					@endif
				@endforeach
			</tbody>
		</table>
		<br>
		<table border="0" cellpadding="0" width="100%">
			<tr>
				<tr>
					<th width="100%" align="left"><b>TIDAK HADIR DENGAN MAAF<b></th>
				</tr>
			</tr>
		</table>
		<br>
		<table border="0" cellpadding="0" width="100%">
			<tbody>
				@php $no = 1; @endphp
				@foreach($data_ajk as $item)
					@if($item->id != $pengerusi_id && $item->id != $pencatat_id)
						@php $ada = 0; @endphp
						@foreach($data_kehadiran as $item2)
							@if($item2->jenis_kehadiran == 0 && $item->id == $item2->kehadiran_ic)
								@php $ada = 1; @endphp
							@endif
						@endforeach
						@if($ada == 0)
						<tr>
							<td width="6%" align="center">{{ $no++ }}.</td>
							<td width="74%" align="left">{{ ucwords(strtolower($item->ajk_nama)) }}</td>
							<td width="20%" align="center"></td>
						</tr>
						<tr>
							<td width="6%" align="center">&nbsp;</td>
							<td width="74%" align="left">{{ $item->jawatan_description }}</td>
							<td width="20%" align="center">&nbsp;</td>
						</tr>
						<tr>
							<td width="6%" align="center">&nbsp;</td>
							<td width="74%" align="left">KRT {{ ucwords(strtolower($data_minit_mesyuarat->nama_krt)) }}</td>
							<td width="20%" align="center">&nbsp;</td>
						</tr>
						@endif
					@endif
				@endforeach
			</tbody>
		</table>
		<br>
		<div class="maincontainer">
			<div class="container">
				<div class="lvl1_1_header"><p class="small"><b>BIL</b></p></div>
					<div class="lvl1_2_back">
			   			<div class="subcontainer">
				  			<div class="lvl1_2_header"><p class="small"><b>PERKARA</b></p></div>
				  			<div class="lvl1_3_header" style="border-left:1px solid;"><p class="small"><b>TINDAKAN</b></p></div>
			   			</div>
					</div>
		  		</div>
			</div>
		</div>
		<div class="maincontainer">
		  	<div class="container">
				<div class="lvl1_1"><p class="small"><b>1.0</b></p></div>
				<div class="lvl1_2_back2">
			   		<div class="subcontainer">
				  		<div class="lvl1_2"><p class="small"><b>PERUTUSAN PENGERUSI</b></p></div>
				  		<div class="lvl1_3"></div>
			   		</div>
				</div>
		  	</div>
		  	<div class="container">
				<div class="lvl1_1"></div>
				<div class="lvl1_2">
			   			<div class="subcontainer">
							<div class="lvl1_12"></div>
							<div class="lvl1_21">
									@php 
										$var_len = strlen($data_minit_mesyuarat->perutusan_pengerusi_mesyuarat); 
										$var_newtext = ""; 
										$var_newidx = 0;
										$var_ambik = "ya";
										$var_data = $data_minit_mesyuarat->perutusan_pengerusi_mesyuarat; 
										for ($var_idx = 0; $var_idx < $var_len; $var_idx++)
										{
											$var_newtext[$var_newidx] = $var_data[$var_idx];
											$var_newidx = $var_newidx + 1;
										}
										$var_newtext = preg_replace('/\sstyle=("|\').*?("|\')/i', '', $var_newtext);
										$var_newtext = preg_replace('/\sclass=("|\').*?("|\')/i', '', $var_newtext);
										$var_newtext = str_replace("<br><br>","",$var_newtext);
										/*
										$var_newtext = str_replace("</p>","",$var_newtext);
										$var_newtext = str_replace("<p>","",$var_newtext);*/
										$var_newtext = str_replace("<br />","",$var_newtext);
										$var_newtext = str_replace("<p></p>","",$var_newtext);
										$var_newtext = str_replace("<!--[if !supportLists]-->","",$var_newtext);
										$var_newtext = str_replace("><!--[endif]-->","",$var_newtext);
										$var_newtext = str_replace("<o:p></o:p>","",$var_newtext);
										/*if(substr($var_newtext,0,3) == '<p>')
										{
											$ll=strlen($var_newtext);
											$var_newtext = substr($var_newtext,3,$ll-3);
										}*/
										//$var_newtext = '<p>'.$var_newtext;
									@endphp
									{!! $var_newtext !!}
							</div>
							<div class="lvl1_3"><p class="small">Makluman</p></div>
			   			</div>
		  		</div>
			</div>
		</div>
		<div class="maincontainer">
		  	<div class="container">
				<div class="lvl1_1"><p class="small"><b>2.0</b></p></div>
				<div class="lvl1_2_back2">
			   		<div class="subcontainer">
				  		<div class="lvl1_2"><p class="small"><b>PENGESAHAN MINIT MESYUARAT</b></p></div>
				  		<div class="lvl1_3"></div>
			   		</div>
				</div>
		  	</div>
		  	<div class="container">
				<div class="lvl1_1"></div>
				<div class="lvl1_2">
			   			<div class="subcontainer">
							<div class="lvl1_12"><p class="small">&nbsp;</p></div>
							<div class="lvl1_21">
									@php 
										$var_len = strlen($data_minit_mesyuarat->minit_yang_lalu_mesyuarat); 
										$var_newtext = ""; 
										$var_newidx = 0;
										$var_ambik = "ya";
										$var_data = $data_minit_mesyuarat->minit_yang_lalu_mesyuarat; 
										for ($var_idx = 0; $var_idx < $var_len; $var_idx++)
										{
											$var_newtext[$var_newidx] = $var_data[$var_idx];
											$var_newidx = $var_newidx + 1;
										}
										$var_newtext = preg_replace('/\sstyle=("|\').*?("|\')/i', '', $var_newtext);
										$var_newtext = preg_replace('/\sclass=("|\').*?("|\')/i', '', $var_newtext);
										$var_newtext = str_replace("<br><br>","",$var_newtext);
										/*$var_newtext = str_replace("</p>","",$var_newtext);
										$var_newtext = str_replace("<p>","",$var_newtext);*/
										$var_newtext = str_replace("<br />","",$var_newtext);
										$var_newtext = str_replace("<p></p>","",$var_newtext);
										$var_newtext = str_replace("<!--[if !supportLists]-->","",$var_newtext);
										$var_newtext = str_replace("><!--[endif]-->","",$var_newtext);
										$var_newtext = str_replace("<o:p></o:p>","",$var_newtext);
										/*if(substr($var_newtext,0,3) == '<p>')
										{
											$ll=strlen($var_newtext);
											$var_newtext = substr($var_newtext,3,$ll-3);
										}*/
									@endphp
									{!! $var_newtext !!}
							</div>
							<div class="lvl1_3"><p class="small">Makluman</p></div>
			   			</div>
		  		</div>
			</div>
		</div>
		<div class="maincontainer">
		  	<div class="container">
				<div class="lvl1_1"><p class="small"><b>3.0</b></p></div>
				<div class="lvl1_2_back2">
			   		<div class="subcontainer">
				  		<div class="lvl1_2"><p class="small"><b>PEMBENTANGAN PENYATA KEWANGAN RUKUN TETANGGA</b></p></div>
				  		<div class="lvl1_3"></div>
			   		</div>
				</div>
		  	</div>
		  	<div class="container">
				<div class="lvl1_1"></div>
				<div class="lvl1_2">
			   			<div class="subcontainer">
							<div class="lvl1_12"><p class="small">&nbsp;</p></div>
							<div class="lvl1_21">
									@php 
										$var_len = strlen($data_minit_mesyuarat->penyata_kewangan_mesyuarat); 
										$var_newtext = ""; 
										$var_newidx = 0;
										$var_ambik = "ya";
										$var_data = $data_minit_mesyuarat->penyata_kewangan_mesyuarat; 
										for ($var_idx = 0; $var_idx < $var_len; $var_idx++)
										{
											$var_newtext[$var_newidx] = $var_data[$var_idx];
											$var_newidx = $var_newidx + 1;
										}
										$var_newtext = preg_replace('/\sstyle=("|\').*?("|\')/i', '', $var_newtext);
										$var_newtext = preg_replace('/\sclass=("|\').*?("|\')/i', '', $var_newtext);
										
										$var_newtext = str_replace("<br><br>","",$var_newtext);
										/*$var_newtext = str_replace("</p>","",$var_newtext);
										$var_newtext = str_replace("<p>","",$var_newtext);*/
										$var_newtext = str_replace("<br />","",$var_newtext);
										$var_newtext = str_replace("<p></p>","",$var_newtext);
										$var_newtext = str_replace("<!--[if !supportLists]-->","",$var_newtext);
										$var_newtext = str_replace("><!--[endif]-->","",$var_newtext);
										$var_newtext = str_replace("<o:p></o:p>","",$var_newtext);
										/*if(substr($var_newtext,0,3) == '<p>')
										{
											$ll=strlen($var_newtext);
											$var_newtext = substr($var_newtext,3,$ll-3);
										}*/
									@endphp
									{!! $var_newtext !!}
							</div>
							<div class="lvl1_3"><p class="small">Makluman</p></div>
			   			</div>
		  		</div>
			</div>
		</div>
		<div class="maincontainer">
		  	<div class="container">
				<div class="lvl1_1"><p class="small"><b>4.0</b></p></div>
				<div class="lvl1_2_back2">
					<div class="subcontainer">
						<div class="lvl1_2"><p class="small"><b>PERKARA-PERKARA BERBANGKIT</b></p></div>
						<div class="lvl1_3"></div>
					</div>
				</div>
			</div>
			@php $no = 4.0; @endphp
        	@foreach($data_pekara_berbangkit as $item)
			@php $no = $no + 0.1; @endphp
		  	<div class="container">
				<div class="lvl1_1"></div>
				<div class="lvl1_2">
					<div class="subcontainer">
						<div class="lvl1_123"><p class="small">&nbsp;</p></div>
						<div class="lvl1_12"><b>{{ $no }}</b></div>
						<div class="lvl1_213"><b>Perkara:</b><br>{{ $item->berbangkit_perkara }}<br><br><b>Tindakan yang diambil:</b><br>{{ $item->berbangkit_tindakan }}<br>&nbsp;</div>
						<div class="lvl1_3">{{ $item->berbangkit_tindakan_siapa }}</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<div class="maincontainer">
		  	<div class="container">
				<div class="lvl1_1"><p class="small"><b>5.0</b></p></div>
				<div class="lvl1_2_back2">
					<div class="subcontainer">
						<div class="lvl1_2"><p class="small"><b>PEMBENTANGAN/PERBINCANGAN</b></p></div>
						<div class="lvl1_3"></div>
					</div>
				</div>
			</div>
			@php $no = 5.0; @endphp
        	@foreach($data_kertas_kerja as $item)
			@php $no = $no + 0.1; @endphp
		  	<div class="container">
				<div class="lvl1_1"></div>
				<div class="lvl1_2">
					<div class="subcontainer">
						<div class="lvl1_123"><p class="small">&nbsp;</p></div>
						<div class="lvl1_12"><b>{{ $no }}</b></div>
						<div class="lvl1_213"><b>Perkara:</b><br>{{ $item->kertas_kerja_perkara }} <br><br><b>Tindakan yang diambil:</b><br>{{ $item->kertas_kerja_tindakan }}<br>&nbsp;</div>
						<div class="lvl1_3">{{ $item->kertas_kerja_tindakan_siapa }}</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<div class="maincontainer">
		  	<div class="container">
				<div class="lvl1_1"><p class="small"><b>6.0</b></p></div>
				<div class="lvl1_2_back2">
					<div class="subcontainer">
						<div class="lvl1_2"><p class="small"><b>HAL-HAL LAIN</b></p></div>
						<div class="lvl1_3"></div>
					</div>
				</div>
			</div>
			@php $no = 6.0; @endphp
        	@foreach($data_hal_lain as $item)
			@php $no = $no + 0.1; @endphp
		  	<div class="container">
				<div class="lvl1_1"></div>
				<div class="lvl1_2">
					<div class="subcontainer">
						<div class="lvl1_123"><p class="small">&nbsp;</p></div>
						<div class="lvl1_12"><b>{{ $no }}</b></div>
						<div class="lvl1_213"><b>Perkara:</b><br>{{ $item->hal_lain_perkara }} <br><br><b>Tindakan yang diambil:</b><br>{{ $item->hal_lain_tindakan }}<br>&nbsp;</div>
						<div class="lvl1_3">{{ $item->hal_lain_tindakan_siapa }}</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<div class="maincontainer">
		  	<div class="container">
				<div class="lvl1_1"><p class="small"><b>7.0</b></p></div>
				<div class="lvl1_2_back2">
			   		<div class="subcontainer">
				  		<div class="lvl1_2"><p class="small"><b>PENUTUP</b></p></div>
				  		<div class="lvl1_3"></div>
			   		</div>
				</div>
		  	</div>
		  	<div class="container">
				<div class="lvl1_1"></div>
				<div class="lvl1_2">
			   			<div class="subcontainer">
							<div class="lvl1_12"><p class="small">&nbsp;</p></div>
							<div class="lvl1_21">
									@php 
										$var_len = strlen($data_minit_mesyuarat->penutup_mesyuarat); 
										$var_newtext = ""; 
										$var_newidx = 0;
										$var_ambik = "ya";
										$var_data = $data_minit_mesyuarat->penutup_mesyuarat; 
										for ($var_idx = 0; $var_idx < $var_len; $var_idx++)
										{
											$var_newtext[$var_newidx] = $var_data[$var_idx];
											$var_newidx = $var_newidx + 1;
										}
										$var_newtext = preg_replace('/\sstyle=("|\').*?("|\')/i', '', $var_newtext);
										$var_newtext = preg_replace('/\sclass=("|\').*?("|\')/i', '', $var_newtext);
										$var_newtext = str_replace("<br><br>","",$var_newtext);
										/*$var_newtext = str_replace("</p>","",$var_newtext);
										$var_newtext = str_replace("<p>","",$var_newtext);*/
										$var_newtext = str_replace("<br />","",$var_newtext);
										$var_newtext = str_replace("<p></p>","",$var_newtext);
										$var_newtext = str_replace("<!--[if !supportLists]-->","",$var_newtext);
										$var_newtext = str_replace("><!--[endif]-->","",$var_newtext);
										$var_newtext = str_replace("<o:p></o:p>","",$var_newtext);
										/*if(substr($var_newtext,0,3) == '<p>')
										{
											$ll=strlen($var_newtext);
											$var_newtext = substr($var_newtext,3,$ll-3);
										}*/
									@endphp
									{!! $var_newtext !!}
							</div>
							<div class="lvl1_3"><p class="small">Makluman</p></div>
			   			</div>
		  		</div>
			</div>
		</div>
		<br>
		<table border="0" cellpadding="0" width="100%">
			<tr>
				<td width="100%" align="left">Disediakan oleh:</td>
			</tr>
			<tr>
				<td height="100" width="100%" align="left">&nbsp;</td>
			</tr>
			<tr>
				<td width="100%" align="left"><b>({{ $pencatat_minit_nama }})</b></td>
			</tr>
			<tr>
				<td width="100%" align="left">{{ ucwords(strtolower($pencatat_minit_jawatan)) }}</td>
			</tr>
			<tr>
				<td width="100%" align="left">KRT {{ ucwords(strtolower($data_minit_mesyuarat->nama_krt)) }}</td>
			</tr>
			<tr>
				<td width="100%" align="left">Tarikh: {{ $data_minit_mesyuarat->tarikh_rekod }}</td>
			</tr>
		</table>
		<br>
		<table border="0" cellpadding="0" width="100%">
			<tr>
				<td width="100%" align="left">Disemak/Disahkan oleh:</td>
			</tr>
			<tr>
				<td height="100" width="100%" align="left">&nbsp;</td>
			</tr>
			<tr>
				<td width="100%" align="left"><b>({{ $data_minit_mesyuarat->penyemak }} )</b></td>
			</tr>
			<tr>
				<td width="100%" align="left">Pegawai Penyelia</td>
			</tr>
			<tr>
				<td width="100%" align="left">KRT {{ ucwords(strtolower($data_minit_mesyuarat->nama_krt)) }}</td>
			</tr>
			<tr>
				<td width="100%" align="left">Tarikh: {{ $data_minit_mesyuarat->tarikh_semak }}</td>
			</tr>
		</table>
</body>
</html>
