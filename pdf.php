<?php
require 'vendor/autoload.php';
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $invoiceNo = $_GET['invoiceNo'];
} else {
    exit;
}
$sql = "SELECT * FROM invoicetotal WHERE invoiceNo = '$invoiceNo'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $invoiceNo = $row['invoiceNo'];
    $partyName = $row['partyName'];
    $gst = $row['gst'];
    $address = $row['address'];
    $date = $row['date'];
    $amountWord = $row['amountWord'];
    $TotalAmount = $row['amount'];
} else {
    echo "No Record Found";
    exit;
}

use Dompdf\Dompdf;
use Dompdf\Options;

// Instantiate and use the dompdf class
$options = new Options();
$options->set('defaultFont', 'Arial');
$dompdf = new Dompdf($options);
$data = base64_encode(file_get_contents('hindi.jpg'));
$src = 'data:image/jpeg;base64,'.$data;
// Load HTML content
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $invoiceNo; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 100%;
            margin: 20px auto;
            border: 2px solid black;
            padding: 5px;
            /* padding-top: 0; */
            margin: 0;
            font-size: 0.95rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        th,
        td {
            padding: 0.5rem;
            border: 1px solid black;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .text-danger {
            color: red;
        }

        .h5 {
            font-size: 1.1rem;
        }

        .h2 {
            font-size: 1.75rem;
        }

        .fw-bold {
            font-weight: bold;
        }

        .py-custom-1 {
            padding-top: 0.2rem;
            padding-bottom: 0.2rem;
        }

        .no-border th,
        .no-border td {
            border: none;
        }

        .p-0 {
            padding: 0;
        }

        .m-0 {
            margin: 0;
        }

        .py-0 {
            padding-top: 0;
            padding-bottom: 0;
        }

        .border-none-invoice td{
            border-bottom-color: lightgray;
        }
    </style>
</head>

<body>
    <div class="container">
        <div style="width: 98%; margin: auto;">
            <table style="width: 100%; border: 0;">
                <tr>
                    <td style="width: 33%; border: 0;">GSTIN: 08AWGPD7728Q1ZV<br> State: Rajasthan</td>
                    <td style="width: 34%; border: 0;" class="text-center"><img src="<?php echo $src; ?>" alt="Not Found"></td>
                    <td style="width: 33%; border: 0;" class="text-end">Mob: 9414060621<br>9887111141</td>
                </tr>
            </table>
            <div class="h5 text-center"><b><u>BILL OF SUPPLY</u></b></div>
            <div class="text-center text-danger h2">DEEPAK PRINTERS</div>
            <div>
                <div class="text-center">Deals in: All Types of Printing Works and Digital Colour Printout</div>
                <div class="text-center fw-bold">Infront of SBI Bank, Jagatpura, Jaipur-302017</div>
                <div class="text-center">Email: deepakprinters.jpr@gmail.com</div>
            </div>
        </div>
        <table class="table table-bordered mx-auto">
            <tr>
                <td colspan="3">
                    <table class="no-border p-0 m-0">
                        <tr class="p-0">
                            <td style="width: 30%;" class="p-0">Name of Party:</td>
                            <td style="width: 70%;" class="p-0"><?php echo $partyName; ?></td>
                        </tr>
                        <tr class="p-0">
                            <td class="p-0">Address:</td>
                            <td class="p-0"><?php echo $address; ?></td>
                        </tr>
                        <tr class="p-0">
                            <td class="p-0">GSTIN/PAN:</td>
                            <td class="p-0"><?php echo $gst; ?></td>
                        </tr>
                    </table>
                </td>
                <td colspan="2">
                    <table class="no-border p-0">
                        <tr class="p-0">
                            <td style="width: 35%;" class="p-0">Invoice No:</td>
                            <td style="width: 65%;" class="p-0"><?php echo $invoiceNo; ?></td>
                        </tr>
                        <tr class="p-0">
                            <td class="p-0">Date:</td>
                            <td class="p-0"><?php echo date("d-m-Y", strtotime($date)); ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="text-center">
                <th style="width: 5%;">S.No.</th>
                <th style="width: 34%;">Description</th>
                <th style="width: 22%;">Qty.</th>
                <th style="width: 19%;">Rate</th>
                <th style="width: 20%;">Amount</th>
            </tr>

            <?php
            $sql2 = "SELECT * FROM invoice WHERE invoiceNo = '$invoiceNo'";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                $count = 1;
                while ($row2 = $result2->fetch_assoc()) {
            ?>
                    <tr class="<?php if ($count != 14) { ?>border-none-invoice<?php } ?>">
                        <td class="text-center"><?php echo $row2['SNo']; ?></td>
                        <td><?php echo $row2['description']; ?></td>
                        <td class="text-center"><?php echo $row2['qty']; ?></td>
                        <td class="text-center"><?php echo $row2['rate']; ?></td>
                        <td class="text-end pe-2"><?php echo $row2['amount']; ?></td>
                    </tr>
            <?php
                    $count++;
                }
            }
            for ($i = $count; $i <= 14; $i++) {
            ?>
                <tr class="<?php if ($i != 14) { ?>border-none-invoice<?php } ?>">
                    <td><?php echo " "; ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php
            }
            ?>
            <tr class="p-0">
                <td class="fw-bold text-center py-0" style="font-size: small;" colspan="2">COMPOSITION SCHEME UNDER GST</td>
                <td class="py-0" rowspan="2" style="font-size: smaller;">
                    <span class="fw-bold">BANK DETAILS</span><br>
                    State Bank of India <br>
                    A/c No: 42626370707 <br>
                    IFSC: SBIN0031798
                </td>
                <td class="fw-bold text-center py-0">Total</td>
                <td class="text-end py-0"><?php echo $TotalAmount; ?></td>
            </tr>
            <tr>
                <td class="py-0" colspan="2" style="text-align: justify;">Rs. (in words): <?php echo $amountWord; ?></td>
                <td class="py-0" colspan="2" style="text-align: justify;">Certified that the above mentioned details are true & correct</td>
            </tr>
        </table>
        <table class="table no-border">
            <tr>
                <td class="py-0">Terms and Conditions:</td>
                <td class="text-end text-danger py-0">For: <span class="fw-bold">DEEPAK PRINTERS</span></td>
            </tr>
            <tr>
                <td class="py-0">1. All subject to Jaipur jurisdiction only.</td>
                <td></td>
            </tr>
            <tr>
                <td class="py-0">2. Goods once sold will not be taken back.</td>
                <td></td>
            </tr>
            <tr>
                <td class="py-0">3. E. & O.E.</td>
                <td class="text-end py-0">Authorised Signature</td>
            </tr>
        </table>
    </div>
</body>

</html>
<?php
$html = ob_get_clean();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$fileName = str_replace("/", "-", $invoiceNo);
$dompdf->stream("$fileName.pdf", ["Attachment" => true]);
exit;
?>