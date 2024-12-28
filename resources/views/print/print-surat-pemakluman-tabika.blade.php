<style type="text/css">
    .page-break {
        page-break-after: always;
    
    }
    table {
        margin:5px;
        font-size:14px;
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
    .bg {
        background-image: url("assets/images/sijil/Sijil_Watikah_Pelantikan.png");
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
</style>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Surat Pemakluman Kelulusan Tabika</title>
    </head>
    <table border="0" cellpadding="0" width="100%">
        <tr>
            <th width="100%" align="right" ></th>
        </tr>
    </table>
    <br><br>
    <table border="0" cellpadding="5" width="100%">
        <tr>
            <th width="70%" align="right" ><b></b></th>
            <th width="30%" align="right" ><b> JPNIN 03/517/07 JLD 11 ()</b></th>
        </tr>
        <tr>
            <th width="70%" align="right" ><b></b></th>
            <th width="30%" align="right" ><b> {{ $lulus_permohonan_pelajar[0]->tarikh_lulus }}</b></th>
        </tr>
    </table>
    <br><br><br><br><br>
    <table border="0" cellpadding="5" width="100%">
        <tr>
            <th width="100%" align="left" ><b>{{ $lulus_permohonan_pelajar[0]->bapa_nama }}</b></th>
        </tr>
        <tr>
            <th width="100%" align="left" ><b>{{ $lulus_permohonan_pelajar[0]->student_alamat }}</b></th>
        </tr>
    </table>
    <br>
    <table border="0" cellpadding="5" width="100%">
        <tr>
            <th width="15%" align="left" >Tuan / Puan,</th>
        </tr>
    </table>
    <br>
    <table border="0" cellpadding="5" width="100%">
        <tr>
            <th width="15%" align="left" ><b>TAWARAN KEMASUKAN KE KELAS TABIKA PERPADUAN BAGI TAHUN 2023</b></th>
        </tr>
    </table>
    <br>
    <table border="0" cellpadding="5" width="100%">
        <tr>
            <th width="15%" align="left" >Dengan segala hormatnya perkara tersebut di atas adalah dirujuk.</th>
        </tr>
    </table>
    <br>
    <table border="0" cellpadding="5" width="100%">
        <tr>
            <th width="15%" align="left" >2. Sukacita dimaklumkan bahawa anak Tuan/Puan bernama <b>{{ $lulus_permohonan_pelajar[0]->student_nama }}</b> telah diterima untuk memasuki kelas Tabika Perpaduan seperti berikut :</th>
        </tr>
    </table>
    <br>
    <table border="0" cellpadding="5" width="100%">
        <tr>
            <th width="15%" align="right">Nama Tabika</th>
            <th width="1%" align="left">:</th>
            <th width="84%" align="left"><b>{{ $lulus_permohonan_pelajar[0]->tbk_nama }}</b></th>
         </tr>
        <tr>
            <th width="15%" align="right">Daerah</th>
            <th width="1%" align="left">:</th>
            <th width="84%" align="left"><b>{{ $lulus_permohonan_pelajar[0]->daerah }}</b></th>
        </tr>
        <tr>
            <th width="15%" align="right">Negeri</th>
            <th width="1%" align="left">:</th>
            <th width="84%" align="left"><b>{{ $lulus_permohonan_pelajar[0]->state }}</b></th>
        </tr>
    </table>
    <br>
    <table border="0" cellpadding="5" width="100%">
        <tr>
            <th width="15%" align="left" >3. Sehubungan itu, guru kelas berkenaan akan menghubungi tuan/puan bagi urusan pendaftaran selanjutnya.</th>
        </tr>
    </table>
    <br>
    <table border="0" cellpadding="5" width="100%">
        <tr>
            <th width="100%" align="left" >Sekian, Terima Kasih</th>
        </tr>
    </table>
    <br>
    <table border="0" cellpadding="5" width="100%">
        <tr>
            <th width="100%" align="left" ><b>"BERKHIDMAT UNTUK NEGARA"</b></th>
        </tr>
    </table>
    <br><br><br><br>
    <table border="0" cellpadding="5" width="100%">
        <tr>
            <th width="100%" align="left" >(  <b>{{ $lulus_permohonan_pelajar[0]->user_fullname }}</b>  )</th>
        </tr>
        <tr>
            <th width="100%" align="left" >Pegawai Perpaduan Daerah</th>
        </tr>
        <tr>
            <th width="100%" align="left" >Jabatan Perpaduan Negara Dan Intergrasi Nasional</th>
        </tr>
        <tr>
            <th width="100%" align="left" >KEMENTERIAN PERPADUAN NEGARA</th>
        </tr>
    </table>
</html>






