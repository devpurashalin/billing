<?php
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo str_replace("/", "-", $invoiceNo)?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        @media print {
            .container {
                width: 100%;
                max-width: 95%;
                margin-top: 32px;
                padding: 0 1px;
            }
        }

        .border-none-invoice {
            border-color: lightgray !important;
            border-left-color: black !important;
            border-right-color: black !important;
        }

        .py-custom-1 {
            padding-top: 0.2rem !important;
            padding-bottom: 0.2rem !important;
        }

        th,
        td {
            padding: 0 0.3rem !important;
        }

        .no-border th,
        .no-border td {
            border: none !important;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container d-flex gap-5 my-5 d-print-none">
        <button class="btn btn-primary" onclick="window.print()">Print</button>
        <a class="text-decoration-none btn btn-danger" target="_blank" href="pdf?invoiceNo=<?php echo $invoiceNo; ?>">Save as PDF</a>
        <form action="./invoiceEdit" method="post">
            <input type="hidden" name="invoiceNo" value="<?php echo $invoiceNo; ?>">
            <button type="submit" class="btn border">Edit</button>
        </form>
    </div>
    <div class="container pt-2" style="border: 2px solid black; font-size: 0.95rem;">
        <div class="p-1 pb-3 mx-auto" style="width: 98%!important;">
            <div class="row">
                <div class="col">
                    GSTIN: 08AWGPD7728Q1ZV <br> State: Rajasthan
                </div>
                <div class="text-center col">
                    श्री गणेशाय नमः
                </div>
                <div class="text-end col">Mob: 9414060621<br>9887111141</div>
            </div>
            <div class="h5 text-center text-decoration-underline">BILL OF SUPPLY</div>
            <div class="text-center text-danger h2 py-0" colspan="5">DEEPAK PRINTERS</div>
            <div>
                <div class="text-center">Deals in: All Types of Printing Works and Digital Colour Printout</div>
                <div class="text-center fw-bold">Infront of SBI Bank, Jagatpura, Jaipur-302017</div>
                <div class="text-center">Email: deepakprinters.jpr@gmail.com</div>
            </div>
        </div>
        <table class="table table-bordered border-black mx-auto" style="width: 98%!important; font-size: 0.95rem">
            <tr>
                <td class="py-2 ps-3" colspan="3">
                    <div class="row pt-1">
                        <div class="col-4">Name of Party:</div>
                        <div class="col-8"><?php echo $partyName; ?></div>
                    </div>
                    <div class="row pt-1">
                        <div class="col-4">Address:</div>
                        <div class="col-8"><?php echo $address; ?></div>
                    </div>
                    <div class="row pt-1">
                        <div class="col-4">GSTIN/PAN:</div>
                        <div class="col-8"><?php echo $gst; ?></div>
                    </div>
                </td>
                <td class="py-2 ps-4" colspan="2">
                    <div class="row">
                        <div class="col-5 px-0">Invoice No:</div>
                        <div class="col-7 px-0"><?php echo $invoiceNo; ?></div>
                    </div>
                    <div style="height: 24px;">
                    </div>
                    <div class="row">
                        <div class="col-5 px-0">Date:</div>
                        <div class="col-7 px-0"><?php echo date("d-m-Y", strtotime($date)); ?></div>
                    </div>
                </td>
            </tr>
            <tr class="text-center">
                <th class="py-custom-1" style="width: 2%;">S.No.</th>
                <th class="py-custom-1" style="width: 10%;">Description</th>
                <th class="py-custom-1" style="width: 5%;">Qty.</th>
                <th class="py-custom-1" style="width: 4%;">Rate</th>
                <th class="py-custom-1" style="width: 5%;">Amount</th>
            </tr>

            <?php
            $sql2 = "SELECT * FROM invoice WHERE invoiceNo = '$invoiceNo'";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                $count = 1;
                while ($row2 = $result2->fetch_assoc()) {
            ?>
                    <tr class="<?php if ($count != 14) { ?>border-none-invoice<?php } ?>">
                        <td class="text-center py-custom-1"><?php echo $row2['SNo']; ?></td>
                        <td class="py-custom-1"><?php echo $row2['description']; ?></td>
                        <td class="text-center py-custom-1"><?php echo $row2['qty']; ?></td>
                        <td class="text-center py-custom-1"><?php echo $row2['rate']; ?></td>
                        <td class="text-end py-custom-1 pe-2"><?php echo $row2['amount']; ?></td>
                    </tr>
            <?php
                    $count++;
                }
            }
            for ($i = $count; $i <= 14; $i++) {
            ?>
                <tr class="<?php if ($i != 14) { ?>border-none-invoice<?php } ?>">
                    <td class="text-center py-custom-1"><?php echo " "; ?></td>
                    <td class="py-custom-1"></td>
                    <td class="text-center py-custom-1"></td>
                    <td class="text-center py-custom-1"></td>
                    <td class="text-end py-custom-1"></td>
                </tr>
            <?php
            }
            ?>

            <tr>
                <td class="fw-bold text-center pt-1" style="font-size: 0.9rem;" colspan="2">COMPOSITION SCHEME UNDER GST</td>
                <td rowspan="2" style="font-size: 0.9rem;">
                    <span class="fw-bold text-decoration-underline">BANK DETAILS</span><br>
                    State Bank of India <br>
                    A/c No: 42626370707 <br>
                    IFSC: SBIN0031798
                </td>
                <td class="fw-bold text-center pt-1">Total</td>
                <td class="text-end pe-2"><?php echo $TotalAmount; ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-size: 0.9rem; text-align: justify;">Rs. (in words): <?php echo $amountWord; ?></td>
                <td colspan="2" style="font-size: 0.78rem; text-align: justify;">Certified that the above mentioned details are true & correct</td>
            </tr>
        </table>
        <table class="table no-border mx-auto" style="width: 98%!important;">
            <tr>
                <td class="py-0">Terms and Conditions:</td>
                <td class="text-end text-danger">For: <span class="fw-bold">DEEPAK PRINTERS</span></td>
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
                <td class="text-end">Authorised Signature</td>
            </tr>
        </table>
    </div>
</body>

</html>