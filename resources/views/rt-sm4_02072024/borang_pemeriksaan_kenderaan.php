<?php

require_once('../tcpdf/tcpdf.php');

function test() {
    $output = 'test';
    return $output;
}

if (isset($_POST["borang_pemeriksaan_kenderaan"])) {

    class MYPDF extends TCPDF {

        public function Header() {
            $this->SetFont('times', '', 12);
            if ($_POST["mrk2_laporan_kategori"] == 1) {
                $sulit = ' <font color="red">SULIT</font>';
            }else{
                $sulit = '';
            }
            $html = '<table border="0" cellpadding="4">
                <tr>
                    <th align="center"><br><br>
                    '.$sulit.'
                        
                    </th>
                </tr>
            </table>';
            $this->writeHTML($html);
        }



        public function Footer() {
            $this->SetY(-28);
            $this->SetFont('times', '', 9);
            //$html = 'PAGE '.$this->getAliasNumPage().' OF '.$this->getAliasNbPages().'<hr><br/><br/>';
            if ($_POST["mrk2_laporan_standards"] == 1) {
                $logo = ' <img src="../img/forensik/logo_standards.png" alt="FORENSIK" width="70">';
            }else{
                $logo = '';
            }
            $html = '
            <hr><br>
            <table border="0" cellpadding="0">
                <tr>
                    <th align="center">'.$logo.'</th>
                </tr>
            </table>';
            $this->writeHTML($html, true, 0, true, 0);
        }
        

    }

    // create new PDF document
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Borang Pemeriksaan Kenderaan');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 009', PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(false,0);

    $pdf->AddPage();

    $pdf->SetFont('helvetica', '', 10);
    $pdf->setPrintFooter(true);

    $content = '
        <style>
    div.a {
        text-transform: uppercase;
    }

    div.b {
        text-transform: lowercase;
    }

    div.c {
        text-transform: capitalize;
    }
    </style>
            <p border ="1" align ="center"><br>
                <table border="0" cellpadding="0">
                    <tr>
                        <th width="25%" align="left"><font size="10"><b>
                          Makmal Forensik <br>
                         Polis Diraja Malaysia <br>
                         Bt. 8 ½, Jalan Cheras <br>
                         43200 Cheras, Selangor <br>
                         Tel : 03-91065730 <br> 
                         Fax : 03-91065757
                        </b></font></th>
                        <th width="75%" align="left"><img src="../img/forensik/forensik_logo.PNG" alt="FORENSIK" width="220"><br><br></th>
                    </tr>
                </table>
                <table border="0" cellpadding="0">
                    <tr>
                        <th><font size="14"><b>UNIT SIASATAN / ANALISIS KENDERAAN</b></font></th>
                    </tr>
                    <tr>
                        <th><font size="14"><b>MAKMAL FORENSIK PDRM<br></b></font></th>
                    </tr>
                </table>
                <table border="0" cellpadding="4">
                    <tr>
                        <th width="10%"></th>
                        <th border="3" width="80%">
                            <font size="20"><b><u>BORANG PEMERIKSAAN KENDERAAN<br></u></b></font>
                            <h1 align="left">
                                <font size="20">NO RPT : ' . $_POST["mrk2_etch_k_no_rpt"] . ' <br>&nbsp; MFSPKDK : ' . $_POST["mrk2_inspection_k_msfspdk"] . '<br>
                                </font>
                            </h1>
                        </th>
                        <th width="10%"></th>
                    </tr>
                </table><br><br><br>
                <table border="0" cellpadding="0">
                    <tr>
                        <th width="10%"></th>
                        <th width="30%" align="left"><font size="11">DISEDIAKAN OLEH</font> </th>
                        <th width="50%" align="left"><font size="11"> : ' . $_POST["mrk2_Nama_Analisis"] . '<br></font></th>
                    </tr>
                    <tr>
                        <th width="10%"></th>
                        <th width="30%" align="left"><font size="11">TARIKH DOKUMEN DISIAPKAN</font></th>
                        <th width="50%" align="left"><font size="11"> : </font></th>
                    </tr>
                </table><br><br><br>
                <table border="0" cellpadding="2">
                    <tr>
                        <th width="10%"></th>
                        <th border="3" width="80%">
                            <font size="10"><b><u><br>BERSANGKUT/BERSABIT REPOT</u></b></font><br>
                            <h4 align="left"><font size="10"> NO Asal : ' . $_POST["mrk2_etch_k_noAsal"] . '</font></h4>
                            <h4 align="left"><font size="10"> No Report : ' . $_POST["mrk2_etch_k_noReport_asal"] . '</font></h4>
                            <h4 align="left"><font size="10"> Tarikh Hilang : ' . $_POST["mrk2_etch_k_date_kejadian"] . '<br></font></h4>
                        </th>
                        <th width="10%"></th>
                    </tr>
                </table><br>
            </p>
            <br/>
            ';
    $pdf->writeHTML($content, true, false, true, false, '');

    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 11);

    $content = '
    <style>
    div.a {
        text-transform: uppercase;
    }

    div.b {
        text-transform: lowercase;
    }

    div.c {
        text-transform: capitalize;
    }
    </style>
            <table border="0.5" cellpadding="4">
                <tr>
                    <th width="20%" rowspan="3"><img src="../img/forensik/forensik_logo.PNG" alt="FORENSIK" width="80"></th>
                    <th width="50%" rowspan="3">Tajuk :<br><font color="blue" size="12">BORANG PEMERIKSAAN BARANG KES</font></th>
                    <th width="30%"><font size="10">Kes No : <b>' . $_POST["mrk2_etch_k_no_makmal"] . '</b></font></th>
                </tr>
                <tr>
                    <th width="30%"><font size="10"> Mukasurat 2 daripada 5</font></th>
                </tr>
                <tr>
                    <th width="30%"><font size="10">Tarikh Terima : <b>' . $_POST["mrk2_inspection_k_date_start"] . '</b></font></th>
                </tr>
                <tr>
                    <th width="70%" rowspan="2"><font color="blue" size="12">UNIT SIASATAN / ANALISIS KENDERAAN</font></th>
                    <th width="30%"><font size="10">Tarikh Selesai : <b>' . $_POST["mrk2_inspection_k_date_end"] . '</b></font></th>
                </tr>
                <tr>
                    <th width="30%"><font size="10"><div class="a"><b>MFSPKDK</b> : ' . $_POST["mrk2_inspection_k_msfspdk"] . '</div></font></th>
                </tr>
            </table>
            <p border="0.5" align="1">
                <table border="0" cellpadding="4">
                    <tr>
                        <th width="100%" colspan="2"><font size="11" align="center"><b><u>PEN/PEGAWAI PENYIASAT</u></b></font></th>
                    </tr>
                </table>
                <table border="0" cellpadding="4">
                    <tr>
                        <th width="25%" colspan="2">PANGKAT/NO/NAMA </th>
                        <th width="75%" colspan="2">:<b> ' . $_POST["mrk2_nama_penyiasat"] . '</b></th>
                    </tr>
                    <tr>
                        <th width="25%" colspan="2"><div class="a">TEMPAT TUGAS</div></th>
                        <th width="75%" colspan="2"><div class="a">: <b>' . $_POST["mrk2_penyiasat_tempat_tugas"] . '</b></div></th>
                    </tr>
                    <tr>
                        <th width="25%">TEL (HP)</th>
                        <th width="25%">: <b>' . $_POST["mrk2_penyiasat_no"] . '</b></th>
                        <th width="15%">TEL (PEJ)</th>
                        <th width="25%">: <b>' . $_POST["mrk2_penyiasat_no_pej"] . '</b></th>
                    </tr>
                </table>
                <table border="0" cellpadding="4">
                    <tr>
                        <th width="100%" colspan="2"><h4 align="center"><u>JURUGAMBAR</u></h4></th>
                    </tr>
                </table>
                <table border="0" cellpadding="4">
                    <tr>
                        <th width="25%" colspan="2">PANGKAT/NO/NAMA</th>
                        <th width="75%" colspan="2">:<b>' . $_POST["mrk2_nama_gambar"] . '</b></th>
                    </tr>
                    <tr>
                        <th width="25%">TEL (HP) :</th>
                        <th width="25%">:</th>
                        <th width="15%">TEL (PEJ)</th>
                        <th width="35%">:<b>' . $_POST["mrk2_gambar_no_pej"] . '</b><br></th>
                    </tr>
                </table>
                <hr>
                <table border="0" cellpadding="4">
                    <tr><br>
                        <th width="25%" colspan="2">TEMPAT PEMERIKSAAN </th>
                        <th width="75%" colspan="2"><div class="a">: <b>' . $_POST["mrk2_inspection_k_location"] . '</b></div></th>
                    </tr>
                    <tr>
                        <th width="25%" colspan="2">TARIKH PEMERIKSAAN :</th>
                        <th width="75%" colspan="2">: <b>' . $_POST["mrk2_inspection_k_date_start"] . '</b></th>
                    </tr>
                    <tr>
                        <th width="25%">MASA MULA</th>
                        <th width="25%">: <b>' . $_POST["mrk2_inspection_k_time_start"] . '</b></th>
                        <th width="20%">MASA TAMAT</th>
                        <th width="30%">: <b>' . $_POST["mrk2_inspection_k_time_end"] . '</b><br></th>
                    </tr>
                </table>
                <hr>
                <table border="0" cellpadding="1">
                    <thead>
                        <tr>
                            <th width="100%" colspan="2"><br><h4 align="center"><u>JURUANALISIS</u></h4></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th width="30%" rowspan ="10"> &nbsp;&nbsp;<br>PANGKAT/NO/NAMA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</th>
                        <th width="70%"></th>
                    </tr>
                        ';
                            $sql = "SELECT 
                        CONCAT(p_pangkat.pangkat_desc,' ',analisis_no,' ',analisis_name) AS Nama_Team
                        FROM t_etch_inspection_k_analisis
                        LEFT JOIN p_pangkat ON p_pangkat.pangkat_id = t_etch_inspection_k_analisis.pangkat_id
                        where inspection_k_id = '". $_POST["mrk2_inspection_k_id"]."';";
                            $result = mysqli_query(mysqli_connect('localhost', 'root', '', 'forensik'), $sql); 
                            $bil = 1;
                            while($row = mysqli_fetch_assoc($result))  
                            {   
                                $content .= '
                                        <tr>
                                            
                                            <th width="70%">  <b>'.$row["Nama_Team"].'</b></th> 
                                        </tr>
                                        ';
                            }
                                $content.= '        
                    </tbody>
                </table>
                <table border="0" cellpadding="1">
                    <thead>
                        <tr>
                            <th width="100%" colspan="2"><br><h4 align="center"><u>PEMBANTU JURUANALISIS</u></h4></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th width="30%" rowspan ="10"> &nbsp;&nbsp;<br>PANGKAT/NO/NAMA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</th>
                        <th width="70%"></th>
                    </tr>
                        ';
                            $sql = "SELECT 
                            CONCAT(p_pangkat.pangkat_desc,' ',pen_analisis_no,' ',pen_analisis_name) AS Nama_Team
                            FROM t_etch_inspection_k_pen_analisis
                            LEFT JOIN p_pangkat ON p_pangkat.pangkat_id = t_etch_inspection_k_pen_analisis.pangkat_id
                            where inspection_k_id = '". $_POST["mrk2_inspection_k_id"]."';";
                            $result = mysqli_query(mysqli_connect('localhost', 'root', '', 'forensik'), $sql); 
                            $bil = 1;
                            while($row = mysqli_fetch_assoc($result))  
                            {   
                                $content .= '
                                        <tr>
                                            
                                            <th width="70%">  <b>'.$row["Nama_Team"].'</b></th> 
                                        </tr>
                                        ';
                            }
                                $content.= '        
                    </tbody>
                </table>
            </p>
            ';
    $pdf->writeHTML($content, true, false, true, false, '');
    
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 11);

    $content = ' 
            <style>
            div.a {
                text-transform: uppercase;
            }

            div.b {
                text-transform: lowercase;
            }

            div.c {
                text-transform: capitalize;
            }
            </style>
            <table border="0.5" cellpadding="4">
                <tr>
                    <th width="20%" rowspan="3"><img src="../img/forensik/forensik_logo.PNG" alt="FORENSIK" width="80"></th>
                    <th width="50%" rowspan="3">Tajuk :<br><font color="blue" size="12">BORANG PEMERIKSAAN BARANG KES</font></th>
                    <th width="30%"><font size="10">Kes No : <b>' . $_POST["mrk2_etch_k_no_makmal"] . '</b></font></th>
                </tr>
                <tr>
                    <th width="30%"><font size="10"> Mukasurat 3 daripada 5</font></th>
                </tr>
                <tr>
                    <th width="30%"><font size="10">Tarikh Terima : <b>' . $_POST["mrk2_inspection_k_date_start"] . '</b></font></th>
                </tr>
                <tr>
                    <th width="70%" rowspan="2"><font color="blue" size="12">UNIT SIASATAN / ANALISIS KENDERAAN</font></th>
                    <th width="30%"><font size="10">Tarikh Selesai : <b>' . $_POST["mrk2_inspection_k_date_end"] . '</b></font></th>
                </tr>
                <tr>
                    <th width="30%"><font size="10"><div class="a"><b>MFSPKDK</b> : ' . $_POST["mrk2_inspection_k_msfspdk"] . '</div></font></th>
                </tr>
            </table>
            <p border="0.5" align="1">
                <table border="0" cellpadding="4">
                    <tr>
                        <th width="100%" colspan="2"><h4 align="center"><u>MAKLUMAT KENDERAAN</u></h4><br></th>
                    </tr>
                    <tr>
                        <th width="30%">NO PENDAFTARAN</th>
                        <th width="70%"><div class="a">: <b>' . $_POST["mrk2_inspection_k_pendaftaran"] . '</b></div></th>
                    </tr>
                    <tr>
                        <th width="30%">JENIS</th>
                        <th width="70%">: <b>' . $_POST["mrk2_jenis_desc"] . '</b></th>
                    </tr>
                    <tr>
                        <th width="30%">BUATAN</th>
                        <th width="70%"><div class="a">: <b>' . $_POST["mrk2_inspection_k_buatan"] . '</b></div> </th>
                    </tr>
                    <tr>
                        <th width="30%">PENGELUAR</th>
                        <th width="70%">: <b>' . $_POST["mrk2_pengeluar_desc"] . '</b></th>
                    </tr>
                    <tr>
                        <th width="30%">MODEL</th>
                        <th width="70%">: <b>' . $_POST["mrk2_model_desc"] . '</b></th>
                    </tr>
                    <tr>
                        <th width="30%">WARNA</th>
                        <th width="70%"><div class="a">: <b>' . $_POST["mrk2_inspection_k_warna"] . '</b></div></th>
                    </tr>
                    <tr>
                        <th width="30%">NO CUKAI JALAN</th>
                        <th width="70%"><div class="a">: <b>' . $_POST["mrk2_inspection_k_cukai"] . '</b></div></th>
                    </tr>
                    <tr>
                        <th width="30%">ODOMETER</th>
                        <th width="70%"><div class="a">: <b>' . $_POST["mrk2_inspection_k_meter"] . '</b></div></th>
                    </tr>
                    <tr>
                        <th width="30%">SYSTEM GEAR</th>
                        <th width="70%"><div class="a">: <b>' . $_POST["mrk2_inspection_k_gear"] . '</b></div></th>
                    </tr>
                    <tr>
                        <th width="30%">SYSTEM AUDIO</th>
                        <th width="70%"><div class="a">: <b>' . $_POST["mrk2_inspection_k_audio"] . '</b></div></th>
                    </tr>
                    <tr>
                        <th width="30%">SYSTEM PENGGERA</th>
                        <th width="70%"><div class="a">: <b>' . $_POST["mrk2_inspection_k_pengera"] . '</b></div></th>
                    </tr>
                    <tr>
                        <th width="30%">SYSTEM BLASTING</th>
                        <th width="70%"><div class="a">: <b>' . $_POST["mrk2_inspection_k_blasting"] . '</b></div></th>
                    </tr>
                </table>
                <hr>
                <table border="0" cellpadding="4">
                    <tr><br>
                        <th width="50%" align="center"><h4>CONTOH CAT PADA BADAN</h4></th>
                        <th width="50%" align="center"><h4>CONTOH CAT PADA CHASIS</h4></th>
                    </tr>
                    <tr>
                        <th><p border="1" width="30%" align="center"><br><br><br><br><br><br><br><br></p></th>
                        <th><p border="1" width="30%" align="center"><br><br><br><br><br><br><br><br></p></th>
                    </tr>
                </table>
            </p>
            ';
    $pdf->writeHTML($content, true, false, true, false, '');
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 11);

    $content = '<style>
    div.a {
        text-transform: uppercase;
    }

    div.b {
        text-transform: lowercase;
    }

    div.c {
        text-transform: capitalize;
    }
    </style>
            <table border="0.5" cellpadding="4">
                <tr>
                    <th width="20%" rowspan="3"><img src="../img/forensik/forensik_logo.PNG" alt="FORENSIK" width="80"></th>
                    <th width="50%" rowspan="3">Tajuk :<br><font color="blue" size="12">BORANG PEMERIKSAAN BARANG KES</font></th>
                    <th width="30%"><font size="10">Kes No : <b>' . $_POST["mrk2_etch_k_no_makmal"] . '</b></font></th>
                </tr>
                <tr>
                    <th width="30%"><font size="10"> Mukasurat 4 daripada 5</font></th>
                </tr>
                <tr>
                    <th width="30%"><font size="10">Tarikh Terima : <b>' . $_POST["mrk2_inspection_k_date_start"] . '</b></font></th>
                </tr>
                <tr>
                    <th width="70%" rowspan="2"><font color="blue" size="12">UNIT SIASATAN / ANALISIS KENDERAAN</font></th>
                    <th width="30%"><font size="10">Tarikh Selesai : <b>' . $_POST["mrk2_inspection_k_date_end"] . '</b></font></th>
                </tr>
                <tr>
                    <th width="30%"><font size="10"><div class="a"><b>MFSPKDK</b> : ' . $_POST["mrk2_inspection_k_msfspdk"] . '</div></font></th>
                </tr>
            </table>
            <p border="0.5" align="center">
                <table border="0" cellpadding="4">
                    <tr>
                        <th width="100%"><h4 align="center"><br><br><u>PEMERIKSAAN NOMBOR CHASIS YANG DI LIHAT</u></h4><br></th>
                    </tr>
                </table>
                <table border="0" cellpadding="4">
                    <tr>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="4%" border="0.5"></th><br>
                    </tr>
                </table>
                <table border="0" cellpadding="4">
                    <tr>
                        <th></th>
                    </tr>
                    <tr>
                        <th width="98%" border="0.5"><h5 align="center"><br><br><br>TAMPALAN ‘TRACING / LIFTING’<br><br><br></h5></th>
                    </tr>
                    <tr>
                        <th align="center"><br><br>BUKTI UBAHSUAI / LAKARAN NOMBOR SEKITARNYA :</th>
                    </tr>
                    <tr>
                        <th align="center">.....................................................................................................................................................</th>
                    </tr>
                    <tr>
                        <th align="center"></th>
                    </tr>
                    <tr>
                        <th align="center"><b><u>KEPUTUSAN PEMERIKSAAN :<br><br><br><br><br><br><br><br><br><br><br></u></b></th>
                    </tr>
                    <tr>
                        <th align="center">.....................................................................................................................................................</th>
                    </tr>
                    <tr>
                        <th align="left" width="49%"><b>TEMPERED/UNTEMPERED</b></th>
                        <th align="right" width="49%"><b>CONCLUSIVE/INCONCLUSIVE</b><br></th>
                    </tr>
                </table>
            </p>
            
            ';
    $pdf->writeHTML($content, true, false, true, false, '');

    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 11);

    $content = '<style>
    div.a {
        text-transform: uppercase;
    }

    div.b {
        text-transform: lowercase;
    }

    div.c {
        text-transform: capitalize;
    }
    </style>
            <table border="0.5" cellpadding="4">
                <tr>
                    <th width="20%" rowspan="3"><img src="../img/forensik/forensik_logo.PNG" alt="FORENSIK" width="80"></th>
                    <th width="50%" rowspan="3">Tajuk :<br><font color="blue" size="12">BORANG PEMERIKSAAN BARANG KES</font></th>
                    <th width="30%"><font size="10">Kes No : <b>' . $_POST["mrk2_etch_k_no_makmal"] . '</b></font></th>
                </tr>
                <tr>
                    <th width="30%"><font size="10"> Mukasurat 5 daripada 5</font></th>
                </tr>
                <tr>
                    <th width="30%"><font size="10">Tarikh Terima : <b>' . $_POST["mrk2_inspection_k_date_start"] . '</b></font></th>
                </tr>
                <tr>
                    <th width="70%" rowspan="2"><font color="blue" size="12">UNIT SIASATAN / ANALISIS KENDERAAN</font></th>
                    <th width="30%"><font size="10">Tarikh Selesai : <b>' . $_POST["mrk2_inspection_k_date_end"] . '</b></font></th>
                </tr>
                <tr>
                    <th width="30%"><font size="10"><div class="a"><b>MFSPKDK</b> : ' . $_POST["mrk2_inspection_k_msfspdk"] . '</div></font></th>
                </tr>
            </table>
            <p border="0.5" align="center">
                <table border="0" cellpadding="4">
                    <tr>
                        <th width="100%"><h4 align="center"><br><br><u>PEMERIKSAAN NOMBOR ENJIN YANG DI LIHAT</u></h4><br></th>
                    </tr>
                </table>
                <table border="0" cellpadding="4">
                    <tr>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="4%" border="0.5"></th><br>
                    </tr>
                    <tr>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="5%" border="0.5"></th>
                        <th width="4%" border="0.5"></th><br>
                    </tr>
                </table>
                <table border="0" cellpadding="4">
                    <tr>
                        <th></th>
                    </tr>
                    <tr>
                        <th width="98%" border="0.5"><h5 align="center"><br><br><br>TAMPALAN ‘TRACING / LIFTING’<br><br><br></h5></th>
                    </tr>
                    <tr>
                        <th align="center"><br><br>BUKTI UBAHSUAI / LAKARAN NOMBOR SEKITARNYA :</th>
                    </tr>
                    <tr>
                        <th align="center">.....................................................................................................................................................</th>
                    </tr>
                    <tr>
                        <th align="center"></th>
                    </tr>
                    <tr>
                        <th align="center"><b><u>KEPUTUSAN PEMERIKSAAN :<br><br><br><br><br><br><br><br><br></u></b></th>
                    </tr>
                    <tr>
                        <th align="center">.....................................................................................................................................................</th>
                    </tr>
                    <tr>
                        <th align="left" width="49%"><b>TEMPERED/UNTEMPERED</b></th>
                        <th align="right" width="49%"><b>CONCLUSIVE/INCONCLUSIVE</b><br></th>
                    </tr>
                </table>
            </p>
            
            ';
    $pdf->writeHTML($content, true, false, true, false, '');
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 10);

    $content = '
            <p border="2" align="1">
                <table border="0" cellpadding="4">
                <br/>
                    <tr>
                        <th width="100%" class"text-center"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LAMPIRAN</b></th>
                    </tr>
                </table>
                <br><br>
                <table border="0" cellpadding="4">
                    <thead>
                        <tr>
                            <th width="3%"></th>
                            <th width="10%" border="0.5">Bil</th>
                            <th width="44%" border="0.5">PENERANGAN</th>
                            <th width="40%" border="0.5">GAMBAR</th>
                            <th width="3%"></th>
                        </tr>
                    </thead>
                    <tbody>';
                    $sql = "SELECT  t_etch_inspection_k_lampiran.*, document.document_uplname , document.document_filename
                    FROM t_etch_inspection_k_lampiran
                    LEFT JOIN document ON document.document_id = t_etch_inspection_k_lampiran.document_id
                    LEFT JOIN t_etch_inspection_k ON t_etch_inspection_k.inspection_k_id = t_etch_inspection_k_lampiran.inspection_k_id
                    WHERE t_etch_inspection_k_lampiran.inspection_k_id = '". $_POST["mrk2_inspection_k_id"]."';";
                    $result = mysqli_query(mysqli_connect('localhost', 'root', '', 'forensik'), $sql); 
                    $bil = 1;
                    while($row = mysqli_fetch_assoc($result))  
                    { 
                        $content .= '
                            <tr>
                                <td width="3%" align="center"></td>
                                <td width="10%" align="center" border="0.5"><b>'.$bil++.'</b></td>
                                <td width="44%" align="left" border="0.5"><b>'.$row["lampiran_k_tajuk"].'</b></td>
                                <td width="40%" align="center" border="0.5"><b><img src="../upload/logs/0/'.$row["document_filename"].'.jpg" style="width:200px;height:100px;"></b></td>
                                <td width="3%" align="center"></td>
                            </tr> ';
                    }
                        $content.= '                
                    </tbody>
                </table>
                <br/><br/><span align="right"> MFSPKDK :' . $_POST["mrk2_inspection_k_msfspdk"] . '</span><br/>
            </p>
            ';
    $pdf->writeHTML($content, true, false, true, false, '');
    
    $pdf->Output('borang_pemeriksaan_kenderaan.pdf', 'I');
} 

