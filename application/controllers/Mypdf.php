<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';


class Mypdf extends TCPDF {
   //Page header
   public function Header() {
    // Add logo image to PDF header
    $imageUrl = 'https://portal.podomorouniversity.ac.id/assets/icon/logo_pu.png';
    $this->Image($imageUrl, 235, 10, 50, 0, '', '', '', false, 300, '', false, false, 0, false, false, false);
    
    // Add user details with HTML
    $this->SetFont('helvetica', '', 12);
    $html = '<b>Name:</b> ' . $GLOBALS['name']  . '<br>';
    $html .= '<b>Department:</b> ' . $GLOBALS['department'] . '<br>';
    $html .= '<b>Date:</b> ' . ($GLOBALS['start_date'] != "" || $GLOBALS['start_date'] != null && $GLOBALS['end_date'] != "" || $GLOBALS['end_date'] != null ? $GLOBALS['start_date'] . ' - ' . $GLOBALS['end_date'] : 'All') . '<br>';
    $this->writeHTML($html, true, false, true, false, '');
    
    // Add header for transaction list with HTML
    $this->SetFont('helvetica', 'B', 16);
    $this->Cell(0, 10, 'Transaction List', 0, 1, 'C');
    $this->SetFont('helvetica', '', 7);
    
    // Table headers with HTML
    $html = '<table border="1" cellpadding="4">
                <tr>
                    <th style="width:100px;">Item Name</th>
                    <th style="width:50px;">Warehouse</th>
                    <th style="width:50px;">In</th>
                    <th style="width:50px;">Out</th>
                    <th style="width:50px;">Balance</th>
                    <th>Desc</th>
                    <th style="width:100px;">User</th>
                    <th style="width:100px;">Transaction Date</th>
                    <th style="width:175px;">Reason</th>
                </tr>';
    $this->writeHTML($html, true, false, true, false, '');
}
// Page footer
public function Footer() {
    // Add footer content to the last page
    $this->SetY(-60); // Adjust Y position to the bottom of the page
    $this->SetFont('helvetica', '', 10);
    
    // Add the "Dibuat Oleh" section on the left
    $this->SetX(15); // Adjust X position to the left margin
    $this->MultiCell(0, 10, "       Dibuat Oleh,\n\n\n\n\n\n\n" . $GLOBALS['name'], 0, 'L', 0, 0);
    
    // Add the "Diketahui Oleh" section on the right
    $this->SetX(-100); // Adjust X position to the right margin
    $this->MultiCell(0, 10, "Diketahui Oleh,     \n\n\n\n\n\n\n" . $GLOBALS['name'], 0, 'R', 0, 0);
}
}
?>