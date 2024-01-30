<?php
 $pdf = pdf_new();
 pdf_open_file($pdf, "kuitti.pdf");
 pdf_begin_page($pdf, 595, 842);
 $arial = pdf_findfont($pdf, "Arial", "host", 1); pdf_setfont($pdf, $arial, 10);
 pdf_show_xy($pdf, $_REQUEST['cartContent'] , 50, 750);
 pdf_end_page($pdf);
 pdf_close($pdf);
 $pdf = new FPDF();
 
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World!');
$pdf->Output();
?>
