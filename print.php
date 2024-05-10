<?php
// Include the TCPDF library
require_once('vendor/autoload.php');

// Include the database connection file
include 'db.php';

// Check if the request method is GET
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['pdfContent'];
} else {
    exit;
}

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Invoice Print');
$pdf->SetSubject('Invoice');
$pdf->SetKeywords('Invoice, TCPDF, PHP');

// Set default header and footer data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set font
$pdf->SetFont('helvetica', '', 10);

// Add a page
$pdf->AddPage();

// HTML content for invoice
$html = '
<style>
    .table {
        display: table;
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        vertical-align: top;
        border-color: #dee2e6;
    }

    .py-0 {
        padding-top: 0!important;
        padding-bottom: 0!important;
    }

    .text-center {
        text-align: center!important;
    }

    .text-end {
        text-align: end!important;
    }

    .text-danger {
        color: #dc3545!important;
    }

    .fw-bold {
        font-weight: 700!important;
    }

    .bg-warning {
        background-color: #ffc107!important;
    }

    .h-100 {
        height: 100%!important;
    }
    .table th,
    .table td {
        border: none;
    }

    .heading {
        border: 1px solid black;
    }

    .forBorder td {
        border-left: 1px solid black;
        border-right: 1px solid black;
    }

    @media print {
        .container {
            width: 100%;
            max-width: none;
            padding: 0 50px;
        }

        #footer {
            page-break-inside: avoid;
        }
    }

    #completeHeight {
        height: 45vh;
    }

    #completeHeight tr {
        height: 4vh;
    }
</style>';
$html .= $content;
// echo $html;

// Output HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('invoice.pdf');