else if (isset($_POST["report_pemeriksaan_kenderaan"])) {

    class MYPDF extends TCPDF {

        public function Header() {
            $this->SetFont('helvetica', '', 11);
            $html = '
            <table border="0" cellpadding="4">
                <tr>
                    <th width="20%"><img src="../img/forensik/forensik_logo.PNG" alt="FORENSIK" width="150"></th>
                    <th width="50%"><b>MAKMAL FORENSIK <br>POLIS DIRAJA MALAYSIA <br>BT. 8 ½, JALAN CHERAS <br>43200 CHERAS <br>SELANGOR</b></th>
                    <th width="30%"><br><br><br><br><b>TEL : 03-91065730 <br>FAX : 03-91065757</b></th>
                </tr>
            </table>
            <hr>';
            $this->writeHTML($html);
            $img_file = '../img/logo-pdrm/logo_polis_forensics_watermark_bw3.png';
            $this->Image($img_file, 0, 70, 0, 160, '', '', '', false, 300, 'C', false, false, 0);
        }

        public function Footer() {
            $this->SetY(-28);
            $this->SetFont('times', '', 9);
            //$html = 'PAGE '.$this->getAliasNumPage().' OF '.$this->getAliasNbPages().'<hr><br/><br/>';
            if ($_POST["mrk2_laporan_standards"] == 1) {
                $logo = '<img src="../img/forensik/logo_standards.png" alt="FORENSIK" width="70">';
            }else{
                $logo = '';
            }
            $html = '
             <span align="right">Page 1 of 1</span><br>
            <table border="0" cellpadding="0">
                <tr>
                    <th align="center">'.$logo.'</th>
                </tr>
            </table>';
            $this->writeHTML($html, true, 0, true, 0);
        }

    }

    // create new PDF document
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Report Kenderaan');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 009', PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
     $pdf->SetAutoPageBreak(false,0);

    $pdf->AddPage();

    $pdf->SetFont('helvetica', '', 10);

    $content = '
            <style>
            div.a {
                text-transform: uppercase;
            }

            div.b {
                text-transform: lowercase;
            }

            div.c {
                text-transform: capitalize;
            }
            </style>
            <table border="0" cellpadding="4">
                <tr>
                <br><br><br>
                    <th width="40%"></th>
                    <th width="20%"><font color="red" size="12"><b> SULIT</b></font></th>
                    <th width="40%" align="right"><font size="9">
                        Ruj:   <b>MFSPKDK ' . $_POST["mrk2_inspection_k_msfspdk"] . '</b>
                        <br>
                        Tarikh:    <b>' . $_POST["mrk2_inspection_k_date_end"] . '</b></font>
                    </th>
                </tr>
            </table>
            <table border="0" cellpadding="4">
                <tr>
                    <th width="100%" align ="center"> <u><b>LAPORAN PEMERIKSAAN ‘ETCHING’</b></u> </th>
                </tr>
                <tr>
                    <th width="100%"> &nbsp;&nbsp;&nbsp; Saya <b>' . $_POST["mrk2_Nama_Analisis"] . '</b> sebagai <b>Juruanalisa Unit Siasatan Kenderaan, Makmal Forensik, PDRM</b> bersama-sama <b>Juru gambar (D6c) Bukit Aman, ' . $_POST["mrk2_nama_gambar"] . ' </b> telah menjalankan pemeriksaan <b>`ETCHING’</b> pada tarikh <b>' . $_POST["mrk2_inspection_k_date_start"] . ' </b> bertempat di <b>' . $_POST["mrk2_inspection_k_location"] . '.</b> Hasil pemeriksaan adalah seperti berikut: </th>
                </tr>
            </table>
            <p border ="1">
                <span align ="center"> <br><b>Butiran/ Maklumat Kenderaan Sebelum Analisa</b><br></span>
                <hr border ="1"> 
                <table border="0" cellpadding="1">  
                    <tr>
                    <br>
                        <th width="20%"> <b>No.Makmal</b> </th>
                        <th width="60%"><div class="a"><b>: MFSPKDK ' . $_POST["mrk2_inspection_k_msfspdk"] . '</b></div></th>
                    </tr>
                    <tr>
                        <th width="20%"> <b>No.Repot</b> </th>
                        <th width="60%"><div class="a"><b>: ' . $_POST["mrk2_etch_k_no_rpt"] . '</b></div></th>
                    </tr>
                    <tr>
                        <th width="20%"></th>
                    </tr>
                    <tr>
                        <th width="20%"> <b>Jenis</b></th>
                        <th width="30%"><div class="a"><b>: ' . $_POST["mrk2_inspection_k_jenis_desc"] . '</b></div></th>
                        <th width="30%"> <b>Model</b></th>
                        <th width="20%"><div class="a"><b>: ' . $_POST["mrk2_model_desc"] . '</b></div></th>
                    </tr>
                    <tr>
                        <th width="20%"> <b>Warna</b></th>
                        <th width="30%"><div class="a"><b>: ' . $_POST["mrk2_inspection_k_warna"] . '</b></div></th>
                        <th width="30%"> <b>No. Pendaftaran</b></th>
                        <th width="20%"><div class="a"><b>: ' . $_POST["mrk2_inspection_k_pendaftaran"] . '</b></div></th>
                    </tr>
                    <tr>
                        <th width="20%"> <b>No. Casis</b></th>
                        <th width="30%"> <b>: </b></th>
                        <th width="30%"> <b>No. Enjin</b></th>
                        <th width="20%"> <b>: </b><br></th>

                    </tr>
                </table>
                <hr border ="1">
                <span align ="center"> <br><b>Hasil Analisa kaedah ‘Electro-chemical Treatment’ </b><br></span>
                <hr border ="1">
                <table border="0" cellpadding="1">
                    <tr>
                        <th>' . $_POST["mrk2_inspection_k_huraian"] . '</th>
                    </tr>
                </table>
            </p>
            <table border="0" cellpadding="1">
                <tr>
                <br>
                    <th>Laporan disediakan oleh: </th>
                </tr>
                <tr>   
                    <th><br><br><br><br>...........................................................</th>
                </tr>
                <tr>   
                    <th><b>' . $_POST["mrk2_Nama_Analisis"] . '</b></th>
                </tr>
                <tr>   
                    <th>Juruanalisa  Unit Siasatan Kenderaan</th>
                </tr>
                <tr>   
                    <th>Makmal Forensik PDRM </th>
                </tr>
                <tr>   
                    <th>Bukit Aman</th>
                </tr>
            </table>
            ';
    $pdf->writeHTML($content, true, false, true, false, '');

    $pdf->Output('report_pemeriksaan_kenderaan.pdf', 'I');
} 