<?php

include('source/php/config.php');

$OrdreID = $_GET['id'];
$Ressnr = $_GET['ressnr'];

// HENTER ODRE-DATA
$Get = mysql_query("SELECT `date`, `session_key` FROM `ordre` WHERE `id` = '$OrdreID' LIMIT 1") or die (msg_MYSQLerror(256144141));
$Get = mysql_fetch_array($Get);
$OrdreDATO = Date_Print($Get['date']);
$SessionKey = $Get['session_key'];


// HENTER ODRE-LISTE
$result = mysql_query("
SELECT OD.`produkt_id`, OD.`antall`, PK.`tittel`, PK.`pris`
FROM `ordre_data` OD
LEFT JOIN `produkter` PK ON PK.`id` = OD.`produkt_id`
WHERE OD.`ordre_id` = '$OrdreID'
") or die (msg_MYSQLerror(44236584894));

$table_row = NULL;
$OrdreSum = 0;
while($row = mysql_fetch_array($result)) {
	$table_row .= '
	<tr>
		<td>' .$row['produkt_id']. '</td>
		<td>' .$row['tittel']. '</td>
		<td>' .NumSplitter($row['pris']). ' kr</td>
		<td>' .$row['antall']. '</td>
	</tr>
	';
	$OrdreSum += $row['pris']*$row['antall'];
} 
$OrdreSum = NumSplitter($OrdreSum);

require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		// Logo
		$image_file = 'source/image/logo.jpg';
		$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 15);
		// Title
		$this->Cell(0, 15, '  VEST-AGDER FYLKESKOMMUNE', 0, false, 'L', 0, '0', 0, false, '', 'M');
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, '
		VAF BRUKERSTØTTE
		E-post: brukerstotte@vaf.no
		Tlf: (+47) 38 07 46 62
', 0, false, 'C', 0, '', 0, false, 'T', 'M');

		$this->Cell(0, 120, '
		Åpent fra 08:00-15:45 på hverdager. 
		Lørdag, søndag og helligdager stengt. 
		Sommeråpent fra kl 08:00—15:00
', 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tor Christian Hansen');
$pdf->SetTitle('BESTILLINGSLISTE FOR IT-UTSTYR');
$pdf->SetSubject('BESTILLINGSLISTE FOR IT-UTSTYR');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// add a page
$pdf->AddPage();

// set font
$pdf->SetFont('helvetica', '', 12);

$dft = <<<EOD
<br /><br />

EOD;

$pdf->writeHTML($dft, true, false, false, false, '');



// set font
$pdf->SetFont('helvetica', 'B', 12);

$pdf->Write($h=0, 'BESTILLIGSLISTE FOR IT-UTSTYR', $link='', $fill=0, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
$pdf->writeHTML('<br />', true, false, false, false, '');
// set font

$pdf->SetFont('helvetica', '', 12);




$pdf->Write($h=0, 'Ordrenummer: ' .$OrdreID, $link='', $fill=0, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
$pdf->Write($h=0, 'Dato: ' .$OrdreDATO, $link='', $fill=0, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
$pdf->Write($h=0, 'Ressursnummer: ' .$Ressnr, $link='', $fill=0, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
//$pdf->writeHTML('<div style="border-bottom: 1px solid #000;"></div>', true, false, false, false, '');
//----

// write RAW 2D Barcode
$pdf->SetXY(125, 37);
// define barcode style
$style = array(
	'position' => '',
	'align' => 'C',
	'stretch' => false,
	'fitwidth' => true,
	'cellfitalign' => '',
	'border' => false,
	'hpadding' => 'auto',
	'vpadding' => 'auto',
	'fgcolor' => array(0,0,0),
	'bgcolor' => false, //array(255,255,255),
	'text' => false,
	'font' => 'helvetica',
	'fontsize' => 8,
	'stretchtext' => 4
);

$pdf->write1DBarcode($SessionKey, 'C39', '', '', '', 20, 0.4, $style, 'N');

// set font
$pdf->SetFont('helvetica', '', 12);


$tbl = '
<br /><br />
<table border="0" cellpadding="2" cellspacing="0" align="left">
<tr style="font-weight: bold;">
	<td>ProduktID:</td>
	<td>Produkttittel:</td>
	<td>Beløp:</td>
	<td>Antall:</td>
</tr>
' .$table_row. '
<tr>
	 <td></td>
</tr>
<tr>
	 <td align="right" style="border-bottom: 1px dashed #000; border-top: 1px dashed #000;" colspan="4">Sum total: ' .$OrdreSum. ' kr</td>
</tr>
</table>
<br />
';

$pdf->writeHTML($tbl, true, false, false, false, '');

// PRINT VARIOUS 1D BARCODES

/*$Signatur = '
<br /><br /><br />
<div align="center">
	<div style="border-top: 1px solid #000; ">Signatur</div>
</div>
';
*/
$pdf->writeHTMLCell(120, '', '', '', '', 0, 0, 0, true, 'J', true);
$pdf->writeHTMLCell(60, '', '', '', $Signatur, 0, 1, 0, true, 'J', true);

$test = '
<div style="border-bottom: 1px solid #000;"></div><br /><br />
<table border="0" cellpadding="2" cellspacing="0" align="left">
<tr>
	<td>
		<strong>VAF BRUKERSTØTTE</strong><br />
		E-post: brukerstotte@vaf.no<br />
		Tlf: (+47) 38 07 46 62 <br />
	</td>
	<td>
		Åpent fra 08:00-15:45 på hverdager. <br />
		Lørdag, søndag og helligdager stengt. <br />
		Sommeråpent fra kl 08:00—15:00
	</td>
</tr>
';
$pdf->writeHTML($test, true, false, false, false, '');
//Close and output PDF document
$pdf->Output('VAF_IT_' .$OrdreID. '.pdf', 'I');

header('Content-disposition: attachment; filename=VAF_IT_ord_' .$OrdreID. '.pdf');
header('Content-type: application/pdf');

//============================================================+
// END OF FILE                                                
//============================================================+

