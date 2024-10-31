<?php
class Pdf extends FPDF{
    function __construct() {
        include_once APPPATH . '/third_party/fpdf/fpdf.php';
    }

    function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
        
        // Your custom content at the bottom
        $this->SetY(-10);
        $this->Cell(0, 10, 'Your Custom Content', 0, 0, 'C');
    }
}
?>