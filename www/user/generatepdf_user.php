<?php 
require_once("../config.php");
//
$tz = date_default_timezone_get();
$custdate = date("F j, Y",strtotime($tz));

require('../fpdf184/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();

// code for print Heading of tables
$pdf->SetFont('Arial','B',12);	

$pdf->Image('../img/Vaccitrack_logo_3A.png',96,280,15);

$pdf->Write(5,'Activity Logs Report                                                                                                   '.$custdate,'C');
$pdf->Ln();
$pdf->Ln();

$width_cell=array(46,98,46);
$pdf->SetFillColor(193,229,252); // Background color of header 
// Header starts /// 
$pdf->Cell($width_cell[0],10,'Username',1,0,'C',true); // First header column 
$pdf->Cell($width_cell[1],10,'Activity',1,0,'C',true); // Second header column
$pdf->Cell($width_cell[2],10,'Date',1,0,'C',true); // Third header column 

//code for print data
$sql = "SELECT username, activity, date from  activity_log ";
$query = $pdo -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{

foreach($results as $row) {
	$counter = 1;
	$pdf->SetFont('Arial','',10);
	$pdf->Ln();
	foreach($row as $column){
		if($counter == 2){
            $pdf->Cell(98,11,$column,1,0,'C');
        }else{
            $pdf->Cell(46,11,$column,1,0,'C');
        }
        ++$counter;
    }
		
} }
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Write(5,'                                                                                                                                               ________________________','C');
$pdf->Ln();
$pdf->Write(5,'                                                                                                                                                            <staff position>','C');
$pdf->Ln();
$pdf->Output();
?>