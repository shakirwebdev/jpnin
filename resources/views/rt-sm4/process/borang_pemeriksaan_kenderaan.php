<?php

require_once('../tcpdf/tcpdf.php');

function test() {
    $output = 'test';
    return $output;
}

if (isset($_POST["borang_pemeriksaan_kenderaan"])) {

    class MYPDF extends TCPDF {

        



        
        

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
                                
                            </h1>
                        </th>
                        <th width="10%"></th>
                    </tr>
                </table><br><br><br>
                <table border="0" cellpadding="0">
                    <tr>
                        <th width="10%"></th>
                        <th width="30%" align="left"><font size="11">DISEDIAKAN OLEH</font> </th>
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
                </tr>
                
                
            </table>
            
            ';
    $pdf->writeHTML($content, true, false, true, false, '');
    
    
    
    $pdf->Output('borang_pemeriksaan_kenderaan.pdf', 'I');
} 

