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
        <title>Surat Pemakluman Ditolak Kemasukan Tabika Perpaduan</title>
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
            <th width="30%" align="right" ><b> {{ $permohonan_pelajar[0]->tarikh_disahkan }}</b></th>
        </tr>
    </table>
    <br><br><br><br><br>
    <table border="0" cellpadding="5" width="100%">
        <tr>
            <th width="100%" align="left" ><b>{{ $permohonan_pelajar[0]->bapa_nama }}</b></th>
        </tr>
        <tr>
            <th width="100%" align="left" ><b>{{ $permohonan_pelajar[0]->student_alamat }}</b></th>
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
            <th width="100%" align="left" ><b>KEPUTUSAN MEMASUKI TABIKA PERPADUAN BAGI TAHUN 2023</b></th>
        </tr>
    </table>
    <br>
    <table border="0" cellpadding="5" width="100%">
        <tr>
            <th width="30%" align="left" ><b>NAMA KANAK - KANAK</b></th>
            <th width="1%" align="left">:</th>
            <th width="64%" align="left">{{ $permohonan_pelajar[0]->student_nama }}</th>
        </tr>
    </table>
    <br>
    <table border="0" cellpadding="5" width="100%">
        <tr>
            <th width="15%" align="left" >Dengan segala hormatnya perkara diatas, dukacitanya dimaklumkan bahawa anak tuan / puan seperti nama diatas tidak berjaya dalam permohonan kemasukan ke
                ke Tabika Perpaduan {{ $permohonan_pelajar[0]->tbk_nama }} atas sebab - sebab seperti berikut :</th>
        </tr>
    </table>
    <br>
    
    <table border="0" cellpadding="5" width="100%">
        <tr>
            <th width="10%"></th>
            <th width="60%" align="left">i) Kanak-kanak tersebut dilahirkan dalam tahun  </th>
            <th width="20%" align="left">
                @php 
                    $ditolak_tahun = $permohonan_pelajar[0]->ditolak_tahun; 
                    
                @endphp
                @if($ditolak_tahun =='1')         
                    <input type="checkbox" id="scales" name="scales" checked disabled></th>
                @else
            
                @endif
            </th>
         </tr>
        <tr>
            <th width="10%"></th>
            <th width="60%" align="left">ii) Kuota telah dipenuhi</th>
            <th width="20%" align="left">
                @php 
                    $ditolak_penuh = $permohonan_pelajar[0]->ditolak_penuh; 
                    
                @endphp
                @if($ditolak_penuh =='1')         
                    <input type="checkbox" id="scales" name="scales" checked disabled></th>
                @else
            
                @endif
            </th>
        </tr>
        <tr>
            <th width="10%"></th>
            <th width="60%" align="left">iii) Permohonan Tidak Lengkap</th>
            <th width="20%" align="left">
                @php 
                    $ditolak_xlengkap = $permohonan_pelajar[0]->ditolak_xlengkap; 
                    
                @endphp
                @if($ditolak_xlengkap =='1')         
                    <input type="checkbox" id="scales" name="scales" checked disabled></th>
                @else
            
                @endif
            </th>
        </tr>
        <tr>
            <th width="10%"></th>
            <th width="60%" align="left">iv) Jarak tempat kediaman / tempat kerja dengan tabika</th>
            <th width="20%" align="left">
                @php 
                    $ditolak_jauh = $permohonan_pelajar[0]->ditolak_jauh; 
                    
                @endphp
                @if($ditolak_jauh =='1')         
                    <input type="checkbox" id="scales" name="scales" checked disabled></th>
                @else
            
                @endif
            </th>
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
            <th width="100%" align="left" >(  <b>{{ $permohonan_pelajar[0]->user_fullname }}</b>  )</th>
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






