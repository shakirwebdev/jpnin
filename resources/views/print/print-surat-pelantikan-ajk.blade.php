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
        <title>Surat Pelantikan AJK KRT</title>
    </head>
    <body>
		<br><br><br><br><br><br><br><br><br><br><br><br>
        <table border="0" cellpadding="0" width="100%">
            <tr>
                <th width="100%" align="right"><b>Tarikh : {{$surat_pelantikan_ajk_krt->ajk_tarikh_disahkan}}</b></th>
            </tr>
            <tr>
                <th width="100%" align="left"><br>{{$surat_pelantikan_ajk_krt->ajk_nama}}</th>
            </tr>
            <tr>
                <th width="100%" align="left">{{$surat_pelantikan_ajk_krt->ajk_alamat}},</th>
            </tr>
			<tr>
                <th width="100%" align="left"><label style="text-transform:uppercase">{{$surat_pelantikan_ajk_krt->daerah_description}},</label></th>
            </tr>
			<tr>
                <th width="100%" align="left"><b style="text-transform:uppercase">{{$surat_pelantikan_ajk_krt->state_description}}</b></th>
            </tr>
        </table>
        <table border="0" cellpadding="0" width="100%">
            <tr>
                <th width="100%" align="left"><br>Tuan / Puan</th>
            </tr>
            <tr>
                <th width="100%" align="left"><br><b><u>PELANTIKAN SEBAGAI AHLI JAWATANKUASA RUKUN TETANGGA {{$surat_pelantikan_ajk_krt->krt_nama}}, {{ strtoupper($surat_pelantikan_ajk_krt->daerah_description) }}, {{ strtoupper($surat_pelantikan_ajk_krt->state_description) }}</u></b></th>
            </tr>
        </table>
        <br>
        <table border="0" cellpadding="0" width="100%">
            <tr>
                <th width="100%" align="justify">
                    Dengan segala hormatnya, sukacita dimaklumkan bahawa saya selaku Penolong Pengarah (Rukun Tetangga) di bawah Seksyen 7, Akta Rukun Tetangga 2012
                    dengan ini melantik tuan/puan sebagai <b>{{$surat_pelantikan_ajk_krt->ajk_jawatan}}</b> Kawasan Rukun Tetangga <b>{{ $surat_pelantikan_ajk_krt->krt_nama }}</b>
                    berkuatkuasa dari <b>{{$surat_pelantikan_ajk_krt->ajk_tarikh_mula}}</b> hingga <b>{{$surat_pelantikan_ajk_krt->ajk_tarikh_akhir}}</b>.
                </th>
            </tr>
        </table>
        <br>
        <table border="0" cellpadding="0" width="100%">
            <tr>
                <th width="100%" align="justify">2. Walau bagaimanapun, pelantikan ini adalah tertakluk kepada Seksyen 7(3), Akta Rukun Tetangga 2012 dan keputusan rekod Tapisan Keselamatan Polis dengan tujuan sekiranya didapati tuan/puan mempunyai apa-apa rekod yang boleh menghilangkan kelayakan tuan/puan memegang apa-apa jawatan, maka dengan sendirinya pelantikan ini terbatal dan ditarik serta merta.
                </th>
            </tr>
        </table>
        <br>
        <table border="0" cellpadding="0" width="100%">
            <tr>
                <th width="100%" align="justify">3. Di atas persetujuan tuan/puan menerima pelantikan ini, terlebih dahulu diucapkan setinggi-tinggi penghargaan dan terima kasih.
                </th>
            </tr>
        </table>
        <br>
        <table border="0" cellpadding="5" width="100%">
            <tr>
                <th width="100%" align="left">Sekian.</th>
            </tr>
        </table>
        <br>
        <table border="0" cellpadding="0" width="100%">
            <tr>
                <th width="100%" align="left"><b>"BERKHIDMAT UNTUK NEGARA"</b></th>
            </tr>
        </table>
        <br>
        <table border="0" cellpadding="0" width="100%">
            <tr>
                <th width="100%" align="left">Saya yang menjalankan amanah,</th>
            </tr>
        </table>
        <br><br>
		@php if($surat_pelantikan_ajk_krt->krt_state == '09' || $surat_pelantikan_ajk_krt->krt_state == '14' || $surat_pelantikan_ajk_krt->krt_state == '15' || $surat_pelantikan_ajk_krt->krt_state == '16') { @endphp
        <table border="0" cellpadding="0" width="100%">
            <tr>
                <th width="100%" align="left"><b style="text-transform:uppercase">{{$surat_pelantikan_ajk_krt->ajk_disahkan_oleh}}</b></th>
            </tr>
            <tr>
                <th width="100%" align="left">Pengarah Rukun Tetangga</th>
            </tr>
            <tr>
                <th width="100%" align="left">Negeri {{$surat_pelantikan_ajk_krt->state_description}}</th>
            </tr>
			<tr>
                <th width="100%" align="left">Jabatan Perpaduan Negara dan Intergrasi Nasional</th>
            </tr>
        </table>
		@php }else{ @endphp
		<table border="0" cellpadding="0" width="100%">
            <tr>
                <th width="100%" align="left"><b style="text-transform:uppercase">{{$surat_pelantikan_ajk_krt->ajk_disahkan_oleh}}</b></th>
            </tr>
            <tr>
                <th width="100%" align="left">Penolong Pengarah Rukun Tetangga</th>
            </tr>
            <tr>
                <th width="100%" align="left">Daerah {{$surat_pelantikan_ajk_krt->daerah_description}}</th>
            </tr>
			<tr>
                <th width="100%" align="left">Negeri {{$surat_pelantikan_ajk_krt->state_description}}</th>
            </tr>
			<tr>
                <th width="100%" align="left">Jabatan Perpaduan Negara dan Intergrasi Nasional</th>
            </tr>
        </table>
		@php } @endphp
		<div align="center" style="padding-top:20px;">- Surat ini dijana oleh komputer -</div>
    </body>
</html>







